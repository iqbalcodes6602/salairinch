<?php
namespace ETLAB;
$obj = new Api();
$urlParams = explode('/', $_SERVER['REQUEST_URI']);
$functionName = end($urlParams);
$obj->$functionName();

class Api {
    public function __construct()
    {
        session_start();
        include('../../../ETWeb/includes/config.php'); 
        $this->mysqli_user=$mysqli_user;
        $this->current_time = date("Y-m-d H:i:s");

        $this->uid= isset($_SESSION['uid'])?$_SESSION['uid']:'';
        $this->type= isset($_SESSION['type'])?$_SESSION['type']:'';
    }
    
    public function getcontactuss() {
        $array=array();
        $data=array();
        $showdatalimit=(int) isset($_POST['showdatalimit'])?mysqli_real_escape_string($this->mysqli_user, $_POST['showdatalimit']):10;
        $currentpage=(int) isset($_POST['currentpage'])?mysqli_real_escape_string($this->mysqli_user, $_POST['currentpage']):1;
        $startfrom = ($currentpage - 1)*$showdatalimit;

        /* Filter */
        $filter=array();
        if(isset($_POST['name']) && $_POST['name']!=""){
            $name=mysqli_real_escape_string($this->mysqli_user, $_POST['name']);
            $filter[]=" name LIKE '%".$name."%'";
        }
        if(isset($_POST['email']) && $_POST['email']!=""){
            $email=mysqli_real_escape_string($this->mysqli_user, $_POST['email']);
            $filter[]=" email LIKE '%".$email."%'";
        }
        if(isset($_POST['mobile']) && $_POST['mobile']!=""){
            $mobile=mysqli_real_escape_string($this->mysqli_user, $_POST['mobile']);
            $filter[]=" mobile LIKE '%".$mobile."%'";
        }
        
        if(isset($_POST['status']) && $_POST['status']!=""){
            $status=mysqli_real_escape_string($this->mysqli_user, $_POST['status']);
            $filter[]=" status = '".$status."'";
        }

        $query="SELECT id as contactusid , name,  email, mobile, message, time From contactus ";
        $where=" order by  id desc LIMIT $startfrom, $showdatalimit";
        
        if(!empty($filter)){
            $where=" where ".implode(' and ',$filter) ."  order by  id desc LIMIT $startfrom, $showdatalimit";
        }
        //  print_r($query.$where);
        //  exit;
        $document=mysqli_query($this->mysqli_user, $query.$where);
        if(mysqli_num_rows($document)>0){	
            while($row=mysqli_fetch_assoc($document)){
                $array[]=$row;
            }
            $data=array('response'=>true,'contactus'=>$array,'totalrows'=> DBS::ExecuteScalar("SELECT COUNT(*) From contactus ".(!empty($filter)?' where '.implode(' and ',$filter):'').""));
        }else{
            $data=array('response'=>false,'message'=>"No data found.");
        }
        echo json_encode($data);
    }

    public function getcontactus() {
        $data=array();
        $key=(int) isset($_POST['key'])?mysqli_real_escape_string($this->mysqli_user, $_POST['key']):0;
        if(	$key>0){
            $contactus=DBS::ExecuteScalarRow("select id as contactusid , name,  email, mobile, message, status, time from contactus where id=? ", array($key));
            if($contactus){
                $data=array('response'=>true,'message'=>'success','contactus'=>$contactus);
            }else{
                $data=array('response'=>false,'message'=>"No data found.");
            }
        }else{
            $data=array('response'=>false,'message'=>"Invalid contactus ID.");
        }
        echo json_encode($data);
    }
    
    public function deletecontactus() {
        $contactusid=mysqli_real_escape_string($this->mysqli_user, $_POST['key']);
        $data=array();
        $contactus = DBS::ExecuteScalarRow("SELECT * FROM contactus where id=?" , array($contactusid));
        if($contactus){	
            $deletecontactus=DBS::Delete('contactus',array('id'=>$contactusid));
            if($deletecontactus){
               $data=array('response'=>true,"message"=>"Delete successfully.");
            }else{
                $data=array('response'=>false,"message"=>"queryfailed");
            }
        }else{
            $data=array('response'=>false,"message"=>"Invalid contactus");
        }
        echo json_encode($data);
    }  


    public function setcontactus() {
        $array=array(
            'name'=>isset($_POST['name'])?mysqli_real_escape_string($this->mysqli_user, $_POST['name']):'',
            'email'=>isset($_POST['email'])?mysqli_real_escape_string($this->mysqli_user, $_POST['email']):'',
            'mobile'=>isset($_POST['mobile'])?mysqli_real_escape_string($this->mysqli_user, $_POST['mobile']):'',
            'message'=>isset($_POST['message'])?mysqli_real_escape_string($this->mysqli_user, $_POST['message']):'',
            'status'=>isset($_POST['status'])?mysqli_real_escape_string($this->mysqli_user, $_POST['status']):0,
            'time'=>$this->current_time
        );

        if($array['name']=="" || $array['name']==null){
            $response=array('status'=>false,"message"=>"Please enter your name.");
        }else if($array['email']=="" || $array['email']==null){
            $response=array('status'=>false,"message"=>"Please enter your email.");
        }else if(!filter_var($array['email'], FILTER_VALIDATE_EMAIL)){
            $response=array('status'=>false,"message"=>"Please enter correct email id.");
        }else if ($array['mobile'] == '' || $array['mobile'] == null){
            $response=array('status'=>false,"message"=>"Please enter your mobile.");
        }else if ($array['message'] == '' || $array['message'] == null){
            $response=array('status'=>false,"message"=>"Please enter message");
        }else if (strlen($array['mobile'])!=10 ){
            $response=array('status'=>false,"message"=>"Please enter correct mobile no.");
        }else{
            $checkmobile=DBS::ExecuteScalar("select * from contactus where mobile=?",array($array['mobile']));
            if(!$checkmobile){
                $insertcontactus=DBS::Insert('contactus',$array);
                if($insertcontactus){
                    $response=array('response'=>true,"message"=>"Added Successfully.");
                }else{
                    $response=array('response'=>false,"message"=>"Unable to add this moment. Please try again.");
                }
            }else{
                $response=array('response'=>false,"message"=>"Mobile already exist."); 
            }
        }
        echo json_encode($response);
    }  


    public function setcontactusupdate() {
        $data=array();
        $contactusid=mysqli_real_escape_string($this->mysqli_user, $_POST['contactusid']);
        $name=mysqli_real_escape_string($this->mysqli_user, $_POST['name']);
        $email=mysqli_real_escape_string($this->mysqli_user, $_POST['email']);
        $message=mysqli_real_escape_string($this->mysqli_user, $_POST['message']);
        $status=mysqli_real_escape_string($this->mysqli_user, $_POST['status']); 
        $result = mysqli_query($this->mysqli_user, "SELECT * FROM contactus where id='$contactusid'");
        if(mysqli_num_rows($result)> 0){	
            $updatearray=array(
                'name'=>$name,
                'email'=>$email,
                'message'=>$message,
                'status'=>$status,
            );
            $updatearray=DBS::Update('contactus',$updatearray,array('id'=>$contactusid));         
            if($updatearray){
                $data=array('response'=>true,"message"=>"contactus Update Successfully");
            }else{
                $data=array('response'=>false,"message"=>"queryfailed");
            }
        }else{
            $data=array('response'=>false,"message"=>"Invalid contactus");
        }
        echo json_encode($data);
    }  
}

