<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"].'/staff/php-v2/functions.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/php-v2/db.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/php-v2/dbLog.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/index.php');
StaffMember::loadStaff(null);


if (isset($_GET["url"]) && count(explode('/',$_GET["url"])) >= 4) {
    $url = explode('/',$_GET["url"]);
    if ($url[2] == 'section') {
        switch($url[3]) {
            case 'project-tasks':
                if (!isset($_POST["projectID"])) Staffpanel::createError('403', 'Insufficient Permissions', 'You do not have permission to access this project.');
                Staffpanel::setClearLevel(1);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/projects/list-tasks.php');
                break;
            case 'project-staff':
                if (!isset($_POST["projectID"])) Staffpanel::createError('403', 'Insufficient Permissions', 'You do not have permission to access this project.');
                Staffpanel::setClearLevel(1);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/projects/manage-staff.php');
                break;
            case 'project-edit':
                if (!isset($_POST["projectID"])) Staffpanel::createError('403', 'Insufficient Permissions', 'You do not have permission to access this project.');
                Staffpanel::setClearLevel(1);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/projects/edit.php');
                break;
        }
    } else if ($url[2] == 'app') {
        switch($url[3]) {
            case '1':
            case 1:
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/assign-staff.php');
                break;
            case '2':
            case 2:
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/create/assignment.php');
                break;
            case '3':
            case 3:
                if (!isset($_POST["projectID"])) Staffpanel::createError('403', 'Insufficient Permissions', 'You do not have permission to access this project.');
                $projParts = Project::loadProject($_POST["projectID"]);
                Staffpanel::setClearLevel(1);
                if (!Project::hasPermissionLevel(4)) Staffpanel::createError('403', 'Insufficient Permissions', 'You do not have permission to do that.');
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/assign-project.php');
                break;
            case '4':
            case 4:
                if (!Assignment::canModify($_POST["assignmentID"])) Staffpanel::createError('403', 'Insufficient Permissions', 'You do not have permission to do that.');
                Staffpanel::setClearLevel(1);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/create/assignment-update.php');
                break;
            case '5':
            case 5:
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/create/edit-assignment.php');
                break;
            case '6':
            case 6:
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/create/run-rates.php');
                break;
            case '7':
            case 7:
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/create/editor-run-rates.php');
                break;
         	case 'addRole':
            case 'addRole':
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/create/add-new-role.php');
                break;
            case 'newMedia':
            case 'newMedia':
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/create/newMedia.php');
                break;
            case 'newAccount':
            case 'newAccount':
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/create/newAccount.php');
                break;
            case 'newAuthority':
            case 'newAuthority':
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/create/newAuthority.php');
                break;
            case 'addRevenue':
            case 'addRevenue':
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/create/add-new-revenue.php');
                break;
            case 'editorRevenue':
            case 'editorRevenue':
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/create/editor-revenue.php');
                break;
            case '8':
            case 8:
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/create/new-staff.php');
                break;
            case '9':
            case 9:
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/assign-to-account.php');
                break;
                
                
            case '  ':
            case 'editstaff':
                Staffpanel::setClearLevel(2);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/create/editor-staff.php');
                break;
            case 'project-stories':
                if (!isset($_POST["projectID"])) Staffpanel::createError('403', 'Insufficient Permissions', 'You do not have permission to access this project.');
                Staffpanel::setClearLevel(1);
                include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/projects/list-stories.php');
                break;
        }
    }
}

db::disconnect();
?>