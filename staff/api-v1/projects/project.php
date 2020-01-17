<?php
class Project {
    public static $projectInfo;
    private static $projectID;
    private static $userPermLevel = false;

    public static function createProject($projectData) {
        // if (isset($projectData["sagaID"])) {
        //     if (!isValidNumber($projectData["sagaID"]) || !Userstories::validateStoryItem($projectData["sagaID"], 'Saga')) return Staffpanel::createError('400','Invalid Saga ID','The saga id was invalid or not an id.');
        //     if (db::$con->query("INSERT INTO projProjects (sagaID, createdBy) VALUES (".$projectData["sagaID"].",".$_SESSION["me"]["staffID"].");")) {
        //         $projectID = db::$con->insert_id;
        //         db::$con->query("INSERT INTO projParticipants (projectID, staffID, permissionLevel) VALUES ($projectID,".$_SESSION["me"]["staffID"].",4);");
        //         return $projectID;
        //     } else
        //         return Staffpanel::createError('408','Server Side Error','The project was unable to be created.');
        if (isset($projectData["title"])) {
            $sagaID = Userstories::addStoryItem('Saga', $projectData["title"], $projectData["desc"], $projectData["parentID"], null);
            if (!$sagaID) return Staffpanel::createError('400','Error Creating Project','An error occured while creating the saga. Did you leave something out?');
            db::$con->query("INSERT INTO projParticipants (sagaID, staffID, permissionLevel) VALUES ($sagaID,".$_SESSION["me"]["staffID"].",4);");
            //$projectID = self::createProject(array('sagaID'=>$sagaID['storyID']));
            //if (!$projectID) return Staffpanel::createError('400','Error Creating Project','Invalid project ID?');
            return $sagaID;
        } else return Staffpanel::createError('400','Error Creating Project','Missing information.');
    }

    public static function loadProject($projectID) {
        if (!(is_numeric($projectID) || ctype_digit($projectID))) return Staffpanel::createError('400','Error Loading Project','Invalid project ID');
        self::$projectID = $projectID;
        self::$userPermLevel = self::canAccessProject();
        if (!self::$userPermLevel) return Staffpanel::createError('403','Insufficient Permissions','You do not have permission to access this project.');

        //$getProjectInfo = db::$con->query("SELECT projectID, sagaID, startDate, endDate, coverPhoto, title, description, department FROM `projProjects` LEFT JOIN storyStories ON sagaID = storyID LEFT JOIN storyLegendsLink ON legendID = parentID LEFT JOIN miscDepartments ON miscDepartments.departmentID = storyLegendsLink.departmentID LEFT JOIN storyInstances ON sagaID = originalStoryID WHERE projProjects.removedBy IS NULL AND projectID = $projectID  ORDER BY storyInstanceID DESC LIMIT 0,1;");
        $getProjectInfo = db::$con->query("SELECT originalStoryID AS projectID, title, description, updatedBy, updatedOn, type, createdBy, createdOn FROM storyInstances LEFT JOIN storyStories ON storyID = originalStoryID WHERE originalStoryID = $projectID AND removedBy IS NULL ORDER BY storyInstanceID DESC LIMIT 0,1;");
        if ($getProjectInfo->num_rows == 0) return Staffpanel::createError('400','Error Loading Project','The project does not exist.');

        self::$projectInfo = $getProjectInfo->fetch_assoc();
        return self::$projectInfo;
    }

    public static function overview() {
        $epicList = Userstories::getEpics(self::$projectID);
        $storyList = [];

        foreach($epicList as $epicKey => $epic) {
            $epicList[$epicKey]["stories"] = Userstories::getStories($epicKey);
            foreach($epicList[$epicKey]["stories"] as $storyKey => $story) {
                array_push($storyList, $storyKey);
            }
        }

        $storyList = self::bulkFetchAssignments($storyList);
        if (!$storyList) return false;


        foreach($epicList as $epicKey => $epic) {
            foreach($epic["stories"] as $storyKey => $story) {
                if (isset($storyList[$storyKey])) {
                    $epicList[$epicKey]["stories"][$storyKey]["assignmentCount"] = ($storyList[$storyKey]["totalAssignments"] != '' ? $storyList[$storyKey]["totalAssignments"] : 0);
                    $epicList[$epicKey]["stories"][$storyKey]["userCount"] = ($storyList[$storyKey]["totalUsers"] != '' ? $storyList[$storyKey]["totalUsers"] : 0);
                    $epicList[$epicKey]["stories"][$storyKey]["percentComplete"] = ($storyList[$storyKey]["completed"] != '' ? $storyList[$storyKey]["completed"] : 0);
                }
            }
        }

        return $epicList;
    }

    private static function bulkFetchAssignments($storyList) {
        if (count($storyList) == 0) return true;
        for ($i = 0; $i < count($storyList); $i++) {
            if (!ctype_digit($storyList[$i])) return false;
        }
        $storyList = implode(',', $storyList);
        $detailList = [];

        $getStoryOverview = db::$con->query("SELECT storyStories.storyID, COUNT(reportAssignments.assignmentID) as totalAssignments, COUNT(DISTINCT workAssignmentsAssignedto.assignedTo) as totalUsers, SUM(percentComplete) as completed FROM storyStories LEFT JOIN reportAssignments ON reportAssignments.storyID = storyStories.storyID LEFT JOIN workAssignmentsAssignedto ON workAssignmentsAssignedto.assignmentID = reportAssignments.assignmentID LEFT JOIN (SELECT MAX(updt.updateID) as updtID, updt.assignmentID, updt.percentComplete FROM reportAssignmentsUpdate AS updt WHERE updt.removedBy IS NULL GROUP BY updt.assignmentID DESC ORDER BY updtID) as updateAssignments ON updateAssignments.assignmentID = reportAssignments.assignmentID WHERE storyStories.storyID IN ($storyList) GROUP BY reportAssignments.storyID;");
        while ($story = $getStoryOverview->fetch_assoc()) {
            $detailList[$story["storyID"]] = $story;
            if ($detailList[$story["storyID"]]["completed"] == '') $detailList[$story["storyID"]]["completed"] = 0;
            else $detailList[$story["storyID"]]["completed"] = $detailList[$story["storyID"]]["completed"] / $detailList[$story["storyID"]]["totalAssignments"];
        }

        return $detailList;
    }

    private static function canAccessProject() {

        if (StaffMember::hasPerms('*',[1])) return 5;
        $checkAccess = db::$con->query("SELECT permissionLevel FROM projParticipants WHERE sagaID = ".self::$projectID." AND staffID = ".StaffMember::$me['staffID']." AND removedBy IS NULL;");
        if ($checkAccess->num_rows == 0) return false;
        else {
            $canAccess = $checkAccess->fetch_assoc();
            return $canAccess['permissionLevel'];
        }
    }

    public static function hasPermissionLevel($level) {
        return (self::$userPermLevel >= $level);
    }

    public static function getProjectParticipants() {
        $partsList = [];

        $getParts = db::$con->query("SELECT staffInfo.staffID, firstName, middleName, lastName, avatar, permissionLevel FROM projParticipants LEFT JOIN staffInfo ON staffInfo.staffID = projParticipants.staffID WHERE projParticipants.sagaID = ".self::$projectID." AND removedBy IS NULL;");
        while ($part = $getParts->fetch_assoc()) {
            $partsList[$part['staffID']] = $part;
        }

        return $partsList;
    }

    public static function getProjectParticipantsByDepartment($deptID) {
        if (!isValidNumber($deptID)) return Staffpanel::createError('400','Invalid Department','The department is invalid.');
        $partsList = [];

        $getParts = db::$con->query("SELECT staffInfo.staffID, firstName, middleName, lastName, avatar, permissionLevel FROM projParticipants LEFT JOIN staffInfo ON staffInfo.staffID = projParticipants.staffID LEFT JOIN linkRoles ON linkRoles.staffID = staffInfo.staffID LEFT JOIN miscRoles ON miscRoles.roleID = linkRoles.roleID WHERE projParticipants.sagaID = ".self::$projectID." AND miscRoles.departmentID = $deptID AND removedBy IS NULL;");
        while ($part = $getParts->fetch_assoc()) {
            $partsList[$part['staffID']] = $part;
        }

        return $partsList;
    }

    public static function assignToProject($staffList) {
        // var_dump($staffList);exit;
        $insertQuery = '';
        foreach($staffList as $key => $item) {
            if (!isValidNumber($key) || !isValidNumber($item)) return Staffpanel::createError('400','Invalid ID','One or many of the ids provided are invalid.');
            if ($item == '0')
                $insertQuery .= ($insertQuery == '' ? '' : ',')."(".self::$projectID.",$key,$item,".StaffMember::$me['staffID'].",1,".StaffMember::$me['staffID'].",CURRENT_TIMESTAMP)";
            else
                $insertQuery .= ($insertQuery == '' ? '' : ',')."(".self::$projectID.",$key,$item,".StaffMember::$me['staffID'].",1,NULL,NULL)";
        }

        if (db::$con->multi_query("CREATE TEMPORARY TABLE staffAssigned
                            (
                            	sagID INT,
                            	staff INT,
                            	permLevel INT,
                            	assignedBy INT,
                            	isAct INT NULL,
                            	deletedBy INT NULL,
                            	deletedOn TIMESTAMP NULL
                            );

                            INSERT INTO staffAssigned VALUES $insertQuery;

                            INSERT INTO projParticipants (sagaID, staffID, permissionLevel, addedBy, isActive, removedBy, removedOn)
                            SELECT * FROM staffAssigned
                            ON DUPLICATE KEY UPDATE permissionLevel = permLevel, isActive = CASE WHEN deletedBy IS NULL THEN 1 ELSE NULL END, removedBy = CASE WHEN deletedBy IS NULL THEN NULL ELSE deletedBy END, removedOn = CASE WHEN deletedBy IS NULL THEN NULL ELSE deletedOn END;

                            DROP TABLE staffAssigned;"))
            echo true;
        else
            return Staffpanel::createError('408','Error Assigning Staff','An error with the server occured while assigning staff members.');
    }
}
?>