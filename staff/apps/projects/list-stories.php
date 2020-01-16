<?php
    $projectInfo = Project::loadProject($_POST["projectID"]);
    $storyList = Assignments::loadByStoryID($_POST["storyID"]);
?>
<div id="story-list-app" class="float-fade-in">
<?php
    if (Project::hasPermissionLevel(4)) {
        echo '<div class="box">
            <div class="box-head invert">
                <h4>Create A New Story</h4>
            </div>
        </div>';
    }
    ?> <div class="box-grid box-grid-small no-hover"> <?php
    foreach($storyList as $storyItem) {
        echo '<div class="box" data-story="'.$storyItem["assignmentID"].'">
            <div class="box-head">
                <h4>'.$storyItem["title"].'</h4>
                <div class="box-head-alt" data-assignment-id="'.$storyItem["assignmentID"].'">
                    <i class="fas fa-cog"></i>
                </div>
            </div>
            <div class="box-content">
                <p class="desc">'.(strlen($storyItem["description"]) > 0 ? $storyItem["description"] : 'No Description Written.').'</p>
                <div>
                    <div class="box-list-cube">
                        <div class="box-container ">
                            <p class="box-list-cube-content">Percent Completed: '.$storyItem["percentComplete"].'%</p>
                        </div>
                    </div>
                    <div class="box-list-cube">
                        <div class="box-container ">
                            <p class="box-list-cube-content">Due On: '.$storyItem["endDate"].'</p>
                            <p class="box-list-cube-content">Days Remaining: '.$storyItem["daysLeft"].'</p>
                        </div>
                    </div>
                    <div class="box-list-cube">
                        <div class="box-container ">
                            <p class="box-list-cube-content">Staff Assigned: '.$storyItem["participants"].'</p>
                        </div>
                    </div>';
                    /*
                    foreach($epicItem["stories"] as $storyItem) {
                        echo '<div class="box box-dropdown">
                                <div class="box-head">
                                    <div class="box-dropdown-click">
                                        <h5>'.$storyItem["title"].'</h5>
                                    </div>
                                    <div class="box-head-alt" data-story-id="'.$storyItem["storyID"].'">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </div>
                                <div class="box-content invert">
                                    <div class="box-list box-list-small">
                                        <div class="box-list-item box-list-cube blc-inverted">
                                            <div class="box-container ">
                                                <p class="box-list-cube-content">'.(isset($storyItem["percentComplete"]) ? $storyItem["percentComplete"] : 0).'% Completed</p>
                                            </div>
                                        </div>
                                        <div class="box-list-item box-list-cube blc-inverted">
                                            <div class="box-container">
                                                <p class="box-list-cube-content">'.(isset($storyItem["assignmentCount"]) ? $storyItem["assignmentCount"] : 0).' Task(s)</p>
                                            </div>
                                        </div>
                                        <div class="box-list-item box-list-cube blc-inverted">
                                            <div class="box-container">
                                                <p class="box-list-cube-content">'.(isset($storyItem["userCount"]) ? $storyItem["userCount"] : 0).' Participants</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p>Last Updated On January 28th, 2019 @ 12:27:11 PM HKT By David Moreno</p>
                                </div>
                            </div>';
                    }
                    */
                    echo '</div>
                '.(Project::hasPermissionLevel(4) ? '<button>Edit</button>' : '').'
                <button class="act-loadStories">View All Stories</button>
            </div>
        </div>';
    }
?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        setBLDD('#story-list-app');
        
        $('[data-assignment-id]').click(function () {
            paneljs.proj.loadStory($(this).attr('data-story-id'), function (app) {
                
            });
        });
    });
</script>
</div>