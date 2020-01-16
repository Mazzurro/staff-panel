<?php
class Assignment {
    private static $assignmentID;

    public static function valAssignment($assignmentID) {
        $valAssignment = db::$con->query("SELECT assignmentID from reportAssignments WHERE assignmentID = ".self::$assignmentID." AND deletedOn IS NULL;");
        return ($valAssignment->num_rows > 0);
    }

    public static function canModify($assignmentID = '-1') {
        if ($assignmentID == '-1') $assignmentID = self::$assignmentID;
        if (!isValidNumber($assignmentID)) return Staffpanel::createError('400', 'Invalid Assignment ID', 'The assignment id provided is not valid.');

        Project::loadProject(Projects::getProjectByChild($assignmentID, 'Assignment'));
        $isAssigned = db::$con->query("SELECT ID from workAssignmentsAssignedto WHERE ID = ".$assignmentID."AND assignedTo = ".StaffMember::$me["staffID"]." AND unassignedOn IS NULL;");
        if ($isAssigned->num_rows > 0) return true;
        else if (Project::hasPermissionLevel(4)) return true;
        else return false;
    }

    public static function addUpdate($assignmentID, $updateDetails) {
        if (!isValidNumber($assignmentID)) return Staffpanel::createError('400', 'Invalid Assignment ID', 'The assignment id provided is not valid.');
        self::$assignmentID = $assignmentID;
        if (!self::valAssignment()) return Staffpanel::createError('400', 'Invalid Assignment', 'The assignment does not exist.');
        if (!self::canModify()) return Staffpanel::createError('403', 'Invalid Permissions', 'You do not have the correct permissions to add an update to this assignment.');

        if (!isValidNumber($updateDetails["percentComplete"]) || $updateDetails["percentComplete"] < 0 || $updateDetails["percentComplete"] > 100) return Staffpanel::createError('400', 'Invalid Input', 'The percent complete provided is invalid.');
        if (strlen($updateDetails["message"]) < 5) return Staffpanel::createError('400', 'Invalid Message Length', 'The update message is too short.');

        $addUpdate = db::$con->prepare("INSERT INTO reportAssignmentsUpdate (assignmentID, updateMessage, percentComplete, updatedBy) VALUES (?,?,?,?);");
        $addUpdate->bind_param("isii", self::$assignmentID, $updateDetails["message"], $updateDetails["percentComplete"], StaffMember::$me["staffID"]);
        if ($addUpdate->execute()) {
            $addUpdate->close();
            return true;
        } else {
            $addUpdate->close();
            return Staffpanel::createError('408', 'Server Error', 'An error occured while adding the update.');
        }
    }
    public static function viewupdates($assignmentID){
        $getUpdateList = db::$con->query("SELECT a.updateID,a.assignmentID,a.updateMessage,a.percentComplete,a.updatedOn,b.staffID,b.firstName,b.middleName,b.lastName FROM reportAssignmentsUpdate AS a LEFT JOIN staffInfo AS b ON a.updatedBy = b.staffID where assignmentID=$assignmentID order by updateID desc");
         while ($Session = $getUpdateList->fetch_assoc()) {
            $SessionList[] = $Session;
        }

        return $SessionList;
    }
}
?>