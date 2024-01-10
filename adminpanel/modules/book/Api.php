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
    
    public function getbooks() {
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

        $query="SELECT id as bookid , name,  email, mobile, subject, time From book ";
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
            $data=array('response'=>true,'book'=>$array,'totalrows'=> DBS::ExecuteScalar("SELECT COUNT(*) From book ".(!empty($filter)?' and '.implode(' and ',$filter):'').""));
        }else{
            $data=array('response'=>false,'message'=>"No data found.");
        }
        echo json_encode($data);
    }

    public function getbook() {
        $data=array();
        $key=(int) isset($_POST['key'])?mysqli_real_escape_string($this->mysqli_user, $_POST['key']):0;
        if(	$key>0){
            $book=DBS::ExecuteScalarRow("select id as bookid , name,  email, mobile, subject, status, time from book where id=? ", array($key));
            if($book){
                $data=array('response'=>true,'message'=>'success','book'=>$book);
            }else{
                $data=array('response'=>false,'message'=>"No data found.");
            }
        }else{
            $data=array('response'=>false,'message'=>"Invalid book ID.");
        }
        echo json_encode($data);
    }
    
    public function deletebook() {
        $bookid=mysqli_real_escape_string($this->mysqli_user, $_POST['key']);
        $data=array();
        $book = DBS::ExecuteScalarRow("SELECT * FROM book where id=?" , array($bookid));
        if($book){	
            $deletebook=DBS::Delete('book',array('id'=>$bookid));
            if($deletebook){
               $data=array('response'=>true,"message"=>"Delete successfully.");
            }else{
                $data=array('response'=>false,"message"=>"queryfailed");
            }
        }else{
            $data=array('response'=>false,"message"=>"Invalid book");
        }
        echo json_encode($data);
    }  


    public function setbook() {
        $array=array(
            'name'=>isset($_POST['name'])?mysqli_real_escape_string($this->mysqli_user, $_POST['name']):'',
            'email'=>isset($_POST['email'])?mysqli_real_escape_string($this->mysqli_user, $_POST['email']):'',
            'mobile'=>isset($_POST['mobile'])?mysqli_real_escape_string($this->mysqli_user, $_POST['mobile']):'',
            'subject'=>isset($_POST['subject'])?mysqli_real_escape_string($this->mysqli_user, $_POST['subject']):'',
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
        }else if ($array['subject'] == '' || $array['subject'] == null){
            $response=array('status'=>false,"message"=>"Please enter subject");
        }else if (strlen($array['mobile'])!=10 ){
            $response=array('status'=>false,"message"=>"Please enter correct mobile no.");
        }else{
            $checkmobile=DBS::ExecuteScalar("select * from book where mobile=?",array($array['mobile']));
            if(!$checkmobile){
                $insertbook=DBS::Insert('book',$array);
                if($insertbook){
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


    public function setbookupdate() {
        $data=array();
        $bookid=mysqli_real_escape_string($this->mysqli_user, $_POST['bookid']);
        $name=mysqli_real_escape_string($this->mysqli_user, $_POST['name']);
        $email=mysqli_real_escape_string($this->mysqli_user, $_POST['email']);
        $subject=mysqli_real_escape_string($this->mysqli_user, $_POST['subject']);
        $status=mysqli_real_escape_string($this->mysqli_user, $_POST['status']); 
        $result = mysqli_query($this->mysqli_user, "SELECT * FROM book where id='$bookid'");
        if(mysqli_num_rows($result)> 0){	
            $updatearray=array(
                'name'=>$name,
                'email'=>$email,
                'subject'=>$subject,
                'status'=>$status,
            );
            $updatearray=DBS::Update('book',$updatearray,array('id'=>$bookid));         
            if($updatearray){
                $data=array('response'=>true,"message"=>"book Update Successfully");
            }else{
                $data=array('response'=>false,"message"=>"queryfailed");
            }
        }else{
            $data=array('response'=>false,"message"=>"Invalid book");
        }
        echo json_encode($data);
    }  
}

