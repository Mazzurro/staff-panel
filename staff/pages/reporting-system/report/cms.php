<?php
   include($_SERVER['DOCUMENT_ROOT']."/s/php/phpHead.php");

   /*
    TODO

    reports
    --
    on new week or dept - replace assignments with loading circle
    manage reports - delete
    
    assignments and reports
    ---------
    add a disabled class for the options that the user will not have permission to do
   */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $title = 'Create A Report'; include($_SERVER['DOCUMENT_ROOT']."/s/headInfo.php"); ?>
<link type="text/css" href="/s/temp.css" rel="stylesheet">
<script type="text/javascript" src="/additional/chart-js/Chart.js"></script>
<script type="text/javascript" src="/s/temp.js"></script>
<style>
assignment {cursor:pointer;}
assignment.active:after {display:none !important;}
assignment-controls{grid-template-columns: 100%; font-size:54px;}
</style>
<style>
/*Hard Changes*/
body {background: #1b1b1b !important;}
assignment {border-radius: 0 !important; box-shadow: 0 0 20px 2px black; z-index: 2;}
assignment assignment-assigned, assignment assignment-assigned-staff:first-child {border-radius: 0 !important;}
.input-container:not(.report-heading-block) {background:black !important; border-radius: 0 !important;box-shadow: 0 0 20px 2px black;}
.input-container:not(.assignment-details) {max-width: 662px;}

p {
  color: #7b7b7b;
}

/*???*/
.input-title {
  padding: 3px 0;
}
.input-item p {
  font-size: 18px;
  margin: 0 1em 1em;
}

h3.section-title {
  max-width: 800px;
  margin: 10px auto 25px auto;
  border: 1px #ad9440 solid;
  padding: 15px 0px;
  box-shadow: 0 0 20px 2px black;
}

.input-container.graph-data {
  position: relative;
  margin-bottom: 100px !important;
}
.input-container.graph-data:after {
    content: '';
    position: absolute;
    width: 100px;
    height: 0;
    border-bottom: 1px #ad9440 solid;
    bottom: -50px;
    display: block;
    left: 50%;
    transform: translateX(-50%);
}

assignment {
  max-width: 700px;
}
assignment.toggleable {
  margin-bottom: 0;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}
assignment.toggleable assignment-assigned, assignment.toggleable assignment-assigned-staff:first-child {
  border-bottom-left-radius: 0;
}
assignment-assigned {
  min-width: 120px;
}
assignment-title h3 {
  font-size: 22px;
}
assignment-controls {
  min-width: 45px;
  min-height: 45px;
  grid-template-columns: 100%;
  font-size: 36px;
}

.assignment-details {
  max-width: 700px;
  padding: 0;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  border-width: 2px;
  margin-top: 0;
  margin-bottom: 25px;
  border-top: 0;
  min-height: 240px;
  max-height: 240px;
  height: auto;
  overflow: auto;
  transition: max-height 0.5s;
}
.assignment-details.active {
  max-height: 100%;
}
.assignment-details p {
  font-size: 18px;
  margin: 10px;
}

.report-heading-block {
    background-position: center;
    background-size: auto 100%;
    padding: 0;
    border-radius: 0;
    box-shadow: 0 0 20px 2px black;
    max-width: 850px !important;
}
.report-heading-block h1.rhb-title {
    width: 100%;
    margin: 0;
    padding-top: 20px;
    background: rgba(0,0,0,0.85);
}
.report-heading-block .rhb-data {
    text-align: center;
    background: rgba(0,0,0,0.85);
}
.rhb-data p {
    display: inline-block;
    margin: 1em;
}
@media (max-width: 800px) {
  .report-heading-block {
    margin: 10px -20px 25px -20px !important;
    border-left: none !important;
    border-right: none !important;
    max-width: unset;
  }
}
</style>
</head>
<body>
<div id="assignment-cms"></div>
<div class="panel" id="assignments">
  <div class="panel-content">
    <div class="input-container">
      <div class="input-block"><h3>Report Details</h3></div>
      <div class="input-block">
        <div class="input-title">Creating A Report For</div>
        <div class="input-item">
          <div class="input-select noselect" id="dept">
            <div class="input-select-current">Select A Department</div>
            <div class="input-select-dropdown">
              <?php
                foreach ($_SESSION["user"]["depts"]["departments"] as $deptID => $dept) {
		  echo '<div onclick="getWeeks($(this))" class="input-select-item" data-value="'.$deptID.'">'.$dept["name"].'</div>';
	        }
              ?>
            </div>
            <input type="hidden" name="dept" value="">
          </div>
        </div>
        <div class="input-error-msg"></div>
      </div>
      <div class="input-block">
        <div class="input-title">Show Assignments For The Week Of</div>
        <div class="input-item">
          <div class="input-select noselect disabled noclick" id="weekOf">
            <div class="input-select-current">Select A Department First</div>
            <div class="input-select-dropdown"></div>
            <input type="hidden" name="weekOf" value="">
          </div>
        </div>
        <div class="input-error-msg"></div>
      </div>
    </div>
  </div>
  <div class="panel-content">
    <h2>Select All Assignments That You Want To Add To Your Report</h2>
    <form id="assignment-list" action="genData.php" method="POST">
      
    </form>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
  $('#assignment-list').submit(function (e) {
    e.preventDefault();
  });
});

function saveReview(button, reviewID) {
  $(button).html('<i class="fas fa-spinner fa-spin"></i>').addClass('disabled noclick');
  $.post('save.php', {type:'review',reviewID:reviewID,review:$('textarea[name=' + reviewID + ']').val(),canReview:true,reportID:$('input[name=reportID]').val()}).done(function () {
    addNotif(['Section Saved', 'Your content was saved.'], 1);
  }).always(function () {
    $(button).html('Save').removeClass('disabled noclick');
  }).fail(function (data) {
    console.log(data.responseJSON.message);
    addNotif(['An Error Occured', data.responseJSON.message], 2);
  });
}

function getWeeks(deptDiv) {
  updateDropDown(deptDiv);
  $('#weekOf .input-select-current').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
  $.post('setUp.php', {action:"getWeeks",deptID:$(deptDiv).attr('data-value')}).done(function (data) {
    $('#weekOf .input-select-current').html('Select A Week');
    $('#weekOf').removeClass('disabled noclick').find('.input-select-dropdown').html(data);
  }).fail(function (data) {
    addNotif(['An Error Occured', data.responseJSON.message], 2);
  });
}

function loadWeek(weekDiv) {
  updateDropDown(weekDiv);
  $.post('setUp.php', {action:"getAssignmentsFromWeek",weekOf:$(weekDiv).attr('data-value'),deptID:$('input[name=dept]').val()}).done(function (data) {
    $('#assignment-list').html(data);
    
    $('assignment').click(function () {
      $(this).toggleClass('active');
      ($(this).find('input').length > 0 ? $(this).find('input').remove() : $(this).append('<input type="hidden" name="assignmentID[]" value="' + $(this).attr('assignment-id') + '">'));
      ($(this).hasClass('active') ? $(this).find('.aci-picked').html('<i class="fas fa-check"></i>') : $(this).find('.aci-picked').html('<i class="fas fa-times"></i>'));
    });
    
    $('.input-radio-item').click(function() {
        $(this).parent().find('.input-radio-clicked').removeClass('input-radio-clicked');
        $(this).find('.input-radio-button').toggleClass('input-radio-clicked');
        $(this).siblings('input').val($(this).find('.input-radio-button').attr('data-name'));
    });
    
    $('.input-checkbox-item').click(function() {
        $(this).find('.input-checkbox-button').toggleClass('input-checkbox-clicked');
        $(this).find('input').val(1 - $(this).find('input').val());
    });
    
    $('#genData').click(function () {
      $('#genData').html('<i class="fas fa-spinner fa-spin"></i>').addClass('disabled noclick');
      $('#assignment-cms, #assignments').addClass('active');
      $.post('genData.php', $('#assignment-list').serialize()).done(function (data) {
        $('#assignment-cms').html(data);
        if ($('#assignment-list input[name=reportID]').length == 0)
          $('#assignment-list').append('<input type="hidden" name="reportID" value="' + $('input[name=reportID]').val() + '">');
        $('#genData').html('Update Report Data').removeClass('disabled noclick');
      }).fail(function (data) {
        addNotif(['An Error Occured', data.responseJSON.message], 2);
      });
    });
  }).fail(function (data) {
    addNotif(['An Error Occured', data.responseJSON.message], 2);
  });
}
</script>
</body>
</html>

<?php include($_SERVER['DOCUMENT_ROOT']."/s/php/phpFoot.php"); ?>