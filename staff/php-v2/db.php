<?php
class db {
    //Staff DB
    public static $con;
    private static $isCon = false;
    private static $addUserAttempt = 0;

    //72 Dragons DB
    public static $pubCon;
    private static $isPubCon = false;


    public static function connect() {
        if (self::$isCon) return;
        self::$con = mysqli_connect('localhost','dragon','DrDragon72!','72DragonsStaff');
        if (self::$con->connect_errno) {
            echo "Failed to connect to MySQL: (".self::$con->connect_errno.")".self::$con->connect_error;
        }
        mysqli_set_charset(self::$con, "utf8");
        self::$isCon = true;
    }
    public static function disconnect() {
        if (!self::$isCon) return;
        mysqli_close(self::$con);
        self::$isCon = false;
    }

    public static function pubConnect() {
        if (self::$isPubCon) return;
        self::$pubCon = mysqli_connect('localhost', 'dragon', 'DrDragon72!','72Dragons');
        if (self::$pubCon->connect_errno) {
            echo "Failed to connect to MySQL: (".self::$pubCon->connect_errno.")".self::$pubCon->connect_error;
        }
        mysqli_set_charset(self::$pubCon, "utf8");
        self::$isPubCon = true;
    }
    public static function pubDisconnect() {
        if (!self::$isPubCon) return;
        mysqli_close(self::$pubCon);
        self::$isPubCon = false;
    }


}

db::connect();

?>
