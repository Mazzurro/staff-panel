<?php
class dbLog {
  public static $con;
  private static $isCon = false;
  private static $addUserAttempt = 0;

  public static function connect() {
    if (self::$isCon) return;
    self::$con = mysqli_connect('localhost','dragon','DrDragon72!','72DragonsLogs');
    mysqli_set_charset(self::$con, "utf8");
    self::$isCon = true;

    if (!isset($_SESSION["sessionID"]))
      self::addUser();

    if (strpos($_SERVER['REQUEST_URI'], '/staff/php-v2/') === false)
      self::pageAccessed();
    self::pingSession();
  }

  public static function disconnect() {
    if (!self::$isCon)
    mysqli_close(self::$con);
    self::$isCon = false;
  }

  private static function addUser() {
    $_SESSION["tokens"]["primary"] = md5(uniqid(rand(), TRUE));

    $registerUser = self::$con->prepare("INSERT INTO staffSession (sessionKey, browserInfo, ip) VALUES (?, ?, ?)");
    $registerUser->bind_param('sss', $_SESSION["tokens"]["primary"], $_SERVER['HTTP_USER_AGENT'], $_SERVER['REMOTE_ADDR']);
    if ($registerUser->execute()) {
      $_SESSION["sessionID"] = mysqli_stmt_insert_id($registerUser);
      $registerUser->close();
      return;
    } else {
      $registerUser->close();
      if (self::$addUserAttempt++ != 5)
        self::addUser();
    }
  }

  private static function killUser() { return;
    session_destroy();
    $_SESSION = array();
  }

  private static function pingSession() {
    self::$con->query("UPDATE staffSession SET sessionEnd = CURRENT_TIMESTAMP WHERE forceDisconnect = 0 AND sessionID = ".$_SESSION["sessionID"]);
    list($matched, $changed, $warnings) = sscanf(self::$con->info, "Rows matched: %d Changed: %d Warnings: %d");
    if ($matched == 0)
      self::killUser();
  }
  public static function forceDisconnect($sessionID) {
    $i = 1;
    $force = self::$con->prepare("UPDATE staffSession SET `forceDisconnect` = ? WHERE (`sessionID` = ?)");
    $force->bind_param('ii',$i, $sessionID);
    if ($force->execute()) {
      $force->close();
      return "success";
    } else {
      $force->close();
      return "error";
    }
  }
  private static function pageAccessed() {
    $addPage = self::$con->prepare("INSERT INTO staffPageaccess (sessionID, pageURL, prevPageURL) VALUES (?, ?, ?)");
    $addPage->bind_param('iss', $_SESSION["sessionID"], $_SERVER['REQUEST_URI'], $_SERVER['HTTP_REFERER']);
    $addPage->execute();
    $addPage->close();
  }

  /*
    Short hand for $action
      new_assnmt - new assignment
      upd_assnmt - update assignment
      del_assnmt - delete assignment
  */
  public static function action($action, $itemID, $result) {return;
    $logAction = self::$con->prepare("INSERT INTO staffAction (sessionID, action, itemID, result) VALUES (?, ?, ?, ?)");
    $logAction->bind_param('isii', $_SESSION["sessionID"], $action, $itemID, $result);
    $logAction->execute();
    $logAction->close();
  }

  public static function loginAttempt($status, $result) {
    switch ($status) {
      case 'IU':
        $addAttempt = self::$con->prepare("INSERT INTO staffLogin (sessionID, gotLoggedIn, invalidUsername, falseUsername, invalidPassword) VALUES (?, 0, 1, ?, 0)");
        $addAttempt->bind_param('is', $_SESSION["sessionID"], $result);
        break;
      case 'IP':
        $addAttempt = self::$con->prepare("INSERT INTO staffLogin (sessionID, gotLoggedIn, invalidUsername, falseUsername, invalidPassword) VALUES (?, 0, 0, ?, 1)");
        $addAttempt->bind_param('is', $_SESSION["sessionID"], $result);
        break;
      case 'LI':
        $addAttempt = self::$con->prepare("INSERT INTO staffLogin (sessionID, gotLoggedIn, loggedInAs) VALUES (?, 1, ?)");
        $addAttempt->bind_param('ii', $_SESSION["sessionID"], $result);
        break;
    }

    $addAttempt->execute();
    $addAttempt->close();
  }
}

dbLog::connect();

?>
