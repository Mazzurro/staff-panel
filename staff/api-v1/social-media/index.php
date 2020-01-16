<?php
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/social-media/schedule/index.php');
class Socialmedia{
	public static function create($LocationsDetails) {
		// $LocationsDetails['location_social_account'] = '1';
		// $LocationsDetails['location_city'] = 'Mumbal';
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
	public static function createAccounts(){
		$addAccounts = db::$con->prepare("INSERT INTO socialMediaAccounts (social_media_account_name, social_media_account_type, social_media_account_owner) VALUES (?,?,?)");
    	$addAccounts->bind_param("sis",$AccountsDetails['social_media_account_name'],$AccountsDetails['social_media_account_type'],$AccountsDetails['social_media_account_owner']);
    	if($addAccounts->execute()){
    		return true;
    	}else{
    		$addAccounts->close();
    		return Staffpanel::createError('408','System Error','An error occured with failed to delete');
    	}
	}
	public static function List(){
		$getLocationList = db::$con->query("SELECT * FROM socialMediaLocations where removed_on is null");
        while($Locations = $getLocationList->fetch_assoc()) {
            $LocationList[] = $Locations;
        }
        return $LocationList;
	}
	public static function AccountsList(){
		$getAccounts = db::$con->query("SELECT social_media_account_id,social_media_account_name,social_media_type FROM socialMediaAccounts AS a LEFT JOIN socialMediaTypes AS b ON a.social_media_account_type = b.social_media_type_id");
        while($Accounts = $getAccounts->fetch_assoc()) {
            $AccountsList[] = $Accounts;
        }
        return $AccountsList;
	}
	public static function Permissions($staffList){
		$insertQuery = '';
        foreach($staffList as $key => $item) {
            if (!isValidNumber($key) || !isValidNumber($item)) return Staffpanel::createError('400','Invalid ID','One or many of the ids provided are invalid.');
            if ($item == '0')
                $insertQuery .= ($insertQuery == '' ? '' : ',')."(".self::$projectID.",$key,$item,".StaffMember::$me['staffID'].",1,".StaffMember::$me['staffID'].",CURRENT_TIMESTAMP)";
            else
                $insertQuery .= ($insertQuery == '' ? '' : ',')."(".self::$projectID.",$key,$item,".StaffMember::$me['staffID'].",1,NULL,NULL)";
        }

        if (db::$con->multi_query("CREATE TEMPORARY TABLE staffAssigned
                            (
                            	social_media_account_id INT,
                            	staff_id INT,
                            	permLevel INT,
                            	removed_on TIMESTAMP NULL
                            );

                            INSERT INTO staffAssigned VALUES $insertQuery;

                            INSERT INTO socialMediaAccountsPermissions (staff_id, staffID, permission_level, removed_on)
                            SELECT * FROM staffAssigned
                            ON DUPLICATE KEY UPDATE permission_level = permLevel, removedOn = CASE WHEN deletedBy IS NULL THEN NULL ELSE deletedOn END;

                            DROP TABLE staffAssigned;"))
            echo true;
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