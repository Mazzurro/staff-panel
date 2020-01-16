<?php
if (isset($_POST['req-website-analytics']) && isset($_POST['req-website-type']) && isset($_POST['req-website-site'])) {
    
    if (in_array($_POST['req-website-site'], array('72dragonsmediacom', '72dragonsservicescom', '72dragonscannescom', 'dyingpianocom'))) {
        $site = $_POST['req-website-site'];
    } else die();
    
    switch($_POST['req-website-type']) {
        case 'html':
            if (!isset($_POST['req-website-fromdate']) || !isset($_POST['req-website-todate']) || !isset($_POST['req-website-singleoverall'])) die('invalid');
            $theFile = file_get_contents('https://crossf.app/ta/d.php?sitename='.$site.'&fromdate='.$_POST['req-website-fromdate'].'&todate='.$_POST['req-website-todate'].'&singleoverall='.$_POST['req-website-singleoverall']);
            $theFile = 'https'.explode('.html', explode('https', $theFile)[1])[0].'.html';
            echo '<button id="analytics-pdf">Export As PDF</button>';
            echo file_get_contents($theFile);
            $_SESSION['tmp-keys'][explode('/ta/', $theFile)[1]] = true;
            echo '<input id="analytics-filename" type="hidden" name="filename" value="'.explode('/ta/', $theFile)[1].'">';
            break;
        case 'pdf':
            if (!isset($_POST['req-website-filename']) || !isset($_SESSION['tmp-keys'][$_POST['req-website-filename']]) || !$_SESSION['tmp-keys'][$_POST['req-website-filename']]) die('invalid');
            //header("Content-type:application/pdf");
            echo ('https://crossf.app/ta/'.$_POST['req-website-filename'].'.pdf');
            break;
    }
    die();
}
?>

<div id="analytics-panel" class="panel">
    <div class="panel-content">
        <h4>Select A Website From The Dropdown</h4>
        <select id="analytics-sites">
            <option value="">Select A Site</option>
            <option value="72dragonsmediacom">72dragonsmedia.com</option>
            <option value="72dragonsservicescom">72dragonsservices.com</option>
            <option value="72dragonscannescom">72dragonscannes.com</option>
            <option value="dyingpianocom">dyingpiano.com</option>
        </select>
        <h4>Enter The Date Range Of The Analytics</h4>
        <div>
            <input type="number" placeholder="DD" name="fromDay">
            <input type="number" placeholder="MM" name="fromMonth">
            <input type="number" placeholder="YYYY" name="fromYear">
        </div>
        <h5>To</h5>
        <div>
            <input type="number" placeholder="DD" name="toDay">
            <input type="number" placeholder="MM" name="toMonth">
            <input type="number" placeholder="YYYY" name="toYear">
        </div>
        <h4>Have Each Graph Show Data From The Entire Range, or Only The First One</h4>
        <h6>If only the first one, the others will show only data of yesterday</h6>
        <input type="checkbox" name="overall" value="1">All Graphs Show All Data
        <button id="get-analytics">Get Analytics</button>
        <hr>
        <h3>[website] analytics</h3>
        <div id="analytics-result"></div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#get-analytics').click(function () {
                $('#analytics-result').html('').addClass('loading');
                $.post('/staff/content/view-analytics', {
                    "req-website-analytics":true,
                    "req-website-site":$('#analytics-sites').val(),
                    "req-website-type":"html",
                    "req-website-fromdate":$('input[name=fromYear]').val()+'-'+$('input[name=fromMonth]').val()+'-'+$('input[name=fromDay]').val(),
                    "req-website-todate":$('input[name=toYear]').val()+'-'+$('input[name=toMonth]').val()+'-'+$('input[name=toDay]').val(),
                    "req-website-singleoverall":($('input[name=overall]')[0].checked ? 1 : 0)
                    
                }).done(function (data) {
                    $('#analytics-result').removeClass('loading').html(data);
                    $('#analytics-pdf').click(function () {
                        $.post('/staff/content/view-analytics', {
                                "req-website-analytics":true,
                                "req-website-site":$('#analytics-sites').val(),
                                "req-website-type":"pdf",
                                "req-website-filename":$('#analytics-filename').val()
                        }).done(function (data) {
                            var link=document.createElement('a');
                            link.href=data;
                            link.target="_blank"
                            link.download=$('#analytics-filename').val()+'.pdf';
                            link.click();
                        }).fail(function (data) {
                            console.log('failed');
                            console.log(data);
                        });
                    });
                });
            });
        });
    </script>
</div>