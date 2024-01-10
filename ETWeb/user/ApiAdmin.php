<?php
namespace ETLAB;
$obj = new ApiAdmin();
$urlParams = explode('/', $_SERVER['REQUEST_URI']);
$functionName = end($urlParams);
if(method_exists($obj, $functionName)){
    $obj->$functionName();
}else{
    echo json_encode(array('status'=>false,'message'=>'Invalid url.'));  
}

class ApiAdmin {
    public function __construct()
    {
        include('../includes/config.php'); 
        include "../includes/functions.php";
        $this->mysqli_user=$mysqli_user;
        $this->current_time = date("Y-m-d H:i:s");
        if($_SERVER["REQUEST_METHOD"] != "POST")
        {
            header("HTTP/1.0 404 Not Found");
	        die;
        }
    }

    public function __destruct() {
        $this->mysqli_user->close();
    }
    
    /*********************************************Admin*************************************/ 

    //user Admin Register
    public function userRegisterFromAdmin(){
        $fname		= mysqli_real_escape_string($this->mysqli_user,trim(isset($_POST['fname']))) ? mysqli_real_escape_string($this->mysqli_user,trim($_POST['fname'])) :'';
        $email   = mysqli_real_escape_string($this->mysqli_user,trim(isset($_POST['email']))) ? mysqli_real_escape_string($this->mysqli_user,trim($_POST['email'])) :'';
        $mobile   = mysqli_real_escape_string($this->mysqli_user,trim(isset($_POST['mobile']))) ? mysqli_real_escape_string($this->mysqli_user,trim($_POST['mobile'])) :'';
        // $password   = generatePassword(10);
        $password   = "password@123";
        
        if($fname == '' || $fname == null){
            $response=array('status'=>false,"message"=>"Please enter your first name.");
        }elseif (!preg_match ('/^[\p{L} ]+$/u', $fname) ){
            $response=array('status'=>false,"message"=>"Please enter valid name.");
        }
        elseif($email == '' || $email == null){
            $response=array('status'=>false,"message"=>"Please enter your business email.");
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response=array('status'=>false,"message"=>"Please enter valid email.");
        }
        elseif($mobile == '' || $mobile == null){
            $response=array('status'=>false,"message"=>"Please enter your business mobile.");
        }elseif (strlen($mobile)!=10) {
            $response=array('status'=>false,"message"=>"Please enter valid mobile.");
        }
        elseif($password == '' || $password == null){
            $response=array('status'=>false,"message"=>"Please enter your password.");
        }else{

            $isEmailExist=DB::ExecuteScalarRow("select * from user where mobile='$mobile'");
            if($isEmailExist){
                $response=array('status'=>false,"message"=>"This mobile id is already registered with us.");
            }else{
                $userInsert=DB::Insert('user',array('fname'=>$fname,'lname'=>'','email'=>$email,'mobile'=>$mobile,'password'=>$password,'registration_time'=>$this->current_time));
                if($userInsert){
                    $response['status']  = true;
                    $response['message'] = "Registration successfully done";
                    $response['data']    = array();
                    //$objMail->processUserRegistrationMail($fname, $email, $pass);
                }else{
                    $response=array('status'=>false,"message"=>"Unable to register user at this moment.");
                }
            }    
        }
        echo json_encode($response);
    }


    //GetAllRegisteredUser
    public function getAllRegisteredUser(){
        $user=DB::Execute("SELECT id,fname,lname,email,mobile,registration_time, `status` FROM user order by fname asc");
        if($user){
            $response=array('status'=>true,"message"=>"Success",'data'=>$user);
        }else{
            $response=array('status'=>false,"message"=>"No Registered User found.");
        }
        echo json_encode($response);
    }

    //Delete All User
    public function deleteAllUser(){
        $deleteUser=DB::ExecuteOnly("TRUNCATE TABLE user");
        if($deleteUser){
            DB::ExecuteOnly("TRUNCATE TABLE login_token");
            $response=array('status'=>true,"message"=>"All User deleted successfully.");
        }else{
            $response=array('status'=>false,"message"=>"Unable to delete users at this moment.");
        }
        echo json_encode($response);
    }

    //Delete Signle User
    public function deleteSingleUser(){
        $uid     =  mysqli_real_escape_string($this->mysqli_user,trim(isset($_POST['uid']))) ? mysqli_real_escape_string($this->mysqli_user,trim($_POST['uid'])) :'';	
        if($uid == '' || $uid == null){
            $response=array('status'=>false,"message"=>"UID is required.");
        }else{
            $isUserExist = isUserExist($uid); 
            if($isUserExist){
                $deleteUser=DB::ExecuteOnly("DELETE FROM `user` where id='$uid'");
                if($deleteUser){
                    DB::ExecuteOnly("DELETE FROM login_token where uid='$uid'");
                    $response=array('status'=>true,"message"=>"User deleted successfully.");
                }else{
                    $response=array('status'=>false,"message"=>"Unable to delete user at this moment.");
                }
            }else{
                $response=array('status'=>false,"message"=>"User not registered.");
            }
        }
        echo json_encode($response);
    }

    //Block User
    public function blockUser(){
        $uid     =  mysqli_real_escape_string($this->mysqli_user,trim(isset($_POST['uid']))) ? mysqli_real_escape_string($this->mysqli_user,trim($_POST['uid'])) :'';
        if($uid == '' || $uid == null){
            $response=array('status'=>false,"message"=>"UID is required.");
        }else{
            //User Check
            $isUserExist = isUserExist($uid); 
            if($isUserExist){
                $isUserBlock = isUserBlock($uid);
                if(!$isUserBlock){
                    $update_qry_rs=DB::Update('user',array('status'=>0),array('id'=>$uid));	
                    if($update_qry_rs){	
                        $response=array('status'=>true,"message"=>"Email ID is blocked successfully.");
                    }else{
                        $response=array('status'=>false,"message"=>"Unable to block user at this moment.");
                    }
                }else{
                    $update_qry_rs=DB::Update('user',array('status'=>1),array('id'=>$uid));	
                    if($update_qry_rs){	
                        $response=array('status'=>true,"message"=>"Email ID is unblocked successfully.");
                    }else{
                        $response=array('status'=>false,"message"=>"Unable to unblock user at this moment.");
                    }
                }
            }else{
                $response=array('status'=>false,"message"=>"User not registered.");
            }
        }
        echo json_encode($response);
    }




    //GetAllLoginUser
    public function getAllLoginUser(){
        $lastuid = 0;
        $select_user_data = "SELECT u.id as uid, u.fname as fname, u.lname as lname, u.email as email, u.mobile, u.first_login_time, u.last_login_time, u.last_seen_time from user as u where first_login_time!='' ORDER BY u.fname ASC";
        $select_user_data_rs = mysqli_query($this->mysqli_user,$select_user_data);
        if($select_user_data_rs)
        {
            if(mysqli_num_rows($select_user_data_rs) > 0)
            {
                while($row  = mysqli_fetch_assoc($select_user_data_rs))
                { 
                    if($lastuid != $row['uid']){
                        $lastuid = $row['uid'];
                        $user_data[] = array(	'uid'=>$row['uid'], 
                                        'fname'=>$row['fname'],
                                        'lname'=>$row['lname'],
                                        'email'=>$row['email'],
                                        'mobile'=>$row['mobile'],
                                        'first_login_time'=>$row['first_login_time'],
                                        'last_login_time'=>$row['last_login_time'],
                                        'last_seen_time'=>$row['last_seen_time']);
                    }
                }
                $response['status']  = true;
                $response['message'] = "Success";
                $response['data']    = $user_data; 
            }
            else
            {
                $response['status']  = false;
                $response['message'] = "No one is login.";
                $response['data']    = array(); 
            }
        }
        else
        {
            $response['status']  = false;
            $response['message'] = "Oops! Sonmething Goes Wrong.Try After Sometime";
            $response['data']    = array(); 
        }
        echo json_encode($response);
    }

    //Logout All User
    // public function logoutAllUser(){
    //     $update_qry = "UPDATE `user` SET `is_active`=0,`last_login_time`='0000-00-00 00:00:00'";
    //     $update_qry_rs = mysqli_query($this->mysqli_user,$update_qry);
        
    //     if($update_qry_rs)
    //     {	
    //         $delete_qry = "TRUNCATE TABLE user_login_details";
    //         $delete_qry_rs = mysqli_query($this->mysqli_user,$delete_qry);	
    //         if($delete_qry_rs)
    //         {	
    //             $response['status'] = true;
    //             $response['message']="All User logout successfully.";
    //             $response['data'] 	= array();
    //         }
    //         else
    //         {
    //             $response['status'] = false;
    //             $response['message']="ERROR : 0101";
    //             $response['data'] 	= array();
    //         }
    //     }
    //     else
    //     {
    //         $response['status'] = false;
    //         $response['message']="ERROR : 0101";
    //         $response['data'] 	= array();
    //     }
    //     echo json_encode($response);
    // }

    public function logoutAllUser(){
        $update_qry = "UPDATE `user` SET `last_seen_time`='0000-00-00 00:00:00'";
        $update_qry_rs = mysqli_query($this->mysqli_user,$update_qry);

        if($update_qry_rs){	
            $update_qry_rs = mysqli_query($this->mysqli_user,"UPDATE `login_token` SET `status`=0");
            if($update_qry_rs){	
                $response=array('status'=>true,"message"=>"All User logout successfully.");
            }else{
                $response=array('status'=>false,"message"=>"Unable to logout at this moment.");
            }
        }else{
            $response=array('status'=>false,"message"=>"Unable to logout users at this moment.");
        }
        echo json_encode($response);
    }

    

    //GetAllActiveUser
    public function getAllActiveUser(){
        $timestamp    = strtotime($this->current_time);
        $time         = $timestamp - (5* 60);
        $datetime     = date("Y-m-d H:i:s", $time);
        $lastuid =0;
        $select_user_data_rs = mysqli_query($this->mysqli_user,"SELECT u.id as uid, u.fname as fname, u.lname as lname, u.mobile, u.email as email, u.first_login_time, u.last_login_time, u.last_seen_time from user as u WHERE u.last_seen_time > '$datetime' ORDER BY u.last_seen_time ASC");
        if(mysqli_num_rows($select_user_data_rs) > 0){
            while($row  = mysqli_fetch_assoc($select_user_data_rs))
            { 
                if($lastuid != $row['uid']){
                    $lastuid = $row['uid'];
                    $user_data[] = $row;
                }
            }
            $response['status']  = true;
            $response['message'] = "Success";
            $response['data']    = $user_data; 
        }else{
            $response['status']  = false;
            $response['message'] = "No one is login.";
            $response['data']    = array(); 
        }
        echo json_encode($response);
    }


    
}

