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
    
    public function getsettings() {
        $array=array();
        $data=array();
        $showdatalimit=(int) isset($_POST['showdatalimit'])?mysqli_real_escape_string($this->mysqli_user, $_POST['showdatalimit']):10;
        $currentpage=(int) isset($_POST['currentpage'])?mysqli_real_escape_string($this->mysqli_user, $_POST['currentpage']):1;
        $startfrom = ($currentpage - 1)*$showdatalimit;

        /* Filter */
        $filter=array();
        if(isset($_POST['slug']) && $_POST['slug']!=""){
            $slug=mysqli_real_escape_string($this->mysqli_user, $_POST['slug']);
            $filter[]=" slug LIKE '%".$slug."%'";
        }
        if(isset($_POST['value']) && $_POST['value']!=""){
            $value=mysqli_real_escape_string($this->mysqli_user, $_POST['value']);
            $filter[]=" value LIKE '%".$value."%'";
        }
        
        if(isset($_POST['status']) && $_POST['status']!=""){
            $status=mysqli_real_escape_string($this->mysqli_user, $_POST['status']);
            $filter[]=" status = '".$status."'";
        }

        $query="SELECT id as settingid , slug,  value,status, time From setting ";
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
            $data=array('response'=>true,'setting'=>$array,'totalrows'=> DBS::ExecuteScalar("SELECT * From setting ".(!empty($filter)?' where '.implode(' and ',$filter):'').""));
        }else{
            $data=array('response'=>false,'message'=>"No data found.");
        }
        echo json_encode($data);
    }

    public function getsetting() {
        $data=array();
        $key=(int) isset($_POST['key'])?mysqli_real_escape_string($this->mysqli_user, $_POST['key']):0;
        if(	$key>0){
            $setting=DBS::ExecuteScalarRow("select id as settingid , slug, value ,status, time from setting where id=? ", array($key));
            if($setting){
                $data=array('response'=>true,'message'=>'success','setting'=>$setting);
            }else{
                $data=array('response'=>false,'message'=>"No data found.");
            }
        }else{
            $data=array('response'=>false,'message'=>"Invalid setting ID.");
        }
        echo json_encode($data);
    }
    
    public function deletesetting() {
        $settingid=mysqli_real_escape_string($this->mysqli_user, $_POST['key']);
        $data=array();
        $setting = DBS::ExecuteScalarRow("SELECT * FROM setting where id=?" , array($settingid));
        if($setting){	
            $deletesetting=DBS::Delete('setting',array('id'=>$settingid));
            if($deletesetting){
               $data=array('response'=>true,"message"=>"Delete successfully.");
            }else{
                $data=array('response'=>false,"message"=>"queryfailed");
            }
        }else{
            $data=array('response'=>false,"message"=>"Invalid setting");
        }
        echo json_encode($data);
    }  


    public function setsetting() {
        $array=array(
            'slug'=>isset($_POST['slug'])?mysqli_real_escape_string($this->mysqli_user, $_POST['slug']):'',
            'value'=>isset($_POST['value'])?mysqli_real_escape_string($this->mysqli_user, $_POST['value']):'',
            'status'=>isset($_POST['status'])?mysqli_real_escape_string($this->mysqli_user, $_POST['status']):0,
            'time'=>$this->current_time
        );

        if($array['slug']=="" || $array['slug']==null){
            $response=array('status'=>false,"message"=>"Please enter your slug.");
        }else if($array['value']=="" || $array['value']==null){
            $response=array('status'=>false,"message"=>"Please enter your value.");
        }else{
            $insertsetting=DBS::Insert('setting',$array);
            if($insertsetting){
                $response=array('response'=>true,"message"=>"Added Successfully.");
            }else{
                $response=array('response'=>false,"message"=>"Unable to add this moment. Please try again.");
            }
        }
        echo json_encode($response);
    }  


    public function setsettingupdate() {
        $data=array();
        $settingid=mysqli_real_escape_string($this->mysqli_user, $_POST['settingid']);
        $slug=mysqli_real_escape_string($this->mysqli_user, $_POST['slug']);
        $value=mysqli_real_escape_string($this->mysqli_user, $_POST['value']);
        $status=mysqli_real_escape_string($this->mysqli_user, $_POST['status']); 
        $result = mysqli_query($this->mysqli_user, "SELECT * FROM setting where id='$settingid'");
        if(mysqli_num_rows($result)> 0){	
            $updatearray=array(
                'slug'=>$slug,
                'value'=>$value,
                'status'=>$status,
            );
            $updatearray=DBS::Update('setting',$updatearray,array('id'=>$settingid));         
            if($updatearray){
                $data=array('response'=>true,"message"=>"setting Update Successfully");
            }else{
                $data=array('response'=>false,"message"=>"queryfailed");
            }
        }else{
            $data=array('response'=>false,"message"=>"Invalid setting");
        }
        echo json_encode($data);
    }  
}

