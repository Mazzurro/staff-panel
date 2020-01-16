<?php
class StaffMember {
    public static $me = array("staffID" => null, "depts" => null);

    //Log the staff member in by the username, password, and unique token provided. Will redirect to the url provided if the $redirect variable is not null
    public static function loginStaff($username, $password, $uniqueToken, $redirect) {
        if ($uniqueToken != $_SESSION["tokens"]["login"]) {
            dbLog::loginAttempt('IT', $uniqueToken);
            return '<div class="small-heading input-error-msg">Invalid Token.</div>';
        }
        db::pubConnect();
        $loginDetails = db::$pubCon->prepare("SELECT memberID, password FROM 72Daccounts WHERE username = ?;");
        $loginDetails->bind_param('s', $username);
        $loginDetails->execute();
        $loginDetails->bind_result($memberID, $valPass);
        $loginDetails->fetch();
        if (!isset($memberID)) {
          dbLog::loginAttempt('IU', $username);
          $loginDetails->close();
          db::pubDisconnect();
          return '<div class="small-heading input-error-msg">The Username Or Password Was Incorrect. Please Try Again.</div>';
        } else {
          if (password_verify(base64_encode($password), $valPass)) {
            $loginDetails->close();

            if (password_needs_rehash(base64_encode($valPass), PASSWORD_DEFAULT)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                db::$pubCon->query("UPDATE 72Daccounts SET password = $newHash WHERE memberID = $memberID");
            }
            db::pubDisconnect();
            $getStaffID = db::$con->query("SELECT staffID FROM staffInfo WHERE memberID = $memberID;");

            $numRows = $getStaffID->num_rows;
            if ($numRows == 0) {
                dbLog::loginAttempt('NS', $username);
                return '<div class="small-heading input-error-msg">Invalid Permissions.</div>';
            }

            dbLog::loginAttempt('LI', $username);
            $staffResult = $getStaffID->fetch_assoc();
            $_SESSION["me"]["staffID"] = $staffResult["staffID"];
            self::loadStaff($staffResult["staffID"]);

            if ($redirect != null)
              header('Location: https://72dragons.com'.$redirect);
            else
              header('Location: https://72dragons.com/staff/panel.php');
          } else {
            dbLog::loginAttempt('IP', $username);
            return '<div class="small-heading input-error-msg">The Username Or Password Was Incorrect. Please Try Again</div>';
          }
        }
    }

    //Load staff details by staff id, will try the setStaff() function if $staffID is null
    public static function loadStaff($staffID) {
        $_SESSION["me"]["clearLevel"] = 0;
        if ($staffID == null) return self::setStaff();
        if (!(is_numeric($staffID) || ctype_digit($staffID))) return false;

        self::$me["staffID"] = $staffID;

        $getClearanceLevel = db::$con->query("SELECT clearanceLevel FROM staffInfo WHERE staffID = $staffID");
        $clearanceLevel = $getClearanceLevel->fetch_assoc();
        $_SESSION["me"]["clearLevel"] = $clearanceLevel["clearanceLevel"];

        $roleList = array('departments' => [], 'roles' => [], 'subRoles' => []);
        $getRoles = db::$con->query("SELECT main.roleID AS staffRoleID, main.name AS staffRole, main.type,
    CASE
    WHEN subOf IS NULL THEN miscDepartments.departmentID
    ELSE parent.roleID
    END AS parentID,
    CASE
    WHEN subOf IS NULL THEN department
    ELSE parent.name
    END AS parent
    FROM linkRoles
    LEFT JOIN miscRoles AS main ON main.roleID = linkRoles.roleID
    LEFT JOIN miscRoles AS parent ON parent.roleID = subOf
    LEFT JOIN miscDepartments ON miscDepartments.departmentID = main.departmentID
    WHERE staffID = ".$staffID."
    ORDER BY type;");
        while($role = $getRoles->fetch_assoc()) {
          switch($role["type"]) {
            case 'Main':
              $roleList["roles"][$role["staffRoleID"]] = array('id' => $role["staffRoleID"], 'name' => $role["staffRole"]);
              $roleList["departments"][$role["parentID"]]["name"] = $role["parent"];
              $roleList["departments"][$role["parentID"]]["id"] = $role["parentID"];
              $roleList["departments"][$role["parentID"]]["children"][] = $role["staffRoleID"];
            break;
            case 'Sub':
              $roleList["subRoles"][$role["staffRoleID"]] = array('id' => $role["staffRoleID"], 'name' => $role["staffRole"]);
              $roleList["roles"][$role["parentID"]]["children"][] = $role["staffRoleID"];
            break;
          }
        }

        self::$me["depts"] = $roleList;
    }

    //Load Staff details by the staff id set in session
    private static function setStaff() {
        if (!isset($_SESSION["me"]["staffID"])) {
            if ($_SERVER["PHP_SELF"] == '/staff/login.php') return false;
            else Staffpanel::createError('440', 'Not Logged In Or Session Expired', 'Please Login');
        }
        self::loadStaff($_SESSION["me"]["staffID"]);
    }

    //If the staff member has permissions to do x
    public static function hasPerms($deptList, $roleList) {
        if (array_intersect(array_keys(self::$me["depts"]["subRoles"]), [1])) return true;
        return ((($deptList == '*') || array_intersect(array_keys(self::$me["depts"]["departments"]), $deptList)) && (($roleList == '*') || array_intersect(array_keys(self::$me["depts"]["roles"]), $roleList) || array_intersect(array_keys(self::$me["depts"]["subRoles"]), $roleList)) && Staffpanel::hasValClearLevel());
    }

    //For testing purposes
    public static function throwup() {
        print_r(self::$me);
    }
}
?>