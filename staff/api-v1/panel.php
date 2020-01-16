<?php

class Staffpanel {
    private static $clearLevel = 0;
    
    public static function setClearLevel($level) {
        if ($level > 5) $level = 5;
        else if ($level < 0) $level = 0;
        self::$clearLevel = $level;
        self::valClearLevel();
    }
    
    public static function valClearLevel() {
        if (!self::hasValClearLevel()) {
            self::createError('403', 'Invalid Clearance Level', 'You do not have a high enough clearance level to access this. If you believe this to be an error, please contact your manager, department head, or David.');
        }
    }
    
    public static function hasValClearLevel() {
        return ((!isset($_SESSION["me"]["clearLevel"]) && self::$clearLevel == 0) || (isset($_SESSION["me"]["clearLevel"]) && $_SESSION["me"]["clearLevel"] >= self::$clearLevel));
    }
    
    public static function createError($type, $title, $message) {
        db::disconnect();
        switch($type) {
            case '408':
            case 408:
                header('HTTP/1.1 408 Server Side Error');
                break;
            case '400':
            case 400:
                header('HTTP/1.1 400 Bad Request');
                break;
            case '403':
            case 403:
                header('HTTP/1.1 403 Insufficient Permissions');
                break;
            case '404':
            case 404:
                header('HTTP/1.1 404 Page Not Found');
                break;
            case '440':
            case 440:
                header('HTTP/1.1 440 Session Expired');
            default:
                $type = '500';
                header('HTTP/1.1 500 Internal Server Error');
        }
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('type'=>$type, 'title'=>$title, 'message'=>$message)));
    }
}
?>