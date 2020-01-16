<?php
class Userstories {
    
    public static function addStoryItem($type, $title, $description, $parentID, $departmentID) {
        if (!in_array($type, ["Legend", "Saga", "Epic", "Story"])) return Staffpanel::createError('400','Error Creating Story Item','Invalid Story Type.');
        if (strlen($title) == 0 || strlen($description) == 0) return Staffpanel::createError('400','Error Creating Story Item','Missing Input');
        if ($type != "Legend") {
            $parentInfo = self::validateStoryItem($parentID, null);
            if (!$parentInfo) return Staffpanel::createError('400','Error Creating Story Item','Not an existing parent');
        } else {
            if (!isValidNumber($departmentID)) return Staffpanel::createError('400','Error Creating Story Item','Not an existing department');
            $parentID = null;
        }
        
        $addStory = db::$con->prepare("INSERT INTO storyStories (type, parentID, createdBy) VALUES (?,?,?);");
        $addStory->bind_param("sii", $type, $parentID, $_SESSION["me"]["staffID"]);
        if ($addStory->execute()) {
            $storyID = $addStory->insert_id;
            $addStory->close();
            
            $addStoryInstance = db::$con->prepare("INSERT INTO storyInstances (originalStoryID, title, description, updatedBy) VALUES (?,?,?,?);");
            $addStoryInstance->bind_param("issi", $storyID, $title, $description, $_SESSION["me"]["staffID"]);
            if ($addStoryInstance->execute()) {
                $addStoryInstance->close();
                return array('storyID'=>$storyID, "type"=>$type, "title"=>$title, "desc"=>$description, "parentID"=>$parentID);
            } else {
                $addStoryInstance->close();
                return Staffpanel::createError('500','Error Creating Story Item','An error occured with the server. Please try again.');
            }
        } else {
            $addStory->close();
            return Staffpanel::createError('500','Error Creating Story Item','An error occured with the server. Please try again.');
        }
    }
    
    //Returns department, type
    public static function validateStoryItem($itemID, $type) {
        if (!isValidNumber($itemID)) return false;
        
        $getIfValStory = db::$con->query("SELECT storyID, type FROM storyStories WHERE storyID = $itemID AND deletedBy IS NULL");
        $itemInfo = $getIfValStory->fetch_assoc();
        if ($getIfValStory->num_rows > 0 && $type != null && $type != $itemInfo["type"]) return false;
        return ($getIfValStory->num_rows == 0 ? false : $itemInfo);
    }
    
    public static function getInfo($storyID, $type) {
        if (!isValidNumber($storyID) || !self::validateStoryItem($storyID, $type)) return Staffpanel::createError('400','Invalid Story ID','The story id provided is not valid.');
        
        $getStory = db::$con->query("SELECT originalStoryID, title, description, updatedBy, updatedOn, type, createdBy, createdOn FROM storyInstances LEFT JOIN storyStories ON storyID = originalStoryID WHERE originalStoryID = $storyID AND removedBy IS NULL ORDER BY storyInstanceID DESC LIMIT 0,1;");
        $story = $getStory->fetch_assoc();
        return $story;
    }
    
    public static function getLegends() {
        if (StaffMember::hasPerms('*',[1]))
            $getLegends = db::$con->query("SELECT storyID, type, storyInstances.storyInstanceID, title, description, CONCAT(firstName,' ',lastName) as name, updatedOn, department FROM storyInstances LEFT JOIN staffInfo ON staffID = updatedBy JOIN (SELECT MAX(inst.storyInstanceID) as styInt, inst.originalStoryID FROM storyInstances as inst WHERE inst.removedBy IS NULL GROUP BY inst.originalStoryID ORDER BY styInt DESC) as lastRecord ON storyInstances.storyInstanceID = lastRecord.styInt LEFT JOIN storyStories ON storyID = storyInstances.originalStoryID AND storyID = lastRecord.originalStoryID AND deletedBy IS NULL LEFT JOIN storyLegendsLink ON storyLegendsLink.legendID = storyID LEFT JOIN miscDepartments ON storyLegendsLink.departmentID = miscDepartments.departmentID WHERE type = 'Legend' ORDER BY department, title;");
        else
            $getLegends = db::$con->query("SELECT storyID, type, storyInstances.storyInstanceID, title, description, CONCAT(firstName,' ',lastName) as name, updatedOn, department FROM storyInstances LEFT JOIN staffInfo ON staffID = updatedBy JOIN (SELECT MAX(inst.storyInstanceID) as styInt, inst.originalStoryID FROM storyInstances as inst WHERE inst.removedBy IS NULL GROUP BY inst.originalStoryID ORDER BY styInt DESC) as lastRecord ON storyInstances.storyInstanceID = lastRecord.styInt LEFT JOIN storyStories ON storyID = storyInstances.originalStoryID AND storyID = lastRecord.originalStoryID AND deletedBy IS NULL LEFT JOIN storyLegendsLink ON storyLegendsLink.legendID = storyID LEFT JOIN miscDepartments ON storyLegendsLink.departmentID = miscDepartments.departmentID WHERE type = 'Legend' AND miscDepartments.departmentID IN (".implode(',', array_keys(StaffMember::$me["depts"]["departments"])).") ORDER BY department, title;");
    
        $legendList = [];
        while ($legend = $getLegends->fetch_assoc()) {
            $legendList[$legend["storyID"]] = $legend;
        }
        
        return $legendList;
    }
    
    public static function getSagas($legendID) {
        if (!isValidNumber($legendID)) return false;
        $sagaList = [];
        
        $getSagaList = db::$con->query("SELECT storyID, type, storyInstances.storyInstanceID, title, description, CONCAT(firstName,' ',lastName) as name, updatedOn FROM storyInstances LEFT JOIN staffInfo ON staffID = updatedBy JOIN (SELECT MAX(inst.storyInstanceID) as styInt, inst.originalStoryID FROM storyInstances as inst WHERE inst.removedBy IS NULL GROUP BY inst.originalStoryID ORDER BY styInt DESC) as lastRecord ON storyInstances.storyInstanceID = lastRecord.styInt LEFT JOIN storyStories ON storyID = storyInstances.originalStoryID AND storyID = lastRecord.originalStoryID AND deletedBy IS NULL WHERE type = 'Saga' AND parentID = $legendID ORDER BY title;");
        while ($saga = $getSagaList->fetch_assoc()) {
            $sagaList[$saga["storyID"]] = $saga;
        }
        
        return $sagaList;
    }
    
    public static function getEpics($sagaID) {
        if (!isValidNumber($sagaID)) return false;
        $epicList = [];
        
        $getEpicList = db::$con->query("SELECT storyID, type, storyInstances.storyInstanceID, title, description, CONCAT(firstName,' ',lastName) as name, updatedOn FROM storyInstances LEFT JOIN staffInfo ON staffID = updatedBy JOIN (SELECT MAX(inst.storyInstanceID) as styInt, inst.originalStoryID FROM storyInstances as inst WHERE inst.removedBy IS NULL GROUP BY inst.originalStoryID ORDER BY styInt DESC) as lastRecord ON storyInstances.storyInstanceID = lastRecord.styInt LEFT JOIN storyStories ON storyID = storyInstances.originalStoryID AND storyID = lastRecord.originalStoryID AND deletedBy IS NULL WHERE type = 'Epic' AND parentID = $sagaID ORDER BY title;");
        while ($epic = $getEpicList->fetch_assoc()) {
            $epicList[$epic["storyID"]] = $epic;
        }
        
        return $epicList;
    }
    
    public static function getStories($epicID) {
        if (!isValidNumber($epicID)) return false;
        $storyList = [];
        
        $getStoryList = db::$con->query("SELECT storyID, type, storyInstances.storyInstanceID, title, description, CONCAT(firstName,' ',lastName) as name, updatedOn FROM storyInstances LEFT JOIN staffInfo ON staffID = updatedBy JOIN (SELECT MAX(inst.storyInstanceID) as styInt, inst.originalStoryID FROM storyInstances as inst WHERE inst.removedBy IS NULL GROUP BY inst.originalStoryID ORDER BY styInt DESC) as lastRecord ON storyInstances.storyInstanceID = lastRecord.styInt LEFT JOIN storyStories ON storyID = storyInstances.originalStoryID AND storyID = lastRecord.originalStoryID AND deletedBy IS NULL WHERE type = 'Story' AND parentID = $epicID ORDER BY title;");
        while ($story = $getStoryList->fetch_assoc()) {
            $storyList[$story["storyID"]] = $story;
        }
        
        return $storyList;
    }
    
    public static function getDepartments($levelID, $level) {
        if (!isValidNumber($levelID)) return Staffpanel::createError('400', 'Invalid ID', 'The id provided was not a number');
        switch ($level) {
            case 'Story':
            case 'Epic':
            case 'Saga':
                $getParentID = db::$con->query("SELECT parentID FROM storyStories WHERE storyID = $levelID;");
                if ($getParentID->num_rows == 0) return Staffpanel::createError('400', 'Empty Response', $level.'-'.$levelID.' did not return anything.');
        }
        switch ($level) {
            case 'Story':
                return self::getDepartments(($getParentID->fetch_assoc())['parentID'], 'Epic');
                break;
            case 'Epic':
                return self::getDepartments(($getParentID->fetch_assoc())['parentID'], 'Saga');
                break;
            case 'Saga':
                return self::getDepartments(($getParentID->fetch_assoc())['parentID'], 'Legend');
                break;
            case 'Legend':
                $deptsList = [];
                $getDeptsID = db::$con->query("SELECT miscDepartments.departmentID, department FROM storyLegendsLink LEFT JOIN miscDepartments ON miscDepartments.departmentID = storyLegendsLink.departmentID WHERE legendID = $levelID;");
                if ($getDeptsID->num_rows == 0) return Staffpanel::createError('400', 'Empty Response', $level.'-'.$levelID.' did not return anything.');
                while ($dept = $getDeptsID->fetch_assoc()) {
                    $deptsList[$dept['departmentID']] = $dept;
                }
                return $deptsList;
                break;
            default: return Staffpanel::createError('400', 'Invalid Section Type', 'The type provided was invalid.');
        }
    }

    public static function getParentID($storyID, $type) {
        if (!isset($type) || !isValidNumber($storyID) || !self::validateStoryItem($storyID, $type)) return Staffpanel::createError('400','Invalid Story ID','The story id provided is not valid.');
        $getParentID = db::$con->query("SELECT parentID FROM storyStories WHERE storyID = $storyID;");
        if ($getParentID->num_rows == 0) return Staffpanel::createError('400', 'Empty Response', $storyID.' does not exist or does not have a parent.');
        else {
            $parent = $getParentID->fetch_assoc();
            return $parent['parentID'];
        }
    }

    public static function editStoryItem($story_id, $data) {
        if (!isset($data['type']) || !isValidNumber($story_id) || !self::validateStoryItem($story_id, $data['type'])) return Staffpanel::createError('400','Invalid Story ID','The story id provided is not valid.');
        if (isset($data['title']) && isset($data['description'])) {
            $addStoryInstance = db::$con->prepare("INSERT INTO storyInstances (originalStoryID, title, description, updatedBy) VALUES (?,?,?,?);");
            $addStoryInstance->bind_param("issi", $story_id, $data['title'], $data['description'], $_SESSION["me"]["staffID"]);
            if ($addStoryInstance->execute()) {
                $addStoryInstance->close();
                if (isset($data['parent_id'])) {
                    return self::changeStoryParent($story_id, $data['parent_id'], $data['type']);
                } else return 1;
            } else {
                $addStoryInstance->close();
                return Staffpanel::createError('500','Error Editing Story Item','An error occured with the server. Please try again.');
            }
        } else if (isset($data['parent_id'])) {
            return self::changeStoryParent($story_id, $data['parent_id'], $data['type']);
        } else return 1;
    }

    public static function changeStoryParent($story_id, $parent_id, $type) {
        if (!isValidNumber($story_id) || !self::validateStoryItem($story_id, $type)) return Staffpanel::createError('400','Invalid Story ID','The story id provided is not valid.');
        $addStoryInstance = db::$con->prepare("UPDATE storyStories SET parentID = ? WHERE storyID = ? AND type = ?;");
        $addStoryInstance->bind_param("iis", $parent_id, $story_id, $type);
        if ($addStoryInstance->execute()) {
            $addStoryInstance->close();
            return 1;
        } else {
            $addStoryInstance->close();
            return Staffpanel::createError('500','Error Editing Story Item','An error occured with the server. Please try again.');
        }
    }
}
?>