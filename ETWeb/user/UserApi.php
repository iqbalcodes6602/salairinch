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
        include('../includes/Cdn.php');
        $this->mysqli_user=$mysqli_user;
        $this->current_time = date("Y-m-d H:i:s");
        $this->token_active_time = (30*60);

        $this->cdn_url="";
        if($GLOBALS['AppConfig']['IsCdn']){
            $this->cdn_url=$GLOBALS['AppConfig']['CdnUploadURL'];
        }else{
            $this->cdn_url=$GLOBALS['AppConfig']['ServerUploadURL'];
            
        }

        if($_SERVER["REQUEST_METHOD"] != "POST")
        {
            header("HTTP/1.0 404 Not Found");
	        die;
        }
    }

    public function __destruct() {
        $this->mysqli_user->close();
    }
    

    public function getopt() {
        $sql = "SELECT id, fname, mobile, email, opt FROM user where otp=1 order by id desc limit 1";
        $result = mysqli_query($this->mysqli_user, $sql);
        $data=array();
        // $optArray=array();
        if(mysqli_num_rows($result)>0)
        {
            $row = mysqli_fetch_assoc($result);
            // while($row = mysqli_fetch_assoc($result)){
            // 	$optArray[]=$row;
            // }
            $data=array('status'=>true, 'message'=>"Data Found", 'user'=>$row);
        }else{
            $data=array('status'=>false, 'message'=>"No Data Found");
        }
        echo json_encode($data);
    }

    public function setopt() {
        $updateArray=array();
        $uid = isset($_POST['uid'])?mysqli_real_escape_string($this->mysqli_user, $_POST['uid']):'';
        if ($uid == '' || $uid == null) {
            $response=array('status'=>false,"message"=>"uid required.");
        }else{
            mysqli_real_escape_string($this->mysqli_user,trim(isset($_POST['opt']))) ? $updateArray['opt']=(int)mysqli_real_escape_string($this->mysqli_user,trim($_POST['opt'])) :'';
           
            $updateScene=DB::Update('user',$updateArray,array('id'=>$uid));	
            if($updateScene){	
                $response=array('status'=>true,"message"=>"Update successfully.");
            }else{
                $response=array('status'=>false,"message"=>"Unable to update at this moment.");
            }
        }
        echo json_encode($response);
    }

    public function setspanpshot() {
        $uid = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['uid']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['uid'])) : '';
        if ($uid == '' || $uid == null) {
            $response=array('status'=>false,"message"=>"Please enter uid.");
        }else{ 
            $user=mysqli_query($this->mysqli_user,"select * from user where id=".$uid);
            if(mysqli_num_rows($user)>0){
                $user_data=mysqli_fetch_assoc($user);

                $image = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['image']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['image'])) : '';
                if(isset($_FILES["image"]["size"]) && $_FILES["image"]["size"]>0)
                {
                    $image="image_".date('Y_m_d_H_i_s').'_'.rand(1000,9999);
                    $sourcePath = $_FILES['image']['tmp_name'];
                    $extension = explode("/", $_FILES["image"]["type"]);
                    $targetPath = "uploads/".$image.".".$extension[1]; // Target path where file is to be stored
                    $dbPath = "uploads/".$image.".".$extension[1];
                    if(move_uploaded_file($sourcePath,$targetPath)){
                        $image=$dbPath;
                        /*Delete Image */
                        // if($user['image']!=""){
                        //     if(file_exists($user['image'])){
                        //         unlink($user['image']);
                        //     }
                        // }
                    }else{
                        $response=array('status'=>false,"message"=>"Unable to upload at this moment.");
                    }
                }else if($image!="") {
                    $folderPath = "uploads/";
                    $image_parts = explode(";base64,", $image);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName =  "image_".date('Y_m_d_H_i_s').'_'.rand(1000,9999).'.jpg';
                    $image = $folderPath . $fileName;
                    file_put_contents($image, $image_base64);
                }
                


                /*Inset Data */
                $updateUser= mysqli_query($this->mysqli_user, "UPDATE user set `image`= '$image' where id='$uid'");  //DBS::Insert("user",$insertArray);	
                if($updateUser){

                    $user_data=array();
                    $user=mysqli_query($this->mysqli_user,"select * from user where id=".$uid);
                    if(mysqli_num_rows($user)>0){
                        $user_data=mysqli_fetch_assoc($user);
                    }

                    $response=array('status'=>true,"message"=>"Update successfully.","user"=>$user_data);
                }else{
                    $response=array('status'=>false,"message"=>"Unable to acess at this moment. Please try again2.");
                }

            }else{
                $response=array('status'=>false,"message"=>"User Not Found.");
            }
        }
        echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    //Upload file
    public function uploadfile(){
        // $uid = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['uid']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['uid'])) : '';
        $loginid = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['loginid']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['loginid'])) : '';
        if ($loginid == '' || $loginid == null) {
            $response=array('status'=>false,"message"=>"Please enter your name.");
        }else{ 

            $user_joinactivity=mysqli_query($this->mysqli_user,"select * from user_joinactivity where id=".$loginid);
            if(mysqli_num_rows($user_joinactivity)>0){
                $user_joinactivity_data=mysqli_fetch_assoc($user_joinactivity);

                $uid=$user_joinactivity_data['uid'];

                $user = DBS::ExecuteScalarRow("SELECT * FROM user WHERE id = ?",array($uid));
                if($user){
                    $file = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['file']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['file'])) : '';
                    if(isset($_FILES["file"]["size"]) && $_FILES["file"]["size"]>0)
                    {
                        if($GLOBALS['AppConfig']['IsCdn']){
                            $x=CdnUpload($_FILES, "file", $GLOBALS['AppConfig']['CdnUploadDir']."uploads/","uploads/");  //Cdn Includes Function
                            if($x){
                                $file=$x['dbPath'];
                            }
                        }else{
                            $fileName="file_".date('Y_m_d_H_i_s').'_'.rand(1000,9999);
                            $sourcePath = $_FILES['file']['tmp_name'];
                            $extension = explode("/", $_FILES["file"]["type"]);
                            $targetPath = "uploads/".$fileName.".".$extension[1]; // Target path where file is to be stored
                            $dbPath = "uploads/".$fileName.".".$extension[1];
                            if(move_uploaded_file($sourcePath,$targetPath)){
                                $file=$dbPath;
                                /*Delete file */
                                // if($user['file']!=""){
                                //     if(file_exists($user['file'])){
                                //         unlink($user['file']);
                                //     }
                                // }
                            }
                        }
                    }else if($file!="") {
                        $folderPath = "uploads/";
                        $file_parts = explode(";base64,", $file);
                        $file_type_aux = explode("file/", $file_parts[0]);
                        $file_base64 = base64_decode($file_parts[1]);
                        $fileName =  "file_".date('Y_m_d_H_i_s').'_'.rand(1000,9999).'.jpg';
                        $file = $folderPath . $fileName;
                        file_put_contents($file, $file_base64);
                    }

                    /*Inset Data */
                    $insertfile= mysqli_query($this->mysqli_user, "INSERT INTO `files` (`uid`,  `file`) VALUES ('$uid','$file')");  //DBS::Insert("user",$insertArray);	
                    if($insertfile){
                        
                        $this->sendGifOnMail($user['fname'],$user['email'],$this->cdn_url.$file,$user_joinactivity_data['activityname']);
                        

                        $filesDataArr=array();
                        $files=mysqli_query($this->mysqli_user,"select IF(file!='' , CONCAT('$this->cdn_url',file) , file)  as file from files where uid='$uid' order by id desc");
                        if(mysqli_num_rows($files)>0){
                            while($filesData=mysqli_fetch_assoc($files)){
                                $filesDataArr[]=$filesData;
                            }
                        }
                        $response=array('status'=>true,"message"=>"Upload successfully.","url"=>$this->cdn_url.$file,'files'=>$filesDataArr);
                    }else{
                        $response=array('status'=>false,"message"=>"Unable to acess at this moment. Please try again2.");
                    }
                    
                }else{
                    $response=array('status'=>false,"message"=>"User not found.");
                }
            }else{
                $response=array('status'=>false,"message"=>"Invalid login id.");
            }
        }
        echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function sendGifOnMail($fname,$email,$link,$activity){
        if($fname==""){
            $fname="user";
        }
        $body='<table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td style="font-family: Cambria, Hoefler Text, Liberation Serif, Times, Times New Roman, serif; font-size: 14px; color:#000; line-height: 22px;"  >
                            Dear '.$fname.',<br><br>
                            Thank you for participation. PFA the output of the activity.<br>
                            '.$link.'<br><br><br><br>
                            Regards,<br>
                            Mini | Big Love Days
                        </td>
                    </tr>
                </table>';
        Mails::DoEmail($fname, $email , $activity ,$body);
    }
}

