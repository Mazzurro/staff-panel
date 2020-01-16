<div class="panel panel-popup float-fade-in" id="assign-projects">
    <div class="panel-content">
        <div class="box-list float-fade-in">
            <div class="box-list-item">
                <div class="box-container">
                    <h3>Assign Staff Members to <?php echo Project::$projectInfo['title']; ?></h3>
                </div>
                <div class="box-list box-list-small">
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
                            setRadioInput('#assign-projects');
                            $('staff-list-department').not('.active').click(function () {
                              $('staff-list-department.active, staff-list-department-chosen.active').removeClass('active');
                              $(this).addClass('active');
                              var iconLoc = $(this).find('staff-list-department-icon'), prevIconData = '<i class="' + iconLoc.attr('dept-icon') + '"></i>';
                              iconLoc.html('<i class="fas fa-spinner fa-spin"></i>');
                              api({call:'departments',param:'staff'}, {'deptID':$(this).attr('dept-id')}, (data) => {
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
                                        <div class="box-container">
                                            <img class="staff-proj-avatar" src="`+$(this).find('staff-list-member-avatar').attr('data-url')+`">
                                            <h6>`+$(this).find('staff-list-member-name').text()+`</h6>
                                            <p>Assign Project Permissions. Each option also includes all previous options before it.</p>
                                        </div>
                                        <div class="box-list box-list-small">
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
                          <button id="cancelAssign">Cancel</button>
                      </div>
                      <script type="text/javascript">
                          $(document).ready(function () {
                             $('#updateAssign').click(function () {
                                $('#thisProject').addClass('disabled');
                                $('panel-content').addClass('loading');
                                let toChange = {};
                                for (var i = 0; i < $('#active-staff [name^=perm]').length; i++)
                                    if ($('#active-staff [name^=perm]').eq(i).val() != -1)
                                        toChange[$('#active-staff [name^=perm]').eq(i).attr('data-id')] = $('#active-staff [name^=perm]').eq(i).val();
                                api({call:'projects',param:'assign'},{staff:toChange, projectID:<?php echo Project::$projectInfo['projectID']; ?>}, (data) => {
                                    $('#assign-projects').addClass('float-fade-out');
                                    $('#assign-projects').find('.float-fade-out').addClass('float-fade-out');
                                    $('#thisProject').removeClass('panel-popup-active');
                                    $('#thisProject').removeClass('disabled');
                                    $('panel-content').removeClass('loading');
                                    setTimeout(function () {
                                        $('#assign-projects').remove();
                                    },750);
                                });
                             });
                             $('#cancelAssign').click(function () {
                                if (confirm('Are you sure you want to exit out of the Project Assignment Panel?')) {
                                    $('#assign-projects').addClass('float-fade-out');
                                    $('#assign-projects').find('.float-fade-out').addClass('float-fade-out');
                                    $('#thisProject').removeClass('panel-popup-active');
                                    setTimeout(function () {
                                        $('#assign-projects').remove();
                                    },750);
                                }
                             });
                          });
                      </script>
                    </app>
                </div>
            </div>
        </div>
    </div>
</div>