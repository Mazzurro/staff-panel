<?php
include($_SERVER["DOCUMENT_ROOT"].'/staff/api-v1/milestones/milestone.php');
class Milestones {
    
    /*
        Query Params
            -level
            -search items
                -title
                -product
                -product type
                -type
                -department
            -date range
    */
    public static function fetchMilestones($queryParams, $page) {
        $page = $page * 50;
        $responseJSON = [];
        
        if (!checkdate($queryParams['fromDate']['month'], $queryParams['fromDate']['day'], $queryParams['fromDate']['year'])) Staffpanel::createError('500','Invalid From Date','The From Date is not valid.');
        else if (!checkdate($queryParams['toDate']['month'], $queryParams['toDate']['day'], $queryParams['toDate']['year'])) Staffpanel::createError('500','Invalid To Date','The To Date is not valid.');
        
        $fromDate = $queryParams['fromDate']['year'].'-'.$queryParams['fromDate']['month'].'-'.$queryParams['fromDate']['day'];
        $toDate = $queryParams['toDate']['year'].'-'.$queryParams['toDate']['month'].'-'.$queryParams['toDate']['day'];
        
        if (isset($queryParams["keywords"])) {
            $keywords = '%'.str_replace(' ', '% %', $queryParams["keywords"]).'%';
        } else $keywords = '%%';

        
        $getMilestones = db::$con->prepare("SELECT milestoneID, title, parentMilestone, level, product, projMilestonesProducts.productTitle, startDate, originalTargetDate FROM `projMilestones` LEFT JOIN projMilestonesProducts ON productID = product WHERE level = 1 AND startDate <= ? AND originalTargetDate >= ? AND title LIKE ? ORDER BY productTitle, startDate DESC LIMIT 0, 50");
        $getMilestones->bind_param('sss', $toDate, $fromDate, $keywords);
        $getMilestones->execute();
        $getMilestones->bind_result($ID, $title, $parent, $level, $productID, $product, $startDate, $targetDate);
        while ($getMilestones->fetch()) {
            $responseJSON[] = array('milestoneID'=>$ID, 'title'=>$title, 'parentMilestone'=>$parent, 'level'=>$level, 'productID'=>$productID, 'product'=>$product, 'startDate'=>$startDate, 'targetDate'=>$targetDate);
        }
        $getMilestones->close();
        
        return $responseJSON;
    }
    
    public static function fetchChildren($parentID) {
        if (!isValidNumber($parentID)) Staffpanel::createError('500','Invalid Milestone ID','The milestone ID is not valid.');
        $responseJSON = [];
        
        $getMilestones = db::$con->query("SELECT milestoneID, title, parentMilestone, level, startDate, originalTargetDate FROM `projMilestones` WHERE parentMilestone = $parentID ORDER BY milestoneID, startDate DESC LIMIT 0, 50");
        while ($milestone = $getMilestones->fetch_assoc()) {
            $responseJSON[] = $milestone;
        }
        
        return $responseJSON;
    }
    
    public static function autocomplete($type, $text) {
        if (strlen($text) == 0) return;
        $responseJSON = [];
        $text = '%'.$text.'%';
        
        switch ($type) {
            case 'owner':
            case 'senior-owner':
                $getResults = db::$con->prepare("SELECT staffID, CONCAT(firstName, ' ', middleName, ' ', lastName) as staffName FROM staffInfo WHERE LOWER(CONCAT(firstName, ' ', middleName, ' ', lastName)) LIKE LOWER(?) AND clearanceLevel > 0 Limit 0, 5");
                break;
            case 'location':
                $getResults = db::$con->prepare("SELECT locationID, locationTitle FROM projMilestonesLocations WHERE LOWER(locationTitle) LIKE LOWER(?) Limit 0, 5");
                break;
            case 'product':
                $getResults = db::$con->prepare("SELECT productID, productTitle FROM projMilestonesProducts WHERE LOWER(productTitle) LIKE LOWER(?) Limit 0, 5");
                break;
            case 'type':
                $getResults = db::$con->prepare("SELECT typeID, typeTitle FROM projMilestonesTypes WHERE LOWER(typeTitle) LIKE LOWER(?) Limit 0, 5");
                break;
        }
        
        $getResults->bind_param('s', $text);
        $getResults->execute();
        $getResults->bind_result($id, $title);
        while ($getResults->fetch()) {
            $responseJSON[] = array('id'=>$id, 'name'=>$title);
        }
        $getResults->close();
        
        return $responseJSON;
    }
    
    public static function valLocation($location, $insert) {
        /*
        check if id or text
        if id, then check if id exists
        if text, then check if text exists
            if $insert is true, insert the text if does not exist
        */
        if (isValidNumber($location)) {
            $doesExist = db::$con->query("SELECT locationID FROM projMilestonesLocations WHERE locationID = $location");
            if ($doesExist->num_rows != 1) return false;
            else return $location;
        } else {
            $doesExist = db::$con->prepare("SELECT locationID FROM projMilestonesLocations WHERE locationTitle = ?");
            $doesExist->bind_param("s", $location);
            $doesExist->execute();
            $doesExist->store_result();
            if ($doesExist->num_rows == 1) {
                $doesExist->bind_result($locationID);
                $desoExist->fetch();
                $doesExist->close();
                return $locationID;
            } else if ($insert) {
                $doesExist->close();
                
                $addLocation = db::$con->prepare("INSERT INTO projMilestonesLocations (locationTitle) VALUES (?)");
                $addLocation->bind_param("s", $location);
                $addLocation->execute();
                $addLocation->store_result();
                $locationID = $addLocation->insert_id;
                $addLocation->close();
                
                return $locationID;
            } else return false;
        }
    }
    
}

?>