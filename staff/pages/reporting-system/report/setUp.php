<?php
include($_SERVER['DOCUMENT_ROOT']."/s/php/phpHead.php");

if (!ctype_digit($_POST["deptID"])) createError($dbStaff, "Not A Valid Department ID.");
$deptID = $_POST["deptID"];
$toValidate = 'department';
include($_SERVER['DOCUMENT_ROOT']."/s/php/validate.php");

switch ($_POST["action"]) {
    case 'getWeeks':
      $getWeeks = $dbStaff->query("SELECT DISTINCT weekOf FROM workAssignments WHERE departmentID = ".$deptID." ORDER BY weekOf DESC");
       while ($weekOf = $getWeeks->fetch_assoc()) {
         echo '<div onclick="loadWeek($(this))" class="input-select-item" data-value="'.$weekOf["weekOf"].'">'.date('M jS', strtotime($weekOf["weekOf"])).'</div>';
       }
    break;
    case 'getAssignmentsFromWeek':
        $prevID = 0;
        $prevDept = '';
        $assignmentsArray = [];

        $weekOf = explode('-', $_POST["weekOf"]);
        if (!checkdate($weekOf[1], $weekOf[2], $weekOf[0])) createError($dbStaff, "Not A Valid Week.");

        $getAssignments = $dbStaff->query("SELECT workAssignments.assignmentID, assignment, CONCAT(firstName,' ',lastName) as name, avatar, deptID, department FROM workAssignments LEFT JOIN workAssignmentsAssignedto ON workAssignments.assignmentID = workAssignmentsAssignedto.assignmentID LEFT JOIN staffInfo ON staffID = workAssignmentsAssignedto.assignedTo LEFT JOIN miscDepartments ON miscDepartments.departmentID = workAssignments.departmentID WHERE weekOf = '".$_POST["weekOf"]."' AND (workAssignments.departmentID = $deptID OR workAssignmentsAssignedto.deptID = $deptID) ORDER BY miscDepartments.department, assignment, workAssignments.assignmentID");
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
            echo '<assignment-assigned-staff style="background-image: url(https://72dragonsservices.com/f/images/staff/avatar/'.$staff["avatar"].');"><span class="noclick noselect">'.$staff["name"].'</span></assignment-assigned-staff>';
          }
          echo '</assignment-assigned><assignment-title><h3>'.$assignment["result"]["assignment"].'</h3></assignment-title><assignment-controls><assignment-controls-item class="aci-picked"><i class="fas fa-times"></i></assignment-controls-item></assignment>';
        }
        ?>
      <div class="input-block"><h3>Additional Report Details</h3></div>
      <div class="input-block input-radio">
          <div class="input-radio-item">
              <div class="input-radio-button" data-name="0"></div>
              <div class="input-title">Weekly Report</div>
          </div>
          <div class="input-radio-item">
              <div class="input-radio-button" data-name="1"></div>
              <div class="input-title">Monthly Report</div>
          </div>
          <div class="input-error-msg"></div>
          <input type="hidden" name="reportType">
      </div>
      <div class="input-block" style="text-align: center;">
        <div class="input-checkbox-item">
          <div class="input-checkbox-button"></div>
          <div class="input-title"><p>Include Graph Data From My Previous Weeks Reports</p></div>
          <input type="hidden" name="inclData" value="0">
        </div>
      </div>
      <input type="hidden" name="weekOf" value="<?php echo $_POST["weekOf"]; ?>">
      <input type="hidden" name="deptID" value="<?php echo $deptID; ?>">
      <input type="hidden" name="canReview" value="1">
      <button class="submit" id="genData">Generate Report Data</button>
      <?php
    break;
}

include($_SERVER['DOCUMENT_ROOT']."/s/php/phpFoot.php");
?>