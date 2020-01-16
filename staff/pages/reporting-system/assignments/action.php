<?php
  include($_SERVER['DOCUMENT_ROOT']."/s/php/phpHead.php");
  
  
switch($_POST["action"]) {
 case 'submit':
 
   if ($_POST["sub_type"] == 'add') {
  	$_POST["dueDate"] = date('Y-m-d', strtotime($_POST["weekOf"]) + (60 * 60 * 24 * ($_POST["dueDate"])));
 
  	$addAssignment = $dbStaff->prepare("INSERT INTO workAssignments (departmentID, assignedBy, assignedTo, weekOf, assignment, categoryID, isNew, isPlanned, sagaID, epicID, storyID, description, dueDate, estStoryPoints) VALUES (?, ?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
  	$addAssignment->bind_param("iissiiiiiissi", $_POST["dept"], $_SESSION["user"]["staff-id"], $_POST["weekOf"], $_POST["title"], $_POST["category"], $_POST["isNew"], $_POST["isPlanned"], $_POST["saga"], $_POST["epic"], $_POST["story"], $_POST["desc"], $_POST["dueDate"], $_POST["estSP"]);
  	if ($addAssignment->execute()) {
  	  $assignmentID = $dbStaff->insert_id;
 	  $addAssignment->close();
 	  
 	  dbLog::action('new_assnmt', $assignmentID, 1);
 	  
  	  $secondQuery = '';
  	  for ($i = 0; $i < count($_POST["staffID"]); $i++) {
  	    if ($i == count($_POST["staffID"]) - 1)
  	      $secondQuery .= '('.$assignmentID.','.$_POST["staffID"][$i].', '.$_POST["deptID"][$i].')';
  	    else
   	      $secondQuery .= '('.$assignmentID.','.$_POST["staffID"][$i].', '.$_POST["deptID"][$i].'), ';
   	  }
   	  if ($dbStaff->query("INSERT INTO workAssignmentsAssignedto (assignmentID, assignedTo, deptID) VALUES $secondQuery"))
   	    echo 1;
   	   else
   	    echo 0;
 	} else {
  	  $addAssignment->close();
  	  dbLog::action('new_assnmt', -1, 0);
  	  echo 0;
  	}
  } else if ($_POST["sub_type"] == 'edit' && ctype_digit($_POST["assignmentID"])) {
        $_POST["dueDate"] = date('Y-m-d', strtotime($_POST["weekOf"]) + (60 * 60 * 24 * ($_POST["dueDate"])));
        $_POST["dateCompleted"] = (!$_POST["wasCompleted"] ? '0000-00-00' : date('Y-m-d', strtotime($_POST["weekOf"]) + (60 * 60 * 24 * ($_POST["dateCompleted"]))));
        $compScore = ($_POST["actSP"] / $_POST["estSP"]) * 100;
        $assignmentID = $_POST["assignmentID"];
 
  	$updateAssignment = $dbStaff->prepare("UPDATE workAssignments SET departmentID = ?, weekOf = ?, assignment = ?, categoryID = ?, isNew = ?, isPlanned = ?, sagaID = ?, epicID = ?, storyID = ?, description = ?, dueDate = ?, dateCompleted = ?, wasCompleted = ?, needsMoreWork = ?, accomplishment = ?, isKeyAccomplishment = ?, comment = ?, estStoryPoints = ?, actStoryPoints = ?, completenessScore = ? WHERE assignmentID = ?");
  	$updateAssignment->bind_param("issiiiiiisssiisisiisi", $_POST["dept"], $_POST["weekOf"], $_POST["title"], $_POST["category"], $_POST["isNew"], $_POST["isPlanned"], $_POST["saga"], $_POST["epic"], $_POST["story"], $_POST["desc"], $_POST["dueDate"], $_POST["dateCompleted"], $_POST["wasCompleted"], $_POST["needsMoreWork"], $_POST["acc"], $_POST["keyAcc"], $_POST["comment"], $_POST["estSP"], $_POST["actSP"], $compScore, $assignmentID);
  	if ($updateAssignment->execute()) {
 	  $updateAssignment->close();
 	  
 	  dbLog::action('upd_assnmt', $assignmentID, 1);
 	  
  	  $secondQuery = '';
  	  
  	  for ($i = 0; $i < count($_POST["staffID"]); $i++) {
  	    if ($i == count($_POST["staffID"]) - 1) {
  	      $secondQuery .= '('.$assignmentID.','.$_POST["staffID"][$i].','.$_POST["deptID"][$i].')';
  	    } else { 
   	      $secondQuery .= '('.$assignmentID.','.$_POST["staffID"][$i].','.$_POST["deptID"][$i].'), ';
   	    }
   	  }
   	  
   	  if ($dbStaff->multi_query("CREATE TEMPORARY TABLE staffAssigned
(
	assnmtID INT,
	assnTo INT,
	deptID INT
);

INSERT INTO staffAssigned VALUES $secondQuery;

DELETE FROM workAssignmentsAssignedto WHERE ID IN (SELECT ID FROM (SELECT * FROM workAssignmentsAssignedto WHERE assignmentID = $assignmentID) as currentAssignments WHERE CONCAT(assignedTo,' ', currentAssignments.deptID) NOT IN (SELECT CONCAT(assnTo,' ',staffAssigned.deptID) as toCheck FROM staffAssigned));

INSERT INTO workAssignmentsAssignedto (assignmentID, assignedTo, deptID)
SELECT * FROM staffAssigned
WHERE NOT EXISTS (SELECT assignmentID, assignedTo, deptID FROM workAssignmentsAssignedto WHERE assignmentID = staffAssigned.assnmtID AND assignedTo = staffAssigned.assnTo AND workAssignmentsAssignedto.deptID = staffAssigned.deptID);

DROP TABLE staffAssigned;")) {
   	    echo 1;
   	  } else
   	    echo createError($dbStaff, $dbStaff->error);
 	} else {
  	  $updateAssignment->close();
  	  dbLog::action('upd_assnmt', $assignmentID, 0);
  	  echo 0;
  	}
  }
 break;
 case 'loadStaffByDept':
  (ctype_digit($_POST["deptID"]) ? $deptID = $_POST["deptID"] : die('Invalid DepartmentID'));
  $getStaff = $dbStaff->query("SELECT linkRoles.staffID, CONCAT(firstName, ' ', lastName) AS name, avatar FROM miscRoles, linkRoles LEFT JOIN staffInfo ON staffInfo.staffID = linkRoles.staffID WHERE linkRoles.roleID = miscRoles.roleID AND miscRoles.departmentID = $deptID");
  while ($staff = $getStaff->fetch_assoc()) {
    echo '<staff-list-member staff-id="'.$staff["staffID"].'" dept-id="'.$deptID.'">
            <staff-list-member-content>
              <staff-list-member-avatar style="background-image: url(http://72dragonsservices.com/f/images/staff/avatar/'.$staff["avatar"].')"></staff-list-member-avatar>
              <staff-list-member-name>'.$staff["name"].'</staff-list-member-name>
            </staff-list-member-content>
          </staff-list-member>';
  }
 break;
 case 'loadWeekAssignments':
	$prevID = 0;
	$prevDept = '';
	$assignmentsArray = [];
	$deptIDs = [];
	foreach ($_SESSION["user"]["depts"]["departments"] as $deptID => $dept) {
		$deptIDs[] = $deptID;
	}
	$deptID = implode(',', $deptIDs);

	$getAssignments = $dbStaff->query("SELECT workAssignments.assignmentID, assignment, CONCAT(firstName,' ',lastName) as name, avatar, deptID, department FROM workAssignments LEFT JOIN workAssignmentsAssignedto ON workAssignments.assignmentID = workAssignmentsAssignedto.assignmentID LEFT JOIN staffInfo ON staffID = workAssignmentsAssignedto.assignedTo LEFT JOIN miscDepartments ON miscDepartments.departmentID = workAssignments.departmentID WHERE weekOf = '".$_POST["weekOf"]."' AND (workAssignmentsAssignedto.assignedTo = ".$_SESSION["user"]["staff-id"]." OR workAssignments.assignedBy = ".$_SESSION["user"]["staff-id"]." OR workAssignments.departmentID IN ($deptID) OR workAssignmentsAssignedto.deptID IN ($deptID)) ORDER BY miscDepartments.department, assignment, workAssignments.assignmentID");
	while ($assignment = $getAssignments->fetch_assoc()) {
		if ($assignment["assignmentID"] == $prevID) {
			$assignmentsArray[$prevID]["staffMembers"][] = array("name" => $assignment["name"], "avatar" => $assignment["avatar"], "dept" => $assignment["deptID"]);
		} else {
			$prevID = $assignment["assignmentID"];
			$assignmentsArray[$prevID] = array("result" => $assignment, "staffMembers" => array(array("name" => $assignment["name"], "avatar" => $assignment["avatar"], "dept" => $assignment["deptID"])));
		}
	}
	
	foreach ($assignmentsArray as $assignment) {
		if ($prevDept != $assignment["result"]["department"]) {
			$prevDept = $assignment["result"]["department"];
			echo '<h3>Assigned From '.$assignment["result"]["department"].'</h3>';
		}
		echo '<assignment assignment-id="'.$assignment["result"]["assignmentID"].'"><assignment-assigned>';
		foreach ($assignment["staffMembers"] as $staff) {
			echo '<assignment-assigned-staff style="background-image: url(http://72dragonsservices.com/f/images/staff/avatar/'.$staff["avatar"].');"><span class="noclick noselect">'.$staff["name"].'</span></assignment-assigned-staff>';
		}
		echo '</assignment-assigned><assignment-title><h3>'.$assignment["result"]["assignment"].'</h3></assignment-title><assignment-controls><assignment-controls-item class="aci-edit"><i class="fas fa-pencil-alt"></i></assignment-controls-item><assignment-controls-item class="aci-delete"><i class="fas fa-times"></i></assignment-controls-item></assignment-controls></assignment>';
	}
 break;
 case 'deleteAssignment':
   if (!ctype_digit($_POST["assignmentID"])) createError($dbStaff, "Invalid Assignment ID.");
   
   $toValidate = 'assignment_delete';
   $assignmentID = $_POST["assignmentID"];
   include($_SERVER['DOCUMENT_ROOT']."/s/php/validate.php");
   
   if ($dbStaff->query("DELETE FROM workAssignments WHERE assignmentID = $assignmentID"))
     echo 1;
   else
     echo createError($dbStaff, "There Was A Problem Deleting The Assignment. Please Try Again.");
 break;
}
  include($_SERVER['DOCUMENT_ROOT']."/s/php/phpFoot.php");
?>