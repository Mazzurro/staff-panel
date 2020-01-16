<div class="panel panel-popup float-fade-in" id="assignment-update">
    <div class="panel-content">
        <div class="box-list float-fade-in">
            <div class="box-list-item">
                <div class="box-container">
                    <h3>Add An Update</h3>
                </div>
                <div class="box-list box-list-small">
                    <h6>Update Message</h6>
                    <p>Enter any and all updates or progress made with this assignment.</p>
                    <div class="box-list-item input-item">
                        <textarea name="update-msg"></textarea>
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h6>Update Progress</h6>
                    <p>Enter the assignments current progress to completion as a percentage (0 - 100)</p>
                    <div class="box-list-item input-item">
                        <input type="number" name="update-prog" placeholder="0 - 100">
                    </div>
                </div>
                <div class="button-area">
                    <button id="addUpdate">Add Update</button>
                    <button id="cancel">Cancel</button>
                </div>
            </div>
            <script type="text/javascript">
                  $(document).ready(function () {
                     $('#addUpdate').click(function () {

                        let msg=$("[name='update-msg']").val();
                        var progress =Number($("[name='update-prog']").val());
                        if(msg.length<5){
                            addNotif("Unable to add an update", "Please enter a message of more than five characters！", 2);
                        }else if(progress<0 || progress>100){
                            addNotif("Unable to add an update", "Please enter a percentage between 0 and 100, for example: 50", 2);
                        }else{
                            paneljs.fetch({type:'api', call:'assignments/update', postData:{
                                updateDetails: {
                                    percentComplete: $('input[name=update-prog]').val(),
                                    message: $('textarea[name=update-msg]').val()
                                },
                                    assignmentID: <?php echo $_POST["assignmentID"]; ?>
                            }}, (data) => {
                                data = data.data
                                fullPageLoad('off');
                                $('#assignment-update').addClass('float-fade-out');
                                $('#assignment-update').find('.float-fade-out').addClass('float-fade-out');
                                $('panel-content').children('.panel-popup-active').removeClass('panel-popup-active');
                                setTimeout(function () {
                                    $('#assignment-update').remove();
                                    $('#assignment-edit').parent().remove();
                                    //传递项目id
                                    //paneljs.setProject(<?php echo $_POST[""]; ?>);
                                    //传递Storyid
                                    paneljs.proj.loadStory(<?php echo $_POST["storyID"]; ?>);
                                },750);
                            });
                        }
                     });
                     $('#cancel').click(function () {
                        if (confirm('Are you sure you want to exit out of the Assignment Update Panel?')) {
                            $('#assignment-update').addClass('float-fade-out');
                            $('#assignment-update').find('.float-fade-out').addClass('float-fade-out');
                            $('panel-content').children('.panel-popup-active').removeClass('panel-popup-active');
                            setTimeout(function () {
                                //$('#assignment-update').remove();
                                //移除#assignment-update父级下的所有元素
                                $('#assignment-update').parent().remove();
                            },750);
                        }
                     });
                  });
              </script>
        </div>
    </div>
</div>