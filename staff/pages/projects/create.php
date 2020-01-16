<div class="panel" id="create-project">
    <div class="panel-content">
        <div class="box-list float-fade-in">
            <div class="box-list-item boxListItem">
                <div class="box-container">
                    <h3>Create A Project</h3>
                    <h6>Creating a new project is very simple! It's as easy as 1, 2, 3... literally:</h6>
                </div>
                <div class="box-bottom">


                <div class="box-list box-list-small">
                    <h5>1. What is the project called?</h5>
                    <div class="box-list-item ">
                        <input type="text" name="project-name" id="projectName">
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h5>2. What is the project description?</h5>
                    <div class="box-list-item ">
                        <textarea name="project-desc" id="projectDesc"  rows="3"></textarea>
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h5>3. What legend does the project belong to?</h5>
                    <div class="box-list-item input-item">
                        <dropdown>
                            <dropdown-head>
                                <dropdown-current>Pick A Legend</dropdown-current>
                                <input type="hidden" name="legendID">
                            </dropdown-head>
                            <dropdown-options>
                                <?php
                                    $legendList = Userstories::getLegends();
                                    foreach($legendList as $legend) {
                                        echo '<dropdown-options-item data-id="'.$legend["storyID"].'">['.$legend["department"].'] - '.$legend["title"].'</dropdown-options-item>';
                                    }
                                ?>
                            </dropdown-options>
                        </dropdown>
                    </div>
                </div>
               <div class="btn-create">
                <button id="createProject">Create Project!</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    setUpDropdowns();
    $('#createProject').click(function () {
        if($('#create-project input[name=project-name]').val()==""){
            addNotif("Unable to create project", "Please enter the project title!", 2);
        }else if($('#create-project textarea[name=project-desc]').val().length<5){
            addNotif("Unable to create project", "Please enter a project description of more than 5 characters!", 2);
        }else if($('#create-project input[name=legendID]').val()==""){
             addNotif("Unable to create project", "Please Pick A Legend", 2);
        }else{
            $.post('api/projects/create', {projectData:{title:$('#create-project input[name=project-name]').val(),desc:$('#create-project textarea[name=project-desc]').val(),parentID:$('#create-project input[name=legendID]').val()}}).done(function (data) {
                        addNotif("Project Created", "Redirecting you to your project page", 1);
                        let uniID = paneljs.genID(0);
                        uniqueContentID = {setID:uniID, currentID:uniID};
                        paneljs.setProject(data.projectID.storyID);
                        loadContent('project', {projectID:data.projectID.storyID}, 1);
                   }).fail(function (data) {
                       data = data.responseJSON;
                       addNotif(data.title, data.message, 2);
            });
        }

    });
});
</script>