<?php
 $projectInfo = Project::loadProject($_POST["projectID"]);
 //$projectInfo = Userstories::getInfo($_POST["projectID"], 'Saga');
 ?>
 <div class="panel" id="thisProject">
    <div class="panel">
        <div class="panel-content tab-main" data-tab-id="main">
            <div class="tab-head">
                <?php
                    echo '<h1>'.$projectInfo["title"].'</h1>
                    <h3>About This Project</h3>
                    <h5>'.(isset($projectInfo["description"]) ? $projectInfo["description"] : 'No Project Description Provided.').'</h5>';
                ?>
            </div>
            <div class="tab-list">
                <div class="tab-list-buttons">
                    <ul>
                        <!--<li data-tab="overview" class="active tab-item">Overview</li>-->
                        <li data-tab="tasks" class="active tab-item">Tasks</li>
                        <!--<li data-tab="milestones" class="tab-item">Milestones</li>-->
                    <?php if (Project::hasPermissionLevel(5)) { ?>
                        <li data-tab="staff" class="tab-item">Manage Staff</li>
                        <li data-tab="edit" class="tab-item">Edit Project</li>
                    <?php } ?>
                    </ul>
                </div>
                <div class="tab-list-dropdown"></div>
            </div>


            <div class="tab-body">
                <?php include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/projects/list-tasks.php'); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

$(document).ready(function () {
    
    let projectTabs = new Tabs('main');
    projectTabs.onSelect((tabItem) => {
        switch(tabItem.id) {
            case 'overview':
            case 'tasks':
            case 'milestones':
            <?php if (Project::hasPermissionLevel(5)) { ?>
            case 'staff':
            case 'edit':
            <?php } ?>
                projectTabs.loadBody({type:'section', contentID:'project-'+tabItem.id, post:{projectID:<?php echo $_POST["projectID"]; ?>}});
                break;
        }
    });

      /* $('[data-tab=overview]').click(function () {
            paneljs.setProject($(this).attr('data-project-id'));
            loadContent('project', {projectID:$(this).attr('data-project-id')}, 0);
       });*/

    
});
</script>