<?php
class Milestone {
    
    public static function getInfo($milestoneID) {
        if (!isValidNumber($milestoneID)) Staffpanel::createError('500','Invalid Milestone ID','The milestone ID is not valid.');
        
        $getMilestoneInfo = db::$con->query("SELECT projMilestones.`milestoneID`, projMilestones.`title`, msParent.milestoneID AS parentID, msParent.title AS parent, msOwner.ownerName AS theOwnerName, msOwner.avatar AS ownerAvatar, msSeniorOwner.ownerName AS theSeniorOwnerName, msSeniorOwner.avatar AS seniorOwnerAvatar, projMilestones.`level`, typeTitle, productTitle,locationTitle, projMilestones.`description`, projMilestones.`RAG`, projMilestones.`startDate`, projMilestones.`originalTargetDate` FROM `projMilestones` 
LEFT JOIN (SELECT milestoneID, title FROM projMilestones) AS msParent ON msParent.milestoneID = projMilestones.parentMilestone 
LEFT JOIN (SELECT staffID, CONCAT(firstName, ' ', lastName) as ownerName, avatar FROM staffInfo) AS msOwner ON owner = msOwner.staffID
LEFT JOIN (SELECT staffID, CONCAT(firstName, ' ', lastName) as ownerName, avatar FROM staffInfo) AS msSeniorOwner ON seniorOwner = msSeniorOwner.staffID
LEFT JOIN projMilestonesTypes ON milestoneType = typeID
LEFT JOIN projMilestonesProducts ON product = productID
LEFT JOIN projMilestonesLocations ON location = locationID
WHERE projMilestones.milestoneID = $milestoneID");
        $milestone = $getMilestoneInfo->fetch_assoc();
        
        return $milestone;
    }
    
    public static function getUpdates($milestoneID, $page) {
        
    }
    
    public static function createMilestone($data) {
        if (count(checkIfSetArray($data, ['description', 'fromDate', 'level', 'location', 'owner', 'parentID', 'rag', 'senior-owner', 'title', 'toDate'])) != 0) Staffpanel::createError('400','Missing Parameters','The request to create a milestone is missing parameters.');
        foreach ($data as $dataKey => $dataItem) {
            switch ($dataKey) {
                case 'description':
                    if (strlen($dataItem) <= 10) Staffpanel::createError('400','Description Is Too Short','Please enter more than 10 characters for the description.');
                    break;
                case 'fromDate':
                    if (!checkdate($dataItem['month'], $dataItem['day'], $dataItem['year'])) Staffpanel::createError('500','Invalid Starting Date','The Starting Date is not a valid date.');
                    break;
                case 'level':
                    if (!in_array(intval($dataItem), array(1, 2, 3))) Staffpanel::createError('400','Invalid Milestone Level','The sent milestone level is either less than 1 or greater than 3.');
                    else if (!isValidNumber($dataItem)) Staffpanel::createError('400','Invalid Milestone Level','The sent milestone level is not a number.');
                    break;
                case 'location':
                    $locationID = Milestones::valLocation($dataItem, true);
                    if (!$locationID) Staffpanel::createError('400','Invalid Location','The sent location is invalid.');
                    break;
                case 'owner':
                    if (!isValidNumber($dataItem)) Staffpanel::createError('400','Invalid Owner','The Owner does not exist or was not selected from the dropdown.');
                    $checkIfMember = new Member($dataItem);
                    break;
                case 'parentID':
                    if ($dataItem == '' || $dataItem == NULL) {
                        if (intval($data['level']) != 1) Staffpanel::createError('400','Missing Milestone Parent','The parent milestone level is missing.');
                        else {
                            $data[$dataKey] = NULL; //ensure value is NULL
                            break;
                        }
                    } else if (!isValidNumber($dataItem)) Staffpanel::createError('400','Invalid Milestone Parent ID','The parent milestone id is invalid.');
                    else if (empty(self::getInfo($dataItem))) Staffpanel::createError('400','Invalid Milestone Parent ID','The parent milestone id is invalid.');
                    break;
                case 'rag':
                    if (!in_array($dataItem, array('R', 'A', 'G'))) Staffpanel::createError('400','Invalid RAG Level','The sent RAG level is not "R", "A", or "G".');
                    break;
                case 'senior-owner':
                    if ($dataItem == '' || $dataItem == NULL) $data[$dataKey] = NULL; //ensure value is NULL
                    else if (!isValidNumber($dataItem)) Staffpanel::createError('400','Invalid Senior Owner','The Senior Owner does not exist or was not selected from the dropdown.');
                    else $checkIfMember = new Member($dataItem);
                    break;
                case 'title':
                    if (strlen($dataItem) <= 10) Staffpanel::createError('400','Title Is Too Short','Please enter more than 10 characters for the title.');
                    break;
                case 'toDate':
                    if (!checkdate($dataItem['month'], $dataItem['day'], $dataItem['year'])) Staffpanel::createError('400','Invalid Target Date','The Target Date is not a valid date.');
                    else if ($dataItem['year'] < $data['fromDate']['year']) Staffpanel::createError('400','Invalid Date Range','The Target Date cannot be before the Starting Date.');
                    else if ($dataItem['year'] == $data['fromDate']['year']) {
                        if ($dataItem['month'] < $data['fromDate']['month']) Staffpanel::createError('400','Invalid Date Range','The Target Date cannot be before the Starting Date.');
                        else if ($dataItem['month'] == $data['fromDate']['month']) {
                            if ($dataItem['day'] < $data['fromDate']['day']) Staffpanel::createError('400','Invalid Date Range','The Target Date cannot be before the Starting Date.');
                        }
                    }
                    break;
            }
        }

        $startDate = $data["fromDate"]["year"].'-'.$data["fromDate"]["month"].'-'.$data["fromDate"]["day"];
        $endDate = $data["toDate"]["year"].'-'.$data["toDate"]["month"].'-'.$data["toDate"]["day"];
        $null = null; //TEMP
        
        $addMilestone = db::$con->prepare("INSERT INTO projMilestones (title, parentMilestone, owner, seniorOwner, level, milestoneType, product, location, description, RAG, startDate, originalTargetDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $addMilestone->bind_param("siiiiiiissss", $data["title"], $data["parentID"], $data["owner"], $data["senior-owner"], $data["level"], $null, $null, $locationID, $data["description"], $data["rag"], $startDate, $endDate);
        if ($addMilestone->execute()) {
            $milestoneID = $addMilestone->insert_id;
            $addMilestone->close();
            return $milestoneID;
        } else {
            $err = $addMilestone->error;
            $addMilestone->close();
            Staffpanel::createError('500','Error Adding Milestone',$err);
        }
    }
}
?>