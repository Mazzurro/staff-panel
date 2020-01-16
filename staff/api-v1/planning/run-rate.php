<?php
class RunRate
{
    public static function Create($RunRateDetails){
        if (!isset($RunRateDetails['Country'])) return Staffpanel::createError('400','Missing Input','The Country cannot be blank.');
        else if (!isset($RunRateDetails['Role'])) return Staffpanel::createError('400','Missing Input','The Role cannot be blank.');
        else if (!isset($RunRateDetails['CostYear'])) return Staffpanel::createError('400','Missing Input','The CostYear cannot be blank.');
        else if (!isset($RunRateDetails['VolunteerCost'])) return Staffpanel::createError('400','Missing Input','The VolunteerCost cannot be blank.');
        else if (!isset($RunRateDetails['AdditionalCost'])) return Staffpanel::createError('400','Missing Input','The AdditionalCost cannot be blank.');
        else if (!isset($RunRateDetails['LowCost'])) return Staffpanel::createError('400','Missing Input','The LowCost cannot be blank.');
        else if (!isset($RunRateDetails['MediumCost'])) return Staffpanel::createError('400','Missing Input','The MediumCost cannot be blank.');
        else if (!isset($RunRateDetails['HighCost'])) return Staffpanel::createError('400','Missing Input','The HighCost cannot be blank.');
        $addRunRate = db::$con->prepare("INSERT INTO RunRate (Country, Role, CostYear, VolunteerCost, AdditionalCost, LowCost, MediumCost, HighCost) VALUES (?,?,?,?,?,?,?,?)");
        $addRunRate->bind_param("iissssss",$RunRateDetails['Country'],$RunRateDetails['Role'],$RunRateDetails['CostYear'],$RunRateDetails['VolunteerCost'],$RunRateDetails['AdditionalCost'],$RunRateDetails['LowCost'],$RunRateDetails['MediumCost'],$RunRateDetails['HighCost']);
        if ($addRunRate->execute()) {
            $addRunRate->close();
            return true;
        }else{
            $addRunRate->close();
            return Staffpanel::createError('408','System Error','An error occured with adding the RunRate.');
        }
    }
    public static function edit($RunRate_id,$RunRateDetails){
        if(empty($RunRate_id)){
            return Staffpanel::createError('400','Invalid RunRate ID','The RunRate id was invalid or not an id.');
        }
        if (!isset($RunRateDetails['Country'])) return Staffpanel::createError('400','Missing Input','The Country cannot be blank.');
        else if (!isset($RunRateDetails['Role'])) return Staffpanel::createError('400','Missing Input','The Role cannot be blank.');
        else if (!isset($RunRateDetails['CostYear'])) return Staffpanel::createError('400','Missing Input','The CostYear cannot be blank.');
        else if (!isset($RunRateDetails['VolunteerCost'])) return Staffpanel::createError('400','Missing Input','The VolunteerCost cannot be blank.');
        else if (!isset($RunRateDetails['AdditionalCost'])) return Staffpanel::createError('400','Missing Input','The AdditionalCost cannot be blank.');
        else if (!isset($RunRateDetails['LowCost'])) return Staffpanel::createError('400','Missing Input','The LowCost cannot be blank.');
        else if (!isset($RunRateDetails['MediumCost'])) return Staffpanel::createError('400','Missing Input','The MediumCost cannot be blank.');
        else if (!isset($RunRateDetails['HighCost'])) return Staffpanel::createError('400','Missing Input','The HighCost cannot be blank.');
        $editRunRate = db::$con->prepare("UPDATE RunRate SET Country = ?, Role = ?, CostYear = ?, VolunteerCost = ?, AdditionalCost = ?, LowCost = ?, MediumCost = ?, HighCost = ? WHERE RunRate_id = ?;");
        $editRunRate->bind_param('iissssssi',$RunRateDetails['Country'],$RunRateDetails['Role'],$RunRateDetails['CostYear'],$RunRateDetails['VolunteerCost'],$RunRateDetails['AdditionalCost'],$RunRateDetails['LowCost'],$RunRateDetails['MediumCost'],$RunRateDetails['HighCost'],$RunRate_id);
        if ($editRunRate->execute()) {
            $editRunRate->close();
            return true;
        }else{
            $editRunRate->close();
            return Staffpanel::createError('408','System Error','An error occured with editing the RunRate.');
        }
    }
    public static function del($RunRate_id){
        if(empty($RunRate_id)){
            return Staffpanel::createError('400','Invalid staff ID','The RunRate id was invalid or not an id.');
        }
        $delRunRate = db::$con->prepare("UPDATE RunRate SET Removed_By = ?, Removed_on = CURRENT_TIMESTAMP WHERE RunRate_id = ?;");
        $delRunRate->bind_param('ii', StaffMember::$me['staffID'], $RunRate_id);
        if ($delRunRate->execute()) {
            return true;
        } else {
            $delRunRate->close();
            return Staffpanel::createError('408','System Error','An error occured with failed to delete');
        }
    }
    public static function CreateRoles($RolesDetails){
        if (!isset($RolesDetails['type'])) return Staffpanel::createError('400','Missing Input','The type cannot be blank.');
        else if (!isset($RolesDetails['name'])) return Staffpanel::createError('400','Missing Input','The name cannot be blank.');
        else if (!isset($RolesDetails['departmentID'])) return Staffpanel::createError('400','Missing Input','The departmentID cannot be blank.');
        $addRunRate = db::$con->prepare("INSERT INTO miscRoles (type, name, departmentID) VALUES (?,?,?)");
        $addRunRate->bind_param("ssi",$RolesDetails['type'],$RolesDetails['name'],$RolesDetails['departmentID']);
        if ($addRunRate->execute()) {
            $addRunRate->close();
            return true;
        }else{
            $addRunRate->close();
            return Staffpanel::createError('408','System Error','An error occured with failed to delete');
        }
    }
    public static function Country(){
        $getCountry = db::$con->query("SELECT * FROM Country");
        while($Country = $getCountry->fetch_assoc()) {
            $CountryList[] = $Country;
        }
        return $CountryList;
    }
    public static function Roles(){
        $getmiscRoles = db::$con->query("SELECT * FROM miscRoles");
        while($miscRoles = $getmiscRoles->fetch_assoc()) {
            $miscRolesList[] = $miscRoles;
        }
        return $miscRolesList;
    }
    public static function Departments(){
        $getDepartments = db::$con->query("SELECT * FROM miscDepartments");
        while($Departments = $getDepartments->fetch_assoc()) {
            $DepartmentsList[] = $Departments;
        }
        return $DepartmentsList;
    }
    public static function RunRateList(){
        $getRunRate = db::$con->query("SELECT * FROM RunRate AS a LEFT JOIN Country AS b ON a.Country = b.Country_id LEFT JOIN miscRoles AS c ON a.Role = c.roleID where Removed_on is null");
        while($RunRate = $getRunRate->fetch_assoc()) {
            $RunRateList[] = $RunRate;
        }
        return $RunRateList;
    }
}
?>