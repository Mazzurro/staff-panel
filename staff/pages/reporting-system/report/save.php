<?php
include($_SERVER['DOCUMENT_ROOT']."/s/php/phpHead.php");

function updateReview($dbStaff, $reviewID, $review, $reportID) {
    $setReview = $dbStaff->prepare("UPDATE workReportsReviews SET review = ? WHERE graphID = ? AND reportID = ?");
    $setReview->bind_param('ssi', $review, $reviewID, $reportID);
    if ($setReview->execute())
        $setReview->close();
    else {
        $setReview->close();
        createError($dbStaff, "Unable To Save Review. Please Try Again.");
    }
}

$reportID = $_POST["reportID"];
$toValidate = 'report';
include($_SERVER['DOCUMENT_ROOT']."/s/php/validate.php");

switch ($_POST["type"]) {
    case 'review':
        updateReview($dbStaff, $_POST["reviewID"], $_POST["review"], $_POST["reportID"]);
    break;
    case 'report':
        foreach($_POST["graphID"] as $reviewID) {
            updateReview($dbStaff, $reviewID, $_POST["$reviewID"], $_POST["reportID"]);
        }
    break;
}

include($_SERVER['DOCUMENT_ROOT']."/s/php/phpFoot.php");
?>