<?php
include($_SERVER['DOCUMENT_ROOT']."/s/php/phpHead.php");

function loadAsgnsByUser($dbStaff, $userID, $reportID) {
        $prevID = 0;
        $prevDept = '';
        $assignmentsArray = [];
        $assignmentDivs = '';

        $getAssignments = $dbStaff->query("SELECT workAssignments.assignmentID, assignment, CONCAT(firstName,' ',lastName) as name, avatar, deptID, department FROM workAssignments LEFT JOIN workAssignmentsAssignedto ON workAssignments.assignmentID = workAssignmentsAssignedto.assignmentID LEFT JOIN staffInfo ON staffID = workAssignmentsAssignedto.assignedTo LEFT JOIN miscDepartments ON miscDepartments.departmentID = workAssignments.departmentID LEFT JOIN workReportsAssignments ON workReportsAssignments.assignmentID = workAssignmentsAssignedto.assignmentID WHERE reportID = $reportID AND (workAssignmentsAssignedto.assignedTo = $userID OR workAssignmentsAssignedto.assignmentID IN (SELECT wRA.assignmentID FROM workReportsAssignments as wRA LEFT JOIN workAssignmentsAssignedto as wAAT ON wAAT.assignmentID = wRA.assignmentID WHERE reportID = $reportID and wAAT.assignedTo = $userID)) ORDER BY miscDepartments.department, assignment, workAssignments.assignmentID");
        while ($assignment = $getAssignments->fetch_assoc()) {
          if ($assignment["assignmentID"] == $prevID) {
            $assignmentsArray[$prevID]["staffMembers"][] = array("name" => $assignment["name"], "avatar" => $assignment["avatar"], "dept" => $assignment["deptID"]);
          } else {
            $prevID = $assignment["assignmentID"];
            $assignmentsArray[$prevID] = array("result" => $assignment, "staffMembers" => array(array("name" => $assignment["name"], "avatar" => $assignment["avatar"], "dept" => $assignment["deptID"])));
          }
        }
        
        echo '<h3 class="section-title">Assignments</h3>';
        
        foreach ($assignmentsArray as $assignment) {
          $assignmentDivs .= '<assignment class="toggleable" assignment-id="'.$assignment["result"]["assignmentID"].'"><assignment-assigned>';
          foreach ($assignment["staffMembers"] as $staff) {
            $assignmentDivs.= '<assignment-assigned-staff style="background-image: url(http://72dragonsservices.com/f/images/staff/avatar/'.$staff["avatar"].');"><span class="noclick noselect">'.$staff["name"].'</span></assignment-assigned-staff>';
          }
          $assignmentDivs .= '</assignment-assigned><assignment-title><h3>'.$assignment["result"]["assignment"].'</h3></assignment-title><assignment-controls><assignment-controls-item class="aci-drop"><i class="fas fa-chevron-down"></i></assignment-controls-item></assignment>';
          
          $getAssignmentDetails = $dbStaff->query("SELECT category, isNew, isPlanned, sSaga.story as saga, sEpic.story as epic, sStory.story as story, workAssignments.description, dueDate, dateCompleted, needsMoreWork, accomplishment, comment, workAssignments.dateAdded FROM workAssignments LEFT JOIN workStories as sSaga ON sagaID = sSaga.storyID LEFT JOIN workStories as sEpic ON epicID = sEpic.storyID LEFT JOIN workStories as sStory ON workAssignments.storyID = sStory.storyID LEFT JOIN workCategories ON workCategories.categoryID = workAssignments.categoryID WHERE assignmentID = ".$assignment["result"]["assignmentID"]);
          $assignmentDetails = $getAssignmentDetails->fetch_assoc();
          $assignmentDivs .= '<div class="input-container assignment-details">
            <div class="input-block"><div class="input-title">Assignment Dates</div><p>Assigned: '.date('F jS, Y', strtotime($assignmentDetails["dateAdded"])).'</p><p>Due: '.date('F jS, Y', strtotime($assignmentDetails["dueDate"])).'</p><p>Completed: '.(date('Y', strtotime($assignmentDetails["dateCompleted"])) == '-0001' ? 'No' : date('F jS, Y', strtotime($assignmentDetails["dateCompleted"]))).'</p></div>
            <div class="input-block"><div class="input-title">About This Assignment</div><p>'.$assignmentDetails["description"].'</p></div>
            <div class="input-block"><div class="input-title">Accomplishments</div><p>'.$assignmentDetails["accomplishment"].'</p></div>
            <div class="input-block"><div class="input-title">Comments</div><p>'.$assignmentDetails["comment"].'</p></div>
            <div class="input-block"><div class="input-title">User Stories</div><p>Saga: '.$assignmentDetails["saga"].'</p><p>Epic: '.$assignmentDetails["epic"].'</p><p>Story: '.$assignmentDetails["story"].'</p></div>
            <div class="input-block"><div class="input-title">Category</div><p>'.$assignmentDetails["category"].'</p></div>
            <div class="input-block"><div class="input-title">Additional Information</div><p>Assigned By</p><p>'.($assignmentDetails["needsMoreWork"] != 1 ? '<i class="far fa-square"></i>' : '<i class="far fa-check-square"></i>').' Needs More Work</p><p>'.($assignmentDetails["isNew"] == 0 ? '<i class="far fa-square"></i>' : '<i class="far fa-check-square"></i>').' Is A New Assignment</p><p>'.($assignmentDetails["isPlanned"] == 0 ? '<i class="far fa-square"></i>' : '<i class="far fa-check-square"></i>').' Was Planned At The Beginning Of The Week</p></div>
          </div>';
        }
        return $assignmentDivs;
}

function gen_report_block($dbStaff, $graphData, $graphAction, $graphType, $reviewable, $report_ID_and_user_ID) {
  if ($graphAction == 'create') {
    $id = md5(uniqid());
    $addGraph = $dbStaff->prepare("INSERT INTO workReportsReviews (graphID, reportID, staffID, graphType) VALUES ('$id', ".$report_ID_and_user_ID[0].", ".($report_ID_and_user_ID[1] == NULL ? "NULL" : $report_ID_and_user_ID[1]).", ?)");
    $addGraph->bind_param('s', $graphType);
    $addGraph->execute();
    $addGraph->close();
    return '<div class="input-block graph-container" graph-id="'.$id.'"><canvas id="'.$id.'" width="400px" height="400px"></canvas><script type="text/javascript">var ctx = document.getElementById("'.$id.'").getContext(\'2d\');
  var myChart = new Chart(ctx, '.$graphData.');</script></div><div class="input-block"><div class="input-title">About The Data Above</div><div class="input-item"><textarea name="'.$id.'"></textarea><input type="hidden" name="graphID[]" value="'.$id.'"><button class="submit" onclick="saveReview(this, \''.$id.'\');">Save</button></div><div class="input-error-msg"></div></div>';
  }
  
  if ($report_ID_and_user_ID[1] == NULL) {
    $getReview = $dbStaff->prepare("SELECT graphID, review FROM workReportsReviews WHERE reportID = ? AND graphType = ?");
    $getReview->bind_param('is', $report_ID_and_user_ID[0], $graphType);
  } else {
    $getReview = $dbStaff->prepare("SELECT graphID, review FROM workReportsReviews WHERE reportID = ? AND staffID = ? AND graphType = ?");
    $getReview->bind_param('iis', $report_ID_and_user_ID[0], $report_ID_and_user_ID[1], $graphType);
  }
  $getReview->execute();
  $getReview->bind_result($id, $review);
  $getReview->fetch();
  $getReview->close();
  
  if ($reviewable)
    return '<div class="input-block graph-container" graph-id="'.$id.'"><canvas id="'.$id.'" width="400px" height="400px"></canvas><script type="text/javascript">var ctx = document.getElementById("'.$id.'").getContext(\'2d\');
  var myChart = new Chart(ctx, '.$graphData.');</script></div>
  <div class="input-block">
    <div class="input-title">About The Data Above</div>
    <div class="input-item"><textarea name="'.$id.'">'.$review.'</textarea><input type="hidden" name="graphID[]" value="'.$id.'"><button class="submit" onclick="saveReview(this, \''.$id.'\');">Save</button></div>
    <div class="input-error-msg"></div>
  </div>';
  else
    return '<div class="input-block graph-container" graph-id="'.$id.'"><canvas id="'.$id.'" width="400px" height="400px"></canvas><script type="text/javascript">var ctx = document.getElementById("'.$id.'").getContext(\'2d\');
  var myChart = new Chart(ctx, '.$graphData.');</script></div>
  <div class="input-block">
    <div class="input-title">About The Data Above</div>
    <div class="input-item"><p>'.$review.'</p></div>
  </div>';
}

function genChartjsDataset($data, $title, $color) {
  return array("label" => $title, "data" => array_reverse($data), "lineTension" => 0, "pointBackgroundColor" => $color, "borderColor" => $color, "borderWidth" => 1);
}

function genChartjsJSON($data, $title) {
$chartJS = array("type" => "line", "data" => array("labels" => array_reverse($data["week"]), "datasets" => []), "options" => array("title" => array("display" => true, "text" => $title, "fontSize" => 20), "scales" => array("yAxes" => [array("ticks" => array("beginAtZero" => true))])));
  $colors = ["#ad9440", "#ad4040", "#338a33", "#3c3778", "#94375e"];
  $i = 0;

  foreach($data as $key => $toGroup) {
    if ($key != "week") {
      $chartJS["data"]["datasets"][] = genChartjsDataset($toGroup, $key, $colors[$i++ % 5]);
    }
  }
  return $chartJS;
}

function getWeekOfData($dbStaff, $report_ID_and_user_ID, $type, $data) {
  $reportID = $report_ID_and_user_ID[0];
  $searchQuery = "SELECT workReportsAssignments.assignmentID FROM workReportsAssignments WHERE reportID = $reportID";
  if ($report_ID_and_user_ID[1] != NULL) {
    $userID = $report_ID_and_user_ID[1];
    $searchQuery = "SELECT workReportsAssignments.assignmentID FROM workReportsAssignments LEFT JOIN workAssignmentsAssignedto on workReportsAssignments.assignmentID = workAssignmentsAssignedto.assignmentID WHERE reportID = $reportID AND workAssignmentsAssignedto.assignedTo = $userID";
  }
  switch($type) {
    case 'overall_assignments':
    case 'user_assignments':
      $title = "Weekly Assignment Progress";

      if ($data == '')
        $data = array("week" => [], "Total" => [], "New" => [], "Completed" => []);

      $getOverallData = $dbStaff->query("SELECT count(assignmentID) as total, SUM(isNew) as newTotal, SUM(wasCompleted) as completed, workReports.weekOf, parentReport FROM workAssignments LEFT JOIN workReports ON workReports.reportID = $reportID WHERE assignmentID IN ($searchQuery)");
      $results = $getOverallData->fetch_assoc();
      $data["week"][] = $results["weekOf"];
      $data["Total"][] = $results["total"];
      $data["New"][] = $results["newTotal"];
      $data["Completed"][] = $results["completed"];
    break;
    case 'overall_storypoints':
    case 'user_storypoints':
      $title = "Story Points";

      if ($data == '')
        $data = array("week" => [], "Estimated" => [], "Actual" => []);
      
      $getOverallData = $dbStaff->query("SELECT SUM(estStoryPoints) as est, SUM(actStoryPoints) as act, workReports.weekOf, parentReport FROM workAssignments LEFT JOIN workReports ON workReports.reportID = $reportID WHERE assignmentID IN ($searchQuery)");
      $results = $getOverallData->fetch_assoc();
      $data["week"][] = $results["weekOf"];
      $data["Estimated"][] = $results["est"];
      $data["Actual"][] = $results["act"];
    break;
    case 'overall_completion':
    case 'user_completion':
      $title = "Overall Completion";

      if ($data == '')
        $data = array("week" => [], "Percent" => []);
      
      $getOverallData = $dbStaff->query("SELECT (SUM(completenessScore) / count(assignmentID)) as completed, workReports.weekOf, parentReport FROM workAssignments LEFT JOIN workReports ON workReports.reportID = $reportID WHERE assignmentID IN ($searchQuery)");
      $results = $getOverallData->fetch_assoc();
      $data["week"][] = $results["weekOf"];
      $data["Percent"][] = $results["completed"];
    break;
  }
  if ($results["parentReport"] != NULL) {
    $report_ID_and_user_ID[0] = $results["parentReport"];
    return getWeekOfData($dbStaff, $report_ID_and_user_ID, $type, $data);
  } else 
    return genChartjsJSON($data, $title);
}

if (!isset($_POST["reportID"])) { //New Report
  foreach($_POST["assignmentID"] as $id) {
    if (!ctype_digit($id)) die('Invalid ID');
  }
  if (!ctype_digit($_POST["deptID"])) createError($dbStaff, "Invalid Department."); else $deptID = $_POST["deptID"];
  if (date('Y', strtotime($_POST["weekOf"])) == '1970') createError($dbStaff, "Invalid Week.");
  if (!ctype_digit($_POST["reportType"])) createError($dbStaff, "Invalid Report Type."); else {
    switch ($_POST["reportType"]) {
      case 0: $reportType = 'weekly-ip'; break;
      case 1: $reportType = 'monthly-ip'; break;
      default: createError($dbStaff, "Invalid Report Type.");
    }
  }

  $assignmentIDs = implode(',', $_POST["assignmentID"]);
  $weekOf = $_POST["weekOf"];
  $userID = NULL;
  $_POST["canReview"] = true;
  $graphAction = 'create';

  //Gen the report ID and link assignments
  if (!$_POST["inclData"])
    $dbStaff->query("INSERT INTO workReports (parentReport, departmentID, weekOf, type, createdBy) VALUES (NULL, $deptID, '$weekOf', '$reportType', ".$_SESSION["user"]["staff-id"].");");
  else
    $dbStaff->query("INSERT INTO workReports (parentReport, departmentID, weekOf, type, createdBy) VALUES ((SELECT reportID FROM (SELECT * FROM workReports) as wrkRpts WHERE weekOf < \"$weekOf\" AND createdBy = ".$_SESSION["user"]["staff-id"]." AND departmentID = $deptID ORDER BY weekOf DESC, reportID DESC LIMIT 0, 1), $deptID, '$weekOf', '$reportType', ".$_SESSION["user"]["staff-id"].");");
  $reportID = $dbStaff->insert_id;
  $dbStaff->query("INSERT INTO workReportsAssignments (reportID, assignmentID) VALUES ($reportID, ".implode("),($reportID,", $_POST["assignmentID"]).");");
  
} else if (ctype_digit($_POST["reportID"])) { //Loading Report
  $reportID = $_POST["reportID"];
  $graphAction = 'view';
  if (isset($_POST["userID"]) && ctype_digit($_POST["userID"]))
    $userID = $_POST["userID"];
  else if (isset($_POST["userID"]) && !ctype_digit($_POST["userID"]))
    die("Invalid User ID");
  else
    $userID = null;
  
  $getDepartment = $dbStaff->query("SELECT departmentID FROM workReports WHERE reportID = $reportID");
  $deptID = ($getDepartment->fetch_assoc())["departmentID"];
  if (strlen($deptID) == 0)
    createError($dbStaff, "Report Does Not Exist.");
} else
  die("Invalid Report ID");


if ($_POST["canReview"]) {
  $toValidate = 'report';
  include($_SERVER['DOCUMENT_ROOT']."/s/php/validate.php");
}

//GENERATE REPORT  

//First gen the overview for the department
////Need to have a distinct completeness score
echo '<div class="panel-content"><div class="input-container report-heading-block" style="background-image: url(http://72dragonsservices.com/f/images/staff/avatar/unknown.png);"><h1 class="rhb-title">Web Department Report</h1><div class="rhb-data">';
$getAsgnData = $dbStaff->query("SELECT count(DISTINCT workReportsAssignments.assignmentID) as total, SUM(wasCompleted) as completed, ROUND(AVG(completenessScore), 0) as compScore FROM workAssignments LEFT JOIN workReportsAssignments ON workReportsAssignments.assignmentID = workAssignments.assignmentID LEFT JOIN workAssignmentsAssignedto ON workAssignmentsAssignedto.assignmentID = workReportsAssignments.assignmentID WHERE reportID = $reportID");
$data = $getAsgnData->fetch_assoc();
echo '<p>'.($data["total"] == 1 ? $data["total"].' Assignment' : $data["total"].' Assignments').'</p><p>'.$data["completed"].' Finished</p><p>'.$data["compScore"].'% Completion</p>';
echo '</div></div>';
echo '<h3 class="section-title">Team Overview</h3>';
echo '<div class="input-container graph-data">';
echo gen_report_block($dbStaff, json_encode(getWeekOfData($dbStaff, [$reportID, $userID], ($userID == NULL ? "overall_assignments" : "user_assignments"), '')), $graphAction, ($userID == NULL ? "overall_assignments" : "user_assignments"), $_POST["canReview"], [$reportID, $userID]);
echo gen_report_block($dbStaff, json_encode(getWeekOfData($dbStaff, [$reportID, $userID], ($userID == NULL ? "overall_storypoints" : "user_storypoints"), '')), $graphAction, ($userID == NULL ? "overall_storypoints" : "user_storypoints"), $_POST["canReview"], [$reportID, $userID]);
echo gen_report_block($dbStaff, json_encode(getWeekOfData($dbStaff, [$reportID, $userID], ($userID == NULL ? "overall_completion" : "user_completion"), '')), $graphAction, ($userID == NULL ? "overall_completion" : "user_completion"), $_POST["canReview"], [$reportID, $userID]);
echo '</div>';

//Then gen for the participating department members
$getStaffIDs = $dbStaff->query("SELECT DISTINCT workAssignmentsAssignedto.assignedTo, CONCAT(firstName,' ',lastName) as name, avatar FROM workReportsAssignments LEFT JOIN workAssignmentsAssignedto ON workAssignmentsAssignedto.assignmentID = workReportsAssignments.assignmentID LEFT JOIN staffInfo ON staffInfo.staffID = workAssignmentsAssignedto.assignedTo WHERE deptID = $deptID AND reportID = $reportID");
while ($staff = $getStaffIDs->fetch_assoc()) {
  $userID = $staff["assignedTo"];
  echo '<div class="input-container report-heading-block" style="background-image: url(http://72dragonsservices.com/f/images/staff/avatar/'.$staff["avatar"].');"><h1 class="rhb-title">'.$staff["name"].'</h1><div class="rhb-data">';
  $getAsgnData = $dbStaff->query("SELECT count(workReportsAssignments.assignmentID) as total, SUM(wasCompleted) as completed, ROUND(AVG(completenessScore), 0) as compScore FROM workAssignments LEFT JOIN workReportsAssignments ON workReportsAssignments.assignmentID = workAssignments.assignmentID LEFT JOIN workAssignmentsAssignedto ON workAssignmentsAssignedto.assignmentID = workReportsAssignments.assignmentID WHERE reportID = $reportID AND workAssignmentsAssignedto.assignedTo = $userID");
  $data = $getAsgnData->fetch_assoc();
  echo '<p>'.($data["total"] == 1 ? $data["total"].' Assignment' : $data["total"].' Assignments').'</p><p>'.$data["completed"].' Finished</p><p>'.$data["compScore"].'% Completion</p>';
  echo '</div></div>';
  echo loadAsgnsByUser($dbStaff, $userID, $reportID);
  echo '<h3 class="section-title">Week Overview</h3>';
  echo '<div class="input-container graph-data">';
  echo gen_report_block($dbStaff, json_encode(getWeekOfData($dbStaff, [$reportID, $userID], ($userID == NULL ? "overall_assignments" : "user_assignments"), '')), $graphAction, ($userID == NULL ? "overall_assignments" : "user_assignments"), $_POST["canReview"], [$reportID, $userID]);
  echo gen_report_block($dbStaff, json_encode(getWeekOfData($dbStaff, [$reportID, $userID], ($userID == NULL ? "overall_storypoints" : "user_storypoints"), '')), $graphAction, ($userID == NULL ? "overall_storypoints" : "user_storypoints"), $_POST["canReview"], [$reportID, $userID]);
  echo gen_report_block($dbStaff, json_encode(getWeekOfData($dbStaff, [$reportID, $userID], ($userID == NULL ? "overall_completion" : "user_completion"), '')), $graphAction, ($userID == NULL ? "overall_completion" : "user_completion"), $_POST["canReview"], [$reportID, $userID]);
  echo '</div>';
}

//Finally gen userstories
echo '<div class="input-container report-heading-block" style="background-image: url(http://72dragonsservices.com/f/images/staff/avatar/unknown.png);"><h1 class="rhb-title">Userstories</h1><div class="rhb-data">';
$getStories = $dbStaff->query("SELECT COUNT(DISTINCT sagaID) as saga, COUNT(DISTINCT epicID) as epic, COUNT(DISTINCT storyID) as story FROM workAssignments LEFT JOIN workReportsAssignments ON workReportsAssignments.assignmentID = workAssignments.assignmentID WHERE reportID = $reportID");
$storyData = $getStories->fetch_assoc();
echo '<p>'.($storyData["saga"] == 1 ? $storyData["saga"].' Saga' : $storyData["saga"].' Sagas').'</p><p>'.($storyData["epic"] == 1 ? $storyData["epic"].' Epic' : $storyData["epic"].' Epics').'</p><p>'.($storyData["story"] == 1 ? $storyData["story"].' Story' : $storyData["story"].' Stories').'</p>';
echo '</div></div>';

if (isset($weekOf))
  echo '<div class="input-container"><div class="input-block"><h3>Public Your Report</h3></div><div class="input-block"><input type="hidden" name="reportID" value="'.$reportID.'"><button class="submit">Publish</button></div></div></div>';

include($_SERVER['DOCUMENT_ROOT']."/s/php/phpFoot.php");
?>