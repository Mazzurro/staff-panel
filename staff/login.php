<?php
include($_SERVER['DOCUMENT_ROOT']."/staff/php-v2/phpHead.php"); Staffpanel::setClearLevel(0);

if (isset($_SESSION["me"]["staffID"])) {
  if (isset($_GET["red"]))
    header('Location: http://192.168.50.90'.$_GET["red"]);
  else
    header('Location: http://192.168.50.90/staff/panel.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = StaffMember::loginStaff($_POST["sUser"], $_POST["sPass"], $_POST["tk"], (isset($_GET["red"]) ? $_GET["red"] : null));
}

if (!isset($_SESSION["tokens"]["login"])) {
    $_SESSION["tokens"]["login"] = md5(uniqid(rand(), TRUE));
}
// var_dump($_SESSION);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
    <title>Login - 72 Dragons Staff</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="manifest" href="manifest.json">
    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto:100,300" rel="stylesheet">
    <link type="text/css" href="/staff/panel.css" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.4/js/all.js"></script>

</head>
<body>
<div class="background logo"></div>
<div id="login-container" class="fullscreen-shade">
    <div class="box">
        <div class="box-head">
            <h4>72 Dragons Staff Example Login</h4>
        </div>
        <div class="box-content">
            <?php if (isset($error)) echo $error; ?>
            <form id="createAccount" action="login.php<?php if (isset($_GET["red"])) echo "?red=".$_GET["red"]; ?>" method="post">
                <div class="input-box">
                    <div class="input-head">
                        <h5>Username</h5>
                    </div>
                    <div class="input-content">
                        <input class="input-item-text" type="text" name="sUser">
                    </div>
                </div>
                <div class="input-box">
                    <div class="input-head">
                        <h5>Password</h5>
                    </div>
                    <div class="input-content">
                        <input class="input-item-text" type="password" name="sPass">
                    </div>
                </div>
                <input type="hidden" name="tk" value="<?php echo $_SESSION["tokens"]["login"]; ?>">
                <button>Submit</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
 $('#createAccount').submit(function (e) {
   var formSubmit = true;
   $(this).find('.submit').html('<i class="fas fa-spinner fa-spin"></i>');
   $('.input-req').each(function () {
     var inputVal = $(this).find('input').val(), inputField = $(this).find('input'), inputError = $(this).find('.input-error-msg');

     if (!inputVal) {
       inputField.addClass('input-error');
       inputError.text('This Field Is Required');
       formSubmit = false;
     } else if (inputField.hasClass('input-error')) {
       inputField.removeClass('input-error');
       inputError.empty();
     }

   });
   if (!formSubmit) {
     $(this).find('.submit').html('Submit');
     $(document).scrollTop(0);
     e.preventDefault();
   }
 });
});
</script>
</body>
</html>

<?php include($_SERVER['DOCUMENT_ROOT']."/staff/php-v2/phpFoot.php"); ?>
