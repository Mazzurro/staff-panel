

<?php $appID = strRand(10); ?>
<div class="panel panel-popup float-fade-in" id="assignment-edit" edit-assignment-id="<?php echo $_POST['assignmentID']; ?>" story_id="<?php echo $_POST['storyID']; ?>">
    <div class="panel-content">
        <div class="box-list float-fade-in">
            <div class="box-list-item">
                <div class="box-container">
                    <h3>Update An Assignment</h3>
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
                        <dropdown id="dropdown_category">
                            <dropdown-head>
                                <dropdown-current>Pick A Category</dropdown-current>
                                <input type="hidden" name="category_id">
                            </dropdown-head>
                            <dropdown-options class="dropdown_item">
                            <?php
                                $categoryList = Assignments::getCategories($_POST["storyID"], 'Story');
                                // var_dump($categoryList);
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
                    <button id="createCategory" style="display: inline-block;">Create A New Category</button>
                    <button id="create-New-category" style="display: inline-block;">Create</button>
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
                    <button id="updateAssignment">update Assignment!</button>
                    <button id="cancel">Cancel</button>
                </div>
            </div>
<script type="text/javascript">
                  $(document).ready(function () {
                     setSelectInput('#assignment-creation');
                      $.ajax({
                        type:"POST",
                        url:"http://192.168.50.90/staff/api/assignments/list_id",
                        data:{assignmentID:$("#assignment-edit").attr('edit-assignment-id')},
                        success:function(res){

                        //截取yyyy为yy
                        let startDateYear=res[0].startDate.substring(2,4);
                        let startDateMonth=res[0].startDate.substring(5,7);
                        let startDateDay=res[0].startDate.substring(8,10);

                        let endDateYear=res[0].endDate.substring(2,4);
                        let endDateMonth=res[0].endDate.substring(5,7);
                        let endDateDay=res[0].endDate.substring(8,10);

                        let startDate=startDateDay+"/"+startDateMonth+"/"+startDateYear;
                        let endDate=endDateDay+"/"+endDateMonth+"/"+endDateYear;


                            $('input[name=assignment-title]').val(res[0].title);
                            $('textarea[name=assignment-desc]').val(res[0].description);
                            $('input[name=category_id]').val(res[0].categoryID);
                            $('input[name=assignment-start]').val(startDate);
                            $('input[name=assignment-end]').val(endDate);
                            $('input[name=assignment-sp]').val(res[0].estStoryPoints);
                            //将下拉框的id和显示值
                            $(".dropdown_item dropdown-options-item").each(function(){
                            //遍历所有dropdown-options-item
                                //将dropdown-options-item中的id与请求的categoryID匹配
                                if($(this).attr("data-id")==res[0].categoryID){
                                    $("#dropdown_category dropdown-current").text($(this).text());
                                }
                            })
                            if(res[0].repeatAssignment=="1"){
                                $('.input-select-item').addClass("active");
                                $("input[name=repeating]").val(res[0].repeatAssignment)
                            }else{
                                $('.input-select-item').removeClass("active");
                                $("input[name=repeating]").val(res[0].repeatAssignment)
                            }
                        }
                      })



                    //点击Create A NEW Category显示隐藏输入框标题
                    $("#category-title").hide();
                    $("#category-title-h6").hide();
                    $("#create-New-category").hide()
                    $("#createCategory").click(function() {
                         $("#category-title").toggle();
                         $("#category-title-h6").toggle();
                         $("#create-New-category").toggle();

                    });

                     //点击Create将输入的文本框添加到下拉框中
                     $("#create-New-category").click(function(){
                        console.log($('input[name=category-title]').val());
                        console.log($("#assignment-edit").attr("story_id"));

                        let category_title=$("#category-title input[name='category-title']").val();
                        console.log(category_title);
                        if(category_title==""){
                            addNotif("Unable to create the category", "Please enter the title for creating the category！", 2);
                        }else{
                            let category_title=$('input[name=category-title]').val();
                            $.ajax({
                                    type:"POST",
                                    url:"http://192.168.50.90/staff/api/assignments/createCategories",
                                    data:{storyID:$("#assignment-edit").attr("story_id"),category:category_title},
                                    success:function(data){
                                        console.log(data)
                                        //创建category成功后将输入框的字符清空并且将Create Category Title隐藏起来
                                        $("#category-title").hide();
                                        $("#category-title-h6").hide();
                                        $("#category-title input").val("");
                                        addNotif("Create the category", "You have created the category successfully！", 1);
                                        //将输入的值添加下拉框中，为点击下拉框某一个时设置点击事件，将点击的某一个选项的数据显示到下拉框中
                                        $("dropdown-options").append(`<dropdown-options-item data-id="${data.categoryID}">[Communities] - ${category_title}</dropdown-options-item>`);
                                        $("dropdown-options-item").click(function () {
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

                    //点击下拉框（显示/隐藏）
                     $('#dropdown_category').click(function() {
                        if ($(this).hasClass('active')) {
                            $("#dropdown_category").addClass("active");
                        }else{
                            $("#dropdown_category").removeClass("active");
                        }
                     })
                     //点击Repeating Assignment下的按钮触发（显示/隐藏）
                     $(".input-select-button").click(function(){
                       $('.input-select-item').toggleClass("active");
                       if($("input[name=repeating]").val()==0){
                            $("input[name=repeating]").val("1")
                       }else{
                            $("input[name=repeating]").val("0")
                       }
                     })

                     $('#updateAssignment').click(function () {
                     let staffList = [];
                     for (var i = 0; i < chosenStaff.length; i++) {
                         staffList.push({staffID:chosenStaff[i].staffID,name:chosenStaff[i].name});
                     }
                      let title=$('input[name=assignment-title]').val();
                      let desc= $('textarea[name=assignment-desc]').val();
                      let category= $('input[name=category_id]').val();
                      let start =$('input[name=assignment-start]').val();
                      let end= $('input[name=assignment-end]').val();
                      let points=$('input[name=assignment-sp]').val();
                       var reg = /^([0-9]|10)$/;
                        if(title==""){
                            addNotif("Unable to update the assignment", "Please enter the title！", 2);
                        }else if(desc.length<5){
                             addNotif("Unable to update the assignment", "Please enter a description of more than five characters！", 2);
                        }else if(staffList.length<=0){
                              addNotif("Unable to update the assignment", 'Please select at least 1 staff member to assign to this assignment. If there are no members, please add some in the "Manage Staff" tab if you have permission to do so.', 2);
                        }else if(category==""){
                              addNotif("Unable to update the assignment", "Please select the task category！", 2);
                        }else if(start.length<8 ||start.length>8){
                              addNotif("Unable to update the assignment", "Please enter the start date in the correct format!", 2);
                        }else if(end.length<8||end.length>8){
                              addNotif("Unable to update the assignment", "Please enter the due date in the correct format!", 2);
                        }else if(points=="" || !reg.test(points) || points==0){
                              addNotif("Unable to update the assignment", "Please enter story points between 1 and 10 (Whole Numbers Only)", 2);
                        }else{
                            fullPageLoad('on');
                            // api({call:'assignments', param:'create'},{
                            //         title: $('input[name=assignment-title]').val(),
                            //         desc: $('textarea[name=assignment-desc]').val(),
                            //         staff: staffList,
                            //         category: $('input[name=category_id]').val(),
                            //         startDate: $('input[name=assignment-start]').val(),
                            //         endDate: $('input[name=assignment-end]').val(),
                            //         storyPoints: $('input[name=assignment-sp]').val(),
                            //         repeat: $('input[name=repeating]').val(),
                            //         projectID: $('[project-id]').eq(0).attr('project-id'),
                            //         storyID: <?php echo $_POST["storyID"]; ?>
                            // }, (data) => {
                            paneljs.fetch({type:'api', call:'assignments/edit_u', postData:{
                                assignmentID:$("#assignment-edit").attr("edit-assignment-id"),
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
                                addNotif("Update the assignment", "Update task successfully", 1);
                                fullPageLoad('off');
                                $('#assignment-edit').addClass('float-fade-out');
                                $('#assignment-edit').find('.float-fade-out').addClass('float-fade-out');
                                $('panel-content').children('.panel-popup-active').removeClass('panel-popup-active');
                                setTimeout(function () {
                                    $('#assignment-edit').parent().remove();
                                    //传递项目id
                                    paneljs.setProject($('[project-id]').eq(0).attr('project-id'));
                                    //传递Storyid
                                    paneljs.proj.loadStory(<?php echo $_POST["storyID"]; ?>);
                                    //loadContent('project-story', {storyID:<?php echo $_POST["storyID"]; ?>,projectID:$('[project-id]').eq(0).attr('project-id')}, 0);
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
                                //移除#assignment-update父级下的所有元素  .parent()
                                $('#assignment-edit').parent().remove();
                            },750);
                        }
                     });//点击事件
                  });
              </script>
        </div>
    </div>
</div>