<?php

namespace ETLAB;

$obj = new Api();
$urlParams = explode('/', $_SERVER['REQUEST_URI']);
$functionName = end($urlParams);
$obj->$functionName();

class Api
{
    public function __construct()
    {
        session_start();
        include('../../../ETWeb/includes/config.php');
        $this->mysqli_user = $mysqli_user;
        $this->current_time = date("Y-m-d H:i:s");

        $this->uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : '';
        $this->type = isset($_SESSION['type']) ? $_SESSION['type'] : '';
    }

    public function getuserlogins()
    {
        $array = array();
        $data = array();
        $showdatalimit = (int) isset($_POST['showdatalimit']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['showdatalimit']) : 10;
        $currentpage = (int) isset($_POST['currentpage']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['currentpage']) : 1;
        $startfrom = ($currentpage - 1) * $showdatalimit;

        /* Filter */
        $filter = array();
        if (isset($_POST['mobile']) && $_POST['mobile'] != "") {
            $mobile = mysqli_real_escape_string($this->mysqli_user, $_POST['mobile']);
            $filter[] = " mobile LIKE '%" . $mobile . "%'";
        }

        $query = "SELECT id as userloginid , mobile,  otp, otp_expiry, time From userlogin ";
        $where = " order by  id desc LIMIT $startfrom, $showdatalimit";

        if (!empty($filter)) {
            $where = " where " . implode(' and ', $filter) . "  order by  id desc LIMIT $startfrom, $showdatalimit";
        }
        //  print_r($query.$where);
        //  exit;
        $document = mysqli_query($this->mysqli_user, $query . $where);
        if (mysqli_num_rows($document) > 0) {
            while ($row = mysqli_fetch_assoc($document)) {
                $array[] = $row;
            }
            $data = array('response' => true, 'userlogin' => $array, 'totalrows' => DBS::ExecuteScalar("SELECT * From userlogin " . (!empty($filter) ? ' where ' . implode(' and ', $filter) : '') . ""));
        } else {
            $data = array('response' => false, 'message' => "No data found.");
        }
        echo json_encode($data);
    }

    public function getuserlogin()
    {
        $data = array();
        $key = (int) isset($_POST['key']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['key']) : 0;
        if ($key > 0) {
            $userlogin = DBS::ExecuteScalarRow("select id as userloginid , mobile, otp ,otp_expiry, time from userlogin where id=? ", array($key));
            if ($userlogin) {
                $data = array('response' => true, 'message' => 'success', 'userlogin' => $userlogin);
            } else {
                $data = array('response' => false, 'message' => "No data found.");
            }
        } else {
            $data = array('response' => false, 'message' => "Invalid userlogin ID.");
        }
        echo json_encode($data);
    }

    public function deleteuserlogin()
    {
        $userloginid = mysqli_real_escape_string($this->mysqli_user, $_POST['key']);
        $data = array();
        $userlogin = DBS::ExecuteScalarRow("SELECT * FROM userlogin where id=?", array($userloginid));
        if ($userlogin) {
            $deleteuserlogin = DBS::Delete('userlogin', array('id' => $userloginid));
            if ($deleteuserlogin) {
                $data = array('response' => true, "message" => "Delete successfully.");
            } else {
                $data = array('response' => false, "message" => "queryfailed");
            }
        } else {
            $data = array('response' => false, "message" => "Invalid userlogin");
        }
        echo json_encode($data);
    }


    public function setuserlogin()
    {
        $array = array(
            'mobile' => isset($_POST['mobile']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['mobile']) : '',
            'otp' => strval(mt_rand(100000, 999999)),
            'otp_expiry' => date('Y-m-d H:i:s', strtotime('+5 minutes')),
            'time' => $this->current_time 
        );

        if ($array['mobile'] == "" || $array['mobile'] == null) {
            $response = array('otp_expiry' => false, "message" => "Please enter your mobile.");
        } else {
            $checkmobile = DBS::ExecuteScalar("select * from userlogin where mobile=?", array($array['mobile']));
            if ($checkmobile) {
                $updatearray = array(
                    'mobile' => $array['mobile'],
                    'otp' => $array['otp'],
                    'otp_expiry' => $array['otp_expiry'],
                    'time' => $array['time']
                );
                $updatearray = DBS::Update('userlogin', $updatearray, array('mobile' => $array['mobile']));
                if ($updatearray) {
                    $response = array('response' => true, "message" => "userlogin Update Successfully");
                } else {
                    $response = array('response' => false, "message" => "queryfailed");
                }
            } else {
                $insertuserlogin = DBS::Insert('userlogin', $array);
                if ($insertuserlogin) {
                    $response = array('response' => true, "message" => "Added Successfully.");
                } else {
                    $response = array('response' => false, "message" => "Unable to add this moment. Please try again.");
                }
            }
        }
        echo json_encode($response);
    }


    public function setuserloginupdate()
    {
        $data = array();
        $userloginid = mysqli_real_escape_string($this->mysqli_user, $_POST['userloginid']);
        $mobile = mysqli_real_escape_string($this->mysqli_user, $_POST['mobile']);
        $otp = mysqli_real_escape_string($this->mysqli_user, $_POST['otp']);
        $otp_expiry = mysqli_real_escape_string($this->mysqli_user, $_POST['otp_expiry']);
        $result = mysqli_query($this->mysqli_user, "SELECT * FROM userlogin where id='$userloginid'");
        if (mysqli_num_rows($result) > 0) {
            $updatearray = array(
                'mobile' => $mobile,
                'otp' => $otp,
                'otp_expiry' => $otp_expiry,
            );
            $updatearray = DBS::Update('userlogin', $updatearray, array('id' => $userloginid));
            if ($updatearray) {
                $data = array('response' => true, "message" => "userlogin Update Successfully");
            } else {
                $data = array('response' => false, "message" => "queryfailed");
            }
        } else {
            $data = array('response' => false, "message" => "Invalid userlogin");
        }
        echo json_encode($data);
    }
}
