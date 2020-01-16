<?php
class Member {
    private static $staffInfo;
    
    function __construct($memberID) {
        if (!isValidNumber($memberID)) Staffpanel::createError('400', 'Invalid Staff ID', 'The staff member does not exist.');
        
        $getStaffInfo = db::$con->query("SELECT * from staffInfo WHERE staffID = $memberID");
        if ($getStaffInfo->num_rows == 0) Staffpanel::createError('400', 'Invalid Staff ID', 'The staff member does not exist.');
        self::$staffInfo = $getStaffInfo->fetch_assoc();
    }
    
    public static function getInfo() {
        return self::$staffInfo;
    }
}
?>