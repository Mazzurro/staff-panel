<?php


    set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname(dirname($_SERVER['DOCUMENT_ROOT']))) . "/php" . PATH_SEPARATOR . get_include_path());
require_once "Mail.php";
require 'Mail/mime.php';

$host = "mail.72dragons.com";
$username = "donotreply@72dragons.com";
$password = "bM3okvff1334!!!";
$port = "25";
$to = "davidmoreno@72dragons.com, drpietroaparicio@72dragons.com, bradleycmiller@72dragons.com, nageshanjayya@72dragons.com, will@72dragons.com, gairik@72dragons.com, purvi@72dragons.com";
$email_from = "72 Dragons <donotreply@72dragons.com>";
$email_subject = "[".date("Y-m-d")."] Daily Social Media Analytics";
$email_body = '<head>
</head>
<body id="body">
<h3>Good Morning/Evening</h3>
<p>Attached are yesterdays analytics from the 72 Dragons Facebook and Instagram Page</p>
<p><b>Currently post analytics are unable to display their photo, so they will be omitted for the meantime to prevent possible confusion.</b></p>
<br>
<p>Have a nice day!</p>
<h6>This email is generated daily and sent from the server. Any replies to this email will not be seen.</h6>
</body>
';
$email_address = "donotreply@72dragons.com";

$headers = array ('From' => $email_from, 'To' => $to, 'Subject' => $email_subject, 'Reply-To' => $email_address);
$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => 'PLAIN', 'socket_options' => array('ssl' => array('verify_peer_name' => false)), 'username' => $username, 'password' => $password));


$mime = new Mail_mime(array('eol' => "\n"));
$mime->setTXTBody('');
$mime->setHTMLBody($email_body);
foreach($_GET['filenames'] as $aFile) {
    $theNewFileName = str_replace('.html', '', $aFile);
    file_put_contents('./'.$theNewFileName,file_get_contents('http://45.32.72.219/pdfs/'.$aFile));
    $mime->addAttachment('./'.$theNewFileName, 'application/pdf');
}
$body = $mime->get();
$hdrs = $mime->headers($headers);


$mail = $smtp->send($to, $hdrs, $body);
//$mail = $smtp->send("drpietroaparicio@72dragons.com, bradleycmiller@72dragons.com, nageshanjayya@72dragons.com", $hdrs, $body);
//$mail = $smtp->send("morenoda96@gmail.com", $hdrs, $body);


if (PEAR::isError($mail)) {
    echo("<p>" . $mail->getMessage() . "</p>");
} else {
    echo("<p>Message successfully sent!</p>");
}
?>