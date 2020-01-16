<?php

/*
    Input as JSON
    
    {
        "department": {
            department_id: 0
        },
        "members": {
            (member id here): 
        }
    }
    
    
    
    
    number of projects worked on
        table of projects
    assignments
        table of assignments
    story points
    percent completed
    
    
    
    
*/

class genReport {
    
    function __construct($fromWeek, $toWeek, $departmentID, $members) {
        self::$duration = array("from"=>$fromWeek, "to"=>$toWeek);
        self::$departmentID = $departmentID;
        self::$members = $members;
        //SET DATEFIRST 7 ;
    }
    
    public static function numOfProjects($singleOrAll) {
        db::$con->query("SELECT theWeek, SUM(...) AS numOfProjects FROM ... LEFT JOIN ... WHERE WEEKOFYEAR(from value) <= WEEKOFYEAR(theWeek) AND WEEKOFYEAR(to value) >= WEEKOFYEAR(theWeek) AND YEAR(from value) <= YEAR(theWeek) AND YEAR(to value) >= YEAR(theWeek)");
    }
    
    //Number of epics and stories by saga
    //SELECT storyStories.storyID, COUNT(epics.storyID) AS totalEpics, COUNT(stories.storyID) AS totalStories FROM `storyStories` LEFT JOIN (SELECT * FROM storyStories WHERE storyStories.type = "Epic") AS epics ON epics.parentID = storyStories.storyID LEFT JOIN (SELECT * FROM storyStories WHERE storyStories.type = "Story") AS stories ON stories.parentID = epics.storyID WHERE storyStories.type = 'Saga' GROUP BY epics.parentID
    //Number of epics and stories and assignments by saga
    //SELECT storyStories.storyID, COUNT(epics.storyID) AS totalEpics, COUNT(stories.storyID) AS totalStories, COUNT(reportAssignments.storyID) AS totalAssignments FROM `storyStories` LEFT JOIN (SELECT * FROM storyStories WHERE storyStories.type = "Epic") AS epics ON epics.parentID = storyStories.storyID LEFT JOIN (SELECT * FROM storyStories WHERE storyStories.type = "Story") AS stories ON stories.parentID = epics.storyID LEFT JOIN reportAssignments ON reportAssignments.storyID = stories.storyID WHERE storyStories.type = 'Saga' GROUP BY epics.parentID
    public static function getAssignments($singleOrAll) {
        
    }
    
    public static function getStoryPoints($singleOrAll) {
        
    }
    
}

?>

<html>
    <head>
        <script src="plotly.min.js"></script>
    </head>
    <body>
        
    </body>
</html>