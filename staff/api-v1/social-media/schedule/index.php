<?php

class SM_Scheduling {
    
    public static function getSchedule() {
        $test = db::$con->query("SELECT postingID, 
theMonth.itemName AS thisMonth, 
theRing.itemName AS thisRing, 
theSphere.itemName AS thisSphere, 
rag, 
firstDraftDue, 
secondDraftDue, 
postingDate, 
comment, 
timeRangeToPost, 
scheduledPost, 
managerApproval, 
postingManager, 
theCategory.itemName AS thisCategory, 
assignedTo,
theType.itemName AS thisType, 
theSeries.itemName AS thisSeries, 
theTitle.itemName AS thisTitle, 
contentDetail, 
thePlatform.itemName AS thisPlatform, 
theContentType.itemName AS thisContentType,
theLive.itemName AS thisLive, 
theRegion.itemName AS thisRegion, 
theLanguage.itemName AS thisLanguage
FROM `socialPostingSchedule` 
LEFT JOIN socialPostingItems AS theMonth ON month = theMonth.itemID 
LEFT JOIN socialPostingItems AS theRing ON ring = theRing.itemID 
LEFT JOIN socialPostingItems AS theSphere ON sphere = theSphere.itemID 
LEFT JOIN socialPostingItems AS theCategory ON contentCategory = theCategory.itemID
LEFT JOIN socialPostingItems AS theType ON postType = theType.itemID 
LEFT JOIN socialPostingItems AS theSeries ON series = theSeries.itemID 
LEFT JOIN socialPostingItems AS theTitle ON title = theTitle.itemID 
LEFT JOIN socialPostingItems AS thePlatform ON platform = thePlatform.itemID 
LEFT JOIN socialPostingItems AS theContentType ON contentType = theContentType.itemID 
LEFT JOIN socialPostingItems AS theLive ON liveSessions = theLive.itemID 
LEFT JOIN socialPostingItems AS theRegion ON targetRegion = theRegion.itemID
LEFT JOIN socialPostingItems AS theLanguage ON targetLanguage = theLanguage.itemID;");
        
        $resultJSON = [];
        while ($result = $test->fetch_assoc()) {
            if ($result["firstDraftDue"] == '0000-00-00') $result["firstDraftDue"] = '';
            if ($result["secondDraftDue"] == '0000-00-00') $result["secondDraftDue"] = '';
            if ($result["postingDate"] == '0000-00-00') $result["postingDate"] = '';
            $resultJSON[] = $result;
        }
        
        return $resultJSON;
    }
    
    public static function uploadCSV($file) {
        //upload file temp
        $dir = $_SERVER["DOCUMENT_ROOT"]."/staff/tmp/";
        $filename = strRand(15).'.csv';
        if (explode('.', strrev($file["name"]))[0] != 'vsc')
            Staffpanel::createError('400', 'Not A CSV File', 'Please upload a valid CSV file.');
        move_uploaded_file($file["tmp_name"], $dir.$filename);
        
        //read file
        $csv = array_map('str_getcsv', file($dir.$filename));
        if ($csv[0][9] != 'Scheduled' && $csv[0][9] != 'Instant')
            array_shift($csv);
        
        $totalCols = 23;
        if (count($csv[0]) != $totalCols)
            Staffpanel::createError('400', 'Missing Columns', 'There are a total of '.count($csv[0]).' columns present in the file instead of '.$totalCols);
        
        $arrayHeads = ["Month", "Ring", "Sphere", "RAG Status", "1st Draft Due", "2nd Draft Due", "Posting Date", "Comment", "Time", "Instant or Scheduled", "Manager Approval", "Posting Manager", "Content", "Assigned", "Type", "Series", "Content/Title", "Content Detail", "Platform", "Content Type", "Live Sessions", "Target Region", "Target Language"];
        array_unshift($csv, $arrayHeads);
        array_walk($csv, function(&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv);
        
        
        
        //add info to db
        //if column info new then add new
        
        foreach($csv as $posting) {
            $queryValues = [];
            foreach ($posting as $column => $value) {
                switch ($column) {
                    case 'Month':
                    case 'Ring':
                    case 'Sphere':
                    case 'Content':
                    case 'Type':
                    case 'Series':
                    case 'Content/Title':
                    case 'Platform':
                    case 'Content Type':
                    case 'Live Sessions':
                    case 'Target Region':
                    case 'Target Language':
                        $checkIfExists = db::$con->prepare("SELECT itemID from socialPostingItems LEFT JOIN socialPostingTypes ON typeID = itemType WHERE typeName = ? AND itemName = ? LIMIT 0, 1;");
                        $checkIfExists->bind_param("ss", $column, $value);
                        $checkIfExists->execute();
                        $checkIfExists->store_result();
                        if ($checkIfExists->num_rows == 1) {
                            $checkIfExists->bind_result($itemID);
                            $checkIfExists->fetch();
                            $checkIfExists->close();
                        } else {
                            $checkIfExists->close();
                            $addItem = db::$con->prepare("INSERT INTO `socialPostingItems`( `itemType`, `itemName`) VALUES ((SELECT typeID FROM socialPostingTypes WHERE typeName = '".$column."' LIMIT 0, 1) ,?);");
                            $addItem->bind_param("s", $value);
                            $addItem->execute();
                            $itemID = $addItem->insert_id;
                            $addItem->close();
                        }
                        
                        if ($column == 'Month') $queryValues[] = $itemID;
                        else $queryValues[] = $itemID;
                        break;
                    default:
                        $queryValues[] = $value;
                }
            }
            
            $addRow = db::$con->prepare("INSERT INTO `socialPostingSchedule`(`month`, `ring`, `sphere`, `rag`, `firstDraftDue`, `secondDraftDue`, `postingDate`, `comment`, `timeRangeToPost`, `scheduledPost`, `managerApproval`, `postingManager`, `contentCategory`, `assignedTo`, `postType`, `series`, `title`, `contentDetail`, `platform`, `contentType`, `liveSessions`, `targetRegion`, `targetLanguage`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $addRow->bind_param("iiisssssssssisiiisiiiii", $queryValues[0],$queryValues[1],$queryValues[2],$queryValues[3],$queryValues[4],$queryValues[5],$queryValues[6],$queryValues[7],$queryValues[8],$queryValues[9],$queryValues[10],$queryValues[11],$queryValues[12],$queryValues[13],$queryValues[14],$queryValues[15],$queryValues[16],$queryValues[17],$queryValues[18],$queryValues[19],$queryValues[20],$queryValues[21],$queryValues[22]);
            if (!$addRow->execute()) {
                $addRow->close();
                Staffpanel::createError('500', 'Database Error', 'An error occured adding the data into the database.');
            }
            $addRow->close();
        }
        
        //delete file temp
        unlink($dir.$filename);
        
        //return ok
        return array('type'=>'Success', 'title'=>'CSV Upload Completed', 'message'=>'The CSV File Was Uploaded');
    }
}
    
?>