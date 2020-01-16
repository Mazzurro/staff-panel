<?php
    $projectInfo = Project::loadProject($_POST["projectID"]);
    $epicList = Project::overview();
     //$projectInfo = Userstories::getInfo($_POST["projectID"], 'Saga');
     //$epicList = Userstories::getEpics($_POST["projectID"]);
?>
<div id="epic-list-app" class="float-fade-in">
    <div class="search-container">
        <select class="bg-search-select">
            <option class="dd-title" value="Title">Title</option>
            <option class="dd-complete" value="Complete">Complete</option>
            <option class="dd-updated-date" value="Updated-date">Updated date</option>
        </select>
        <input id="search-box" type="search" name="search" placeholder="Search...">
        <button style="margin:0px"><i class="fa fa-search search-icon"></i></button>
    </div>
<?php
    if (Project::hasPermissionLevel(4)) {
        echo '<div class="box">
            <div class="box-head invert" onclick="paneljs.proj.createEpic();">
                <h4>Create A New Epic</h4>
            </div>
        </div>';
    }
    ?> <div class="box-grid box-grid-small no-hover"> <?php
    foreach($epicList as $epicItem) {
        //$epicItem["stories"] = [];
        echo '<div class="box box-epic" data-epic="'.$epicItem["storyID"].'">
            <div class="box-head">
                <h4>'.$epicItem["title"].'</h4>
                <div class="box-head-alt" data-epic-id="'.$epicItem["storyID"].'">
                    <i class="fas fa-cog"></i>
                </div>
            </div>
            <div class="box-content">
                <p class="desc">'.(strlen($epicItem["description"]) > 0 ? $epicItem["description"] : 'No Description Written.').'</p>
                <div>
                    <!--<div class="box-list-cube">
                        <div class="box-container ">
                            <p class="box-list-cube-content">Percent Completed: '.count($epicItem["stories"]).'%</p>
                        </div>
                    </div>
                    <div class="box-list-cube">
                        <div class="box-container ">
                            <p class="box-list-cube-content">Due On: '.count($epicItem["stories"]).'</p>
                        </div>
                    </div>
                    <div class="box-list-cube">
                        <div class="box-container ">
                            <p class="box-list-cube-content">Stories: '.count($epicItem["stories"]).'</p>
                        </div>
                    </div>-->';
                    
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
                                            <div class="box-container">
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
                                    <!--<p>Last Updated On January 28th, 2019 @ 12:27:11 PM HKT By David Moreno</p>-->
                                </div>
                            </div>';
                    }
                    
                    echo '<!--<div class="box-list-cube">
                        <div class="box-container ">
                            <p class="box-list-cube-content">Assignments Remaining: '.count($epicItem["stories"]).' of 12</p>
                        </div>
                    </div>-->
                </div>
                '.(Project::hasPermissionLevel(4) ? '<button onclick="paneljs.proj.createStory('.$epicItem["storyID"].');">Add New Story</button>' : '').'
                '.(Project::hasPermissionLevel(4) ? '<button onclick="paneljs.proj.updateEpic('.$epicItem["storyID"].');">Edit</button>' : '').'
                <!--<button class="act-loadStories">View All Stories</button>-->
            </div>
            <div class="box-list box-list-small box-list-toggleable info-storyItems">';
            /*if (Project::hasPermissionLevel(4)) {
                echo '<div class="box-list-item box-list-dd">
                    <div class="box-container box-list-dd-title">
                        <h5>Create Story Item</h5>
                    </div>
                    <div class="box-list box-list-small">
                        <h5>1.What is the story called?</h5>
                        <div class="box-list-item input-item">
                            <input type="text" name="item-name">
                        </div>
                    </div>
                    <div class="box-list box-list-small">
                        <h5>2. What is the story description?</h5>
                        <div class="box-list-item input-item">
                            <textarea name="item-desc"></textarea>
                        </div>
                    </div>
                    <button class="createStoryItem" data-story-type="Story" data-story-parentid="'.$epicItem["storyID"].'">Create Story!</button>
                </div>';
            }*/

        echo '</div>
        </div>';
    }
?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        setBLDD('#epic-list-app');
        
        $('[data-story-id]').click(function () {
            paneljs.proj.loadStory($(this).attr('data-story-id'));
        });



        //当按输入内容时触发
        $("#search-box").on("input propertychange",function(){
            console.log($( "#search-box").val());
            //获取当前下拉框选中的option的class名称
            var dropdownValue = $(".bg-search-select").find("option:selected").attr("class");
            var searchValue = $("#search-box").val();
            //隐藏所有
            $(".box-epic").hide();
            switch(dropdownValue){
                case "dd-title":
                    //显示有关标题类型的项目
                    console.log("显示标题");
                    //判断.float-fade-in .box-head元素内是否包含另一个元素
                    $('.box-epic .box-head:contains("' + searchValue + '")').closest(".box-epic").show();
                break;
                case "dd-complete":
                        console.log("显示百分比");
                        $('.box-epic .box-list-cube>.box-container>p:contains("' + searchValue + '")').closest(".box-epic").show();
                break;
                case "dd-updated-date":
                        $('.box-epic .invert p:contains("' + searchValue + '")').closest(".box-epic").show();
                break;
                default:
                    if(searchValue==""){
                        $(".box-epic").show();
                    }
            }

        })
    });
</script>
</div>