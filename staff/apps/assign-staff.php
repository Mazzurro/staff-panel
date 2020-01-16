<app app-name="staff-list">
  <staff-list>
    <staff-list-main>
      <staff-list-members>
        <staff-list-members-content></staff-list-members-content>
      </staff-list-members>
    </staff-list-main>
    <staff-list-side>
      <staff-list-side-content>
        <staff-list-department-chosen>
          <staff-list-department-content>
            <staff-list-department-icon><span>
            <?php
                $staffMembers = '';
                $i = 0;
                if (isset($assignmentID)) {
                  $getAssignedTo = db::$con->query("SELECT deptID, staffID, CONCAT(firstName, ' ', lastName) AS name, avatar, faIcon FROM workAssignmentsAssignedto, staffInfo, miscDepartments WHERE assignedTo = staffID AND workAssignmentsAssignedto.deptID = miscDepartments.departmentID AND assignmentID = ".$_GET["assignmentID"]);
                  while ($assignedTo = $getAssignedTo->fetch_assoc()) {
                    $i++;
                    $staffMembers .= '{staffID:'.$assignedTo["staffID"].', name:'.$assignedTo["name"].', deptID:'.$assignedTo["deptID"].', staffDiv:\'<staff-list-member staff-id="'.$assignedTo["staffID"].'" dept-id="'.$assignedTo["deptID"].'" class="chosen"><staff-list-member-content><staff-list-member-avatar style="background-image: url(https://72dragons.com/staff/media/images/avatars/'.$assignedTo["avatar"].')"></staff-list-member-avatar><staff-list-member-name><i class="'.$assignedTo["faIcon"].'"></i> '.$assignedTo["name"].'</staff-list-member-name></staff-list-member-content></staff-list-member>\'},';
                  }
                }
                echo $i;
            ?>
            </span></staff-list-department-icon>
            <staff-list-department-name>Chosen Staff</staff-list-department-name>
          </staff-list-department-content>
        </staff-list-department-chosen>
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
        echo "var chosenStaff = [$staffMembers];";
      ?>
      $(document).ready(function () {
      console.log("任务成员");
        console.log(chosenStaff);
        $('staff-list-department').not('.active').click(function () {
          $('staff-list-department.active, staff-list-department-chosen.active').removeClass('active');
          $(this).addClass('active');
          var iconLoc = $(this).find('staff-list-department-icon'), prevIconData = '<i class="' + iconLoc.attr('dept-icon') + '"></i>';
          iconLoc.html('<i class="fas fa-spinner fa-spin"></i>');
        //   api({call:'projects',param:'staff'}, {'deptID':$(this).attr('dept-id'),projectID:$('[project-id]').eq(0).attr('project-id')}, (data) => {
          paneljs.fetch({type:'api', call:'projects/staff', postData:{'deptID':$(this).attr('dept-id'),projectID:<?php if (isset($_POST['sagaID'])) echo $_POST['sagaID']; else {?> $('[project-id]').eq(0).attr('project-id') <?php } ?>}}, (data) => {
              data = data.data;
            $('staff-list-members-content').empty();
            for (var staff in data) {
                let staffMember = data[staff];
                $('staff-list-members-content').append(`<staff-list-member staff-id="`+staffMember.staffID+`">
                    <staff-list-member-content>
                      <staff-list-member-avatar style="background-image: url(https://72dragons.com/staff/media/images/avatars/`+staffMember.avatar+`)"></staff-list-member-avatar>
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
              if ($(this).hasClass('active')) {
                for (var i = 0; i < chosenStaff.length; i++) {
                  if (chosenStaff[i].staffID == $(this).attr('staff-id')) {
                    chosenStaff.splice(i, 1);
                    break;
                  }
                }
                $('staff-list-department-content span').text(parseInt($('staff-list-department-content span').text()) - 1);
              } else {
                var staffDiv = $(this).clone();
                staffDiv.addClass('chosen').find('staff-list-member-name').prepend('<i class="' + $('staff-list-department.active').find('staff-list-department-icon').attr('dept-icon') + '"></i> ');
        		chosenStaff.push({'staffID':$(this).attr('staff-id'),'name':$(this).find('staff-list-member-name').text(),'deptID':$(this).attr('dept-id'),'staffDiv':staffDiv});
        		$('staff-list-department-content span').text(parseInt($('staff-list-department-content span').text()) + 1);
              }
              $(this).toggleClass('active');
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
</app>