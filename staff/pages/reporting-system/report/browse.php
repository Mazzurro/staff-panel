<script type="text/javascript" src="/additional/chart-js/Chart.js"></script>
<style>
assignment-controls {
  grid-template-rows: 50% 50%;
}
</style>
<div class="panel" id="assignments">
  <div class="panel-content">
      <div id="assignment-list-container" class="display-list display-list-mini noWalls">
          <?php
            $reportData = ReportSystem::searchReports($_POST["queryData"], $_POST["page"], $_POST["amount"]);
            if (!$reportData || count($reportData) == 0) {
                echo '<h1>End Of List</h1>';
            } else {
                foreach ($reportData as $report) {
                    echo '<div class="display-box float-fade-in" report-id="'.$report["result"]["reportID"].'">';
                    foreach ($report["staffMembers"] as $staff) {
                        echo '<div class="display-box-cover" style="background-image: url(https://72dragonsservices.com/f/images/staff/avatar/'.$staff["avatar"].');"></div>';
                    }
                    echo '<div class="display-box-text">
                            <h6>Week Of '.$report["result"]["weekOf"].'</h6>
                            <p>'.$report["result"]["department"].' Report</h6>
                            <p>Created By '.$staff["name"].'</p>
                        </div>
                        <div class="display-box-options">
                            <div><i class="fas fa-eye"></i></div>
                            <div><i class="fas fa-file-download"></i></div>';
                    if (StaffMember::hasPerms([$report["result"]["departmentID"]], [2]) || StaffMember::$me["staffID"] == $staff["staffID"])
                        echo '<div><i class="fas fa-pencil-alt"></i></div>';
                    echo '</div>
                        </div>';
                        //<assignment-controls class="noWalls"><assignment-controls-item class="aci-view"><a href="reports/'.$report["result"]["reportID"].'/read" target="_blank"><i class="fas fa-eye"></i></a></assignment-controls-item><assignment-controls-item class="aci-edit"><i class="fas fa-pencil-alt"></i></assignment-controls-item><assignment-controls-item class="aci-public"><i class="fas fa-globe-americas"></i></assignment-controls-item><assignment-controls-item class="aci-delete"><i class="fas fa-times"></i></assignment-controls-item></assignment-controls></assignment>';
                }
                echo '<button id="reports-load-more">Load More</button>';
            }
          ?>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
  
  $('.aci-edit').click(function () {
    //load report for editing
  });
  
  $('.aci-delete').click(function () {
    if (confirm('Are You Sure You Want To Delete This Report?')) {
      var report = $(this).closest('assignment');
      $.post('browse.php', {action:"deleteReport",reportID:report.attr('report-id')}).done(function (data) {
        report.remove();
        addNotif(['Report Deleted', "The Report Was Successfully Deleted."], 1);
      }).fail(function (data) {
        addNotif(['An Error Occured', data.responseJSON.message], 2);
      });
    }
  });
  
  $('#reports-load-more').click(function () {
    loadMoreReports(null, 2, 30);
  });
  
});

function loadMoreReports(queryData, page, amount) {
    $('#reports-load-more').addClass('disabled noclick').text('Loading...');
    $.post('/staff/api/browse-reports/', {queryData:queryData, page:page, amount:amount}).done(function (data) {
        data = JSON.parse(data);
        console.log(data);
        if (Object.keys(data).length > 0) {
            for (var reportID in data) {
                $(`
                    <assignment report-id="`+reportID+`">
                        <assignment-assigned></assignment-assigned>
                        <assignment-title>
                            <h3>Week Of `+data[reportID].result.weekOf+`</h3>
                            <h6>`+data[reportID].result.department+` Report</h6>
                            <p>Created By `+data[reportID].staffMembers[0].name+`</p>
                        </assignment-title>
                        <assignment-controls class="noWalls">
                            <assignment-controls-item class="aci-view">
                                <a href="reports/`+reportID+`/read" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </assignment-controls-item>
                            <assignment-controls-item class="aci-edit">
                                <i class="fas fa-pencil-alt"></i>
                            </assignment-controls-item>
                            <assignment-controls-item class="aci-public">
                                <i class="fas fa-globe-americas"></i>
                            </assignment-controls-item>
                            <assignment-controls-item class="aci-delete">
                                <i class="fas fa-times"></i>
                            </assignment-controls-item>
                        </assignment-controls>
                    </assignment>
                `).insertAfter('#reports-load-more');
                for (var staff in data[reportID].staffMembers) {
                    $('assignment[report-id='+reportID+'] assignment-assigned').append('<assignment-assigned-staff style="background-image: url(https://72dragonsservices.com/f/images/staff/avatar/'+data[reportID].staffMembers[staff].avatar+');"><span class="noclick noselect">'+data[reportID].staffMembers[staff].name+'</span></assignment-assigned-staff>');
                }
            }
            $('#reports-load-more').remove();
            $('#assignments .panel-content').append('<button id="reports-load-more">Load More</button>');
            $('#reports-load-more').click(function () {
                loadMoreReports(queryData, ++page, amount);
              });
        } else {
            $('#reports-load-more').remove();
            $('#assignments .panel-content').append('<h1 style="text-align: center">- End Of List -</h1>');
        }
    }).fail(function () {
        $('#reports-load-more').removeClass('disabled noclick').text('Load More');
        addNotif("An Error Occured Loading The Reports.", "Please try again.", 2);
    });
}

function loadWeek(weekDiv) {
  updateDropDown(weekDiv);
  $.post('action.php', {action:"loadWeekAssignments",weekOf:$(weekDiv).attr('data-value')}).done(function (data) {
    $('#assignments .panel-content').html(data);
    $('.aci-edit').click(function () {
      $('assignment.active').removeClass('active');
      $(this).closest('assignment').addClass('active');
      $('#assignments, #assignment-cms').addClass('active');
      $('#cms-iframe').attr('src', 'create.php?type=edit&assignmentID=' + $(this).closest('assignment').attr('assignment-id'));
    });
  });
}
</script>