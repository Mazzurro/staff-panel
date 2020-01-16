<?php

class Sessions {
    public static function List($page,$title,$value) {
        // if(!empty($_GET['page'])){
        //     $page = $_GET['page'];
        // }
        //搜索
        if(!empty($value)){
            // $title = $_POST['title'];
            // $value = $_POST['value'];
            $where="where $title like '%".$value."%'";
        }else{
            $where = '';
        }
        if($page == ''){
            $page = '1';
        }
        dbLog::connect();
        $item = ($page-1)*50;
        $getSessionList = dbLog::$con->query("SELECT * FROM staffSession {$where} ORDER BY sessionID DESC LIMIT $item,50");
        while ($Session = $getSessionList->fetch_assoc()) {
            $SessionList[] = $Session;
        }
        return $SessionList;
    }
    public static function Pageaccess($sessionID) {
        dbLog::connect();
        $getPageaccessList = dbLog::$con->query("SELECT * FROM staffPageaccess where `sessionID` = $sessionID ORDER BY timestamp DESC");
        while ($Pageaccess = $getPageaccessList->fetch_assoc()) {
            $PageaccessList[] = $Pageaccess;
        }
        return $PageaccessList;
    }

}

?>