<?php
 $projectInfo = Project::loadProject($_POST["projectID"]);
 if (!Userstories::validateStoryItem($_POST["storyID"], 'Story')) createError('403', 'Invalid Story Item', 'The story item does not belong to this project.');
 $storyItem = Userstories::getInfo($_POST["storyID"], 'Story');
?>

 <div class="panel-content skinny" id="thisProjectStory" project-id="<?php echo $_POST["projectID"]; ?>">
    <div class="panel">
        <div class="panel-content">
        <?php
            echo '<h5 id="gobacktoproject">Back To '.$projectInfo["title"].'</h5>';
            echo '<h1>'.$storyItem["title"].'</h1>';

            if (Project::hasPermissionLevel(4)) {
                echo '<div class="button-area">
                    <button id="editstory" onclick="paneljs.proj.editStory('.$_POST["storyID"].');" >Edit Story</button>
                </div>';
            }

            echo '<h3>About This Story</h3>
            <h6>'.$storyItem["description"].'</h6>';
        ?>
        </div>
    </div>
    <div class="search-container" style="margin: 20px 20px;">
        <select class="bg-search-select">
            <option class="dd-title" value="title">Title</option>
            <option class="dd-complete" value="complete">Complete</option>
            <option class="dd-updated-date" value="updated-date">Updated date</option>
        </select>
        <input id="search-box" type="search" name="search" placeholder="Search...">
        <button style="margin:0px"><i class="fa fa-search search-icon"></i></button>
    </div>
    <div class="panel">
        <div class="panel-content">
            <div id="assignment-list-container" class="box-list float-fade-in">
                <?php
                    $assignmentList = Assignments::loadByStoryID($_POST["storyID"]);
                    // var_dump($assignmentList);
                    if (!$assignmentList || count($assignmentList) == 0) {
                        echo '<h1>There Are No Assignments For This Story.</h1>';
                    } else {
                        foreach ($assignmentList as $assignment) {
                            echo '<div class="box-list-item box-list-Community" assignment-id="'.$assignment["assignmentID"].'">
                                <div class="box-container">
                                    <div class="dd">
                                        <div class="dd-tab"><i class="fas fa-ellipsis-h"></i></div>
                                        <div class="dd-drop">';
                                            if (Project::hasPermissionLevel(2))
                                                echo '<div class="dd-item" data-dd="update">Add Update</div>';
                                            echo '<div class="dd-item" data-dd="editor">Editor</div><div class="dd-item" data-dd="delete">Delete</div>
                                        </div>
                                    </div>
                                    <h4 class="dd-title">'.$assignment["title"].'</h4>
                                    <h6>Description</h6>
                                    <p class="desc">'.$assignment["description"].'</p>
                                    <h6>Assignment Overview</h6>
                                    <div class="box-list box-list-small float-fade-in">
                                        <div class="box-list-item box-list-cube">
                                            <div class="box-container box-list-cube-content">
                                                <p data-percent="'.(isset($assignment["percentComplete"]) ? $assignment["percentComplete"] : 0).'">Completed</p>
                                                <h6 class="dd-completed">'.(isset($assignment["percentComplete"]) ? $assignment["percentComplete"] : 0).'%</p>
                                            </div>
                                        </div>
                                        <div class="box-list-item box-list-cube">
                                            <div class="box-container box-list-cube-content">
                                                <p>Participants</p>
                                                <h6>'.$assignment["participants"].'</p>
                                            </div>
                                        </div>
                                        <div class="box-list-item box-list-cube">
                                            <div class="box-container box-list-cube-content">
                                                <p>Due Date</p>
                                                <h6>'.(isset($assignment["endDate"]) ? $assignment["endDate"] : '-').'</p>
                                            </div>
                                        </div>
                                        <div class="box-list-item box-list-cube">
                                            <div class="box-container box-list-cube-content">
                                                <p>Days Left</p>
                                                <h6>'.(isset($assignment["endDate"]) ? $assignment["daysLeft"] : '-').'</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="update-date">'.(isset($assignment["name"]) ? 'Last Updated By '.$assignment["name"].' On '.$assignment["updatedOn"].' UTC' : '').'</p>
                                </div>
                            </div>';
                        }
                    }
                if (Project::hasPermissionLevel(4)) {
                    echo '<div class="box-list-item" id="newassignment">
                        <div class="box-container">
                            <h4>Create A New Assignment</h4>
                        </div>
                    </div>';
                } ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    setUpDropdowns();
    setDD('#thisProjectStory');

    //监听input的value值改变
        //当按input发生变化触发
        //$("#search-box").keyup(function(){
        $("#search-box").on("input propertychange",function(){
            //获取当前下拉框选中的option的class名称
            var dropdownValue = $(".bg-search-select").find("option:selected").attr("class");
            var searchValue = $("#search-box").val();
            //隐藏所有
            $(".box-list-Community").hide();
            switch(dropdownValue){
                case "dd-title":
                    //显示有关标题类型的项目
                    console.log("显示标题");
                    //判断.float-fade-in .box-head元素内是否包含另一个元素
                       $(".box-list-Community .dd-title").filter(":Contains("+searchValue+")").closest('.box-list-Community').show();
                    break;
                case "dd-complete":
                        console.log("显示百分比");
                        $(".box-list-Community .dd-completed").filter(":Contains("+searchValue+")").closest('.box-list-Community').show();
                    break;
                case "dd-updated-date":
                        console.log("显示更新时间");
                        $(".box-list-Community .update-date").filter(":Contains("+searchValue+")").closest('.box-list-Community').show();
                    break;
                default:
                    console.log("default");
                    if(searchValue==""){
                        $(".box-list-Community").show();
                    }
            }
        });

   $('#gobacktoproject').click(function () {
        let uniID = paneljs.genID(5);
        uniqueContentID = {setID:uniID, currentID:uniID};
        loadContent('project', {projectID:<?php echo $_POST["projectID"]; ?>}, uniID, 1);
        /*<?php echo $_POST['storyID']?>*/
   });

    <?php if (Project::hasPermissionLevel(2)) { ?>
    $('.dd-item[data-dd=update]').click(function () {
        $('#thisProjectStory').addClass('panel-popup-active loading');
        let randAppID = paneljs.genID(5);
        $('#thisProjectStory').append(`<div id="app-`+randAppID+`"></div>`);
        paneljs.fetch({type:'app', call:'4', postData:{storyID:<?php echo $_POST["storyID"]; ?>,assignmentID:$(this).closest('[assignment-id]').attr('assignment-id')}}, function (data) {
            $('#thisProjectStory').removeClass('loading');
            $('#app-'+randAppID).append(data.data);
        });
        // loadApp(4,randAppID,{assignmentID:$(this).closest('[assignment-id]').attr('assignment-id')}, function (data) {
        //   $('#thisProjectStory').removeClass('loading');
        //   $('#app-'+randAppID).replaceWith(data);
        // });
    });

    $('.dd-item[data-dd=editor]').click(function () {
            //加载
            $ ('#thisProjectStory').addClass('panel-popup-active loading');
            let randAppID = paneljs.genID(0);
            $('#thisProjectStory').append(`<div id="app-`+randAppID+`"></div>`);
            paneljs.fetch({type:'app', call:'5', postData:{storyID:<?php echo $_POST["storyID"]; ?>,assignmentID:$(this).closest('[assignment-id]').attr('assignment-id')}}, function (data) {
                $('#thisProjectStory').removeClass('loading');
                $('#app-'+randAppID).append(data.data);
                setUpDropdowns();
            });
    });

    $(".dd-item[data-dd=delete]").click(function(){
       if(confirm("Are you sure you want to delete the assignment?")){
            paneljs.fetch({type:'api', call:'assignments/del', postData:{assignmentID:$(this).closest('[assignment-id]').attr('assignment-id')}}, function(data){
                addNotif("Delete the assignment", "Delete the success", 1);
                 //重新加载页面
                 //传递项目di
                 //paneljs.setProject(<?php echo($_POST["projectID"])?>);
                 paneljs.proj.loadStory(<?php echo $_POST["storyID"]; ?>);
                 //loadContent('project', {projectID:<?php echo($_POST["projectID"])?>}, 0);
            });
       }
    })

    <?php } ?>

   <?php if (Project::hasPermissionLevel(4)) { ?>
    $('#newassignment').click(function () {
        $('#thisProjectStory').addClass('panel-popup-active loading');
        let randAppID = paneljs.genID(0);
        $('#thisProjectStory').append(`<div id="app-`+randAppID+`"></div>`);
        paneljs.fetch({type:'app', call:'2', postData:{storyID:<?php echo $_POST["storyID"]; ?>}}, function (data) {
            $('#thisProjectStory').removeClass('loading');
            $('#app-'+randAppID).append(data.data);
            setUpDropdowns();
        });

    });
   <?php } ?>
});
 <?php if (Project::hasPermissionLevel(4)) { ?>
    function addAssignmentDiv(assignmentInfo) {
        $('#assignment-list-container').prepend(`<div class="box-list-item box-list-Community" assignment-id="`+assignmentInfo.assignmentID+`">
                                <div class="box-container">
                                    <div class="dd">
                                        <div class="dd-tab"><i class="fas fa-ellipsis-h"></i></div>
                                        <div class="dd-drop">
                                            <div class="dd-item" data-dd="update">Add Update</div>
                                            <div class="dd-item">Info</div>
                                        </div>
                                    </div>
                                    <h4>`+assignmentInfo.title+`</h4>
                                    <h6>Description</h6>
                                    <p class="desc">`+assignmentInfo.desc+`</p>
                                    <h6>Assignment Overview</h6>
                                    <div class="box-list box-list-small float-fade-in">
                                        <div class="box-list-item box-list-cube">
                                            <div class="box-container box-list-cube-content">
                                                <p data-percent="0">Completed</p>
                                                <h6>0%</p>
                                            </div>
                                        </div>
                                        <div class="box-list-item box-list-cube">
                                            <div class="box-container box-list-cube-content">
                                                <p>Participants</p>
                                                <h6>`+assignmentInfo.participants+`</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`);
    }
   <?php } ?>

</script>