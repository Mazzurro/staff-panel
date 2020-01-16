<?php
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/projects/userstories/index.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/projects/project.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/projects/assignments/index.php');
class Projects {


    public static function getProjects($page, $amount) {
        if (!(is_numeric($page) || ctype_digit($page)) || !(is_numeric($amount) || ctype_digit($amount))) return false;
        if ($amount > 20) $amount = 20;
        else if ($amount < 1) $amount = 1;
        if ($page < 1) $page = 1;
        $page = ($page-1) * $amount;
        $projectList = [];

        if (StaffMember::hasPerms('*',[1]))
            $getProjectList = db::$con->query("SELECT storyStories.storyID, storyStories.TYPE, storyInstances.storyInstanceID, storyInstances.title, storyInstances.description, CONCAT(firstName, ' ', lastName) AS updatedBy, storyInstances.updatedOn, COUNT(reportAssignments.assignmentID) AS numOfAssignments, (SUM(theUpdates.percentComplete) / COUNT(theUpdates.updateID)) AS totalPercent FROM storyInstances LEFT JOIN staffInfo ON staffID = updatedBy JOIN( SELECT MAX(inst.storyInstanceID) AS styInt, inst.originalStoryID FROM storyInstances AS inst WHERE inst.removedBy IS NULL GROUP BY inst.originalStoryID ORDER BY styInt DESC ) AS lastRecord ON storyInstances.storyInstanceID = lastRecord.styInt LEFT JOIN storyStories ON storyStories.storyID = storyInstances.originalStoryID AND storyStories.storyID = lastRecord.originalStoryID AND storyStories.deletedBy IS NULL LEFT JOIN( SELECT * FROM storyStories WHERE TYPE = 'Epic' AND deletedBy IS NULL ) AS theEpics ON theEpics.parentID = storyStories.storyID LEFT JOIN( SELECT * FROM storyStories WHERE TYPE = 'Story' AND deletedBy IS NULL ) AS theStories ON theStories.parentID = theEpics.storyID LEFT JOIN reportAssignments ON reportAssignments.storyID = theStories.storyID AND reportAssignments.deletedBy IS NULL LEFT JOIN( SELECT * FROM reportAssignmentsUpdate WHERE removedBy IS NULL GROUP BY assignmentID DESC ) AS theUpdates ON theUpdates.assignmentID = reportAssignments.assignmentID WHERE storyStories.TYPE = 'Saga' GROUP BY storyStories.storyID ORDER BY storyInstances.title;");
        else
            $getProjectList = db::$con->query("SELECT storyStories.storyID, storyStories.TYPE, storyInstances.storyInstanceID, storyInstances.title, storyInstances.description, CONCAT(firstName, ' ', lastName) AS updatedBy, storyInstances.updatedOn, COUNT(reportAssignments.assignmentID) AS numOfAssignments, (SUM(theUpdates.percentComplete) / COUNT(theUpdates.updateID)) AS totalPercent FROM storyInstances LEFT JOIN staffInfo ON staffID = updatedBy JOIN( SELECT MAX(inst.storyInstanceID) AS styInt, inst.originalStoryID FROM storyInstances AS inst WHERE inst.removedBy IS NULL GROUP BY inst.originalStoryID ORDER BY styInt DESC ) AS lastRecord ON storyInstances.storyInstanceID = lastRecord.styInt LEFT JOIN storyStories ON storyStories.storyID = storyInstances.originalStoryID AND storyStories.storyID = lastRecord.originalStoryID AND storyStories.deletedBy IS NULL LEFT JOIN( SELECT * FROM storyStories WHERE TYPE = 'Epic' AND deletedBy IS NULL ) AS theEpics ON theEpics.parentID = storyStories.storyID LEFT JOIN( SELECT * FROM storyStories WHERE TYPE = 'Story' AND deletedBy IS NULL ) AS theStories ON theStories.parentID = theEpics.storyID LEFT JOIN reportAssignments ON reportAssignments.storyID = theStories.storyID AND reportAssignments.deletedBy IS NULL LEFT JOIN( SELECT * FROM reportAssignmentsUpdate WHERE removedBy IS NULL GROUP BY assignmentID DESC ) AS theUpdates ON theUpdates.assignmentID = reportAssignments.assignmentID RIGHT JOIN (SELECT * FROM projParticipants WHERE removedBy IS NULL AND staffID = ".StaffMember::$me['staffID']." GROUP BY sagaID, staffID DESC) AS projPart ON projPart.sagaID = lastRecord.originalStoryID AND projPart.removedBy IS NULL WHERE storyStories.TYPE = 'Saga' GROUP BY storyStories.storyID ORDER BY storyInstances.title;");
        while ($project = $getProjectList->fetch_assoc()) {
            $projectList[] = $project;
        }
        // var_dump($projectList);
        return $projectList;
    }
    public static function editProjects($title,$description,$originalStoryID) {
        // return $_SESSION['me']['clearLevel'];
        if($_SESSION['me']['clearLevel'] == 5){
            $edit = db::$con->prepare("UPDATE storyInstances SET `title` = ?,`description` = ? WHERE (`originalStoryID` = ?)");
            $edit->bind_param('ssi',$title ,$description, $originalStoryID);
            if ($edit->execute()) {
              $edit->close();
              return "success";
            } else {
              $edit->close();
              return "error";
            }
        }else{
            return "Insufficient permissions";
        }




    }
    public static function getProjectByChild($childID, $type) {
        if (!isValidNumber($childID)) return Staffpanel::createError('400', 'Invalid '.$type.' ID', 'The '.$type.' id provided is not valid.');
        switch ($type) {
            case 'Assignment':
                $getStory = db::$con->query("SELECT parentID FROM storyStories LEFT JOIN reportAssignments ON storyStories.storyID = reportAssignments.storyID WHERE assignmentID = $childID AND reportAssignments.deletedOn IS NULL AND storyStories.deletedOn IS NULL;");
                if ($getStory->num_rows == 0) return Staffpanel::createError('400', 'Project Not Found', 'A project was not found.');
                $story = $getStory->fetch_assoc();
                return self::getProjectByChild($story["parentID"], 'Epic');
                break;
            case 'Story':
                $parentType = 'Epic';
                break;
            case 'Epic':
                $parentType = 'Saga';
                break;
            case 'Saga':
                return $childID;
                $getProject = db::$con->query("SELECT projectID FROM projProjects WHERE sagaID = $childID AND removedOn IS NULL;");
                if ($getProject->num_rows == 0) return Staffpanel::createError('400', 'Project Not Found', 'A project was not found.');
                $project = $getProject->fetch_assoc();
                return $project["projectID"];
                break;
            default:
                Staffpanel::createError('400', 'Invalid Child Type', 'The child type provided does not exist.');
        }

        $getParent = db::$con->query("SELECT parentID FROM storyStories WHERE storyID = $childID AND deletedOn IS NULL;");
        if ($getParent->num_rows == 0) return Staffpanel::createError('400', 'Project Not Found', 'A project was not found.');
        $parent = $getParent->fetch_assoc();
        return self::getProjectByChild($parent["parentID"], $parentType);
    }
}
?>