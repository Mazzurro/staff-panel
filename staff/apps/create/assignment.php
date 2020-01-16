<?php $appID = strRand(10); ?>
<div class="panel panel-popup float-fade-in" id="assignment-creation" story_id="<?php echo $_POST['storyID']; ?>">
    <div class="panel-content">
        <div class="box-list float-fade-in">
            <div class="box-list-item">
                <div class="box-container">
                    <h3>Create An Assignment</h3>
                </div>
                <div class="box-list box-list-small">
                    <h6>Assignment Title</h6>
                    <p>The title should be short while easily being able to provide the reader with a general idea of what your assignment is about!</p>
                    <div class="box-list-item input-item">
                        <input type="text" name="assignment-title">
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h6>Assignment Description</h6>
                    <p>Please be as descriptive as possible, the last thing you want are multiple people coming to you asking what the assignment is about or requesting more information.</p>
                    <div class="box-list-item input-item">
                        <textarea name="assignment-desc"></textarea>
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h6>Assign Staff Members</h6>
                    <p>You may assign staff members below, they will be able to view and provide updates to the assignment. If this assignment is in a project, they will be able to view the project and the epics, stories, and assignments they are included in.</p>
                    <div class="box-list-item input-item">
                        <?php include($_SERVER["DOCUMENT_ROOT"].'/staff/apps/assign-staff.php'); ?>
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h6>Assignment Category</h6>
                    <p>This will help you be able to better manage and organize current and past assignments. If you don't see a category that will fit this assignment, then you can make one! Unlike stories, it is good to generalize the category (but not too much!).</p>
                    <div class="box-list-item input-item">
                        <dropdown>
                            <dropdown-head>
                                <dropdown-current>Pick A Category</dropdown-current>
                                <input type="hidden" name="category_id">
                            </dropdown-head>
                            <dropdown-options>
                            <?php
                                $categoryList = Assignments::getCategories($_POST["storyID"], 'Story');
                                foreach($categoryList as $category) {
                                    echo '<dropdown-options-item data-id="'.$category["categoryID"].'">['.$category["department"].'] - '.$category["category"].'</dropdown-options-item>';
                                }
                            ?>
                            </dropdown-options>
                        </dropdown>
                    </div>
                    <h6  id="category-title-h6"style="margin: 15px 0px;">Create Category Title</h6>
                    <div id="category-title" class="box-list-item input-item">
                        <input type="text" name="category-title"/>
                    </div>
                    <button id="createCategory">Create A New Category</button>
                    <button id="create-New-category">Create</button>

                </div>
                <div class="box-list box-list-small">
                    <h6>Assignment Start Date</h6>
                    <p>Pick a date for when this assignment will be started on.</p>
                    <div class="box-list-item input-item">
                        <input type="text" name="assignment-start" placeholder="DD/MM/YY">
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h6>Assignment Due Date</h6>
                    <p>Pick a date for when this assignment will be due. If this is a repeating assignment, then you can skip this step.</p>
                    <div class="box-list-item input-item">
                        <input type="text" name="assignment-end" placeholder="DD/MM/YY">
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h6>Estimated Story Points</h6>
                    <p>These are a measuring system for amount of work an assignment will take, out of 10.</p>
                    <div class="box-list-item input-item">
                        <input type="number" name="assignment-sp" min="0" max="10" step=".01">
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h6>Repeating Assignment</h6>
                    <p>If the assignment will be repeating, enter the number of days per cycle, otherwise you can skip this step.</p>
                    <div class="box-list-item input-item input-select">
                        <ul>
                            <li class="input-select-item">
                                <div class="input-select-button"></div>
                                <p class="input-select-text">This is a repeating assignment.</p>
                                <input type="hidden" name="repeating" value="0">
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="button-area">
                    <button id="createAssignment">Create Assignment!</button>
                    <button id="cancel">Cancel</button>
                </div>
            </div>
            <script type="text/javascript">
                  $(document).ready(function () {
                     setSelectInput('#assignment-creation');
                     //点击Create A NEW Category显示隐藏输入框标题
                     $("#category-title").hide();
                     $("#category-title-h6").hide();
                    $("#createCategory").click(function() {
                         $("#category-title").toggle();
                         $("#category-title-h6").toggle();
                    });
                     //点击Create将输入的文本框添加到下拉框中
                     $("#create-New-category").click(function(){
                        console.log($('input[name=category-title]').val());
                        console.log();
                        let story_id=$("#assignment-creation").attr("story_id");
                        let category_title=$('input[name=category-title]').val();

                        if(category_title==""){
                            addNotif("Unable to create the category", "Please enter the title for creating the category！", 2);
                        }else{
                            console.log("进else")
                            console.log(category_title);
                            console.log(story_id);
                            $.ajax({
                                    type:"POST",
                                    url:"http://192.168. 50.90/staff/api/assignments/createCategories",
                                    data:{storyID:story_id,category:category_title},
                                    success:function(data){
                                        console.log(data)
                                        $("dropdown-options").append(`<dropdown-options-item data-id="${data.categoryID}">[Communities] - ${category_title}</dropdown-options-item>`);

                                        $("dropdown-options-item").click(function () {
                                             console.log("点击dropdown-options-item");
                                            //得到当前点击dropdown-options-item的id值
                                            //将选中的id赋值给input标签
                                            $("input[name=category_id]").val($(this).data("id"));
                                            //把选中下框显示的值赋给dropdown-current标签
                                            $("dropdown-current").text($(this).text());
                                        })
                                    }
                                })
                        }
                     })

                     $('#createAssignment').click(function () {
                     let staffList = [];
                     for (var i = 0; i < chosenStaff.length; i++) {
                         staffList.push({staffID:chosenStaff[i].staffID,name:chosenStaff[i].name});
                     }
                      let title=$('input[name=assignment-title]').val();
                      let desc= $('textarea[name=assignment-desc]').val();
                      let category= $('input[name=categoryid]').val();
                      let start =$('input[name=assignment-start]').val();
                      let end= $('input[name=assignment-end]').val();
                      let points=$('input[name=assignment-sp]').val();
                      //
                       var reg = /^([0-9]|10)$/;
                        //addNotif("test", "hello", 2);
                        if(title==""){
                            addNotif("Unable to create the assignment", "Please enter the title！", 2);
                        }else if(desc.length<5){
                             addNotif("Unable to create the assignment", "Please enter a description of more than five characters！", 2);
                        }else if(staffList.length<=0){
                              addNotif("Unable to create the assignment", 'Please select at least 1 staff member to assign to this assignment. If there are no members, please add some in the "Manage Staff" tab if you have permission to do so.', 2);
                        }else if(category==""){
                              addNotif("Unable to create the assignment", "Please select the task category！", 2);
                        }else if(start.length<8){
                              addNotif("Unable to create the assignment", "Please enter the start date in the correct format!", 2);
                        }else if(end.length<8){
                              addNotif("Unable to create the assignment", "Please enter the due date in the correct format!", 2);
                        }else if(points=="" || !reg.test(points) || points==0){
                              addNotif("Unable to create the assignment", "Please enter story points between 1 and 10 (Whole Numbers Only)", 2);
                        }else{
                            fullPageLoad('on');
                            // api({call:'assignments', param:'create'},{
                            //         title: $('input[name=assignment-title]').val(),
                            //         desc: $('textarea[name=assignment-desc]').val(),
                            //         staff: staffList,
                            //         category: $('input[name=categoryid]').val(),
                            //         startDate: $('input[name=assignment-start]').val(),
                            //         endDate: $('input[name=assignment-end]').val(),
                            //         storyPoints: $('input[name=assignment-sp]').val(),
                            //         repeat: $('input[name=repeating]').val(),
                            //         projectID: $('[project-id]').eq(0).attr('project-id'),
                            //         storyID: <?php echo $_POST["storyID"]; ?>
                            // }, (data) => {
                            paneljs.fetch({type:'api', call:'assignments/create', postData:{
                                title: $('input[name=assignment-title]').val(),
                                desc: $('textarea[name=assignment-desc]').val(),
                                staff: staffList,
                                category: $('input[name=category_id]').val(),
                                startDate: $('input[name=assignment-start]').val(),
                                endDate: $('input[name=assignment-end]').val(),
                                storyPoints: $('input[name=assignment-sp]').val(),
                                repeat: $('input[name=repeating]').val(),
                                projectID: $('[project-id]').eq(0).attr('project-id'),
                                storyID: <?php echo $_POST["storyID"]; ?>
                            }}, (data) => {
                                console.log(data.data.assignmentID);
                                /*addAssignmentDiv({
                                    assignmentID: data.data.assignmentID,
                                    title: $('input[name=assignment-title]').val(),
                                    desc: $('textarea[name=assignment-desc]').val(),
                                    participants: chosenStaff.length,
                                    endDate: $('input[name=assignment-end]').val()
                                });*/

                                fullPageLoad('off');
                                $('#assignment-creation').addClass('float-fade-out');
                                $('#assignment-creation').find('.float-fade-out').addClass('float-fade-out');
                                $('panel-content').children('.panel-popup-active').removeClass('panel-popup-active');
                                setTimeout(function () {
                                    $('#assignment-creation').parent().remove();
                                    //传递项目id
                                    paneljs.setProject(data.data.assignmentID);
                                    //传递Storyid
                                    paneljs.proj.loadStory(<?php echo $_POST["storyID"]; ?>);
                                },750);
                            });
                        }
                     });
                     $('#cancel').click(function () {
                        if (confirm('Are you sure you want to exit out of the Assignment Creation Panel?')) {
                            $('#assignment-creation').addClass('float-fade-out');
                            $('#assignment-creation').find('.float-fade-out').addClass('float-fade-out');
                            $('panel-content').children('.panel-popup-active').removeClass('panel-popup-active');
                            setTimeout(function () {
                                //移除#assignment-update父级下的所有元素.parent()
                                $('#assignment-creation').parent().remove();
                            },750);
                        }
                     });//点击事件
                  });
              </script>
        </div>
    </div>
</div>