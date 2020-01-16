<?php
   include($_SERVER['DOCUMENT_ROOT']."/s/php/phpHead.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $title = 'Browse Assignments'; include($_SERVER['DOCUMENT_ROOT']."/s/headInfo.php"); ?>
<link type="text/css" href="/s/temp.css" rel="stylesheet">
<script type="text/javascript" src="/s/temp.js"></script>
</head>
<body>
<div id="assignment-cms" class="loading">
  <iframe id="cms-iframe" src=""></iframe>
</div>
<div class="panel" id="assignments">
  <div class="panel-content">
    <div class="input-container">
      <div class="input-block"><h3>Manage Assignments</h3></div>
      <div class="input-block">
        <div class="input-title">Show Assignments For The Week Of</div>
        <div class="input-item">
          <div class="input-select noselect" id="weekOf">
            <div class="input-select-current">Select A Week</div>
            <div class="input-select-dropdown">
              <?php
                $getWeeks = $dbStaff->query("SELECT DISTINCT weekOf FROM workAssignments WHERE departmentID IN (".implode(',', array_keys($_SESSION["user"]["depts"]["departments"])).") ORDER BY weekOf DESC");
                while ($weekOf = $getWeeks->fetch_assoc()) {
                  echo '<div onclick="loadWeek($(this))" class="input-select-item" data-value="'.$weekOf["weekOf"].'">'.date('M jS', strtotime($weekOf["weekOf"])).'</div>';
                }
              ?>
            </div>
            <input type="hidden" name="weekOf" value="">
          </div>
        </div>
        <div class="input-error-msg"></div>
      </div>
    </div>
  </div>
  <div class="panel-content"></div>
</div>
<script type="text/javascript">

function loadWeek(weekDiv) {
  updateDropDown(weekDiv);
  $.post('action.php', {action:"loadWeekAssignments",weekOf:$(weekDiv).attr('data-value')}).done(function (data) {
    $('#assignments .panel-content').eq(1).html(data);
    
    $('.aci-edit').click(function () {
      $('assignment.active').removeClass('active');
      $(this).closest('assignment').addClass('active');
      $('#assignments, #assignment-cms').addClass('active');
      $('#cms-iframe').attr('src', 'create.php?type=edit&assignmentID=' + $(this).closest('assignment').attr('assignment-id'));
    });
    
    $('.aci-delete').click(function () {
      if (confirm('Are You Sure You Want To Delete This Assignment?')) {
        var assignment = $(this).closest('assignment');
        $.post('action.php', {action:"deleteAssignment",assignmentID:assignment.attr('assignment-id')}).done(function (data) {
          assignment.remove();
          addNotif(['Assignment Deleted', "The Assignment Was Successfully Deleted."], 1);
        }).fail(function (data) {
          addNotif(['An Error Occured', data.responseJSON.message], 2);
        });
      }
    });
  });
}
</script>
</body>
</html>

<?php include($_SERVER['DOCUMENT_ROOT']."/s/php/phpFoot.php"); ?>