<?php
//hi there
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
    header('Content-Type: application/json');
    echo file_get_contents("https://graph.facebook.com/v3.3/1478038602226629/insights?access_token=EAACTMzReSCwBAG8ZBz1rVpyBWSHBccZClZB6aNXZA5HZCK2HGkwCOp8r8InIGs9G1EWEw4ZANQNTqnsVm9CDHgp31BQP6bYjSMpxbrGot9HZATvp00qQ1IZCSEzlwlDZA7JnHGtEnPcCAMVtK2uaLkBBxlzmJBadf9mpjLN5K7ZB1clQZDZD&metric=page_post_engagements,page_engaged_users,page_impressions_unique,page_fans_online_per_day,page_fan_adds_unique,page_fan_removes_unique,page_fans,page_fans_gender_age,page_fans_city&period=day&date_preset=last_14d");
?>