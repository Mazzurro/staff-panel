<div class="box">
        <div class="box-head">
            <input type="hidden" name="id" value="<?php echo($_POST["projectID"])?>" />
            <h4>Edit Project</h4>
        </div>
        <div class="box-content">
            <form >
            <div style="max-width: 1200px;margin: auto;padding: 10px 0;">
                <h4 style="color:#ad9440;">Title</h4>
                <div class="">
                    <input class="edit-Project" type="text" placeholder="Please enter the project title"/>
                </div>
            </div>
            <div style="max-width: 1200px;margin: auto;padding: 10px 0;">
                <h4 style="color:#ad9440;">Description</h4>
                <div class="">
                    <textarea style="resize: none" rows="5" name="" class="edit-Project" placeholder="Please fill in the description"></textarea>
                </div>
            </div>
            <form/>
        <div>
        <button id="btn" >Submit Information</button>
</div>

<script type="text/javascript">


$(document).ready(function () {

   $("#btn").click(function () {
        console.log($(".box-head input").val())
        /*console.log($(".box-content textarea").val());
        console.log($(".box-content input").val().length);
        console.log($(".box-content textarea").val().length);*/
        $('input[name=id]').val();
        let projectTitle=$(".box-content input").val();
        let projectDescription=$(".box-content textarea").val();
        if(projectTitle.length==0){
            addNotif("Edit project", "Please enter the title of the edit project！", 2);
        }else if(projectDescription.length<5){
            addNotif("Edit project", "Please enter a description of more than five characters!", 2);
        }else{
            $.ajax({
                type:"POST",
                url:"http://192.168.50.90/staff/api/projects/edit",
                data:{originalStoryID:$(".box-head input").val(),Title:projectTitle,Description:projectDescription},
                success:function (data) {
                    console.log(data);
                    alert(data);
                    $('form')[0].reset();
                     addNotif("Edit project", "Edit project successful!", 1);
                    //重新加载页面
                    paneljs.setProject($(".box-head input").val());
                    loadContent('project', {projectID:$(".box-head input").val()}, 0);
                    //paneljs.proj.loadStory($(".box-head input").val());

                }
            })
        }


   });
});
</script>