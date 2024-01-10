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
        include('../../api/db.php'); 
        $this->conn=$conn;
        $this->current_time = date("Y-m-d H:i:s");
        $this->current_date = date("Y-m-d");

        $this->uid= isset($_SESSION['uid'])?$_SESSION['uid']:'';
        $this->type= isset($_SESSION['type'])?$_SESSION['type']:'';
    }
    
    public function getanalatics() {

        if($this->type=="supervisor"){
            $data=array('response'=>true,
                            'totaluser'=> DB::ExecuteScalar("SELECT COUNT(*) From site_users where createdby='$this->uid' "),
                            'newuser'=> DB::ExecuteScalar("SELECT COUNT(*) From site_users where date(created_at) = CURDATE() and createdby='$this->uid'"),
                            'totalordertoday'=> DB::ExecuteScalar("SELECT sum(orderamount) as total FROM `orders` as o left join site_users as u on o.uid=u.id WHERE date(o.insert_time) = '$this->current_date' and o.type = 'BIDPLACE' and u.createdby='$this->uid' "),
                            'totalwintoday'=> DB::ExecuteScalar("SELECT sum(orderamount) as total FROM `orders` as o left join site_users as u on o.uid=u.id WHERE date(o.insert_time) = '$this->current_date' and o.type = 'WINBIDPOINT' and u.createdby='$this->uid'"),
                        );
        }else{
            $data=array('response'=>true,
                            'totaluser'=> DB::ExecuteScalar("SELECT COUNT(*) From site_users"),
                            'newuser'=> DB::ExecuteScalar("SELECT COUNT(*) From site_users where date(created_at) = CURDATE()"),
                            'totalordertoday'=> DB::ExecuteScalar("SELECT sum(orderamount) as total FROM `orders` WHERE date(insert_time) = '$this->current_date' and type = 'BIDPLACE'"),
                            'totalwintoday'=> DB::ExecuteScalar("SELECT sum(orderamount) as total FROM `orders` WHERE date(insert_time) = '$this->current_date' and type = 'WINBIDPOINT'"),
                            
                            // 'totalfriendrequest'=> DB::ExecuteScalar("SELECT COUNT(*) From chat where msg ='Friend request'"),
                            // 'todayfriendrequest'=> DB::ExecuteScalar("SELECT COUNT(*) From chat where msg ='Friend request' and date(timestamp) = CURDATE()"),
                            // 'connections'=> DB::ExecuteScalar("SELECT COUNT(*) From chat where msg ='Acknowledgement'"),
                            // 'todayconnections'=> DB::ExecuteScalar("SELECT COUNT(*) From chat where msg ='Acknowledgement' and date(timestamp) = CURDATE()"),
                            // 'totalfeedback'=> DB::ExecuteScalar("SELECT COUNT(*) From user_feedback"),
                            // 'todayfeedback'=> DB::ExecuteScalar("SELECT COUNT(*) From user_feedback where date(timestamp) = CURDATE()"),
                            // 'totalqna'=> DB::ExecuteScalar("SELECT COUNT(*) From user_qna"),
                            // 'todayqna'=> DB::ExecuteScalar("SELECT COUNT(*) From user_qna where date(time) = CURDATE()"),
                            
                            // 'totalpersonalmeet'=> DB::ExecuteScalar("SELECT COUNT(*) From meeting where type='Personal'"),
                            // 'todaypersonalmeet'=> DB::ExecuteScalar("SELECT COUNT(*) From meeting where type='Personal' and date(timestamp) = CURDATE()"),
                            // 'totalcoffeemeet'=> DB::ExecuteScalar("SELECT COUNT(*) From meeting where type='NetworkingCoffee'"),
                            // 'todaycoffeemeet'=> DB::ExecuteScalar("SELECT COUNT(*) From meeting where type='NetworkingCoffee' and date(timestamp) = CURDATE()"),
                            // 'activepersonalmeet'=> DB::ExecuteScalar("SELECT COUNT(*) From meeting where type='Personal' and isactive='1' "),
                            // 'activecoffeemeet'=> DB::ExecuteScalar("SELECT COUNT(*) From meeting where type='NetworkingCoffee' and isactive='1'"),
                            
                            // 'totaldownload'=> DB::ExecuteScalar("SELECT SUM(isdownload) From user_panel_mgmt where isdownload>0"),
                            // 'todaydownload'=> DB::ExecuteScalar("SELECT SUM(isdownload) From user_panel_mgmt where isdownload>0 and date(timestamp) = CURDATE()"),
                            // 'uniquedownload'=> DB::ExecuteScalar("SELECT COUNT(*) From user_panel_mgmt where isdownload>0"),
                            // 'todayuniquedownload'=> DB::ExecuteScalar("SELECT COUNT(*) From user_panel_mgmt where isdownload>0 and date(timestamp) = CURDATE()"),
                            // 'totalview'=> DB::ExecuteScalar("SELECT SUM(isview) From user_panel_mgmt where isview>0"),
                            // 'todayview'=> DB::ExecuteScalar("SELECT SUM(isview) From user_panel_mgmt where isview>0 and date(timestamp) = CURDATE()"),
                            // 'uniqueview'=> DB::ExecuteScalar("SELECT COUNT(*) From user_panel_mgmt where isview>0"),
                            // 'todayuniqueview'=> DB::ExecuteScalar("SELECT COUNT(*) From user_panel_mgmt where isview>0 and date(timestamp) = CURDATE()"),
                        );
        }
        
        echo json_encode($data);
    }
}

