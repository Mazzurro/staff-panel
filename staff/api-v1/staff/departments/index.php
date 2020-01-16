<?php
class Departments {
    public static function getStaffByID($departmentID) {
        if (!isValidNumber($departmentID) || !StaffMember::hasPerms([$departmentID], [])) return createError('400', 'Invalid Department ID', 'The department id is invalid.');
        $staffList = [];
        
        $getStaffMembers = db::$con->query("SELECT staffInfo.staffID, firstName, middleName, lastName, avatar FROM staffInfo LEFT JOIN linkRoles ON staffInfo.staffID = linkRoles.staffID LEFT JOIN miscRoles ON linkRoles.roleID = miscRoles.roleID WHERE miscRoles.departmentID = $departmentID");
        while($staffMember = $getStaffMembers->fetch_assoc()) {
            $staffList[$staffMember['staffID']] = $staffMember;
        }
        return $staffList;
    }
}
?>