<?php $projectInfo = Project::loadProject($_POST["projectID"]); ?>
<div class="box-list float-fade-in" id="manage-project-staff">
    <div class="box-list-item">
        <div class="box-container box-manage-staff">
            <h3>Assign Staff Members to <?php echo Project::$projectInfo['title']; ?></h3>
        </div>
        <div class="box-list box-list-small box-small-manage-staff">
            <app app-name="staff-list">
              <staff-list>
                <staff-list-main>
                  <staff-list-members>
                    <staff-list-members-content></staff-list-members-content>
                  </staff-list-members>
                </staff-list-main>
                <staff-list-side>
                  <staff-list-side-content>
                  <?php
                    if ($_SESSION["me"]["clearLevel"] > 2)
                        $getDepartments = db::$con->query("SELECT departmentID, department, faIcon FROM miscDepartments");
                    else
                        $getDepartments = db::$con->query("SELECT departmentID, department, faIcon FROM miscDepartments WHERE departmentID IN (".implode(',',array_keys(StaffMember::$me["depts"]["departments"])).")");
                    while ($department = $getDepartments->fetch_assoc()) {
                      echo '<staff-list-department dept-id="'.$department["departmentID"].'">
                              <staff-list-department-content>
                                <staff-list-department-icon dept-icon="'.$department["faIcon"].'"><i class="'.$department["faIcon"].'"></i></staff-list-department-icon>
                                <staff-list-department-name>'.$department["department"].'</staff-list-department-name>
                              </staff-list-department-content>
                            </staff-list-department>';
                    }
                  ?>
                  </staff-list-side-content>
                </staff-list-side>
                <script type="text/javascript">
                  <?php
                    $getParts = Project::getProjectParticipants();
                    echo "var chosenStaff = [".implode(',',array_keys($getParts))."];";
                  ?>
                  $(document).ready(function () {
                    setRadioInput('#active-staff');
                    $('staff-list-department').not('.active').click(function () {
                        $('staff-list-department.active, staff-list-department-chosen.active').removeClass('active');
                        $(this).addClass('active');
                        var iconLoc = $(this).find('staff-list-department-icon'), prevIconData = '<i class="' + iconLoc.attr('dept-icon') + '"></i>';
                        iconLoc.html('<i class="fas fa-spinner fa-spin"></i>');
                      
                        paneljs.fetch({type:'api', call:'departments/staff', postData:{'deptID':$(this).attr('dept-id')}}, (data) => {
                            if (!data.status) {
                                addNotif('Staff Load Error', 'An error occured while loading the staff list.', 2);
                                return false;
                            }
                            
                            data = data.data; //data data data data data
                            
                            $('staff-list-members-content').empty();
                            for (var staff in data) {
                                let staffMember = data[staff];
                                $('staff-list-members-content').append(`<staff-list-member staff-id="`+staffMember.staffID+`">
                                    <staff-list-member-content>
                                      <staff-list-member-avatar data-url="https://72dragons.com/staff/media/images/avatars/`+staffMember.avatar+`" style="background-image: url(https://72dragons.com/staff/media/images/avatars/`+staffMember.avatar+`)"></staff-list-member-avatar>
                                      <staff-list-member-name>`+staffMember.firstName+` `+staffMember.lastName+`</staff-list-member-name>
                                    </staff-list-member-content>
                                  </staff-list-member>`);
                            }
                            iconLoc.html(prevIconData);
                            
                            $('staff-list-member').each(function () {
                              for (var i = 0; i < chosenStaff.length; i++) {
                                if ($(this).attr('staff-id') == chosenStaff[i].staffID)
                                  $(this).addClass('active');
                              }
                            });
                
                            $('staff-list-member').click(function () {
                              if (!$(this).hasClass('active')) {
                                $(this).addClass('active');
                                chosenStaff.push({'staffID':$(this).attr('staff-id')});
                        		$('#active-staff').prepend(`<div class="box-list-item">
                                    <div class="box-container box-manage-staff">
                                        <img class="staff-proj-avatar" src="`+$(this).find('staff-list-member-avatar').attr('data-url')+`">
                                        <h6>`+$(this).find('staff-list-member-name').text()+`</h6>
                                        <p>Assign Project Permissions. Each option also includes all previous options before it.</p>
                                    </div>
                                    <div class="box-list box-list-small box-small-manage-staff">
                                        <div class="box-list-item input-item input-select isb-radio">
                                            <ul>
                                            <?php
                                                $permTitle = array('Remove From Project', 'View Only', 'View And Add Updates To Assigned Assignments.', 'View All Assignments', 'Create Epics, Stories, And Assignments. Add Updates To All Assignments.', 'Edit Project Details And Manage Participants.');
                                                for ($i = 0; $i < count($permTitle); $i++) {
                                                    echo '<li class="input-select-item'.(2 == $i ? ' active' : '').'">
                                                            <div class="input-select-button"></div>
                                                            <p class="input-select-text">'.$permTitle[$i].'</p>
                                                            <input type="hidden" name="inputval" value="'.$i.'">
                                                        </li>';
                                                }
                                            ?>
                                            </ul>
                                            <input type="hidden" name="perm[`+$(this).attr('staff-id')+`]" data-id="`+$(this).attr('staff-id')+`" value="2">
                                        </div>
                                    </div>
                                 </div>`);
                                 setRadioInput($('#active-staff').children('.box-list-item').eq(0));
                              }
                            });
                        });
                    });
                    
                    $('staff-list-department-chosen').click(function () {
                      $('staff-list-department.active').removeClass('active');
                      $(this).addClass('active');
                      $('staff-list-members-content').empty();
                      for (var i = 0; i < chosenStaff.length; i++) {
                        $('staff-list-members-content').append(chosenStaff[i].staffDiv);
                      }
                      $('staff-list-member.chosen').click(function () {
                        chosenStaff.splice($('staff-list-member.chosen').index($(this)), 1);
                        $(this).remove();
                        $('staff-list-department-content span').text(parseInt($('staff-list-department-content span').text()) - 1);
                      });
                    });
                  });
                </script>
              </staff-list>
              <div class="box-list" id="active-staff">
                 <?php
                    foreach ($getParts as $staff) {
                        echo '<div class="box-list-item">
                            <div class="box-container">
                                <img class="staff-proj-avatar" src="https://72dragons.com/staff/media/images/avatars/'.$staff['avatar'].'">
                                <h6>'.$staff['firstName'].(isset($staff['middleName']) ? ' '.$staff['middleName'].' ' : ' ').$staff['lastName'].'</h6>
                                <p>Assign Project Permissions. Each option also includes all previous options before it.</p>
                            </div>
                            <div class="box-list box-list-small">
                                <div class="box-list-item input-item input-select isb-radio">
                                    <ul>';
                                    for ($i = 0; $i < count($permTitle); $i++) {
                                        echo '<li class="input-select-item'.($staff["permissionLevel"] == $i ? ' active' : '').'">
                                                <div class="input-select-button"></div>
                                                <p class="input-select-text">'.$permTitle[$i].'</p>
                                                <input type="hidden" name="inputval" value="'.$i.'">
                                            </li>';
                                    }
                                    echo '</ul>
                                    <input type="hidden" name="perm['.$staff['staffID'].']" data-id="'.$staff['staffID'].'" value="-1">
                                </div>
                            </div>
                         </div>';
                    }
                 ?>
              </div>
              <div class="button-area">
                  <button id="updateAssign">Update</button>
              </div>
              <script type="text/javascript">
                  $(document).ready(function () {
                     $('#updateAssign').click(function () {
                        $('panel-content').children().eq(0).addClass('disabled');
                        $('panel-content').addClass('loading');
                        let toChange = {};
                        
                        for (var i = 0; i < $('#active-staff [name^=perm]').length; i++)
                            if ($('#active-staff [name^=perm]').eq(i).val() != -1)
                                toChange[$('#active-staff [name^=perm]').eq(i).attr('data-id')] = $('#active-staff [name^=perm]').eq(i).val();
                        
                        paneljs.fetch({type:'api', call:'projects/assign', postData:{staff:toChange, projectID:<?php echo Project::$projectInfo['projectID']; ?>}}, (result) => {
                            if (result.status) {
                                addNotif('Staff Updated Successfully', 'The project has been updated with the chosen staff members and permissions.', 1);
                                let appParent = $('#manage-project-staff').parent();
                                appParent.empty().addClass('loading');
                                paneljs.fetch({type:'section', call:'project-staff', postData:{projectID:<?php echo Project::$projectInfo['projectID']; ?>}}, (result) => {
                                       html(result.data).removeClass('loading');
                                });
                            }
                            else addNotif('Staff Update Error', 'An error occured updating the project staff information.', 2);
                            
                            $('panel-content').children().eq(0).removeClass('disabled');
                            $('panel-content').removeClass('loading');
                        });
                     });
                  });
              </script>
            </app>
        </div>
    </div>
</div>