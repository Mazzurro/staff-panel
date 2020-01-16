<?php
	session_start();
include($_SERVER["DOCUMENT_ROOT"].'/staff/php-v2/functions.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/php-v2/db.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/php-v2/dbLog.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/index.php');
StaffMember::loadStaff(null);


  /*Create a fatal error and return it to the user*/
  function createError($errMsg) {
    db::disconnect();
    dbLog::disconnect();
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'Error: '.$errMsg)));
  }

  /*Create a non-fatal error and continue with the process*/
  function createNonFatalError($errMsg, $location) {
    return json_encode(array('message' => 'Error: '.$errMsg, 'errorAt' => $location));
  }

  function getHTMLHead($title) {
        echo '<title>'.$title.' - 72 Dragons Staff</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="mobile-web-app-capable" content="yes">
<link rel="manifest" href="manifest.json">

<link href="https://fonts.googleapis.com/css?family=Roboto:100,300" rel="stylesheet">
<link type="text/css" href="/staff/default.css" rel="stylesheet">
<link type="text/css" href="/staff/staff.css" rel="stylesheet">
<link type="text/css" href="/staff/temp.css" rel="stylesheet">

<link type="text/css" href="/staff/panel.css" rel="stylesheet">
<!--
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.6.3/js/all.js" integrity="sha384-EIHISlAOj4zgYieurP0SdoiBYfGJKkgWedPHH4jCzpCXLmzVsw1ouK59MuUtP4a1" crossorigin="anonymous"></script>
-->
<script  type="text/javascript" src="/staff/jquery-3.3.1.js"></script>
<script defer src="/staff/all.js"></script>
<script type="text/javascript" src="/staff/staff.js"></script>
<script type="text/javascript" src="/staff/temp.js"></script>';
  }
?>