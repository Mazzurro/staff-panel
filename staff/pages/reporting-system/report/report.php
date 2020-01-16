<?php


if ($_GET["url"]) {
  switch ($url[4]) {
    case 'read': $editMode = 0; $title = '[VIEW] Report #'.$reportID; break;
    case 'edit':  $editMode = 1; $title = '[EDIT] Report #'.$reportID; break;
    default: die('Invalid URL');
  }
} else
  die('Invalid URL');

if ($editMode = 0) {?>
<head>
    <?php getHTMLHead($title); ?>
</head>
<?php } ?>
<script type="text/javascript" src="/additional/chart-js/Chart.js"></script>
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
<pre style="color: #ad9440;">
<?php
print_r(Report::loadReport($reportID));
?>
</pre>
<input type="hidden" name="reportID" value="<?php echo $reportID;?>">
<script type="text/javascript">
$(document).ready(function () {
  $('assignment-controls').click(function () {
    $(this).closest('assignment').toggleClass('toggled').next().toggleClass('active');
    if ($(this).closest('assignment').hasClass('toggled')) {
      $(this).children().html('<i class="fas fa-chevron-up"></i>');
    } else {
      $(this).children().html('<i class="fas fa-chevron-down"></i>');
    }
  });
});

function saveReview(button, reviewID) {
  $(button).html('<i class="fas fa-spinner fa-spin"></i>').addClass('disabled noclick');
  $.post('/s/report/save.php', {type:'review',reviewID:reviewID,review:$('textarea[name=' + reviewID + ']').val(),canReview:true,reportID:$('input[name=reportID]').val()}).done(function () {
    addNotif(['Section Saved', 'Your content was saved.'], 1);
  }).always(function () {
    $(button).html('Save').removeClass('disabled noclick');
  }).fail(function (data) {
    console.log(data.responseJSON.message);
    addNotif(['An Error Occured', data.responseJSON.message], 2);
  });
}

</script>