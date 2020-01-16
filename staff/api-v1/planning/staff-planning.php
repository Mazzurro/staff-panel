<?php
/**
 *
 */
class Staffing
{
    public static function CreateProduct($ProductDetails){
        if (!isset($ProductDetails['type'])) return Staffpanel::createError('400','Missing Input','The type cannot be blank.');
        else if (!isset($ProductDetails['title'])) return Staffpanel::createError('400','Missing Input','The title cannot be blank.');
        if($ProductDetails['parentID'] == null){
            $addProduct = db::$con->prepare("INSERT INTO Product (type, title) VALUES (?,?)");
            $addProduct->bind_param("ss",$ProductDetails['type'],$ProductDetails['title']);
            if ($addProduct->execute()) {
                $typeID = $addProduct->insert_id;
                $addProduct->close();
                return $typeID;
            }else{
                $addProduct->close();
                return Staffpanel::createError('408','System Error','An error occured with adding the Product.');
            }
        }else{
            $addProduct = db::$con->prepare("INSERT INTO Product (type, title, parentID) VALUES (?,?,?)");
            $addProduct->bind_param("ssi",$ProductDetails['type'],$ProductDetails['title'],$ProductDetails['parentID']);
            if ($addProduct->execute()) {
                $typeID = $addProduct->insert_id;
                $addProduct->close();
                return $typeID;
            }else{
                $addProduct->close();
                return Staffpanel::createError('408','System Error','An error occured with adding the '.$ProductDetails['type'].'.');
            }
        }

    }
    public static function CreateStaff($StaffDetails){
        // var_dump($_POST);exit;
        // $StaffDetails['departmentID'] = '1';
        $StaffDetails['clearanceLevel'] = '0';
        // $StaffDetails['firstName'] = '1';
        // $StaffDetails['middleName'] = '1';
        // $StaffDetails['lastName'] = '1';
        $StaffDetails['email'] = 'no';
        // $StaffDetails['phoneNumber'] = '1';
        // $StaffDetails['city'] = '1';
        // $StaffDetails['state'] = '1';
        $StaffDetails['country'] = 'no';
        $StaffDetails['avatar'] = 'unknown.png';
        $StaffDetails['planned'] = '0';
        // $StaffDetails['joinDate'] = '2019-01-01';
        // $StaffDetails['leaveDate'] = '2019-01-01';
        // $StaffDetails['location'] = '1';
        // $StaffDetails['functionalManager'] = '1';
        // $StaffDetails['locationManager'] = '1';
        // $StaffDetails['roleID'] = '1';
        mysqli_autocommit(db::$con,FALSE);
        $addStaff = db::$con->prepare("INSERT INTO staffInfo (departmentID, clearanceLevel, firstName, middleName, lastName, email, country, avatar, planned, joinDate, leaveDate, location, functionalManager, locationManager) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $addStaff->bind_param("iissssssissiii",$StaffDetails['departmentID'],$StaffDetails['clearanceLevel'],$StaffDetails['firstName'],$StaffDetails['middleName'],$StaffDetails['lastName'],$StaffDetails['email'],$StaffDetails['country'],$StaffDetails['avatar'],$StaffDetails['planned'],$StaffDetails['joinDate'],$StaffDetails['leaveDate'],$StaffDetails['location'],$StaffDetails['functionalManager'],$StaffDetails['locationManager']);
        if ($addStaff->execute()) {
            $staffID = $addStaff->insert_id;
            $addlinkStaff = db::$con->prepare("INSERT INTO `linkStaff` (staffID, runrateID, productID) VALUES (?,?,?)");
            $addlinkStaff->bind_param("iii", $staffID,$StaffDetails['runrateID'],$StaffDetails['productID']);

            $addlinkRoles = db::$con->prepare("INSERT INTO `linkRoles` (staffID, roleID) VALUES (?,?)");
            $addlinkRoles->bind_param("ii", $staffID,$StaffDetails['roleID']);

            $addsalary = db::$con->prepare("INSERT INTO `Salary` (staffID, salary) VALUES (?,?)");
            $addsalary->bind_param("ii", $staffID,$StaffDetails['salary']);

            if($addlinkStaff->execute() && $addlinkRoles->execute() && $addsalary->execute()) {
                mysqli_commit(db::$con);
                return true;
            }else{
                // echo "aa";
                mysqli_rollback(db::$con);
                return Staffpanel::createError('408','System Error','An error occured with adding the staff.');
            }
        }else{
            // echo "bb";
            mysqli_rollback(db::$con);
            $addStaff->close();
            return Staffpanel::createError('408','System Error','An error occured with adding the staff.');
        }
    }
    public static function Info(){
        $getstaff = db::$con->query("SELECT staffID,firstName,middleName,lastName FROM staffInfo WHERE removed_On is null");
        while($staff = $getstaff->fetch_assoc()) {
            $staffList[] = $staff;
        }
        return $staffList;
    }
    public static function edit($staffID,$StaffDetails){
        if(empty($staffID)){
            return Staffpanel::createError('400','Invalid staff ID','The staff id was invalid or not an id.');
        }

        mysqli_autocommit(db::$con,FALSE);
        $editStaff = db::$con->prepare("UPDATE staffInfo SET departmentID = ?, firstName = ?, middleName = ?, lastName = ?, joinDate = ?, leaveDate = ?, location = ?, functionalManager = ?, locationManager = ? WHERE staffID = ?;");
        $editStaff->bind_param('isssssiiii',$StaffDetails['departmentID'],$StaffDetails['firstName'],$StaffDetails['middleName'],$StaffDetails['lastName'],$StaffDetails['joinDate'],$StaffDetails['leaveDate'],$StaffDetails['location'],$StaffDetails['functionalManager'],$StaffDetails['locationManager'],$staffID);

        $editlinkStaff = db::$con->prepare("UPDATE linkStaff SET runrateID = ?, productID = ? WHERE staffID = ?;");
        $editlinkStaff->bind_param("iii", $StaffDetails['runrateID'],$StaffDetails['productID'],$staffID);

        $editlinkRoles = db::$con->prepare("UPDATE linkRoles SET roleID = ? WHERE staffID = ?;");
        $editlinkRoles->bind_param("ii", $StaffDetails['roleID'],$staffID);

        $editSalary = db::$con->prepare("UPDATE Salary SET salary = ? WHERE staffID = ?;");
        $editSalary->bind_param("ii", $StaffDetails['salary'],$staffID);

        if($editStaff->execute() && $editlinkStaff->execute() && $editlinkRoles->execute() && $editSalary->execute()){
            mysqli_commit(db::$con);
            return true;
        }else{
            mysqli_rollback(db::$con);
            $editlinkRoles->close();
            return Staffpanel::createError('408','System Error','An error occured with editing the staff.');
        }
    }
    public static function addStaff($staffID,$StaffDetails){
        $addlinkStaff = db::$con->prepare("INSERT INTO `linkStaff` (staffID, runrateID, productID) VALUES (?,?,?)");
        $addlinkStaff->bind_param("iii", $staffID,$StaffDetails['runrateID'],$StaffDetails['productID']);
        if ($addlinkStaff->execute()) {
            $addlinkStaff->close();
            return true;
        }else{
            $addlinkStaff->close();
            return Staffpanel::createError('408','System Error','An error occured with adding the staff.');
        }
    }
    public static function addRoles($staffID,$StaffDetails){
        $addlinkRoles = db::$con->prepare("INSERT INTO `linkRoles` (staffID, roleID) VALUES (?,?)");
        $addlinkRoles->bind_param("ii", $staffID,$StaffDetails['roleID']);
        if ($addlinkRoles->execute()) {
            $addlinkRoles->close();
            return true;
        }else{
            $addlinkRoles->close();
            return Staffpanel::createError('408','System Error','An error occured with adding the staff.');
        }
    }
    public static function editStaff($staffID,$StaffDetails){
        $editlinkStaff = db::$con->prepare("UPDATE linkStaff SET runrateID = ?, productID = ? WHERE staffID = ?;");
        $editlinkStaff->bind_param("iii", $StaffDetails['runrateID'],$StaffDetails['productID'],$staffID);
        if ($editlinkStaff->execute()) {
            $editlinkStaff->close();
            return true;
        }else{
            $editlinkStaff->close();
            return Staffpanel::createError('408','System Error','An error occured with editing the staff.');
        }
    }
    public static function editRoles($staffID,$StaffDetails){
        $editlinkRoles = db::$con->prepare("UPDATE linkRoles SET roleID = ? WHERE staffID = ?;");
        $editlinkRoles->bind_param("ii", $StaffDetails['roleID'],$staffID);
        if ($editlinkRoles->execute()) {
            $editlinkRoles->close();
            return true;
        }else{
            $editlinkRoles->close();
            return Staffpanel::createError('408','System Error','An error occured with editing the staff.');
        }
    }
    public static function Product(){
        $getProduct = db::$con->query("SELECT typeID,type,title FROM Product WHERE parentID is null AND type = 'Product' AND removedOn is null");
        while($Product = $getProduct->fetch_assoc()) {
            $ProductList[] = $Product;
        }
        return $ProductList;
    }
    public static function Capability($parentID){
        $getCapability = db::$con->query("SELECT typeID,type,title FROM Product WHERE parentID = $parentID AND type = 'Capability' AND removedOn is null");
        while($Capability = $getCapability->fetch_assoc()) {
            $CapabilityList[] = $Capability;
        }
        return $CapabilityList;
    }
    public static function Service($parentID){
        $getService = db::$con->query("SELECT typeID,type,title FROM Product WHERE parentID = $parentID AND type = 'Service' AND removedOn is null");
        while($Service = $getService->fetch_assoc()) {
            $ServiceList[] = $Service;
        }
        return $ServiceList;
    }
    public static function List($joinDate,$leaveDate){
        // $staffID = '57';
        if(!empty($joinDate)){
            if(empty($leaveDate)){
                $where = "AND joinDate > '$joinDate-01'";
            }else{
                $where = "AND joinDate > '$joinDate-01' AND joinDate < '$leaveDate-01'";
            }
        }else{
            $where = '';
        }

        // exit;
//$where = AND joinDate > $joinDate AND leaveDate > $leaveDate;
        $getstaffList = db::$con->query("SELECT *,a.staffID,a.departmentID FROM staffInfo AS a LEFT JOIN linkRoles AS b ON a.staffID = b.staffID LEFT JOIN linkStaff AS c ON c.staffID = a.staffID LEFT JOIN miscDepartments AS d ON d.departmentID = a.departmentID LEFT JOIN Product AS e ON c.productID = e.typeID LEFT JOIN miscRoles AS f ON b.roleID = f.roleID LEFT JOIN Country AS g ON a.location = g.Country_id LEFT JOIN Salary AS h ON a.staffID = h.staffID WHERE a.removed_On is null {$where}");
        while($staff = $getstaffList->fetch_assoc()) {
            $staffList[] = $staff;
        }
        $new_data = [];
        foreach ($staffList as $k =>$row) {
            $key = $row['staffID'];
            if (!array_key_exists($key, $new_data)) {
                $new_data[$key] = $row;
                $new_data[$key]['roles'] = array();
            }
            $new_data[$key]['roles'][$row['roleID']] = ['type'=>$row['type'],'name'=>$row['name']];
            unset($new_data[$key]['linkID'],$new_data[$key]['subOf']);
            unset($new_data[$key]['type'],$new_data[$key]['name']);
            unset($new_data[$key]['removedOn'],$new_data[$key]['removedBy']);
            unset($new_data[$key]['removed_On'],$new_data[$key]['removed_By']);
            unset($new_data[$key]['faIcon']);
            unset($new_data[$key]['city'],$new_data[$key]['country'],$new_data[$key]['email'],$new_data[$key]['location'],$new_data[$key]['location'],$new_data[$key]['phoneNumber']);
            $RunRate_id = $new_data[$key]['runrateID'];
            // if(!empty($RunRate_id)){
            //     $getRunRate = db::$con->query("SELECT * FROM RunRate AS a LEFT JOIN Country AS b ON a.Country = b.Country_id LEFT JOIN miscRoles AS c ON a.Role = c.roleID where RunRate_id = $RunRate_id AND Removed_on is null");
            //     $RunRate = $getRunRate->fetch_assoc();
            //     unset($RunRate['Removed_By'],$RunRate['Removed_on'],$RunRate['Country'],$RunRate['Role']);
            //     $new_data[$key]['RunRate'] = $RunRate;
            // }
            $Country_id = $new_data[$key]['Country_id'];
            $roleID = $new_data[$key]['roleID'];
            if($RunRate_id == 1){
                $getRunRate = db::$con->query("SELECT * FROM RunRate WHERE Country = $Country_id AND Role = $roleID");
                $RunRate = $getRunRate->fetch_assoc();
                $new_data[$key]['RunRate'] = ['VolunteerCost'=>$RunRate['VolunteerCost']];
            }elseif($RunRate_id == 2){
                $getRunRate = db::$con->query("SELECT * FROM RunRate WHERE Country = $Country_id AND Role = $roleID");
                $RunRate = $getRunRate->fetch_assoc();
                $new_data[$key]['RunRate'] = ['AdditionalCost'=>$RunRate['AdditionalCost']];
            }elseif($RunRate_id == 3){
                $getRunRate = db::$con->query("SELECT * FROM RunRate WHERE Country = $Country_id AND Role = $roleID");
                $RunRate = $getRunRate->fetch_assoc();
                $new_data[$key]['RunRate'] = ['LowCost'=>$RunRate['LowCost']];
            }elseif($RunRate_id == 4){
                $getRunRate = db::$con->query("SELECT * FROM RunRate WHERE Country = $Country_id AND Role = $roleID");
                $RunRate = $getRunRate->fetch_assoc();
                $new_data[$key]['RunRate'] = ['MediumCost'=>$RunRate['MediumCost']];
            }elseif($RunRate_id == 5){
                $getRunRate = db::$con->query("SELECT * FROM RunRate WHERE Country = $Country_id AND Role = $roleID");
                $RunRate = $getRunRate->fetch_assoc();
                $new_data[$key]['RunRate'] = ['HighCost'=>$RunRate['HighCost']];
            }else{
                $new_data[$key]['RunRate'] = 'NULL';
            }
            $functionalManager = $new_data[$key]['functionalManager'];
            if(!empty($functionalManager)){
                $getstaff = db::$con->query("SELECT staffID,firstName,middleName,lastName FROM staffInfo WHERE staffID = $functionalManager AND removed_On is null");
                $staff = $getstaff->fetch_assoc();
                // unset($new_data[$key]['functionalManager']);
                $new_data[$key]['FunctionalManager'] = ['staffID'=>$staff['staffID'],'name'=>$staff['firstName'].' '.$staff['middleName'].' '.$staff['lastName']];
            }else{
                // unset($new_data[$key]['functionalManager']);
                $new_data[$key]['FunctionalManager'] = 'null';
            }
            $locationManager = $new_data[$key]['locationManager'];
            if(!empty($locationManager)){
                $getstaff_2 = db::$con->query("SELECT staffID,firstName,middleName,lastName FROM staffInfo WHERE staffID = $locationManager AND removed_On is null");
                $staff_2 = $getstaff_2->fetch_assoc();
                // unset($new_data[$key]['locationManager']);
                $new_data[$key]['LocationManager'] = ['staffID'=>$staff_2['staffID'],'name'=>$staff_2['firstName'].' '.$staff_2['middleName'].' '.$staff_2['lastName']];
            }else{
                $new_data[$key]['LocationManager'] = 'null';
            }
            // return($new_data);
        }
        // $RunRate_id = '2';
        // var_dump($staffList);
        foreach ($new_data as $key => $value) {
            $new_List[] = $value;
        }
        return $new_List;
    }
    public static function getTree($pId=null){
        // $_POST['joinDate'] = '2017-01';
        // $_POST['leaveDate'] = '2020-02';
            $getProduct = db::$con->query("SELECT typeID,type,title,parentID FROM Product WHERE removedOn is null");
            while($Product = $getProduct->fetch_assoc()) {
                $ProductList[] = $Product;
            }
            $temp=array();
            foreach($ProductList as $k=>$v){
                if($v['parentID']==$pId){
                    $temp[$k]=$v;
                    $temp[$k]['son']=Staffing::getTree($v['typeID']);
                    unset($temp[$k]['parentID']);
                    if(empty($temp[$k]['son'])){
                        unset($temp[$k]['son']);
                    }
                    $Staff = Staffing::List($_POST['joinDate'],$_POST['leaveDate']);
                    foreach ($Staff as $key => $value) {
                        if($v['typeID'] == $value['productID']){
                            $temp[$k]['staff'][$value['staffID']]=$value;
                        }
                    }

                }
            }

       return $temp;
    }
    public static function Country(){
        $getCountry = db::$con->query("SELECT * FROM Country");
        while($Country = $getCountry->fetch_assoc()) {
            $CountryList[] = $Country;
        }
        return $CountryList;
    }
    public static function getstaff($staffID){
        // echo "string";exit;
        // $staffID = '103';
        if(empty($staffID)){
            return Staffpanel::createError('400','Invalid staff ID','The staff id was invalid or not an id.');
        }
        $getstaffList = db::$con->query("SELECT *,a.staffID,a.departmentID FROM staffInfo AS a LEFT JOIN linkRoles AS b ON a.staffID = b.staffID LEFT JOIN linkStaff AS c ON c.staffID = a.staffID LEFT JOIN miscDepartments AS d ON d.departmentID = a.departmentID LEFT JOIN Product AS e ON c.productID = e.typeID LEFT JOIN miscRoles AS f ON b.roleID = f.roleID LEFT JOIN Country AS g ON a.location = g.Country_id LEFT JOIN Salary AS h ON a.staffID = h.staffID where a.staffID=$staffID AND a.removed_On is null");
        while($staff = $getstaffList->fetch_assoc()) {
            $staffList[] = $staff;
        }
        $new_data = [];
        // var_dump($staffList);
        // exit;
        foreach ($staffList as $k =>$row) {
            $key = $row['staffID'];
            if (!array_key_exists($key, $new_data)) {
                $new_data[$key] = $row;
                $new_data[$key]['roles'] = array();
            }
            $new_data[$key]['roles'][$row['roleID']] = ['type'=>$row['type'],'name'=>$row['name']];
            unset($new_data[$key]['linkID'],$new_data[$key]['subOf']);
            unset($new_data[$key]['type'],$new_data[$key]['name']);
            unset($new_data[$key]['removedOn'],$new_data[$key]['removedBy']);
            unset($new_data[$key]['removed_On'],$new_data[$key]['removed_By']);
            unset($new_data[$key]['faIcon']);
            unset($new_data[$key]['city'],$new_data[$key]['country'],$new_data[$key]['email'],$new_data[$key]['location'],$new_data[$key]['location'],$new_data[$key]['phoneNumber']);

            $typeID = $new_data[$key]['parentID'];
            $getProduct = db::$con->query("SELECT * FROM Product WHERE typeID = $typeID");
            $Product = $getProduct->fetch_assoc();
            $new_data[$key]['Product'] = $Product['parentID'];
            $new_data[$key]['Capability'] = $new_data[$key]['parentID'];
            $new_data[$key]['Service'] = $new_data[$key]['productID'];

            $RunRate_id = $new_data[$key]['runrateID'];

            $Country_id = $new_data[$key]['Country_id'];
            $roleID = $new_data[$key]['roleID'];
            if($RunRate_id == 1){
                $getRunRate = db::$con->query("SELECT * FROM RunRate WHERE Country = $Country_id AND Role = $roleID");
                $RunRate = $getRunRate->fetch_assoc();
                $new_data[$key]['RunRate'] = ['VolunteerCost'=>$RunRate['VolunteerCost']];
            }elseif($RunRate_id == 2){
                $getRunRate = db::$con->query("SELECT * FROM RunRate WHERE Country = $Country_id AND Role = $roleID");
                $RunRate = $getRunRate->fetch_assoc();
                $new_data[$key]['RunRate'] = ['AdditionalCost'=>$RunRate['AdditionalCost']];
            }elseif($RunRate_id == 3){
                $getRunRate = db::$con->query("SELECT * FROM RunRate WHERE Country = $Country_id AND Role = $roleID");
                $RunRate = $getRunRate->fetch_assoc();
                $new_data[$key]['RunRate'] = ['LowCost'=>$RunRate['LowCost']];
            }elseif($RunRate_id == 4){
                $getRunRate = db::$con->query("SELECT * FROM RunRate WHERE Country = $Country_id AND Role = $roleID");
                $RunRate = $getRunRate->fetch_assoc();
                $new_data[$key]['RunRate'] = ['MediumCost'=>$RunRate['MediumCost']];
            }elseif($RunRate_id == 5){
                $getRunRate = db::$con->query("SELECT * FROM RunRate WHERE Country = $Country_id AND Role = $roleID");
                $RunRate = $getRunRate->fetch_assoc();
                $new_data[$key]['RunRate'] = ['HighCost'=>$RunRate['HighCost']];
            }else{
                $new_data[$key]['RunRate'] = 'NULL';
            }
            $functionalManager = $new_data[$key]['functionalManager'];
            if(!empty($functionalManager)){
                $getstaff = db::$con->query("SELECT staffID,firstName,middleName,lastName FROM staffInfo WHERE staffID = $functionalManager AND removed_On is null");
                $staff = $getstaff->fetch_assoc();
                // unset($new_data[$key]['functionalManager']);
                $new_data[$key]['FunctionalManager'] = ['staffID'=>$staff['staffID'],'name'=>$staff['firstName'].' '.$staff['middleName'].' '.$staff['lastName']];
            }else{
                // unset($new_data[$key]['functionalManager']);
                $new_data[$key]['FunctionalManager'] = 'null';
            }
            $locationManager = $new_data[$key]['locationManager'];
            if(!empty($locationManager)){
                $getstaff_2 = db::$con->query("SELECT staffID,firstName,middleName,lastName FROM staffInfo WHERE staffID = $locationManager AND removed_On is null");
                $staff_2 = $getstaff_2->fetch_assoc();
                // unset($new_data[$key]['locationManager']);
                $new_data[$key]['LocationManager'] = ['staffID'=>$staff_2['staffID'],'name'=>$staff_2['firstName'].' '.$staff_2['middleName'].' '.$staff_2['lastName']];
            }else{
                $new_data[$key]['LocationManager'] = 'null';
            }
            // return($new_data);
        }
        // $RunRate_id = '2';
        // var_dump($staffList);
        foreach ($new_data as $key => $value) {
            unset($value['parentID']);
            unset($value['productID']);
            $new_List[] = $value;
        }
        return $new_List;
    }
    public static function del($staffID){
        if(empty($staffID)){
            return Staffpanel::createError('400','Invalid staff ID','The staff id was invalid or not an id.');
        }
        $delRunRate = db::$con->prepare("UPDATE staffInfo SET removed_By = ?, removed_On = CURRENT_TIMESTAMP WHERE staffID = ?;");
        $delRunRate->bind_param('ii', StaffMember::$me['staffID'], $staffID);
        if ($delRunRate->execute()) {
            return true;
        } else {
            $delRunRate->close();
            return Staffpanel::createError('408','System Error','An error occured with failed to delete');
        }
    }
}
?>