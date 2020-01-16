<?php

    $projects = Projects::getProjects($_POST["page"], $_POST["amount"]);
    //$projects = array();
    //$legends = Userstories::getLegends();
    //foreach ($legends as $legendID => $legendStory) {
    //    $projects = array_merge($projects, Userstories::getSagas($legendID));
    //}
?>
<style></style>
<div id="project-list" class="panel">
    <div class="panel-content">
        <div class="search-container">
            <select class="bg-search-select">
                <option class="dd-title" value="title">Title</option>
                <option class="dd-complete" value="complete">Complete</option>
                <option class="dd-updated-date" value="updated-date">Updated date</option>
            </select>
            <input id="search-box" type="search" name="search" placeholder="Search...">
            <button style="margin:0px"><i class="fa fa-search search-icon"></i></button>
        </div>


        <div id="project-list-container" class="box-grid">
            <?php
                foreach($projects as $projectItem) {
                    // var_dump($projectItem);
                    echo '<div class="box float-fade-in" data-project-id="'.$projectItem["storyID"].'">
                            <div class="box-head">
                                <h3>'.$projectItem["title"].'</h3>
                            </div>
                            <div class="box-content">
                                <h5>Last Updated By '.$projectItem["updatedBy"].'</h5>
                                <h5 class="complete">Last Updated On '.$projectItem["updatedOn"].'</h5>
                                <h5 class="updatedOn">'.round($projectItem["totalPercent"], 2).'% Complete</h5>
                            </div>
                        </div>';
                }
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
            //当按input发生变化触发
            //$("#search-box").keyup(function(){
            $("#search-box").on("input propertychange",function(){
                console.log($( "#search-box").val());
                //获取当前下拉框选中的option的class名称
                var dropdownValue = $(".bg-search-select").find("option:selected").attr("class");
                var searchValue = $("#search-box").val();
                //隐藏所有
                $(" .float-fade-in").hide();
                switch(dropdownValue){
                    case "dd-title":
                        //显示有关标题类型的项目
                        console.log("显示标题");
                        //判断.float-fade-in .box-head元素内是否包含另一个元素
                        $('.float-fade-in .box-head:contains("' + searchValue + '")').closest(".float-fade-in").show();
                        break;
                    case "dd-complete":
                            console.log("显示百分比");
                            $('.float-fade-in .updatedOn:contains("' + searchValue + '")').closest(".float-fade-in").show();
                        break;
                    case "dd-updated-date":
                            console.log("显示更新时间");
                            $('.float-fade-in .complete:contains("' + searchValue + '")').closest(".float-fade-in").show();
                        break;
                    default:
                        console.log("default");
                        if(searchValue==""){
                            console.log("if")
                            $(".float-fade-in").show();
                        }
                }

            })

   $('[data-project-id]').click(function () {
        //setPageURL($(this).find('h6').text(), '/staff/project/'+$(this).attr('data-project-id')+'/'+formatTextToURL($(this).find('h6').text()));
        paneljs.setProject($(this).attr('data-project-id'));
        loadContent('project', {projectID:$(this).attr('data-project-id')}, 0);
   });


});
</script>