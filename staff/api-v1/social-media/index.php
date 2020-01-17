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
        $gg = intval((56 * pow((pow((500 / 56) , (1 / (11)))) , (1))));
        // echo $gg;

        $new_data = [];
        foreach ($LocationList as $key => $value) {
        	$key = $value['location_id'];
        	if (!array_key_exists($key, $new_data)) {
                $new_data[$key] = $value;
            }
            $end = intval(($value['followers_total'] * pow((pow(($value['followers_total'] / 56) , (1 / (11)))) , (1))));
            $new_data[$key]['followers'][$value['followers_date']] = ['Start of Month Follower Count'=>$value['followers_total'],'End of Month Follower Count'=>$gg,'of New Followers'=>$gg-$value['followers_total']];
        }
        return $new_data;
        var_dump($LocationList);
	}
	public static function AccountsList(){
		$getAccounts = db::$con->query("SELECT social_media_account_id,social_media_account_name,social_media_type FROM socialMediaAccounts AS a LEFT JOIN socialMediaTypes AS b ON a.social_media_account_type = b.social_media_type_id");
        while($Accounts = $getAccounts->fetch_assoc()) {
            $AccountsList[] = $Accounts;
        }
        return $AccountsList;
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