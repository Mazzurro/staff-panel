<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header('Content-Type: application/json');


switch($_GET['id']) {
    case 1:
    case '1':
        echo file_get_contents("https://graph.facebook.com/17841405702734743/insights?access_token=EAACTMzReSCwBAG8ZBz1rVpyBWSHBccZClZB6aNXZA5HZCK2HGkwCOp8r8InIGs9G1EWEw4ZANQNTqnsVm9CDHgp31BQP6bYjSMpxbrGot9HZATvp00qQ1IZCSEzlwlDZA7JnHGtEnPcCAMVtK2uaLkBBxlzmJBadf9mpjLN5K7ZB1clQZDZD&metric=follower_count,impressions,profile_views,reach&period=day&since=1562037097&until=1564629097");
    break;
    case 2:
    case '2':
        echo file_get_contents("https://graph.facebook.com/17841405702734743/insights?access_token=EAACTMzReSCwBAG8ZBz1rVpyBWSHBccZClZB6aNXZA5HZCK2HGkwCOp8r8InIGs9G1EWEw4ZANQNTqnsVm9CDHgp31BQP6bYjSMpxbrGot9HZATvp00qQ1IZCSEzlwlDZA7JnHGtEnPcCAMVtK2uaLkBBxlzmJBadf9mpjLN5K7ZB1clQZDZD&metric=online_followers&period=lifetime&since=1562037097&until=1564629097");
    break;
    case 3:
    case '3':
        echo file_get_contents("https://graph.facebook.com/17841405702734743/insights?access_token=EAACTMzReSCwBAG8ZBz1rVpyBWSHBccZClZB6aNXZA5HZCK2HGkwCOp8r8InIGs9G1EWEw4ZANQNTqnsVm9CDHgp31BQP6bYjSMpxbrGot9HZATvp00qQ1IZCSEzlwlDZA7JnHGtEnPcCAMVtK2uaLkBBxlzmJBadf9mpjLN5K7ZB1clQZDZD&metric=audience_city,audience_gender_age&period=lifetime");
    break;
}
?>