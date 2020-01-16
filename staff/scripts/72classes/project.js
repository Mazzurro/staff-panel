class Project {
    
    constructor(projectID) {
        this.projectID = projectID;
    }
    
    createEpic() {    
        let popupID = paneljs.setPopup(`<div class="box">
            <div class="box-head">
                <h4>Create An Epic</h4>
                <div class="box-head-alt">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="box-content">
                <div class="box-list box-list-small">
                    <h5>1. What is the Title of the Epic?</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="item-name">
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h5>2. What is the Description of the Epic?</h5>
                    <div class="box-list-item input-item">
                        <textarea name="item-desc"></textarea>
                    </div>
                </div>
                <button class="createEpicItem" data-story-type="Epic">Create Epic!</button>
            </div>
        </div>`, 1), thePopUp = $('[data-popupID="'+popupID.result+'"]'), sagaID = this.projectID;
        
        thePopUp.find('.createEpicItem').click(function () {
            if(thePopUp.find('[name=item-name]').val()==""){
                addNotif("Unable to Create the Epic", "Please enter the title！", 2);
            }else if(thePopUp.find('[name=item-desc]').val().length<5){
                addNotif("Unable to Create the Epic", "Please enter a description of more than five characters！", 2);
            }else{
                paneljs.fetch({type:'api', call:'stories/create', postData:{title:thePopUp.find('[name=item-name]').val(), description:thePopUp.find('[name=item-desc]').val(), type:'Epic', parentID:sagaID, departmentID:null}}, function (data) {
                    paneljs.closePopup(popupID.result);
                    addNotif("Create An Epic", "Creating the epic was successful!", 1);
                });
            }

        });
        thePopUp.find('.box-head-alt').click(function () {
            paneljs.closePopup(popupID.result);
        });
    }
    
    loadEpicDetails(epicID) {
        
    }

    updateEpic(storyID) {
        let popupID = paneljs.setPopup(`<div class="box">
            <div class="box-head">
                <h4>Update An Epic</h4>
                <div class="box-head-alt">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="box-content">
                <div class="box-list box-list-small">
                    <h5>1. Epic Title</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="item-name">
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h5>2. Epic Description</h5>
                    <div class="box-list-item input-item">
                        <textarea name="item-desc"></textarea>
                    </div>
                </div>
                <button class="UpdateEpicItem" data-story-type="Story">Update Epic</button>
            </div>
        </div>`, 1), thePopUp = $('[data-popupID="'+popupID.result+'"]');



        thePopUp.find('.UpdateEpicItem').click(function () {
            if(thePopUp.find('[name=item-name]').val()==""){
                addNotif("Unable to Update the Epic", "Please enter the title！", 2);
            }else if(thePopUp.find('[name=item-desc]').val().length<5){
                addNotif("Unable to Update the Epic", "Please enter a description of more than five characters！", 2);
            }else{
                paneljs.fetch({type:'api', call:'stories/edit',
                    postData:{
                        story_id:storyID,
                        data:{
                            title:thePopUp.find('[name=item-name]').val(),
                            description:thePopUp.find('[name=item-desc]').val(),
                            type:'Epic'//,
                            // parent_id:''
                        },
                    }}, function (data) {
                    paneljs.closePopup(popupID.result);
                    addNotif("Update An Epic", "updating the epic was successful!", 1);
                });
            }


        });


        paneljs.fetch({type:'api', call:'stories/info', postData:{type:'Epic', storyID:storyID, }}, function (data) {
            thePopUp.find('[name=item-name]').val(data.data.title);
            if (data.data.description===null || data.data.description===undefined){
                console.log("if")
                thePopUp.find('[name=item-desc]').val("");
            }else{
                thePopUp.find('[name=item-desc]').val(data.data.description);
            }
        });
        thePopUp.find('.box-head-alt').click(function () {
            paneljs.closePopup(popupID.result);
        });

    }
    
    createStory(epicID) {
        let popupID = paneljs.setPopup(`<div class="box">
            <div class="box-head">
                <h4>Create An Story</h4>
                <div class="box-head-alt">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="box-content">
                <div class="box-list box-list-small">
                    <h5>1. What is the Title of the Story?</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="item-name">
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h5>2. What is the Description of the Story?</h5>
                    <div class="box-list-item input-item">
                        <textarea name="item-desc"></textarea>
                    </div>
                </div>
                <button class="createStoryItem" data-story-type="Story">Create Story</button>
            </div>
        </div>`, 1), thePopUp = $('[data-popupID="'+popupID.result+'"]');
        
        thePopUp.find('.createStoryItem').click(function () {
            if(thePopUp.find('[name=item-name]').val()==""){
                addNotif("Unable to Create the story", "Please enter the title！", 2);
            }else if(thePopUp.find('[name=item-desc]').val().length<5){
                addNotif("Unable to Create the story", "Please enter a description of more than five characters！", 2);
            }else{
                paneljs.fetch({type:'api', call:'stories/create', postData:{title:thePopUp.find('[name=item-name]').val(), description:thePopUp.find('[name=item-desc]').val(), type:'Story', parentID:epicID, departmentID:null}}, function (data) {
                    paneljs.closePopup(popupID.result);
                    addNotif("Create A Story", "Creating the Story was successful!", 1);
                });
            }

        });
        thePopUp.find('.box-head-alt').click(function () {
            paneljs.closePopup(popupID.result);
        });

    }

    editStory(storyID) {
        let popupID = paneljs.setPopup(`<div class="box">
            <div class="box-head">
                <h4>Update An Story</h4>
                <div class="box-head-alt">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="box-content">
                <div class="box-list box-list-small">
                    <h5>1. Story Title</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="item-name">
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h5>2. Story Description</h5>
                    <div class="box-list-item input-item">
                        <textarea name="item-desc"></textarea>
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h5>3. Story type</h5>
                    <div class="box-list-item input-item" style="color: #ad9440;">
                        <dropdown>
                            <dropdown-head>
                                <dropdown-current>Pick A Category</dropdown-current>
                                <input type="hidden" name="storyid">
                            </dropdown-head>
                            <dropdown-options>
                            
                            </dropdown-options>
                        </dropdown>
                    </div>
                </div>
                <button class="editStory" data-story-type="Story">Update Story</button>
            </div>
        </div>`, 1), thePopUp = $('[data-popupID="'+popupID.result+'"]');
        //点击下拉框（显示/隐藏）
        thePopUp.find('dropdown').click(function () {
            thePopUp.find('dropdown').toggleClass("active");
        })

        paneljs.fetch({type:'api', call:'stories/info', postData:{type:'Story', storyID:storyID}}, function (data) {
            thePopUp.find('input[name=item-name]').val(data.data.title);
            thePopUp.find('textarea[name=item-desc]').val(data.data.description);
        })

        let projID = this.projectID;
        paneljs.fetch({type:'api',call:'stories/getparentid',postData:{type:"Story",storyID:storyID}},function (res) {
            let text='';
            paneljs.fetch({
                type: 'api',
                call: 'stories/getchildren',
                postData: {type: "saga", storyID: projID}
            }, function (data) {
                //遍历下拉框的数据
                for (let i in data.data) {
                    thePopUp.find('dropdown-options').append(`<dropdown-options-item  data-id="${data.data[i].storyID}">${data.data[i].title}</dropdown-options-item>`);
                    if (data.data[i].storyID==res.data){//判断如果ID相同则把当前的标题显示到下拉框上
                        $('dropdown-current').text(data.data[i].title);
                    }
                }
                thePopUp.find("dropdown-options-item").click(function () {
                    //得到当前点击dropdown-options-item的id值
                    //将选中的id赋值给input标签
                    thePopUp.find("input[name=storyid]").val($(this).data("id"));
                    //把选中下框显示的值赋给dropdown-current标签
                    thePopUp.find("dropdown-current").text($(this).text());
                })
            })
            thePopUp.find('input[name=storyid]').val(res.data);

        })

        thePopUp.find('.editStory').click(function () {
            if(thePopUp.find('[name=item-name]').val()==""){
                addNotif("Unable to update the story", "Please enter the title！", 2);
            }else if(thePopUp.find('[name=item-desc]').val().length<5){
                addNotif("Unable to update the story", "Please enter a description of more than five characters！", 2);
            }else{
                paneljs.fetch({type:'api', call:'stories/edit',
                    postData:{
                        story_id:storyID,
                        data:{
                            title:thePopUp.find('[name=item-name]').val(),
                            description:thePopUp.find('[name=item-desc]').val(),
                            type:'Story',
                            parent_id:thePopUp.find('[name=storyid]').val()
                        },
                    }}, function (data) {
                        paneljs.closePopup(popupID.result);
                        addNotif("Update A Epic", "Updating the Story was successful!", 1);
                });
            }


        });

        thePopUp.find('.box-head-alt').click(function () {
            paneljs.closePopup(popupID.result);
        });



    }



    loadStoryDetails(storyID) {

    }
    
    loadStory(storyID) {
        loadContent('project-story', {storyID:storyID, projectID:this.projectID}, paneljs.genID(5), 1);
        // paneljs.fetch({type:'content', call:'project-story', postData:{storyID:storyID, projectID:this.projectID}}, function (data) {
        //     if (data.status)
        //         callback(data.data); 
        // });
    }
    
    loadStories(epicID, lastStoryID, amount, page) {
        
    }
    
    createMilestone() {
        
    }
    
    loadMilestoneDetails(milestoneID) {
        
    }
}