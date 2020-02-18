<?php
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/social-media/schedule/index.php');
class Socialmedia{
	public static function create($LocationsDetails) {
		// $LocationsDetails['location_social_account'] = '1';
		// $LocationsDetails['location_city'] = 'Calcutta';
		// $LocationsDetails['location_country'] = 'India';
		// $LocationsDetails['location_required_followers'] = '500';
		// $LocationsDetails['location_required_date'] = '2020-01-01';
		// $LocationsDetails['location_priority'] = '1';
		// $LocationsDetails['location_growth'] = '1';
		// $LocationsDetails['location_film_lovers'] = '5';
		// $LocationsDetails['followers_total'] = '200';
		// $LocationsDetails['followers_date'] = '2020-01-11';
		// $LocationsDetails['population_total'] = '20000';
		// $LocationsDetails['population_year'] = '2019';

		mysqli_autocommit(db::$con,FALSE);
		$addLocations = db::$con->prepare("INSERT INTO socialMediaLocations (location_social_account, location_city, location_country, location_required_followers, location_required_date, location_priority, location_growth, location_film_lovers) VALUES (?,?,?,?,?,?,?,?)");
        $addLocations->bind_param("ssssssss",$LocationsDetails['location_social_account'],$LocationsDetails['location_city'],$LocationsDetails['location_country'],$LocationsDetails['location_required_followers'],$LocationsDetails['location_required_date'],$LocationsDetails['location_priority'],$LocationsDetails['location_growth'],$LocationsDetails['location_film_lovers']);
        if ($addLocations->execute()) {
        	$location_id = $addLocations->insert_id;
        	$addFollowers = db::$con->prepare("INSERT INTO socialMediaLocationsFollowers (followers_location, followers_total, followers_date) VALUES (?,?,?)");
        	$addFollowers->bind_param("sss",$location_id,$LocationsDetails['followers_total'],$LocationsDetails['followers_date']);

        	$addPopulation = db::$con->prepare("INSERT INTO socialMediaLocationsPopulation (population_location, population_total, population_year) VALUES (?,?,?)");
        	$addPopulation->bind_param("sss",$location_id,$LocationsDetails['population_total'],$LocationsDetails['population_year']);
        	if($addFollowers->execute() && $addPopulation->execute()){
        		mysqli_commit(db::$con);
                return true;
        	}else{
        		mysqli_rollback(db::$con);
                return Staffpanel::createError('408','System Error','An error occured with adding the location.');
        	}
        }else{
        	mysqli_rollback(db::$con);
            return Staffpanel::createError('408','System Error','An error occured with adding the location.');
        }

	}
	public static function createAccounts($AccountsDetails){
		$addAccounts = db::$con->prepare("INSERT INTO socialMediaAccounts (social_media_account_name, social_media_account_type, social_media_account_owner) VALUES (?,?,?)");
    	$addAccounts->bind_param("sis",$AccountsDetails['social_media_account_name'],$AccountsDetails['social_media_account_type'],$AccountsDetails['social_media_account_owner']);
    	if($addAccounts->execute()){
    		return true;
    	}else{
    		$addAccounts->close();
    		return Staffpanel::createError('408','System Error','An error occured with adding the Accounts.');
    	}
	}
	public static function List(){
		$getLocationList = db::$con->query("SELECT * FROM socialMediaLocations AS a LEFT JOIN socialMediaLocationsFollowers AS b ON a.location_id = b.followers_location LEFT JOIN socialMediaLocationsPopulation AS c ON a.location_id = c.population_location where a.removed_on is null order by followers_id desc");
        while($Locations = $getLocationList->fetch_assoc()) {
            $LocationList[] = $Locations;
        }
        // var_dump($LocationList);
        $new_data = [];
        foreach ($LocationList as $key => $value) {
        	$key = $value['location_id'];
        	if (!array_key_exists($key, $new_data)) {
                $new_data[$key] = $value;
            }
            $new_data[$key]['EST_Max_Film_Loving_Followers'] = intval($value['population_total']*($value['location_film_lovers']/100));
        }
        return $new_data;
	}
	public static function List2(){
		// ROUND_DOWN(((location_required_followers - current_followers) / (Number of months between location_required_date and current_followers_date)) * (number of months since current_followers_date) + current_followers)
		// ROUND_UP(current_followers * ((((location_required_followers / current_followers) ^ (1 / (Number of months between location_required_date and current_followers_date)))) ^ (number of months since current_followers_date)))
		$getLocationList = db::$con->query("SELECT * FROM socialMediaLocations AS a LEFT JOIN socialMediaLocationsFollowers AS b ON a.location_id = b.followers_location where a.removed_on is null");
        while($Locations = $getLocationList->fetch_assoc()) {
            $LocationList[] = $Locations;
        }
        // $gg = intval((56 * pow((pow((500 / 56) , (1 / (11)))) , (1))));
        // echo $gg;

        $new_data = [];
        foreach ($LocationList as $key => $value) {
        	$key = $value['location_id'];
        	if (!array_key_exists($key, $new_data)) {
                $new_data[$key] = $value;
            }
            $year = date("Y",strtotime($value['followers_date']));
            $month = date("m",strtotime($value['followers_date']));

            $year2 = date("Y",strtotime($value['location_required_date']));
            $month2 = date("m",strtotime($value['location_required_date']));

            $between = ($year2 * 12 + $month2) - ($year * 12 + $month) + 1;
            $YM = $year.'-'.$month;
            $End = intval(($value['followers_total'] * pow((pow(($value['location_required_followers'] / $value['followers_total']) , (1 / ($between)))) , (1))));

            if($value['location_growth'] == 1){
            	for ($i=1; $i < $between; $i++) {
	            	$aa = $month+$i;
	            	if($aa<=12){
	            		if($aa<10){
	            			$bb = $year.'-0'.$aa;
	            		}else{
	            			$bb = $year.'-'.$aa;
	            		}

	            	}else{
	            		$bb = $year+ceil(($aa-12)/12).'-0'.($aa-12);
	            	}
	            	$cc = $month+($i-1);
	            	if($cc<=12){
	            		if($cc<10){
	            			$dd = $year.'-0'.$cc;
	            		}else{
	            			$dd = $year.'-'.$cc;
	            		}

	            	}else{
	            		$dd = $year+intval(($cc-12)/12).'-'.$cc-12;
	            	}

	            	$start = intval(($value['followers_total'] * pow((pow(($value['location_required_followers'] / $value['followers_total']) , (1 / ($between)))) , (1+($i-1)))));
	            	$end = intval(($value['followers_total'] * pow((pow(($value['location_required_followers'] / $value['followers_total']) , (1 / ($between)))) , (1+$i))));

	            	$hh = intval(($value['followers_total'] * pow((pow(($value['location_required_followers'] / $value['followers_total']) , (1 / ($between)))) , (1+($i-2)))));

	            	$new_data[$key]['followers'][$bb] = ['Start of Month Follower Count'=>$start,'End of Month Follower Count'=>$end,'of New Followers'=>$end-$start,'High Reach Count'=>round(4.5*$start),'Average Reach Count'=>3*$start,'Low Reach Count'=>round(1.5*$start)];

	            	if($dd = $YM){
	            		$new_data[$key]['followers'][$year.'-0'.($month-1)] = ['Start of Month Follower Count'=>$new_data[$key]['followers'][$year.'-0'.($month-2)]['End of Month Follower Count'],'End of Month Follower Count'=>$value['followers_total'],'of New Followers'=>$value['followers_total']-$new_data[$key]['followers'][$year.'-0'.($month-2)]['End of Month Follower Count'],'High Reach Count'=>round(4.5*$new_data[$key]['followers'][$year.'-0'.($month-2)]['End of Month Follower Count']),'Average Reach Count'=>3*$new_data[$key]['followers'][$year.'-0'.($month-2)]['End of Month Follower Count'],'Low Reach Count'=>round(1.5*$new_data[$key]['followers'][$year.'-0'.($month-2)]['End of Month Follower Count'])];
	            	}

	            }
            $new_data[$key]['followers'][$YM] = ['Start of Month Follower Count'=>$value['followers_total'],'End of Month Follower Count'=>$End,'of New Followers'=>$End-$value['followers_total'],'High Reach Count'=>round(4.5*$value['followers_total']),'Average Reach Count'=>3*$value['followers_total'],'Low Reach Count'=>round(1.5*$value['followers_total'])];
            // unset($new_data[$key]['followers'][$year.'-00']);
            }else{
            	$linear = intval((($value['location_required_followers'] - $value['followers_total']) / ($between)) * (1) + $value['followers_total']);
            	for ($i=1; $i < $between; $i++) {
	            	$aa = $month+$i;
	            	if($aa<=12){
	            		if($aa<10){
	            			$bb = $year.'-0'.$aa;
	            		}else{
	            			$bb = $year.'-'.$aa;
	            		}

	            	}else{
	            		$bb = $year+ceil(($aa-12)/12).'-0'.($aa-12);
	            	}
	            	$cc = $month+($i-1);
	            	if($cc<=12){
	            		if($cc<10){
	            			$dd = $year.'-0'.$cc;
	            		}else{
	            			$dd = $year.'-'.$cc;
	            		}

	            	}else{
	            		$dd = $year+intval(($cc-12)/12).'-'.$cc-12;
	            	}
	            	$start = intval((($value['location_required_followers'] - $value['followers_total']) / ($between)) * (1+($i-1)) + $value['followers_total']);
	            	$end = intval((($value['location_required_followers'] - $value['followers_total']) / ($between)) * (1+$i) + $value['followers_total']);
	            	$hh = intval((($value['location_required_followers'] - $value['followers_total']) / ($between)) * (1+($i-2)) + $value['followers_total']);
	            	$new_data[$key]['followers'][$bb] = ['Start of Month Follower Count'=>$start,'End of Month Follower Count'=>$end,'of New Followers'=>$end-$start,'High Reach Count'=>round(4.5*$start),'Average Reach Count'=>3*$start,'Low Reach Count'=>round(1.5*$start)];

	            	if($dd = $YM){
	            		$new_data[$key]['followers'][$year.'-0'.($month-1)] = ['Start of Month Follower Count'=>$new_data[$key]['followers'][$year.'-0'.($month-2)]['End of Month Follower Count'],'End of Month Follower Count'=>$value['followers_total'],'of New Followers'=>$value['followers_total']-$new_data[$key]['followers'][$year.'-0'.($month-2)]['End of Month Follower Count'],'High Reach Count'=>round(4.5*$new_data[$key]['followers'][$year.'-0'.($month-2)]['End of Month Follower Count']),'Average Reach Count'=>3*$new_data[$key]['followers'][$year.'-0'.($month-2)]['End of Month Follower Count'],'Low Reach Count'=>round(1.5*$new_data[$key]['followers'][$year.'-0'.($month-2)]['End of Month Follower Count'])];
	            	}

	            }
            $new_data[$key]['followers'][$YM] = ['Start of Month Follower Count'=>$value['followers_total'],'End of Month Follower Count'=>$linear,'of New Followers'=>$linear-$value['followers_total'],'High Reach Count'=>round(4.5*$value['followers_total']),'Average Reach Count'=>3*$value['followers_total'],'Low Reach Count'=>round(1.5*$value['followers_total'])];
            }

        }
        foreach ($new_data as $k => $v) {
        	unset($v['followers'][$year.'-00']);
            $new_List[] = $v;
        }
        // var_dump($new_data);
        return $new_List;

	}
	public static function AccountsList(){
		$getAccounts = db::$con->query("SELECT social_media_account_id,social_media_account_name,social_media_type FROM socialMediaAccounts AS a LEFT JOIN socialMediaTypes AS b ON a.social_media_account_type = b.social_media_type_id");
        while($Accounts = $getAccounts->fetch_assoc()) {
            $AccountsList[] = $Accounts;
        }
        return $AccountsList;
	}
	public static function getAccountInfo($account_id){
		$accountData = self::AccountsList();
		foreach($accountData as $account) {
			if ($account['social_media_account_id'] == $account_id) return $account;
		}
	}
	    public static function getAccountParticipants($account_id) {
        $partsList = [];

        $getParts = db::$con->query("SELECT staffInfo.staffID, firstName, middleName, lastName, avatar, permission_level FROM socialMediaAccountsPermissions LEFT JOIN staffInfo ON staffInfo.staffID = socialMediaAccountsPermissions.staff_id WHERE socialMediaAccountsPermissions.social_media_account_id = $account_id AND socialMediaAccountsPermissions.removed_on IS NULL;");
        while ($part = $getParts->fetch_assoc()) {
            $partsList[$part['staffID']] = $part;
        }

        return $partsList;
    }
	public static function Permissions($Accounts_id,$staffList){
		// $Accounts_id = '1';
		// $staffList = ['40'=>'2','41'=>'2','43'=>'2'];
		$insertQuery = '';
        foreach($staffList as $key => $item) {
            if (!isValidNumber($key) || !isValidNumber($item)) return Staffpanel::createError('400','Invalid ID','One or many of the ids provided are invalid.');
            if ($item == '0')
                $insertQuery .= ($insertQuery == '' ? '' : ',')."($Accounts_id,$key,$item,CURRENT_TIMESTAMP)";
            else
                $insertQuery .= ($insertQuery == '' ? '' : ',')."($Accounts_id,$key,$item,NULL)";
        }
        if (db::$con->multi_query("CREATE TEMPORARY TABLE staffPermissions
                            (
                            	account_id INT,
                            	staffid INT,
                            	permLevel INT,
                            	deletedOn TIMESTAMP NULL
                            );

                            INSERT INTO staffPermissions VALUES $insertQuery;

                            INSERT INTO socialMediaAccountsPermissions (social_media_account_id, staff_id, permission_level, removed_on)
                            SELECT * FROM staffPermissions
                            ON DUPLICATE KEY UPDATE permission_level = permLevel, social_media_account_id = account_id, staff_id = staffid;

                            DROP TABLE staffPermissions;"))
            return true;
        else
            return Staffpanel::createError('408','Error Assigning Staff','An error with the server occured while assigning staff members.');
	}
	public static function edit(){

	}
	public static function socialMediaTypes(){
        $getTypes = db::$con->query("SELECT * FROM socialMediaTypes");
        while($Types = $getTypes->fetch_assoc()) {
            $TypesList[] = $Types;
        }
        return $TypesList;
    }
    public static function delAccounts($Accounts_id){
    	if(empty($Accounts_id)){
            return Staffpanel::createError('400','Invalid Accounts ID','The Accounts id was invalid or not an id.');
        }
        $delAccounts = db::$con->prepare("UPDATE socialMediaAccounts SET removed_on = CURRENT_TIMESTAMP WHERE social_media_account_id = ?;");
        $delAccounts->bind_param('i',$Accounts_id);
        if ($delAccounts->execute()) {
            return true;
        } else {
            $delAccounts->close();
            return Staffpanel::createError('408','System Error','An error occured with failed to delete');
        }
    }
    public static function del($Locations_id){
    	if(empty($Locations_id)){
            return Staffpanel::createError('400','Invalid Locations ID','The Locations id was invalid or not an id.');
        }
        $delLocations = db::$con->prepare("UPDATE socialMediaLocations SET removed_on = CURRENT_TIMESTAMP WHERE location_id = ?;");
        $delLocations->bind_param('i',$Locations_id);
        if ($delLocations->execute()) {
            return true;
        } else {
            $delLocations->close();
            return Staffpanel::createError('408','System Error','An error occured with failed to delete');
        }
    }
}
?>