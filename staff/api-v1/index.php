<?php


include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/staff/user/index.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/staff/departments/index.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/staff/members/index.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/projects/index.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/social-media/index.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/milestones/index.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/panel.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/sessions/index.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/planning/run-rate.php');
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/planning/staff-planning.php');

$apiOnly = false;
if (!class_exists('db')) {
    $apiOnly = true;
	session_start();
	include($_SERVER["DOCUMENT_ROOT"].'/staff/php-v2/functions.php');
    include($_SERVER["DOCUMENT_ROOT"].'/staff/php-v2/db.php');
    include($_SERVER["DOCUMENT_ROOT"].'/staff/php-v2/dbLog.php');
    StaffMember::loadStaff(null);
}

if (isset($_GET["api"]) && count(explode('/',$_GET["api"])) >= 4) {
    header('Content-Type: application/json; charset=UTF-8');
    $apiURL = explode('/',$_GET["api"]);
    switch($apiURL[3]) {
        case 'sessions':
            switch($apiURL[4]) {
                case 'Pageaccess':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Sessions::Pageaccess($_POST['sessionID']));
                    break;
                case 'list':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Sessions::List($_POST["page"],$_POST["title"],$_POST["value"]));
                    break;
                case 'disconnect':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(dbLog::forceDisconnect($_POST["sessionID"]));
                    break;
            }
            break;
        case 'assignments':
            switch($apiURL[4]) {
                case 'create':
                    if (!isset($_POST["projectID"])) Staffpanel::createError('403', 'Insufficient Permissions', 'You do not have permission to access this project.');
                    $projParts = Project::loadProject($_POST["projectID"]);
                    Staffpanel::setClearLevel(1);
                    if (!Project::hasPermissionLevel(4)) Staffpanel::createError('403', 'Insufficient Permissions', 'You do not have permission to do that.');
                    echo json_encode(Assignments::createAssignment($_POST));
                    break;
                case 'update':
                    Staffpanel::setClearLevel(1);
                    if (!isset($_POST["assignmentID"]) || !isset($_POST["updateDetails"])) Staffpanel::createError('400', 'Missing Information', 'Some information is missing.');
                    echo Assignment::addUpdate($_POST["assignmentID"], $_POST["updateDetails"]);
                    break;
                case 'list':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Assignments::loadByDateRange($_POST["startDate"], $_POST["endDate"]));//
                    break;
                case 'viewupdates':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Assignment::viewupdates($_POST["assignmentID"]));
                    break;
                case 'edit':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Assignments::editAssignment($_POST["assignmentID"], $_POST));
                    break;
                case 'edit_u':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Assignments::updateAssignment($_POST["assignmentID"], $_POST));
                    break;
                case 'del':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Assignments::delAssignment($_POST["assignmentID"]));
                    break;
                case 'createCategories':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Assignments::createCategories($_POST["storyID"],'Story',$_POST['category']));
                    break;
                case 'list_id':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Assignments::getAssignment($_POST["assignmentID"]));//
                    break;
            }
            break;
        case 'projects':
            switch($apiURL[4]) {
                case 'edit':
                    if (!isset($_POST["Title"]) || !isset($_POST["Description"])) Staffpanel::createError('400', 'Missing Information', 'Some information is missing.');
                    echo json_encode(Projects::editProjects($_POST['Title'],$_POST['Description'],$_POST['originalStoryID']));
                    break;
                case 'create':
                    Staffpanel::setClearLevel(3);
                    if (!isset($_POST["projectData"])) return false;
                    $projectResponse = Project::createProject($_POST["projectData"]);
                    if (!$projectResponse) Staffpanel::createError('500','Error Creating Project','An error occured while creating the project.');
                    echo json_encode(array("projectID"=>$projectResponse));
                    break;
                case 'manage':
                    Staffpanel::setClearLevel(1);
                    if (!isset($_POST["page"]) || !isset($_POST["amount"])) {
                        $_POST["page"] = "1";
                        $_POST["amount"] = "30";
                    }
                    echo json_encode(Projects::getProjects($page, $amount));
                    break;
                case 'assign':
                    if (!isset($_POST["projectID"])) Staffpanel::createError('403', 'Insufficient Permissions', 'You do not have permission to access this project.');
                    $projParts = Project::loadProject($_POST["projectID"]);
                    Staffpanel::setClearLevel(1);
                    if (!Project::hasPermissionLevel(5)) Staffpanel::createError('403', 'Insufficient Permissions', 'You do not have permission to do that.');
                    Project::assignToProject($_POST["staff"]);
                    break;
                case 'staff':
                    if (!isset($_POST["projectID"]) || !isset($_POST['deptID'])) Staffpanel::createError('403', 'Insufficient Permissions', 'You do not have permission to access this project.');
                    $projParts = Project::loadProject($_POST["projectID"]);
                    Staffpanel::setClearLevel(1);
                    if (!Project::hasPermissionLevel(4)) Staffpanel::createError('403', 'Insufficient Permissions', 'You do not have permission to do that.');
                    echo json_encode(Project::getProjectParticipantsByDepartment($_POST["deptID"]));
                    break;
            }
            break;
        case 'reports':
            switch($apiURL[4]) {
                case 'create':
                    Staffpanel::setClearLevel(3);
                    break;
                case 'browse':
                    Staffpanel::setClearLevel(3);
                    if (!isset($_POST["queryData"]) || !isset($_POST["page"]) || !isset($_POST["amount"])) {
                        $_POST["queryData"] = array("departments"=>array_keys(StaffMember::$me["depts"]["departments"]));
                        $_POST["page"] = "1";
                        $_POST["amount"] = "30";
                    }
                    echo json_encode(ReportSystem::searchReports($_POST["queryData"], $_POST["page"], $_POST["amount"]));
                    break;
            }
            break;
        case 'stories':
            switch($apiURL[4]) {
                case 'create':
                    Staffpanel::setClearLevel(3);
                    if (!isset($_POST["title"]) || !isset($_POST["description"]) || !isset($_POST["type"]) || !isset($_POST["parentID"]) || !isset($_POST["departmentID"])) return Staffpanel::createError('400','Error Creating Story Item','Missing Parameters.');
                    echo json_encode(Userstories::addStoryItem($_POST["type"],$_POST["title"],$_POST["description"],$_POST["parentID"],$_POST["departmentID"]));
                    break;
                case 'manage':
                    Staffpanel::setClearLevel(3);
                    break;
                case 'edit':
                    Staffpanel::setClearLevel(2);
                    if (!isset($_POST["story_id"]) || !isset($_POST["data"])) return Staffpanel::createError('400','Error Editing Story Item','Missing Parameters.');
                    echo json_encode(Userstories::editStoryItem($_POST["story_id"],$_POST["data"]));
                    break;
                case 'info':
                    Staffpanel::setClearLevel(2);
                    if (!isset($_POST["storyID"]) || !isset($_POST["type"])) return Staffpanel::createError('400','Error Fetching Story Item Info','Missing Parameters.');
                    echo json_encode(Userstories::getInfo($_POST['storyID'], $_POST['type']), true);
                    break;
                case 'getchildren':
                    Staffpanel::setClearLevel(2);
                    if (!isset($_POST["storyID"]) || !isset($_POST["type"])) return Staffpanel::createError('400','Error Fetching Story Item Info','Missing Parameters.');
                    switch ($_POST['type']) {
                        case 'self':
                            echo json_encode(Userstories::getLegends(), true);
                            break;
                        case 'legend':
                            echo json_encode(Userstories::getSagas($_POST['storyID']), true);
                            break;
                        case 'saga':
                            echo json_encode(Userstories::getEpics($_POST['storyID']), true);
                            break;
                        case 'epic':
                            echo json_encode(Userstories::getStories($_POST['storyID']), true);
                            break;
                    }
                    break;
                case 'getparentid':
                    Staffpanel::setClearLevel(1);
                    if (!isset($_POST["storyID"]) || !isset($_POST["type"])) return Staffpanel::createError('400','Error Fetching Story Item Info','Missing Parameters.');
                    echo json_encode(Userstories::getparentid($_POST['storyID'], $_POST['type']), true);
                 break;
            }
            break;
        case 'departments':
            switch($apiURL[4]) {
                case 'staff':
                    Staffpanel::setClearLevel(2);
                    if (!isset($_POST["deptID"])) return Staffpanel::createError('400','Error Fetching Department Staff','Missing Parameters.');
                    echo json_encode(Departments::getStaffByID($_POST["deptID"]));
                    break;
            }
            break;
        case 'milestones':
            switch($apiURL[4]) {
                case 'create':
                    echo json_encode(Milestone::createMilestone($_POST));
                    break;
                case 'list':
                    echo json_encode(Milestones::fetchMilestones($_POST,$_POST['page']));
                    break;
                case 'next-level':
                    echo json_encode(Milestones::fetchChildren($_POST["parentID"]));
                    break;
                case 'info':
                    echo json_encode(Milestone::getInfo($_POST["milestoneID"]));
                    break;
                case 'autocomplete':
                    echo json_encode(Milestones::autocomplete($_POST["type"], $_POST["text"]));
                    break;
            }
            break;
        case 'film-budget-calc':
            Staffpanel::setClearLevel(3);
            break;
        case 'social-media':
            switch($apiURL[4]) {
                case 'schedule':
                    switch($apiURL[5]) {
                        case 'list':
                            Staffpanel::setClearLevel(2);
                            echo json_encode(SM_Scheduling::getSchedule());
                            break;
                        case 'upload':
                            Staffpanel::setClearLevel(2);
                            echo json_encode(SM_Scheduling::uploadCSV($_FILES["csvFile"]));
                            break;
                    }
                    break;
            }
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
        case 'run-rate':
            switch($apiURL[4]) {
                case 'create':
                    Staffpanel::setClearLevel(4);
                    echo json_encode(RunRate::Create($_POST));
                    break;
                case 'edit':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(RunRate::edit($_POST['RunRate_id'],$_POST));
                    break;
                case 'del':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(RunRate::del($_POST['RunRate_id']));
                    break;
                case 'list':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(RunRate::RunRateList());
                    break;
                case 'country':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(RunRate::Country());
                    break;
                case 'departments':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(RunRate::Departments());
                    break;
                case 'roles':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(RunRate::Roles());
                    break;
                case 'create-roles':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(RunRate::CreateRoles($_POST));
                    break;
            }
            break;
        case 'staffing':
            switch($apiURL[4]) {
                case 'Info':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Staffing::Info());
                    break;
                case 'Product':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Staffing::Product());
                    break;
                case 'Capability':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Staffing::Capability($_POST['parentID']));
                    break;
                case 'Service':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Staffing::Service($_POST['parentID']));
                    break;
                case 'create-Product':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Staffing::CreateProduct($_POST));
                    break;
                case 'create-Staff':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Staffing::CreateStaff($_POST));
                    break;
                case 'edit-Staff':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Staffing::edit($_POST['staffID'],$_POST));
                    break;
                case 'list':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Staffing::list());
                    break;
                case 'getTree':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Staffing::getTree());
                    break;
                case 'Country':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Staffing::Country());
                    break;
                case 'getstaff':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Staffing::getstaff($_POST['staffID']));//
                    break;
                case 'del':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Staffing::del($_POST['staffID']));//
                    break;
            }
            break;
        case 'Socialmedia':
            switch($apiURL[4]) {
                case 'Types':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Socialmedia::socialMediaTypes());
                    break;
                case 'create':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Socialmedia::create($_POST));
                    break;
                case 'createAccounts':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Socialmedia::createAccounts($_POST));
                    break;
                case 'AccountsList':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Socialmedia::AccountsList());
                    break;
                case 'List':
                    Staffpanel::setClearLevel(1);
                    echo json_encode(Socialmedia::List());
                    break;
            }
            break;
        default:
            switch ($_GET["api"]) {
                case '/staff/api/social-media/scheduling/list':
                    include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/social-media/schedule/index.php');
                    break;
                default:
                    return Staffpanel::createError('400','Invalid API Request','Your request does not exist.');
            }
    }
}

if ($apiOnly) {
    db::disconnect();
}


?>