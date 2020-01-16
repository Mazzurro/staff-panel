<?php
	session_start();
include($_SERVER["DOCUMENT_ROOT"].'/staff/php-v2/functions.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/php-v2/db.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/php-v2/dbLog.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/index.php');
StaffMember::loadStaff(null);

if (isset($_GET["url"]) && count(explode('/',$_GET["url"])) >= 4) {
    $url = explode('/',$_GET["url"]);
    if ($url[2] == 'content') {
        switch($url[3]) {
            case 'create-projects':
                Staffpanel::setClearLevel(3);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/pages/projects/create.php');
                break;
            case 'manage-projects':
                Staffpanel::setClearLevel(1);
                if (!isset($_POST["page"]) || !isset($_POST["amount"])) {
                    $_POST["page"] = "1";
                    $_POST["amount"] = "30";
                }
                include($_SERVER["DOCUMENT_ROOT"].'/staff/pages/projects/index.php');
                break;
            case 'milestones':
                Staffpanel::setClearLevel(3);
                echo '<iframe src="http://192.168.50.90/staff/apps/projects/milestones.php"></iframe>';
                break;
            case 'project':
                Staffpanel::setClearLevel(1);
                if (!isset($_POST["projectID"]) || !isValidNumber($_POST["projectID"])) return Staffpanel::createError('400', 'Invalid Project', 'The project you are looking for does not exist');

                include($_SERVER["DOCUMENT_ROOT"].'/staff/pages/projects/project.php');
                break;
            case 'project-story':
                Staffpanel::setClearLevel(1);

                include($_SERVER["DOCUMENT_ROOT"].'/staff/pages/projects/story.php');
                break;
            case 'create-reports':
                Staffpanel::setClearLevel(0);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/pages/report.php');
                break;
            case 'manage-reports':
                Staffpanel::setClearLevel(3);
                if (!isset($_POST["queryData"])) $_POST["queryData"] = array("departments"=>array_keys(StaffMember::$me["depts"]["departments"]));
                if (!isset($_POST["page"])) $_POST["page"] = "1";
                if (!isset($_POST["amount"])) $_POST["amount"] = "30";

                include($_SERVER["DOCUMENT_ROOT"].'/staff/pages/reporting-system/report/browse.php');
                break;
            case 'run-rate':
               Staffpanel::setClearLevel(2);
               include($_SERVER["DOCUMENT_ROOT"].'/staff/pages/planning/run-rate.php');
               break;
           case 'staff-planning':
              Staffpanel::setClearLevel(2);
              include($_SERVER["DOCUMENT_ROOT"].'/staff/pages/planning/staff-planning.php');
              break;
           case 'revenue':
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/pages/planning/revenue.php');
                break;
            case 'social-media-planning':
                  Staffpanel::setClearLevel(2);
                  include($_SERVER["DOCUMENT_ROOT"].'/staff/pages/planning/social-media.php');
                  break;
            case 'create-stories':
                Staffpanel::setClearLevel(2);
                break;
            case 'manage-stories':
                Staffpanel::setClearLevel(2);
                break;
            case 'social-media-schedule':
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/pages/social-media/posting-schedule.php');
                break;
            case 'film-budget-calc':
                Staffpanel::setClearLevel(3);
                break;
            case 'manage-users':
                Staffpanel::setClearLevel(5);
                break;
            case 'manage-roles':
                Staffpanel::setClearLevel(5);
                break;
            case 'manage-sessions':
                Staffpanel::setClearLevel(5);
                break;
            case 'view-analytics':
                Staffpanel::setClearLevel(5);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/pages/analytics/index.php');
                break;
            default:
                switch ($url[2]) {
                    case 'reports':
                        Staffpanel::setClearLevel(3);
                        $reportID = $url[3];
                        include($_SERVER["DOCUMENT_ROOT"].'/staff/pages/reporting-system/report/report.php');
                        break;
                }
        }
    }
}

db::disconnect();
?>
