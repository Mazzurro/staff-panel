<?php
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/projects/assignments/assignment.php');

class Assignments {

    public static function createAssignment($assignmentDetails) { //check if valid catid and storyid and storyid belongs to the project
        if (!isset($assignmentDetails['projectID'])) return Staffpanel::createError('400','Missing Input','No project ID provided.');
        else if (!isset($assignmentDetails['title'])) return Staffpanel::createError('400','Missing Input','The assignment title cannot be blank.');
        else if (strlen($assignmentDetails['title']) > 100) return Staffpanel::createError('400','Lengthy Title','The title is too long (max 100 characters).');
        else if (!isset($assignmentDetails['desc'])) return Staffpanel::createError('400','Missing Input','The assignment description cannot be blank.');
        else if (!isset($assignmentDetails['category'])) return Staffpanel::createError('400','Missing Input','Please pick a category.');
        else if (!isset($assignmentDetails['startDate'])) return Staffpanel::createError('400','Missing Input','The start date cannot be blank.');
        else if (!isset($assignmentDetails['storyPoints']) || $assignmentDetails['storyPoints'] < 1 || $assignmentDetails['storyPoints'] > 10) return Staffpanel::createError('400','Missing Input','Invalid Story Points.');
        else if ((!isset($assignmentDetails['endDate']) || strlen($assignmentDetails['endDate']) != 8)) return Staffpanel::createError('400','Invalid Input','Please choose either the end date or that the assignment is repeating.');
        else if (isset($assignmentDetails['endDate'])) {
            $endDateVal = DateTime::createFromFormat('d/m/y',$assignmentDetails['endDate']);
            if (!($endDateVal && $endDateVal->format('d/m/y') == $assignmentDetails['endDate'])) return Staffpanel::createError('400','Invalid Date','The end date is invalid (DD/MM/YY).');
            $assignmentDetails['endDate'] = $endDateVal->format('Y-m-d');
        } else
            $assignmentDetails['endDate'] = NULL;

        $startDateVal = DateTime::createFromFormat('d/m/y',$assignmentDetails['startDate']);
        if (!($startDateVal && $startDateVal->format('d/m/y') == $assignmentDetails['startDate'])) return Staffpanel::createError('400','Invalid Date','The start date is invalid (DD/MM/YY).');
        $assignmentDetails['startDate'] = $startDateVal->format('Y-m-d');

        Project::loadProject($assignmentDetails["projectID"]);
        $staffList = Project::getProjectParticipants();
        $staffIDs = [];

        foreach($assignmentDetails['staff'] as $staff) {
            if (!isValidNumber($staff['staffID'])) return Staffpanel::createError('400','Invalid Staff ID','A staff id is invalid.');
            if (!isset($staffList[$staff['staffID']])) return Staffpanel::createError('400','Invalid Staff Member',$staff['name'].' has not been given permissions for this project.');
            $staffIDs[] = $staff['staffID'];
        }

        $addAssignment = db::$con->prepare("INSERT INTO reportAssignments (assignedBy, title, description, categoryID, storyID, startDate, endDate, estStoryPoints, repeatAssignment) VALUES (?,?,?,?,?,?,?,?,?);");
        $addAssignment->bind_param('issiissii', StaffMember::$me['staffID'], $assignmentDetails['title'], $assignmentDetails['desc'], $assignmentDetails['category'], $assignmentDetails['storyID'], $assignmentDetails['startDate'], $assignmentDetails['endDate'], $assignmentDetails['storyPoints'], $assignmentDetails['repeat']);
        if ($addAssignment->execute()) {
            $assignmentID = $addAssignment->insert_id;
            $addAssignment->close();

            if (isset($assignmentDetails['staff']) && count($assignmentDetails['staff']) > 0) {
                $insertQuery = '('.$assignmentID.','.implode('),('.$assignmentID.',',$staffIDs).');';
                db::$con->query('INSERT INTO workAssignmentsAssignedto (assignmentID, assignedTo) VALUES '.$insertQuery);
            }

            return array('assignmentID'=>$assignmentID);
        } else {
            $addAssignment->close();
            return Staffpanel::createError('408','System Error','An error occured with adding the assignment.');
        }
    }

    public static function loadByStoryID($storyID) {
        if (!isValidNumber($storyID) || !Userstories::validateStoryItem($storyID, 'Story')) return Staffpanel::createError('400','Invalid Story ID','The story id was invalid or not an id.');
        $assignmentList = [];

        $getAssignments = db::$con->query("SELECT reportAssignments.assignmentID, assignedBy, title, description, storyID, endDate, percentComplete, CONCAT(firstName,' ',middleName,' ',lastName) as name, updateAssignments.updatedOn, COUNT(assignedTo) as participants FROM `reportAssignments` LEFT JOIN (SELECT MAX(updt.updateID) as updtID, updt.assignmentID, updt.percentComplete, updt.updatedBy, updt.updatedOn FROM reportAssignmentsUpdate AS updt WHERE updt.removedBy IS NULL GROUP BY updt.assignmentID DESC ORDER BY updtID) as updateAssignments ON updateAssignments.assignmentID = reportAssignments.assignmentID LEFT JOIN workAssignmentsAssignedto ON reportAssignments.assignmentID = workAssignmentsAssignedto.assignmentID LEFT JOIN staffInfo ON staffInfo.staffID = updateAssignments.updatedBy WHERE reportAssignments.deletedOn is null AND storyID = $storyID GROUP BY reportAssignments.assignmentID ORDER BY reportAssignments.assignmentID DESC;");
        while($assignment = $getAssignments->fetch_assoc()) {
            $assignment["daysLeft"] = ($assignment["endDate"] != NULL ? round((strtotime($assignment["endDate"]) - time()) / (60 * 60 * 24)) : 'N/A');
            $assignmentList[] = $assignment;
        }

        $getMember = db::$con->query("SELECT reportAssignments.assignmentID,staffInfo.staffID,workAssignmentsAssignedto.assignedTo,staffInfo.firstName,staffInfo.middleName,staffInfo.lastName,startDate,endDate FROM reportAssignments LEFT JOIN workAssignmentsAssignedto ON reportAssignments.assignmentID = workAssignmentsAssignedto.assignmentID LEFT JOIN staffInfo ON staffInfo.staffID = workAssignmentsAssignedto.assignedTo WHERE storyID = $storyID AND reportAssignments.deletedOn is null");
        while($Member = $getMember->fetch_assoc()) {
            $MemberList[] = $Member;
        }
        $new_list = array_merge($assignmentList,$MemberList);
        $new_data = [];
        foreach ($new_list as $k =>$row) {
            $key = $row['assignmentID'];
            if (!array_key_exists($key, $new_data)) {
                $new_data[$key] = $row;
                $new_data[$key]['members'] = array();
            }
            // $new_data[$key]['members'][$row['assignedTo']] = $row['lastName'].' '.$row['middleName'].' '.$row['firstName'];
            $new_data[$key]['members'][$row['assignedTo']] =['staffID'=>$row['assignedTo'],'member'=>$row['lastName'].' '.$row['middleName'].' '.$row['firstName']];
            unset($new_data[$key]['assignedTo']);
            unset($new_data[$key]['firstName']);
            unset($new_data[$key]['middleName']);
            unset($new_data[$key]['lastName']);
            unset($new_data[$key]['members'][""]);
        }
        foreach ($new_data as $key => $value) {
            $new_assignmentList[] = $value;
        }
        // var_dump($new_assignmentList);
        return $new_assignmentList;
    }

    public static function loadByDateRange($startDate, $endDate) {
        $assignmentList = [];

        $getAssignments = db::$con->query("SELECT reportAssignments.assignmentID, title, reportAssignments.categoryID, category, asnStory.storyID, asnStory.story, asnEpic.epicID, asnEpic.epic, asnSaga.sagaID, asnSaga.saga, asnLegend.legendID, asnLegend.legend,reportAssignments.description,reportAssignments.estStoryPoints, workAssignmentsAssignedto.assignedTo,staffInfo.firstName,staffInfo.middleName,staffInfo.lastName, endDate, DATE(startDate) AS startingDate FROM reportAssignments LEFT JOIN (SELECT storyID, title AS story, parentID FROM storyStories LEFT JOIN storyInstances ON originalStoryID = storyID WHERE type = 'Story' GROUP BY originalStoryID DESC ORDER BY storyID, originalStoryID DESC) AS asnStory ON asnStory.storyID = reportAssignments.storyID LEFT JOIN (SELECT storyID AS epicID, title AS epic, parentID FROM storyStories LEFT JOIN storyInstances ON originalStoryID = storyID WHERE type = 'Epic' GROUP BY originalStoryID DESC ORDER BY storyID, originalStoryID DESC ) AS asnEpic ON asnEpic.epicID = asnStory.parentID LEFT JOIN (SELECT storyID AS sagaID, title AS saga, parentID FROM storyStories LEFT JOIN storyInstances ON originalStoryID = storyID WHERE type = 'Saga' GROUP BY originalStoryID DESC ORDER BY storyID, originalStoryID DESC ) AS asnSaga ON asnSaga.sagaID = asnEpic.parentID LEFT JOIN (SELECT storyID AS legendID, title AS legend, parentID FROM storyStories LEFT JOIN storyInstances ON originalStoryID = storyID WHERE type = 'Legend' GROUP BY originalStoryID DESC ORDER BY storyID, originalStoryID DESC) AS asnLegend ON asnLegend.legendID = asnSaga.parentID LEFT JOIN workCategories ON reportAssignments.categoryID = workCategories.categoryID LEFT JOIN workAssignmentsAssignedto ON reportAssignments.assignmentID = workAssignmentsAssignedto.assignmentID LEFT JOIN staffInfo ON staffInfo.staffID = workAssignmentsAssignedto.assignedTo WHERE DATE(startDate) >= '$startDate' AND endDate <= '$endDate' AND DATE(startDate) <= endDate AND reportAssignments.deletedOn is null;");
        //$getAssignments = db::$con->query("SELECT assignmentID, title, reportAssignments.categoryID, category, endDate, DATE(createdOn) AS startingDate FROM reportAssignments LEFT JOIN workCategories ON reportAssignments.categoryID = workCategories.categoryID WHERE DATE(createdOn) >= '$startDate' AND endDate <= '$endDate' AND DATE(createdOn) <= endDate;");
        while($assignment = $getAssignments->fetch_assoc()) {
            $assignmentList[] = $assignment;
        }
        // var_dump($assignmentList);

        $new_data = [];
        foreach ($assignmentList as $k =>$row) {
            $key = $row['assignmentID'];
            if (!array_key_exists($key, $new_data)) {
                $new_data[$key] = $row;
                $new_data[$key]['members'] = array();
            }
            // $new_data[$key]['members'][$row['assignedTo']] = $row['lastName'].' '.$row['middleName'].' '.$row['firstName'];
            $new_data[$key]['members'][$row['assignedTo']] =['staffID'=>$row['assignedTo'],'member'=>$row['firstName'].' '.$row['middleName'].' '.$row['lastName']];
            unset($new_data[$key]['assignedTo']);
            unset($new_data[$key]['firstName']);
            unset($new_data[$key]['middleName']);
            unset($new_data[$key]['lastName']);
        }
        foreach ($new_data as $key => $value) {
            $new_assignmentList[] = $value;
        }
        // var_dump($new_assignmentList);
        return $new_assignmentList;
    }

    /*
        $levelID can be a story id, epic id, saga id, legend id, or department id. It just needs to be labeled in the $level variable
    */
    public static function getCategories($levelID, $level) {
        if (!isValidNumber($levelID)) return Staffpanel::createError('400', 'Invalid ID', 'The id provided was not a number');
        switch ($level) {
            case 'Story':
            case 'Epic':
            case 'Saga':
                $getParentID = db::$con->query("SELECT parentID FROM storyStories WHERE storyID = $levelID;");
                if ($getParentID->num_rows == 0) return Staffpanel::createError('400', 'Empty Response', $level.'-'.$levelID.' did not return anything.');
        }
        switch ($level) {
            case 'Story':
                return self::getCategories(($getParentID->fetch_assoc())['parentID'], 'Epic');
                break;
            case 'Epic':
                return self::getCategories(($getParentID->fetch_assoc())['parentID'], 'Saga');
                break;
            case 'Saga':
                return self::getCategories(($getParentID->fetch_assoc())['parentID'], 'Legend');
                break;
            case 'Legend':
                $deptsList = [];
                $getDeptsID = db::$con->query("SELECT departmentID FROM storyLegendsLink WHERE legendID = $levelID;");
                if ($getDeptsID->num_rows == 0) return Staffpanel::createError('400', 'Empty Response', $level.'-'.$levelID.' did not return anything.');
                while ($dept = $getDeptsID->fetch_assoc()) {
                    $deptsList = array_merge($deptsList, self::getCategories($dept['departmentID'], 'Department'));
                }
                return $deptsList;
                break;
            case 'Department':
                $catList = [];
                $getCatsID = db::$con->query("SELECT categoryID, category, department FROM workCategories LEFT JOIN miscDepartments ON miscDepartments.departmentID = workCategories.departmentID WHERE workCategories.departmentID = $levelID;");
                if ($getCatsID->num_rows == 0) return Staffpanel::createError('400', 'Empty Response', $level.'-'.$levelID.' did not return anything.');
                while ($cat = $getCatsID->fetch_assoc()) {
                    $catList[] = $cat;
                }
                return $catList;
                break;
            default: return Staffpanel::createError('400', 'Invalid Section Type', 'The type provided was invalid.');
        }
    }
    public static function getAssignment($assignmentID) {
        $getAssignment = db::$con->query("SELECT reportAssignments.assignmentID,assignedBy,title,description,categoryID,storyID,startDate,endDate,estStoryPoints,repeatAssignment,staffInfo.avatar,staffInfo.firstName,staffInfo.middleName,staffInfo.lastName, workAssignmentsAssignedto.assignedTo FROM reportAssignments LEFT JOIN workAssignmentsAssignedto ON reportAssignments.assignmentID = workAssignmentsAssignedto.assignmentID LEFT JOIN staffInfo ON staffInfo.staffID = workAssignmentsAssignedto.assignedTo WHERE reportAssignments.assignmentID = $assignmentID ;");
        while ($Assignment = $getAssignment->fetch_assoc()) {
            $AssignmentList[] = $Assignment;
        }
        $new_data = [];
        foreach ($AssignmentList as $k =>$row) {
            $key = $row['assignmentID'];
            if (!array_key_exists($key, $new_data)) {
                $new_data[$key] = $row;
                $new_data[$key]['members'] = array();
            }
            // $new_data[$key]['members'][$row['assignedTo']] = $row['lastName'].' '.$row['middleName'].' '.$row['firstName'];
            $new_data[$key]['members'][$row['assignedTo']] =['staffID'=>$row['assignedTo'],'member'=>$row['lastName'].' '.$row['middleName'].' '.$row['firstName'],'avatar'=>$row['avatar']];
            unset($new_data[$key]['assignedTo']);
            unset($new_data[$key]['firstName']);
            unset($new_data[$key]['middleName']);
            unset($new_data[$key]['lastName']);
            unset($new_data[$key]['avatar']);
        }
        foreach ($new_data as $key => $value) {
            $new_assignmentList[] = $value;
        }
        return $new_assignmentList;
    }

    public static function createCategories($levelID,$level,$category) {
        if (!isValidNumber($levelID)) return Staffpanel::createError('400', 'Invalid ID', 'The id provided was not a number');
        switch ($level) {
            case 'Story':
            case 'Epic':
            case 'Saga':
                $getParentID = db::$con->query("SELECT parentID FROM storyStories WHERE storyID = $levelID;");
                if ($getParentID->num_rows == 0) return Staffpanel::createError('400', 'Empty Response', $level.'-'.$levelID.' did not return anything.');
        }
        switch ($level) {
            case 'Story':
                return self::createCategories(($getParentID->fetch_assoc())['parentID'], 'Epic',$category);
                break;
            case 'Epic':
                return self::createCategories(($getParentID->fetch_assoc())['parentID'], 'Saga',$category);
                break;
            case 'Saga':
                return self::createCategories(($getParentID->fetch_assoc())['parentID'], 'Legend',$category);
                break;
            case 'Legend':
                $deptsList = [];
                $getDeptsID = db::$con->query("SELECT departmentID FROM storyLegendsLink WHERE legendID = $levelID;");
                if ($getDeptsID->num_rows == 0) return Staffpanel::createError('400', 'Empty Response', $level.'-'.$levelID.' did not return anything.');
                while ($dept = $getDeptsID->fetch_assoc()) {
                    $deptsList = array_merge($deptsList, self::createCategories($dept['departmentID'], 'Department',$category));
                }
                return $deptsList;
                break;
            case 'Department':
                $addCategories = db::$con->prepare("INSERT INTO workCategories (departmentID, category, addedBy) VALUES (?,?,?);");
                $addCategories->bind_param('iss', $levelID, $category, StaffMember::$me['staffID']);
                if ($addCategories->execute()) {
                    $categoryID = $addCategories->insert_id;
                    return array('categoryID'=>$categoryID);
                }else{
                    $addCategories->close();
                    return Staffpanel::createError('408','System Error','An error occured with adding the Categories.');
                }
                break;
            default: return Staffpanel::createError('400', 'Invalid Section Type', 'The type provided was invalid.');
        }



    }



    public static function fetchByDates($queryParams) {

        if (!checkdate($queryParams['fromDate']['month'], $queryParams['fromDate']['day'], $queryParams['fromDate']['year'])) Staffpanel::createError('500','Invalid From Date','The From Date is not valid.');
        else if (!checkdate($queryParams['toDate']['month'], $queryParams['toDate']['day'], $queryParams['toDate']['year'])) Staffpanel::createError('500','Invalid To Date','The To Date is not valid.');

        $fromDate = $queryParams['fromDate']['year'].'-'.$queryParams['fromDate']['month'].'-'.$queryParams['fromDate']['day'];
        $toDate = $queryParams['toDate']['year'].'-'.$queryParams['toDate']['month'].'-'.$queryParams['toDate']['day'];

        $responseJSON = [];
        //later check for role and permissions
        $getAssignments = db::$con->prepare("SELECT sagas.storyID, reportAssignments.assignmentID, reportAssignments.title, reportAssignments.startDate, reportAssignments.endDate FROM reportAssignments LEFT JOIN storyStories ON storyStories.storyID = reportAssignments.storyID LEFT JOIN (SELECT storyID, parentID FROM storyStories) AS epics ON epics.storyID = storyStories.parentID LEFT JOIN (SELECT storyID, parentID FROM storyStories) AS sagas ON sagas.storyID = epics.parentID WHERE startDate <= ? AND endDate >= ? ORDER BY sagas.storyID, startDate");
        $getAssignments->bind_param("ss", $fromDate, $toDate);
        $getAssignments->execute();
        $getAssignments->bind_result($storyID, $assignmentID, $assignmentTitle, $startDate, $endDate);
        while ($getAssignments->fetch()) {
            $responseJSON[] = array('storyID'=>$storyID, 'assignmentID'=>$assignmentID, 'assignmentTitle'=>$assignmentTitle, 'startDate'=>$startDate, 'endDate'=>$endDate);
        }
        $getAssignments->close();

        return $responseJSON;
    }

    public static function editAssignment($assignmentID, $assignmentDetails) {
        if (!isValidNumber($assignmentID) || !Assignment::valAssignment($assignmentID)) return Staffpanel::createError('400','Invalid Assignment ID','The assignment id was invalid or not an id.');
        if (!Assignment::canModify($assignmentID)) return Staffpanel::createError('403','Invalid Permissions','You do not have permission to access this assignment.');

        if (!isset($assignmentDetails['title'])) return Staffpanel::createError('400','Missing Input','The assignment title cannot be blank.');
        else if (strlen($assignmentDetails['title']) > 100) return Staffpanel::createError('400','Lengthy Title','The title is too long (max 100 characters).');
        else if (!isset($assignmentDetails['desc'])) return Staffpanel::createError('400','Missing Input','The assignment description cannot be blank.');
        else if (!isset($assignmentDetails['category'])) return Staffpanel::createError('400','Missing Input','Please pick a category.');
        else if (!isset($assignmentDetails['startDate'])) return Staffpanel::createError('400','Missing Input','The start date cannot be blank.');
        else if (!isset($assignmentDetails['storyPoints']) || $assignmentDetails['storyPoints'] < 1 || $assignmentDetails['storyPoints'] > 10) return Staffpanel::createError('400','Missing Input','Invalid Story Points.');
        else if ((!isset($assignmentDetails['endDate']) || strlen($assignmentDetails['endDate']) != 8)) return Staffpanel::createError('400','Invalid Input','Please choose either the end date or that the assignment is repeating.');
        else if (isset($assignmentDetails['endDate'])) {
            $endDateVal = DateTime::createFromFormat('d/m/y',$assignmentDetails['endDate']);
            if (!($endDateVal && $endDateVal->format('d/m/y') == $assignmentDetails['endDate'])) return Staffpanel::createError('400','Invalid Date','The end date is invalid (DD/MM/YY).');
            $assignmentDetails['endDate'] = $endDateVal->format('Y-m-d');
        } else
            $assignmentDetails['endDate'] = NULL;

        $startDateVal = DateTime::createFromFormat('d/m/y',$assignmentDetails['startDate']);
        if (!($startDateVal && $startDateVal->format('d/m/y') == $assignmentDetails['startDate'])) return Staffpanel::createError('400','Invalid Date','The start date is invalid (DD/MM/YY).');
        $assignmentDetails['startDate'] = $startDateVal->format('Y-m-d');

        Project::loadProject(Projects::getProjectByChild($assignmentID, 'Assignment'));
        $staffList = Project::getProjectParticipants();
        $staffIDs = [];

        foreach($assignmentDetails['staff'] as $staff) {
            if (!isValidNumber($staff['staffID'])) return Staffpanel::createError('400','Invalid Staff ID','A staff id is invalid.');
            if (!isset($staffList[$staff['staffID']])) return Staffpanel::createError('400','Invalid Staff Member',$staff['name'].' has not been given permissions for this project.');
            $staffIDs[] = $staff['staffID'];
        }

        $addAssignment = db::$con->prepare("UPDATE reportAssignments SET assignedBy = ?, title = ?, description = ?, categoryID = ?, storyID = ?, startDate = ?, endDate = ?, estStoryPoints = ?, repeatAssignment = ? WHERE assignmentID = ?;");
        $addAssignment->bind_param('issiissiii', StaffMember::$me['staffID'], $assignmentDetails['title'], $assignmentDetails['desc'], $assignmentDetails['category'], $assignmentDetails['storyID'], $assignmentDetails['startDate'], $assignmentDetails['endDate'], $assignmentDetails['storyPoints'], $assignmentDetails['repeat'], $assignmentID);
        if ($addAssignment->execute()) {
            $addAssignment->close();


            $insertQuery = '';
            if (isset($assignmentDetails['staff']) && count($assignmentDetails['staff']) > 0) {
                $insertQuery = '('.$assignmentID.','.implode('),('.$assignmentID.',',$staffIDs).');';

                if (db::$con->multi_query("CREATE TEMPORARY TABLE staffAssigned
                    (
                        asID INT,
                        staff INT
                    );

                    INSERT INTO staffAssigned VALUES $insertQuery;

                    UPDATE workAssignmentsAssignedto SET unassignedOn = CURRENT_TIMESTAMP WHERE assignmentID = $assignmentID;

                    INSERT INTO workAssignmentsAssignedto (assignmentID, assignedto)
                    SELECT * FROM staffAssigned
                    ON DUPLICATE KEY UPDATE unassignedOn = NULL;

                    DROP TABLE staffAssigned;"))
                    echo true;
                else
                    return Staffpanel::createError('408','Error Assigning Staff','An error with the server occured while assigning staff members.');
            }

            return array('assignmentID'=>$assignmentID);
        } else {
            $addAssignment->close();
            return Staffpanel::createError('408','System Error','An error occured with adding the assignment.');
        }
    }
    public static function updateAssignment($assignmentID, $assignmentDetails) {
        // var_dump($_POST);exit;
        // if (!isValidNumber($assignmentID) || !Assignment::valAssignment($assignmentID)) return Staffpanel::createError('400','Invalid Assignment ID','The assignment id was invalid or not an id.');
        if (!Assignment::canModify($assignmentID)) return Staffpanel::createError('403','Invalid Permissions','You do not have permission to access this assignment.');

        if (!isset($assignmentDetails['title'])) return Staffpanel::createError('400','Missing Input','The assignment title cannot be blank.');
        else if (strlen($assignmentDetails['title']) > 100) return Staffpanel::createError('400','Lengthy Title','The title is too long (max 100 characters).');
        else if (!isset($assignmentDetails['desc'])) return Staffpanel::createError('400','Missing Input','The assignment description cannot be blank.');
        else if (!isset($assignmentDetails['category'])) return Staffpanel::createError('400','Missing Input','Please pick a category.');
        else if (!isset($assignmentDetails['startDate'])) return Staffpanel::createError('400','Missing Input','The start date cannot be blank.');
        else if (!isset($assignmentDetails['storyPoints']) || $assignmentDetails['storyPoints'] < 1 || $assignmentDetails['storyPoints'] > 10) return Staffpanel::createError('400','Missing Input','Invalid Story Points.');
        else if ((!isset($assignmentDetails['endDate']) || strlen($assignmentDetails['endDate']) != 8)) return Staffpanel::createError('400','Invalid Input','Please choose either the end date or that the assignment is repeating.');
        else if (isset($assignmentDetails['endDate'])) {
            $endDateVal = DateTime::createFromFormat('d/m/y',$assignmentDetails['endDate']);
            if (!($endDateVal && $endDateVal->format('d/m/y') == $assignmentDetails['endDate'])) return Staffpanel::createError('400','Invalid Date','The end date is invalid (DD/MM/YY).');
            $assignmentDetails['endDate'] = $endDateVal->format('Y-m-d');
        } else
            $assignmentDetails['endDate'] = NULL;

        $startDateVal = DateTime::createFromFormat('d/m/y',$assignmentDetails['startDate']);
        if (!($startDateVal && $startDateVal->format('d/m/y') == $assignmentDetails['startDate'])) return Staffpanel::createError('400','Invalid Date','The start date is invalid (DD/MM/YY).');
        $assignmentDetails['startDate'] = $startDateVal->format('Y-m-d');

        Project::loadProject(Projects::getProjectByChild($assignmentID, 'Assignment'));
        $staffList = Project::getProjectParticipants();
        $staffIDs = [];

        foreach($assignmentDetails['staff'] as $staff) {
            if (!isValidNumber($staff['staffID'])) return Staffpanel::createError('400','Invalid Staff ID','A staff id is invalid.');
            if (!isset($staffList[$staff['staffID']])) return Staffpanel::createError('400','Invalid Staff Member',$staff['name'].' has not been given permissions for this project.');
            $staffIDs[] = $staff['staffID'];
        }
        $addAssignment = db::$con->prepare("UPDATE reportAssignments SET assignedBy = ?, title = ?, description = ?, categoryID = ?, storyID = ?, startDate = ?, endDate = ?, estStoryPoints = ?, repeatAssignment = ? WHERE assignmentID = ?;");
        $addAssignment->bind_param('issiissiii', StaffMember::$me['staffID'], $assignmentDetails['title'], $assignmentDetails['desc'], $assignmentDetails['category'], $assignmentDetails['storyID'], $assignmentDetails['startDate'], $assignmentDetails['endDate'], $assignmentDetails['storyPoints'], $assignmentDetails['repeat'], $assignmentID);

        if ($addAssignment->execute()) {
            $addAssignment->close();


            $insertQuery = '';
            if (isset($assignmentDetails['staff']) && count($assignmentDetails['staff']) > 0) {
                $insertQuery = '('.$assignmentID.','.implode('),('.$assignmentID.',',$staffIDs).');';

                if (db::$con->multi_query("CREATE TEMPORARY TABLE staffAssigned
                    (
                        asID INT,
                        staff INT
                    );

                    INSERT INTO staffAssigned VALUES $insertQuery;

                    UPDATE workAssignmentsAssignedto SET unassignedOn = CURRENT_TIMESTAMP WHERE assignmentID = $assignmentID;

                    INSERT INTO workAssignmentsAssignedto (assignmentID, assignedto)
                    SELECT * FROM staffAssigned
                    ON DUPLICATE KEY UPDATE unassignedOn = NULL;

                    DROP TABLE staffAssigned;"))
                    echo true;
                else
                    return Staffpanel::createError('408','Error Assigning Staff','An error with the server occured while assigning staff members.');
            }

            return array('assignmentID'=>$assignmentID);
        } else {
            $addAssignment->close();
            return Staffpanel::createError('408','System Error','An error occured with adding the assignment.');
        }
    }

    public static function delAssignment($assignmentID) {
        $delAssignment = db::$con->prepare("UPDATE reportAssignments SET deletedBy = ?, deletedOn = CURRENT_TIMESTAMP WHERE assignmentID = ?;");
        $delAssignment->bind_param('ii', StaffMember::$me['staffID'], $assignmentID);
        if ($delAssignment->execute()) {
            return true;

            // $getstory = db::$con->query("SELECT storyID FROM reportAssignments WHERE assignmentID = $assignmentID;");
            // $getstoryID = $getstory->fetch_assoc();
            // // var_dump($getstoryID['storyID']);
            // // $storyID = '606';
            // $delstoryInstances = db::$con->prepare("UPDATE storyInstances SET removedBy = ?, removedOn = CURRENT_TIMESTAMP WHERE originalStoryID = ?;");
            // $delstoryInstances->bind_param('is', StaffMember::$me['staffID'], $getstoryID['storyID']);
            // if ($delstoryInstances->execute()) {
            //     return true;
            // } else {
            //     $delAssignment->close();
            //     return Staffpanel::createError('408','System Error','An error occured with failed to delete');
            // }
        } else {
            $delAssignment->close();
            return Staffpanel::createError('408','System Error','An error occured with failed to delete');
        }
    }
}
?>