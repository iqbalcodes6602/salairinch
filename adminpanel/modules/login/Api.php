<?php

namespace ETLAB;
$obj = new Api();
$urlParams = explode('/', $_SERVER['REQUEST_URI']);
$functionName = end($urlParams);
$obj->$functionName();
class Api {
    public function __construct()
    {
        include('../../../ETWeb/includes/config.php'); 
        $this->mysqli_user=$mysqli_user;
    }

    public function __destruct()
    {
        mysqli_close($this->mysqli_user);
    }
    
    public function login() {
        
        $data=array();
        $email=mysqli_real_escape_string($this->mysqli_user,$_POST['email']);
        $password=mysqli_real_escape_string($this->mysqli_user,$_POST['password']);
        $user=mysqli_query($this->mysqli_user,"SELECT * FROM `admin` where email='$email' and `password`='$password' ");
        if(mysqli_num_rows($user)>0){
            $userdetails=mysqli_fetch_array($user);
            session_start();
            $_SESSION['type']='admin';
            $data['response']=true;
            $data['message']="Login Successfully";
            $data['data']=$userdetails;

            // $userdetails=mysqli_fetch_array($user);
            // if($userdetails['type']=="admin" || $userdetails['type']=="supervisor" ){
            //     session_start();
            //     $_SESSION['type']=$userdetails['type'];
            //     $_SESSION['uid']=$userdetails['id'];
            //     $data['response']=true;
            //     $data['message']="Login Successfully";
            //     $data['data']=$userdetails;
            // }else{
            //     $data['response']=false;
            //     $data['message']="Your don't have access to open panel.";
            // }

        }else{
            $data['response']=false;
            $data['message']="Login Failed";
        }
        echo json_encode($data);
    }   

    public function logout(){
        session_start();
        unset($_SESSION);
        session_destroy();
        header("Location: ../../../index.php");
    }
}

