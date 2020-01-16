<?php
//hisss
include($_SERVER['DOCUMENT_ROOT']."/staff/php-v2/phpHead.php"); Staffpanel::setClearLevel(1);
// var_dump($_SESSION);
// print_r(StaffMember::throwup());
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php getHTMLHead('Home'); ?>
    <link rel="stylesheet" type="text/css" href="/staff/scripts/slick/slick.css">
	<link rel="stylesheet" type="text/css" href="/staff/scripts/slick/slick-theme.css">
	<script type="text/javascript" src="/staff/scripts/slick/slick.js"></script>
	<link rel="stylesheet" type="text/css" href="/staff/scripts/tabulator/dist/css/tabulator.css">
	<script type="text/javascript" src="scripts/tabulator/dist/js/tabulator.js"></script>
	<script type="text/javascript" src="/staff/scripts/72classes/panel.js"></script>
	<script type="text/javascript" src="/staff/scripts/72classes/project.js"></script>
	<script type="text/javascript" src="/staff/scripts/72classes/tabs.js"></script>
</head>

<body>
    <nav>
        <ul>
            <li class="nav-icon" id="nav-icon"><i class="fas fa-bars"></i></li>
            <li>72 Dragons Staff Panel</li>
            <li class="nav-icon" id="notification-icon"><i class="fas fa-bell"></i></li>
        </ul>
    </nav>
    <div class="background logo background-fixed"></div>
    <panel-content>

    </panel-content>
    <sidebar class="noselect" id="sidebar-nav">
        <sidebar-content>
            <sidebar-head>
                <img src="https://72dragons.com/images/72Dragons-solologo.png">
            </sidebar-head>
            <ul>
                <li class="list-parent list-last">
                    <span class="list-parent-span">Home</span>
                </li>

                <li class="list-parent">
                    <span class="list-parent-span">Tracking</span>
                    <ul>
                        <li class="list-child list-last"><span data-tag="create-projects">New Project/Saga</span></li>
                        <li class="list-child list-last"><span data-tag="manage-projects">Manage Tracking</span></li>
                        <li class="list-child list-last"><span data-tag="milestones">Tracking Reports</span></li>
                    </ul>
                </li>
                <?php if (StaffMember::hasPerms('*', [2,3,19])) { ?>
                <li class="list-parent">
                   <span class="list-parent-span">Reports</span>
                   <ul>
                       <li class="list-child list-last"><span data-tag="create-reports">Create</span></li>
                       <li class="list-child list-last"><span data-tag="manage-reports">Manage</span></li>
                   </ul>
                </li>
                <li class="list-parent">
                   <span class="list-parent-span">Planning</span>
                   <ul>
                       <li class="list-child list-last"><span data-tag="run-rate">Run Rates</span></li>
                       <li class="list-child list-last"><span data-tag="staff-planning">Staff Planning</span></li>
                       <li class="list-child list-last"><span data-tag="revenue">Revenue</span></li>
                       <li class="list-child list-last"><span data-tag="social-media-planning">Social Media</span></li>
                   </ul>
                </li>
                <!-- <li class="list-parent">
                   <span class="list-parent-span">Stories</span>
                   <ul>
                       <li class="list-child list-last"><span data-tag="create-stories">Create</span></li>
                       <li class="list-child list-last"><span data-tag="manage-stories">Manage</span></li>
                   </ul>
                </li> -->


                <?php }
                    if (StaffMember::hasPerms([12], '*')) { ?>
                <li class="list-parent">
                    <span class="list-parent-span">Social Media</span>
                    <ul>
                        <li class="list-child list-last"><span data-tag="social-media-schedule">Posting Schedule</span></li>
                    </ul>
                </li>
                <?php }
                    if (StaffMember::hasPerms([13], '*')) { ?>
                <li class="list-parent">
                    <span class="list-parent-span">Film Data</span>
                    <ul>
                        <li class="list-child list-last"><span data-tag="film-budget-calc">Budget Calculator</span></li>
                    </ul>
                </li>
                <?php }
                      if (StaffMember::hasPerms('*', [1])) { ?>
                <li class="list-parent">
                    <span class="list-parent-span">Admin</span>
                    <ul>
                        <li class="list-child list-last"><span data-tag="manage-users">Manage Users</span></li>
                        <li class="list-child list-last"><span data-tag="manage-roles">Manage Roles</span></li>
                        <li class="list-child list-last"><span data-tag="manage-sessions">Manage Sessions</span></li>
                        <li class="list-child list-last"><span data-tag="view-analytics">Website Analytics</span></li>
                    </ul>
                </li>
                <?php } ?>
                <li class="list-parent">
                    <span class="list-parent-span">Account</span>
                    <ul>
                        <li class="list-child list-last"><span data-action="notifs">Notifications (0)</span></li>
                        <li class="list-child list-last"><span data-action="logout">Logout</span></li>
                    </ul>
                </li>
            </ul>
        </sidebar-content>
    </sidebar>
    <sidebar class="noselect" id="sidebar-notif">
        <sidebar-content>
        </sidebar-content>
    </sidebar>
    <div class="notif-animate-container"></div>
    <script type="text/javascript">
        let uniqueContentID = {setID:0, currentID:0};
        $(document).ready(function () {
            $('.list-last').click(function () {
                if ($(this).children().attr('data-tag').length) {
                    loadContent($(this).children().attr('data-tag'), {}, 0);
                    $('#sidebar-nav').removeClass('active');
                } else if ($(this).children().attr('data-action').length) {

                }
            });

            $('.list-parent').not($('.list-last')).find('.list-parent-span').click(function () {
                $(this).parent().toggleClass('active');
            });

            $('#nav-icon').click(function () {
                $('#sidebar-nav').toggleClass('active');
            });

            $('#notification-icon').click(function () {
                $('#sidebar-notif').toggleClass('active');
            });
        });

        function loadContent(dataTag, postData, tries) {
            $('.float-fade-in').addClass('float-fade-out');
            $('panel-content').children().addClass('float-fade-out');
            setTimeout(function () {
                $('panel-content').empty().addClass('loading');
                paneljs.fetch({type:'content',call:dataTag, postData:postData}, (data) => {
                        if (data.status) {
                            $('panel-content').html(data.data);
                        } else {
                            if (++tries == 4) {
                                addNotif("Unable To Load Section - Maximum Tries Reached", "Please check your internet connection or contact David.", 2);
                            } else {
                                addNotif("Unable To Load Section", "Retrying "+tries+" of 3", 2);
                                loadContent(dataTag, postData, tries);
                            }
                        }

                        $('panel-content').removeClass('loading');
                });
            }, 500);
        }
    </script>

</body>

</html>

<?php include($_SERVER['DOCUMENT_ROOT']."/staff/php-v2/phpFoot.php");?>