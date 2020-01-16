<?php
   include($_SERVER['DOCUMENT_ROOT']."/s/php/phpHead.php");
   
   if (isset($_GET["assignmentID"]) && ctype_digit($_GET["assignmentID"])) {
     $toValidate = 'assignment_edit';
     $assignmentID = $_GET["assignmentID"];
     include($_SERVER['DOCUMENT_ROOT']."/s/php/validate.php");
     $getAssignmentInfo = $dbStaff->query("SELECT * FROM workAssignments WHERE assignmentID = ".$_GET["assignmentID"]);
     $assignment = $getAssignmentInfo->fetch_assoc();
   }
   
   function getItem($item) {
     if ($_GET["type"] != 'edit')
       return;
     
     switch($item) {
       default:
         return $assignment["$item"];
     }
   }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $title = 'Create An Assignment'; include($_SERVER['DOCUMENT_ROOT']."/s/headInfo.php"); ?>
<link type="text/css" href="/s/temp.css" rel="stylesheet">
<script type="text/javascript" src="/s/temp.js"></script>
<style>
.hidden {
  display: none !important;
}


/*App*/
app, app *:not(script):not(style) {
  display: block;
}
staff-list {
  border: 1px #ad9440 solid;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 0 20px 2px black;
}
staff-list-main {
  height: 300px;
  background: black;
}
staff-list-side {
  border-top: 1px #ad9440 dashed;
  height: 100px;
  background: #151515;
  overflow-x: auto;
  overflow-y: hidden;
}
staff-list-side-content {
  width: -moz-max-content;
  width: max-content;
  height: 100%;
}
staff-list-members {
  overflow: auto;
  height: 300px;
}
staff-list-department, staff-list-member, staff-list-department-chosen {
  width: 120px;
  text-align: center;
  height: 100%;
  display: inline-grid !important;
  cursor: pointer;
  transition: filter 0.25s;
}
staff-list-department:hover, staff-list-department-chosen:hover {
  filter: brightness(120%);
}
staff-list-member.chosen:hover staff-list-member-avatar {
  position: relative;
  filter: grayscale(1);
}
staff-list-member.chosen:hover:before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-45deg);
    width: 50px;
    height: 10px;
    z-index: 5;
    background: #800;
}
staff-list-member.chosen:hover:after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(45deg);
    width: 50px;
    height: 10px;
    z-index: 5;
    background: #800;
}
staff-list-department.active, staff-list-department-chosen.active {
  filter: brightness(150%);
}
staff-list-member.chosen {
  position: relative;
}
staff-list-member.active {
  filter: brightness(50%);
}
staff-list-member:hover staff-list-member-avatar {
  transform: scale(1.10);
}
staff-list-member:hover staff-list-member-name {
  font-size: 0;
}
staff-list-department-content, staff-list-member-content {
  align-self: center;
}
staff-list-department-icon, staff-list-member-avatar {
  border: 1px #ad9440 solid;
  border-radius: 100%;
  width: 40px;
  height: 40px;
  margin: auto;
  font-size: 18px;
  display: grid !important;
}
staff-list-member-avatar {
  background-size: cover;
  background-position: center;
  width: 70px !important;
  height: 70px !important;
  transition: transform 0.25s;
}
staff-list-department-icon svg, staff-list-department-icon span {
  align-self: center;
  margin: auto !important;
}
staff-list-department-name, staff-list-member-name {
  font-size: 14px;
  margin: 5px;
  transition: font-size 0.25s;
}
</style>
</head>
<body>
<div class="panel">
  <?php if (isset($_GET["result"])) echo '<script>alert("The Assignment Was Created Successfully!");</script>'; ?>
  <form id="createAssignment" action="" method="post">
    <div class="panel-content">
      
      <div class="input-container">
        <div class="input-block"><h3>Week Of</h3></div>
        <div class="input-block">
          <div class="input-title">Creating The Assignment For The Week Of</div>
          <div class="input-item">
            <div class="input-select noselect" id="weekOf">
                <?php
                  $date = (!isset($assignment) ? date("l") : $assignment["weekOf"]);
                  if (date('D', strtotime($date)) == 'Fri')
                    $weekOf = date('F j, Y', strtotime($date));
                  else
                    $weekOf = date('F j, Y', strtotime("last Friday"));
                  
                  echo '<div class="input-select-current">'.date('F j', strtotime($weekOf)).'</div>
                          <div class="input-select-dropdown">';
                  
                  for ($i = -3; $i < 4; $i++) {
                    echo '<div onclick="updateDropDown($(this))" class="input-select-item" data-value="'.date('Y-m-d', strtotime($weekOf) + (60 * 60 * 24 * ($i * 7))).'">'.date('F j', strtotime($weekOf) + (60 * 60 * 24 * ($i * 7))).'</div>';
                  }
                ?>
              </div>
              <input type="hidden" name="weekOf" value="<?php echo date('Y-m-d', strtotime($weekOf)); ?>">
            </div>
          </div>
          <div class="input-error-msg"></div>
        </div>
      </div>
      
      <div class="input-container">
        <div class="input-block"><h3>Assignment Info</h3></div>
        <div class="input-block">
          <div class="input-title">Title</div>
          <div class="input-item"><input type="text" name="title" value="<?php echo (!isset($assignment) ? '' : $assignment["assignment"]); ?>"></div>
          <div class="input-error-msg"></div>
        </div>
        <div class="input-block">
          <div class="input-title">Description</div>
          <div class="input-item"><textarea name="desc"><?php echo (!isset($assignment) ? '' : $assignment["description"]); ?></textarea></div>
          <div class="input-error-msg"></div>
        </div>
      </div>
      
      <div class="input-container">
        <div class="input-block"><h3>Assign To</h3></div>
        <div class="small-heading">Assign work to multiple staff members by browsing different departments. A staff member may appear in multiple departments as they belong to said departments. If you are confused about which one to add, it will be based on what department would be in charge of completing the assignment.</div>
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
                if (isset($assignment)) {
                  $getAssignedTo = $dbStaff->query("SELECT deptID, staffID, CONCAT(firstName, ' ', lastName) AS name, avatar, faIcon FROM workAssignmentsAssignedto, staffInfo, miscDepartments WHERE assignedTo = staffID AND workAssignmentsAssignedto.deptID = miscDepartments.departmentID AND assignmentID = ".$_GET["assignmentID"]);
                  while ($assignedTo = $getAssignedTo->fetch_assoc()) {
                    $i++;
                    $staffMembers .= '{staffID:'.$assignedTo["staffID"].', deptID:'.$assignedTo["deptID"].', staffDiv:\'<staff-list-member staff-id="'.$assignedTo["staffID"].'" dept-id="'.$assignedTo["deptID"].'" class="chosen"><staff-list-member-content><staff-list-member-avatar style="background-image: url(http://72dragonsservices.com/f/images/staff/avatar/'.$assignedTo["avatar"].')"></staff-list-member-avatar><staff-list-member-name><i class="'.$assignedTo["faIcon"].'"></i> '.$assignedTo["name"].'</staff-list-member-name></staff-list-member-content></staff-list-member>\'},';
                  }
                }
                echo $i;
                    ?>
                    </span></staff-list-department-icon>
                    <staff-list-department-name>Chosen Staff</staff-list-department-name>
                  </staff-list-department-content>
                </staff-list-department-chosen>
              <?php
                $getDepartments = $dbStaff->query("SELECT departmentID, department, faIcon FROM miscDepartments");
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
                $('staff-list-department').not('.active').click(function () {
                  $('staff-list-department.active, staff-list-department-chosen.active').removeClass('active');
                  $(this).addClass('active');
                  var iconLoc = $(this).find('staff-list-department-icon'), prevIconData = '<i class="' + iconLoc.attr('dept-icon') + '"></i>';
                  iconLoc.html('<i class="fas fa-spinner fa-spin"></i>');
                  $.post('action.php', {'action':'loadStaffByDept', 'deptID':$(this).attr('dept-id')}).done(function (data) {
                    iconLoc.html(prevIconData);
                    $('staff-list-members-content').html(data);
                    autoMargins($('staff-list-members-content'), $('staff-list-member'));
                    
                    $('staff-list-member').each(function () {
                      for (var i = 0; i < chosenStaff.length; i++) {
                        if ($(this).attr('staff-id') == chosenStaff[i].staffID && $(this).attr('dept-id') == chosenStaff[i].deptID)
                          $(this).addClass('active');
                      }
                    });

                    $('staff-list-member').click(function () {
                      if ($(this).hasClass('active')) {
                        for (var i = 0; i < chosenStaff.length; i++) {
                          if (chosenStaff[i].staffID == $(this).attr('staff-id') && chosenStaff[i].deptID == $(this).attr('dept-id')) {
                            chosenStaff.splice(i, 1);
                            break;
                          }
                        }
                        $('staff-list-department-content span').text(parseInt($('staff-list-department-content span').text()) - 1);
                      } else {
                        var staffDiv = $(this).clone();
                        staffDiv.addClass('chosen').find('staff-list-member-name').prepend('<i class="' + $('staff-list-department.active').find('staff-list-department-icon').attr('dept-icon') + '"></i> ');
			chosenStaff.push({'staffID':$(this).attr('staff-id'),'deptID':$(this).attr('dept-id'),'staffDiv':staffDiv});
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
                  autoMargins($('staff-list-members-content'), $('staff-list-member'));
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
      </div>

      <div class="input-container">
        <div class="input-block"><h3>User Stories</h3></div>
        <?php
         if (isset($assignment)) {
          $userStoriesQueries = "SELECT department FROM miscDepartments WHERE departmentID = ".$assignment["departmentID"]."; SELECT story FROM workStories WHERE storyID = ".$assignment["sagaID"]."; SELECT story FROM workStories WHERE storyID = ".$assignment["epicID"]."; SELECT story FROM workStories WHERE storyID = ".$assignment["storyID"]."; SELECt category FROM workCategories WHERE categoryID = ".$assignment["categoryID"].";";
          $userStories = array("dept" => array("id" => 0, "name" => ""), "saga" => array("id" => 0, "name" => ""), "epic" => array("id" => 0, "name" => ""), "story" => array("id" => 0, "name" => ""), "category" => array("id" => 0, "name" => ""));
          $count = 0;
          $dbStaff->multi_query($userStoriesQueries);
          do {
            if ($userStoryResult = $dbStaff->store_result()) {
              while ($userStory = $userStoryResult->fetch_assoc()) {
                switch ($count++) {
                  case 0:
                    $userStories["dept"]["id"] = $assignment["departmentID"];
                    $userStories["dept"]["name"] = $userStory["department"];
                  break;
                  case 1:
                    $userStories["saga"]["id"] = $assignment["sagaID"];
                    $userStories["saga"]["name"] = $userStory["story"];
                  break;
                  case 2:
                    $userStories["epic"]["id"] = $assignment["epicID"];
                    $userStories["epic"]["name"] = $userStory["story"];
                  break;
                  case 3:
                    $userStories["story"]["id"] = $assignment["storyID"];
                    $userStories["story"]["name"] = $userStory["story"];
                  break;
                  case 4:
                    $userStories["category"]["id"] = $assignment["categoryID"];
                    $userStories["category"]["name"] = $userStory["category"];
                  break;
                }
              }
              $userStoryResult->free();
            }
          } while ($dbStaff->more_results() && $dbStaff->next_result());
         }
        ?>
        <div class="input-block">
          <div class="input-title">Department
            <div class="input-notice"><i class="fas fa-question-circle"></i></div>
          </div>
          <div class="input-notice-item">
            <p>The department where the user stories will be located under.</p>
          </div>
          <div class="input-item">
            <div class="input-select noselect" id="dept">
              <div class="input-select-current"><?php echo (!isset($assignment) ? 'Choose A Department' : $userStories["dept"]["name"]); ?></div>
              <div class="input-select-dropdown">
                <?php
                  $i = 0;
                  foreach($_SESSION["user"]["depts"]["departments"] as $department) {
                    echo '<div onclick="updateLocDropDown(\'saga\', $(this))" class="input-select-item" data-value="'.$department["id"].'">'.$department["name"].'</div>';
                    $i++;
                  }
                  if ($i == 0)
                    echo '<div onclick="updateLocDropDown(\'saga\', $(this))" class="input-select-item" data-value="N/A">You Aren\'t In Any Departments</div>';
                ?>
              </div>
              <input type="hidden" name="dept" value="<?php echo (!isset($assignment) ? '' : $userStories["dept"]["id"]); ?>">
            </div>
          </div>
          <div class="input-error-msg"></div>
        </div>
        <div class="input-block">
          <div class="input-title">Saga
            <div class="input-notice"><i class="fas fa-question-circle"></i></div>
          </div>
          <div class="input-notice-item">
            <p>Saga items are the main groupings of each section. For Productions, it may be films, clients, events, etc. While Sales may have them listed as products, clients, etc.</p>
          </div>
          <div class="input-item">
            <div class="input-select <?php echo (isset($assignment) ? '' : 'noselect disabled noclick'); ?>" id="saga">
              <div class="input-select-current"><?php echo (!isset($assignment) ? 'Choose A Department First' : $userStories["saga"]["name"]); ?></div>
              <div class="input-select-dropdown">
                <?php
                 if (isset($assignment)) {
                  $i = 0;
                  $getStories = mysqli_query($dbStaff, "SELECT storyID, story FROM workStories WHERE parentID = ".$userStories["dept"]["id"]." AND type = 'Saga' ORDER BY Story ASC;");
                  while ($story = mysqli_fetch_array($getStories)) {
                    $i++;
                    echo '<div onclick="updateLocDropDown(\'epic\', $(this))" class="input-select-item" data-value="'.$story["storyID"].'">'.$story["story"].'</div>';
                  }
                  if ($i == 0)
                    echo '<div onclick="updateLocDropDown(\'epic\', $(this))" class="input-select-item" data-value="N/A">No Sagas Found</div>';
                 }
                ?>
              </div>
              <input type="hidden" name="saga" value="<?php echo (!isset($assignment) ? '' : $userStories["saga"]["id"]); ?>">
            </div>
          </div>
          <div class="input-error-msg"></div>
        </div>
        <div class="input-block">
          <div class="input-title">Epic
            <div class="input-notice"><i class="fas fa-question-circle"></i></div>
          </div>
          <div class="input-notice-item">
            <p>The Epic is the topic of your assignment. If you're creating an assignment about editing Big In Asia, then the Epic would be 'Big In Asia'.</p><!--'-->
          </div>
          <div class="input-item">
            <div class="input-select <?php echo (isset($assignment) ? '' : 'noselect disabled noclick'); ?>" id="epic">
              <div class="input-select-current"><?php echo (!isset($assignment) ? 'Choose A Saga First' : $userStories["epic"]["name"]); ?></div>
              <div class="input-select-dropdown">
                <?php
                 if (isset($assignment)) {
                  $i = 0;
                  $getStories = mysqli_query($dbStaff, "SELECT storyID, story FROM workStories WHERE parentID = ".$userStories["saga"]["id"]." AND type = 'Epic' ORDER BY Story ASC;");
                  while ($story = mysqli_fetch_array($getStories)) {
                    $i++;
                    echo '<div onclick="updateLocDropDown(\'story\', $(this))" class="input-select-item" data-value="'.$story["storyID"].'">'.$story["story"].'</div>';
                  }
                  if ($i == 0)
                    echo '<div onclick="updateLocDropDown(\'story\', $(this))" class="input-select-item" data-value="N/A">No Epics Found</div>';
                 }
                ?>
              </div>
              <input type="hidden" name="epic" value="<?php echo (!isset($assignment) ? '' : $userStories["epic"]["id"]); ?>">
            </div>
          </div>
          <div class="input-error-msg"></div>
        </div>
        <div class="input-block">
          <div class="input-title">Story
            <div class="input-notice"><i class="fas fa-question-circle"></i></div>
          </div>
          <div class="input-notice-item">
            <p>A Story would the focus of your assignment. For example, if you are creating an assignment for the filming of 'Father', your Story would be titled 'Filming' and be under the Epic 'Father', which would be under the Saga 'Films'.</p>
            <p>If this seems to be the same as the assignment, then the assignment may not be specific. A good assignment for the filming of 'Father' may be 'Filming Father In Boston Park', while the story items would be as they are in the previous paragraph.</p>
          </div>
          <div class="input-item">
            <div class="input-select <?php echo (isset($assignment) ? '' : 'noselect disabled noclick'); ?>" id="story">
              <div class="input-select-current"><?php echo (!isset($assignment) ? 'Choose An Epic First' : $userStories["story"]["name"]); ?></div>
              <div class="input-select-dropdown">
                <?php
                 if (isset($assignment)) {
                  $i = 0;
                  $getStories = mysqli_query($dbStaff, "SELECT storyID, story FROM workStories WHERE parentID = ".$userStories["epic"]["id"]." AND type = 'Story' ORDER BY Story ASC;");
                  while ($story = mysqli_fetch_array($getStories)) {
                    $i++;
                    echo '<div onclick="updateDropDown($(this))" class="input-select-item" data-value="'.$story["storyID"].'">'.$story["story"].'</div>';
                  }
                  if ($i == 0)
                    echo '<div onclick="updateDropDown($(this))" class="input-select-item" data-value="N/A">No Stories Found</div>';
                 }
                ?>
              </div>
              <input type="hidden" name="story" value="<?php echo (!isset($assignment) ? '' : $userStories["story"]["id"]); ?>">
            </div>
          </div>
          <div class="input-error-msg"></div>
        </div>
       <div class="panel-open panel panel-expand" style="background:none;">
        <div class="small-heading panel-open-toggle" onclick="$(this).next().css('height', $(this).next().children().outerHeight() - $(this).next().height() + 'px')">Create A Story Item</div>
        <div class="panel-open-content">
          <div class="panel-content">
            <div class="small-heading">Select Which Kind Of Story Item You Want To Create</div>
            <div class="input-block input-radio">
              <div class="input-radio-item">
                <div class="input-radio-button" data-name="saga"></div>
                <div class="input-title">Saga</div>
              </div>
              <div class="input-radio-item">
                <div class="input-radio-button" data-name="epic"></div>
                <div class="input-title">Epic</div>
              </div>
              <div class="input-radio-item">
                <div class="input-radio-button" data-name="story"></div>
                <div class="input-title">Story</div>
              </div>
              <div class="input-error-msg"></div>
              <input type="hidden" name="storytoCreate">
            </div>
            <div class="small-heading">Once You Select The Item Type, Pick What Parent You Want To Connect It To In The Dropdowns Above (If Applicable)</div>
            <div class="small-heading">(Example: If you decide to create an Epic, you would select an item from the Saga dropdown above that you would want the Epic to be listen under. If the item type is a Saga, then it will be created under which ever department you are creating this assignment for and you will not need to pick from the dropdowns above to connect it.)</div>
            <div class="input-block">
              <input type="text" name="addStory" value="" placeholder="Story Name">
              <div class="small-heading status-msg"></div>
              <button class="submit" panel-open-type="story">Add</button>
              <div class="small-heading">Once Created, The Item Will Be Automatically Added To The Dropdown List Above.</div>
            </div>
          </div>
        </div>
       </div>
      </div>
      
      <div class="input-container">
        <div class="input-block"><h3>Category Type</h3></div>
        <div class="input-block">
          <div class="input-title">Category
            <div class="input-notice"><i class="fas fa-question-circle"></i></div>
          </div>
          <div class="input-notice-item">
            <p>Categories are different from story items in the sense that they are broader. An example would be the Web Team having 'Web Page' or 'Sitemap' as one of their categories, while Production Services have 'Editing'.</p>
            <p>If you feel the category your assignment goes under is not listed, then you may create one by clicking 'Add A Category' below.</p>
          </div>
          <div class="input-item">
            <div class="input-select <?php echo (isset($assignment) ? '' : 'noselect disabled noclick'); ?>" id="category">
              <div class="input-select-current"><?php echo (!isset($assignment) ? 'Choose A Department First' : $userStories["category"]["name"]); ?></div>
              <div class="input-select-dropdown">
                <?php
                 if (isset($assignment)) {
                  $i = 0;
                  $getCategories = mysqli_query($dbStaff, "SELECT categoryID, category FROM workCategories WHERE departmentID = ".$userStories["dept"]["id"]." ORDER BY category ASC;");
                  while ($category = mysqli_fetch_array($getCategories)) {
                    $i++;
                    echo '<div onclick="updateDropDown($(this))" class="input-select-item" data-value="'.$category["categoryID"].'">'.$category["category"].'</div>';
                  }
                  if ($i == 0)
                    echo '<div onclick="updateDropDown($(this))" class="input-select-item" data-value="N/A">No Categories Found</div>';
                 }
                ?>
              </div>
              <input type="hidden" name="category" value="<?php echo (!isset($assignment) ? '' : $userStories["category"]["id"]); ?>">
            </div>
          </div>
          <div class="input-error-msg"></div>
        </div>
       <div class="panel-open panel panel-expand" style="background:none;">
        <div class="small-heading panel-open-toggle">Create A Category</div>
        <div class="panel-open-content">
          <div class="panel-content">
            <div class="input-block">
              <input type="text" name="addCategory" value="" placeholder="Category Name">
              <div class="small-heading status-msg"></div>
              <button class="submit" panel-open-type="category">Add</button>
            </div>
          </div>
        </div>
       </div>
      </div>
      
      <div class="input-container">
        <div class="input-block"><h3>Additional Details</h3></div>
        <div class="input-block">
          <div class="input-checkbox-item">
            <div class="input-checkbox-button <?php echo (!isset($assignment) || !$assignment["isPlanned"] ? '' : 'input-checkbox-clicked'); ?>"></div>
            <div class="input-title"><p>This Assignment Was Planned At The Beginning Of The Week.</p></div>
            <input type="hidden" name="isPlanned" value="<?php echo (!isset($assignment) ? '' : $assignment["isPlanned"]); ?>">
          </div>
        </div>
        <div class="input-block">
          <div class="input-checkbox-item">
            <div class="input-checkbox-button <?php echo (!isset($assignment) || !$assignment["isNew"] ? '' : 'input-checkbox-clicked'); ?>"></div>
            <div class="input-title"><p>This Assignment Was Not Assigned Last Week</p></div>
            <input type="hidden" name="isNew" value="<?php echo (!isset($assignment) ? '' : $assignment["isNew"]); ?>">
          </div>
        </div>
        <div class="input-block">
          <div class="input-title">Estimated Story Points
            <div class="input-notice"><i class="fas fa-question-circle"></i></div>
          </div>
          <div class="input-notice-item">
            <p>Estimated story points are the level of difficulty / amount of time an assignment may be/take. The levels range from 1 to 10, with 1 being the lowest difficulty and 10 being the heighest.</p>
          </div>
          <div class="input-item"><input type="number" name="estSP" value="<?php echo (!isset($assignment) ? '' : $assignment["estStoryPoints"]); ?>" max="10" min="1"></div>
          <div class="input-error-msg"></div>
        </div>
        <div class="input-block">
          <div class="input-title">Day Due This Week</div>
          <div class="input-item">
            <div class="input-select noselect" id="dueDate">
              <div class="input-select-current"><?php echo (!isset($assignment) ? 'Day Due' : date('l', strtotime($assignment["dueDate"]))); ?></div>
              <div class="input-select-dropdown">
                <?php
                  $date = new DateTime('now');
                  if ($date->format('D') == 'Fri')
                    $weekOf = $date->format('F j, Y');
                  else
                    $weekOf = date('F j, Y', strtotime("last Friday"));
                  
                  for ($i = 0; $i < 7; $i++) {
                    echo '<div onclick="updateDropDown($(this))" class="input-select-item" data-value="'.$i.'">'.date('l', strtotime($weekOf) + (60 * 60 * 24 * $i)).'</div>';
                  }
                ?>
              </div>
              <input type="hidden" name="dueDate" value="<?php echo (!isset($assignment) ? 'Day Due' : (date('N', strtotime($assignment["dueDate"])) + 2) % 7); ?>">
            </div>
          </div>
          <div class="input-error-msg"></div>
        </div>
      </div>
      
      <?php if ($_GET["type"] == 'edit') { ?>
      <div class="input-container">
        <div class="input-block"><h3>Assignment Completion Details</h3></div>
        <div class="input-block">
          <div class="input-checkbox-item">
            <div class="input-checkbox-button <?php if($assignment["wasCompleted"]) echo 'input-checkbox-clicked'; ?>"></div>
            <div class="input-title"><p>This Assignment Was Completed</p></div>
            <input type="hidden" name="wasCompleted" value="<?php echo $assignment["wasCompleted"]; ?>">
          </div>
        </div>
        <div class="input-block <?php if(!$assignment["wasCompleted"]) echo 'hidden'; ?>">
          <div class="input-title">Day Completed This Week</div>
          <div class="input-item">
            <div class="input-select noselect" id="completedDate">
              <div class="input-select-current"><?php echo (!isset($assignment) ? 'Day Completed' : date('l', strtotime($assignment["dateCompleted"]))); ?></div>
              <div class="input-select-dropdown">
                <?php
                  for ($i = 0; $i < 7; $i++) {
                    echo '<div onclick="updateDropDown($(this))" class="input-select-item" data-value="'.$i.'">'.date('l', strtotime($weekOf) + (60 * 60 * 24 * $i)).'</div>';
                  }
                ?>
              </div>
              <input type="hidden" name="completedDate" value="<?php echo (!isset($assignment) ? 'Day Due' : (date('N', strtotime($assignment["dateCompleted"])) + 2) % 7); ?>">
            </div>
          </div>
          <div class="input-error-msg"></div>
        </div>
        <div class="input-block">
          <div class="input-checkbox-item">
            <div class="input-checkbox-button <?php if($assignment["needsMoreWork"]) echo 'input-checkbox-clicked'; ?>"></div>
            <div class="input-title"><p>This Assignment Needs More Work</p></div>
            <input type="hidden" name="needsMoreWork" value="<?php echo $assignment["needsMoreWork"]; ?>">
          </div>
        </div>
        <div class="input-block">
          <div class="input-title">Actual Story Points
            <div class="input-notice"><i class="fas fa-question-circle"></i></div>
          </div>
          <div class="input-notice-item">
            <p>Actual story points are the level of completion reached on the assignment for this week relative to the story points. If you listed 5 estimated story points, and was able to get 70% of the assignment completed, then you would list 3.5 as the actual story points.</p>
          </div>
          <div class="input-item"><input type="number" name="actSP" value="<?php echo $assignment["actStoryPoints"]; ?>" max="10" min="0"></div>
          <div class="input-error-msg"></div>
        </div>
      </div>
      
      <div class="input-container">
        <div class="input-block"><h3>Accomplishments And Comments</h3></div>
        <div class="input-block">
          <div class="input-title">Accomplishment</div>
          <div class="input-item"><textarea name="acc"><?php echo $assignment["accomplishment"]; ?></textarea></div>
          <div class="input-error-msg"></div>
        </div>
        <div class="input-block">
          <div class="input-checkbox-item">
            <div class="input-checkbox-button <?php if($assignment["isKeyAccomplishment"]) echo 'input-checkbox-clicked'; ?>"></div>
            <div class="input-title"><p>This Was A Key Accomplishment For The Week</p></div>
            <input type="hidden" name="keyAcc" value="<?php echo $assignment["isKeyAccomplishment"]; ?>">
          </div>
        </div>
        <div class="input-block">
          <div class="input-title">Comment</div>
          <div class="input-item"><textarea name="comment"><?php echo $assignment["comment"]; ?></textarea></div>
          <div class="input-error-msg"></div>
        </div>
      </div>
      <?php } ?>
      
      
      <input type="hidden" name="action" value="submit">
      <input type="hidden" name="sub_type" value="<?php echo ($_GET["type"] == 'edit' ? 'edit' : 'add'); ?>">
      <?php if ($_GET["type"] == 'edit') echo '<input type="hidden" name="assignmentID" value="'.$assignment["assignmentID"].'">'; ?>
      <button class="submit" id="sendForm"><?php echo ($_GET["type"] == 'edit' ? 'Update' : 'Create'); ?></button>
    </div>
  </form>
</div>
<script type="text/javascript">
$(document).ready(function() {  
  
  $('.panel-open-toggle').click(function () {
    if ($(this).next().height() == 0)
      $(this).next().css('height', $(this).next().children().outerHeight() + 'px');
    else
      $(this).next().css('height', '0px');
  });
  
  
  $('#createAssignment').submit(function (e) {
    e.preventDefault();
  });
  
  $('#sendForm').click(function () {
    $('#sendForm').html('<i class="fas fa-spinner fa-spin"></i>').addClass('disabled noclick');
    for (var i = 0; i < chosenStaff.length; i++) {
      $(this).before('<input type="hidden" name="deptID[]" value="'+chosenStaff[i].deptID+'"><input type="hidden" name="staffID[]" value="'+chosenStaff[i].staffID+'">');
    }
    $.post('action.php', $('#createAssignment').serialize()).done(function (data) {
      <?php echo ($_GET["type"] == 'edit' ? "addNotif(['Assignment Updated', 'Your assignment was updated successfully.'], 1);" : 'window.location.replace("create.php?result=success&type=add");'); ?>
    }).fail(function (data) {
      addNotif(['An Error Occured', data.responseJSON.message], 2);
    }).always(function () {
      $('#sendForm').html('<?php echo ($_GET["type"] == 'edit' ? 'Update' : 'Create'); ?>').removeClass('disabled noclick');
    });
  });
  
  $('input[name=wasCompleted]').closest('.input-checkbox-item').click(function () {
    $('#completedDate').closest('.input-block').toggleClass('hidden');
  });
  
  $('.panel-open button').click(function () {
    var formData = new FormData(), smallForm = $(this).closest('.panel-open-content'), button = $(this), addType = $(this).attr('panel-open-type');
    switch(addType) {
      case 'story':
        var storyType = $('input[name=storytoCreate]').val(), storyName = $('input[name=addStory]').val();
        formData.append('action', 'addStory');
        formData.append('storyName', storyName);
        formData.append('storyType', storyType);
        switch (storyType) {
          case 'saga':
            formData.append('parentID', $('input[name=dept]').val());
          break;
          case 'epic':
            formData.append('parentID', $('input[name=saga]').val());
          break;
          case 'story':
            formData.append('parentID', $('input[name=epic]').val());
          break;
        }
      break;
      case 'category':
        var categoryName = smallForm.find('input[name=addCategory]').val();
        formData.append('action', 'addCategory');
        formData.append('departmentID', $('input[name=dept]').val());
        formData.append('categoryName', categoryName);
      break;
      default:
        return false;
    }
    
    smallForm.find('.small-heading.status-msg').empty();
    button.html('<i class="fas fa-spinner fa-spin"></i>').addClass('disabled noclick');
    
    $.ajax({
      type: 'POST',
      url: '/s/old_assignments/action.php',
      data: formData,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(data) {
      smallForm.find('.small-heading.status-msg').css('color', '#006600').text('Added Successfully!');
      switch(addType) {
        case 'story':
          switch (storyType) {
            case 'saga':
              $('#saga').find('.input-select-dropdown').append('<div onclick="updateLocDropDown(\'epic\', $(this))" class="input-select-item" data-value="' + data + '">' + storyName + '</div>');
            break;
            case 'epic':
              $('#epic').find('.input-select-dropdown').append('<div onclick="updateLocDropDown(\'story\', $(this))" class="input-select-item" data-value="' + data + '">' + storyName + '</div>');
            break;
            case 'story':
              $('#story').find('.input-select-dropdown').append('<div onclick="updateDropDown($(this))" class="input-select-item" data-value="' + data + '">' + storyName + '</div>');
            break;
          }
        break;
        case 'category':
          $('#category .input-select-dropdown').append('<div onclick="updateDropDown($(this))" class="input-select-item" data-value="' + data + '">' + categoryName + '</div>');
        break;
      }
      $('#' + storyType).removeClass('noselect disabled noclick');
    }).fail(function(data) {
      smallForm.find('.small-heading.status-msg').css('color', '#800000').text(data.responseJSON.message);
    }).always(function() {
      button.html('Add').removeClass('disabled noclick');
    });
  });
});

function resetDropDown(dropDown, isValid) {
  var type = dropDown.find('.input-select').attr('id');
  if (!isValid)
    dropDown.find('.input-select').addClass('noselect disabled noclick');
  
  dropDown.find('.input-select-dropdown').empty();
  dropDown.find('.input-select-current').text('Choose A(n) ' + type.charAt(0).toUpperCase() + type.substr(1).toLowerCase())
  dropDown.find('input').val('');
  
  switch(type) {
    case 'saga':
      updateLocDropDown('saga', null);
    break;
    case 'epic':
      resetDropDown($('#story').closest('.input-block'), false);
    break;
    case 'category':
      $.post('/s/old_assignments/action.php', {'action': 'getCategories', 'departmentID': $('input[name=dept]').val()}, function (data) {
        data = JSON.parse(data);
        for (var i = 0; i < data.length; i++)
          $('#category .input-select-dropdown').append('<div onclick="updateDropDown($(this))" class="input-select-item" data-value="' + data[i].categoryID + '">' + data[i].categoryName + '</div>');
        $('#category').removeClass('noselect disabled noclick');
      });
    break;
  }
}

function updateLocDropDown(toUpdate, dropDown) {
  if (dropDown != null)
    updateDropDown(dropDown);
  var formData = new FormData(), TUdropDown = $('#' + toUpdate);
  formData.append('action', 'getStory');
  formData.append('storyType', toUpdate);
  formData.append('parentID', dropDown.attr('data-value'));
  TUdropDown.find('.input-select-dropdown').empty().append('<div class="input-select-item">Loading...</div>');
  
  $.ajax({
      type: 'POST',
      url: '/s/old_assignments/action.php',
      data: formData,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(data) {
      data = JSON.parse(data);
      TUdropDown.find('.input-select-dropdown').empty();
      TUdropDown.find('input').val('');
      
      if (data.length == 0) {
        TUdropDown.find('.input-select-current').text('No Items Found');
        TUdropDown.addClass('noselect disabled noclick');
      } else
        TUdropDown.find('.input-select-current').text('Choose A(n) ' + toUpdate.charAt(0).toUpperCase() + toUpdate.substr(1).toLowerCase());
        
      switch(toUpdate) {
        case 'saga':
          resetDropDown($('#category').closest('.input-block'), true);
          for (var i = 0; i < data.length; i++)
            TUdropDown.removeClass('noselect disabled noclick').find('.input-select-dropdown').append('<div onclick="updateLocDropDown(\'epic\', $(this))" class="input-select-item" data-value="' + data[i].storyID + '">' + data[i].storyName + '</div>');
          resetDropDown($('#epic').closest('.input-block'), false);
        break;
        case 'epic':
          for (var i = 0; i < data.length; i++)
            TUdropDown.removeClass('noselect disabled noclick').find('.input-select-dropdown').append('<div onclick="updateLocDropDown(\'story\', $(this))" class="input-select-item" data-value="' + data[i].storyID + '">' + data[i].storyName + '</div>');
          resetDropDown($('#story').closest('.input-block'), false);
        break;
        case 'story':
          for (var i = 0; i < data.length; i++)
            TUdropDown.removeClass('noselect disabled noclick').find('.input-select-dropdown').append('<div onclick="updateDropDown($(this))" class="input-select-item" data-value="' + data[i].storyID + '">' + data[i].storyName + '</div>');
        break;
      }
    }).fail(function(data) {
      alert(data.responseJSON.message);
    });
}
</script>
</body>
</html>

<?php include($_SERVER['DOCUMENT_ROOT']."/s/php/phpFoot.php"); ?>