<?php
namespace ETLAB;
$obj = new Api();
$urlParams = explode('/', $_SERVER['REQUEST_URI']);
$functionName = end($urlParams);
if(method_exists($obj, $functionName)){
    $obj->$functionName();
}else{
    echo json_encode(array('status'=>false,'message'=>'Invalid url.'));  
}

class Api {
    public function __construct()
    {
        include('../includes/config.php'); 
        include "../includes/functions.php";
        $this->mysqli_user=$mysqli_user;
        $this->current_time = date("Y-m-d H:i:s");
        $this->token_active_time = (30*60);
        if($_SERVER["REQUEST_METHOD"] != "POST")
        {
            // header("HTTP/1.0 404 Not Found");
	        // die;
        }
    }
    
    //Registered User
    public function registereduser() {
        $select_user_data = "SELECT fname as First_Name, lname as Last_Name, company as Company, email as Email_ID, mobile as Mobile, registration_time as Registration_Time, first_login_time AS First_Login_Time, last_login_time as Last_Login_Time , last_seen_time as Last_Seen_Time FROM user order by fname ASC";
        $rs_total = mysqli_query($this->mysqli_user,$select_user_data);
        $count    = mysqli_num_fields($rs_total);
        $sep = "\t"; //tabbed character
        while($finfo = mysqli_fetch_field($rs_total))
        {
            printf($finfo->name . $sep);
        }
        print("\n");
        // fetch data each row, store on tabular row data
        $data ='';
        while($row = mysqli_fetch_row($rs_total))
        {	
            $line = '';
            foreach($row as $value){
                if(!isset($value) || $value == ""){
                    $value = '"' . $value . '"' . "\t";
                }else{
                    $value = str_replace('"', '""', $value);
                    $value = '"' . $value . '"' . "\t";
                }
                $line .= $value;
            }
            $data .= trim($line)."\n";
            $data = str_replace("\r", "", $data);
        }
        $name="Registration_Details_".date('d-m-y').'-list.xls';
        header("Content-type:application/vnd.ms-excel;name='excel'");
        header("Content-Disposition: attachment; filename=$name");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Output data
        //echo $header."\n\n".$data;
        echo $data;
    }


    //Today's Login User
    public function loginuser() {
        $select_user_data = "SELECT fname as First_Name, lname as Last_Name, email as Email_ID, mobile as Mobile, registration_time as Registration_Time, first_login_time AS First_Login_Time, last_login_time as Last_Login_Time , last_seen_time as Last_Seen_Time FROM user WHERE first_login_time != '' ORDER BY last_seen_time ASC";
        $rs_total = mysqli_query($this->mysqli_user,$select_user_data);
        $count    = mysqli_num_fields($rs_total);
        $sep = "\t"; //tabbed character
        while($finfo = mysqli_fetch_field($rs_total))
        {
            printf($finfo->name . $sep);
        }
        print("\n");
        // fetch data each row, store on tabular row data
        $data ='';
        while($row = mysqli_fetch_row($rs_total))
        {
            $line = '';
            foreach($row as $value){
                if(!isset($value) || $value == ""){
                    $value = '"' . $value . '"' . "\t";
                }else{
                    $value = str_replace('"', '""', $value);
                    $value = '"' . $value . '"' . "\t";
                }
                $line .= $value;
            }
            $data .= trim($line)."\n";
            $data = str_replace("\r", "", $data);
        }
        $name="LoginDetails_".date('d-m-y').'-list.xls';
        header("Content-type:application/vnd.ms-excel;name='excel'");
        header("Content-Disposition: attachment; filename=$name");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Output data
        //echo $header."\n\n".$data;
        echo $data;    
    }

    //All Active User
    public function activeuser() {
        $timestamp    = strtotime($this->current_time);
        $time         = $timestamp - (5* 60); //5 Min
        $datetime     = date("Y-m-d H:i:s", $time);
        $select_user_data = "SELECT fname as First_Name, lname as Last_Name, email as Email_ID, mobile as Mobile, registration_time as Registration_Time, first_login_time AS First_Login_Time, last_login_time as Last_Login_Time , last_seen_time as Last_Seen_Time FROM user WHERE last_seen_time > '$datetime' ORDER BY last_seen_time ASC";
        $rs_total = mysqli_query($this->mysqli_user,$select_user_data);
        $count    = mysqli_num_fields($rs_total);
        $sep = "\t"; //tabbed character
        while($finfo = mysqli_fetch_field($rs_total))
        {
            printf($finfo->name . $sep);
        }
        print("\n");
        // fetch data each row, store on tabular row data
        $data ='';
        while($row = mysqli_fetch_row($rs_total))
        {
            $line = '';
            foreach($row as $value){
                if(!isset($value) || $value == ""){
                    $value = '"' . $value . '"' . "\t";
                }else{
                    $value = str_replace('"', '""', $value);
                    $value = '"' . $value . '"' . "\t";
                }
                $line .= $value;
            }
            $data .= trim($line)."\n";
            $data = str_replace("\r", "", $data);
        }
        $name="ActiveUserDetails_".date('d-m-y').'-list.xls';
        header("Content-type:application/vnd.ms-excel;name='excel'");
        header("Content-Disposition: attachment; filename=$name");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Output data
        //echo $header."\n\n".$data;
        echo $data;    
    }

}

