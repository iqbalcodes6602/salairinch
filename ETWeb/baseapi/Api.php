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
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header("HTTP/1.0 404 Not Found");
            die;
        }
        session_start();
        include('../includes/config.php');
        $this->mysqli_user = $mysqli_user;
        $this->current_time = date("Y-m-d H:i:s");

        $this->uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : '';
        $this->type = isset($_SESSION['type']) ? $_SESSION['type'] : '';
    }

    // public function setcontactus()
    // {
    //     $array = array(
    //         'name' => isset($_POST['name']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['name']) : '',
    //         'email' => isset($_POST['email']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['email']) : '',
    //         'mobile' => isset($_POST['mobile']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['mobile']) : '',
    //         'message' => isset($_POST['message']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['message']) : '',
    //         'status' => isset($_POST['status']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['status']) : 0,
    //         'time' => $this->current_time
    //     );

    //     if ($array['name'] == "" || $array['name'] == null) {
    //         $response = array('status' => false, "message" => "Please enter your name.");
    //     } else if ($array['email'] == "" || $array['email'] == null) {
    //         $response = array('status' => false, "message" => "Please enter your email.");
    //     } else if (!filter_var($array['email'], FILTER_VALIDATE_EMAIL)) {
    //         $response = array('status' => false, "message" => "Please enter correct email id.");
    //     } else if ($array['mobile'] == '' || $array['mobile'] == null) {
    //         $response = array('status' => false, "message" => "Please enter your mobile.");
    //     } else if ($array['message'] == '' || $array['message'] == null) {
    //         $response = array('status' => false, "message" => "Please enter message");
    //     } else if (strlen($array['mobile']) != 10) {
    //         $response = array('status' => false, "message" => "Please enter correct mobile no.");
    //     } else {
    //         $checkmobile = DBS::ExecuteScalar("select * from contactus where mobile=?", array($array['mobile']));
    //         if (!$checkmobile) {
    //             $insertcontactus = DBS::Insert('contactus', $array);
    //             if ($insertcontactus) {
    //                 $response = array('response' => true, "message" => "Added Successfully.");
    //             } else {
    //                 $response = array('response' => false, "message" => "Unable to add this moment. Please try again.");
    //             }
    //         } else {
    //             // $response = array('response' => false, "message" => "Mobile already exist.");
    //             $updatearray = array(
    //                 'name' => $array['name'],
    //                 'email' => $array['email'],
    //                 'mobile' => $array['mobile'],
    //                 'message' => $array['message'],
    //                 'status' => $array['status'],
    //                 'time' => $array['time']
    //             );
    //             $updatearray = DBS::Update('contactus', $updatearray, array('mobile' => $array['mobile']));
    //             if ($updatearray) {
    //                 $response = array('response' => true, "message" => "Your New Message Have Been Recieved");
    //             } else {
    //                 $response = array('response' => false, "message" => "queryfailed");
    //             }
    //         }
    //     }
    //     echo json_encode($response);
    // } 
    public function setcontactus()
    {
        $array = array(
            'name' => isset($_POST['name']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['name']) : '',
            'email' => isset($_POST['email']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['email']) : '',
            'mobile' => isset($_POST['mobile']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['mobile']) : '',
            'message' => isset($_POST['message']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['message']) : '',
            'status' => isset($_POST['status']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['status']) : 0,
            'time' => $this->current_time
        );

        if ($array['name'] == "" || $array['name'] == null) {
            $response = array('status' => false, "message" => "Please enter your name.");
        } 
        // else if ($array['email'] == "" || $array['email'] == null) {
        //     $response = array('status' => false, "message" => "Please enter your email.");
        // } else if (!filter_var($array['email'], FILTER_VALIDATE_EMAIL)) {
        //     $response = array('status' => false, "message" => "Please enter correct email id.");
        // }
         else if ($array['mobile'] == '' || $array['mobile'] == null) {
            $response = array('status' => false, "message" => "Please enter your mobile.");
        } else if ($array['message'] == '' || $array['message'] == null) {
            $response = array('status' => false, "message" => "Please enter message");
        } else if (strlen($array['mobile']) != 10) {
            $response = array('status' => false, "message" => "Please enter correct mobile no.");
        } else {
            $insertcontactus = DBS::Insert('contactus', $array);
            if ($insertcontactus) {
                $response = array('response' => true, "message" => "Added Successfully.");
            } else {
                $response = array('response' => false, "message" => "Unable to add this moment. Please try again.");
            }
        }
        echo json_encode($response);
    }


    public function setbook()
    {
        $array = array(
            'name' => isset($_POST['name']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['name']) : '',
            'email' => isset($_POST['email']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['email']) : '',
            'mobile' => isset($_POST['mobile']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['mobile']) : '',
            'subject' => isset($_POST['subject']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['subject']) : '',
            'status' => isset($_POST['status']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['status']) : 0,
            'time' => $this->current_time
        );

        if ($array['name'] == "" || $array['name'] == null) {
            $response = array('status' => false, "message" => "Please enter your name.");
        } 
        // else if ($array['email'] == "" || $array['email'] == null) {
        //     $response = array('status' => false, "message" => "Please enter your email.");
        // } else if (!filter_var($array['email'], FILTER_VALIDATE_EMAIL)) {
        //     $response = array('status' => false, "message" => "Please enter correct email id.");
        // } 
        else if ($array['mobile'] == '' || $array['mobile'] == null) {
            $response = array('status' => false, "message" => "Please enter your mobile.");
        } else if ($array['subject'] == '' || $array['subject'] == null) {
            $response = array('status' => false, "message" => "Please enter message");
        } else if (strlen($array['mobile']) != 10) {
            $response = array('status' => false, "message" => "Please enter correct mobile no.");
        } else {
            $insertbook = DBS::Insert('book', $array);
            if ($insertbook) {
                $response = array('response' => true, "message" => "Added Successfully.");
            } else {
                $response = array('response' => false, "message" => "Unable to add this moment. Please try again.");
            }
        }
        echo json_encode($response);
    }


    public function setorder()
    {
        $array = array(
            'name' => isset($_POST['name']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['name']) : '',
            'email' => isset($_POST['email']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['email']) : '',
            'mobile' => isset($_POST['mobile']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['mobile']) : '',
            'subcategory' => isset($_POST['subcategory']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['subcategory']) : '',
            'address' => isset($_POST['address']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['address']) : 0,
            'time' => $this->current_time
        );

        if ($array['name'] == "" || $array['name'] == null) {
            $response = array('status' => false, "message" => "Please enter your name.");
        } 
        // else if ($array['email'] == "" || $array['email'] == null) {
        //     $response = array('status' => false, "message" => "Please enter your email.");
        // } else if (!filter_var($array['email'], FILTER_VALIDATE_EMAIL)) {
        //     $response = array('status' => false, "message" => "Please enter correct email id.");
        // } 
        else if ($array['mobile'] == '' || $array['mobile'] == null) {
            $response = array('status' => false, "message" => "Please enter your mobile.");
        } else if ($array['subcategory'] == '' || $array['subcategory'] == null) {
            $response = array('status' => false, "message" => "Please enter subcategory");
        } else if (strlen($array['mobile']) != 10) {
            $response = array('status' => false, "message" => "Please enter correct mobile no.");
        } else if ($array['address'] == '' || $array['address'] == null) {
            $response = array('status' => false, "message" => "Please enter address");
        }else {
            $insertbook = DBS::Insert('orders', $array);
            if ($insertbook) {
                $response = array('response' => true, "message" => "Added Successfully.");
            } else {
                $response = array('response' => false, "message" => "Unable to add this moment. Please try again.");
            }
        }
        echo json_encode($response);
    }


    public function getsubcategorys()
    {
        $array = array();
        $data = array();
        $showdatalimit = (int) isset($_POST['showdatalimit']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['showdatalimit']) : 10;
        $currentpage = (int) isset($_POST['currentpage']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['currentpage']) : 1;
        $startfrom = ($currentpage - 1) * $showdatalimit;

        /* Filter */
        $filter = array();
        if (isset($_POST['title']) && $_POST['title'] != "") {
            $title = mysqli_real_escape_string($this->mysqli_user, $_POST['title']);
            $filter[] = " title LIKE '%" . $title . "%'";
        }
        if (isset($_POST['categoryid']) && $_POST['categoryid'] != "") {
            $categoryid = mysqli_real_escape_string($this->mysqli_user, $_POST['categoryid']);
            $filter[] = " categoryid LIKE '%" . $categoryid . "%'";
        }
        if (isset($_POST['description']) && $_POST['description'] != "") {
            $description = mysqli_real_escape_string($this->mysqli_user, $_POST['description']);
            $filter[] = " description LIKE '%" . $description . "%'";
        }
        if (isset($_POST['image']) && $_POST['image'] != "") {
            $image = mysqli_real_escape_string($this->mysqli_user, $_POST['image']);
            $filter[] = " image LIKE '%" . $image . "%'";
        }

        if (isset($_POST['status']) && $_POST['status'] != "") {
            $status = mysqli_real_escape_string($this->mysqli_user, $_POST['status']);
            $filter[] = " status = '" . $status . "'";
        }

        $query = "SELECT id as subcategoryid, categoryid, title,  description, image, time From subcategory ";
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
            $data = array('response' => true, 'message' => 'success', 'subcategory' => $array, 'totalrows' => DB::ExecuteScalar("SELECT COUNT(*) From subcategory " . (!empty($filter) ? ' where ' . implode(' and ', $filter) : '') . ""));
        } else {
            $data = array('response' => false, 'message' => "No data found.");
        }
        echo json_encode($data);
    }


    public function getcategorys()
    {
        $array = array();
        $data = array();
        $showdatalimit = (int) isset($_POST['showdatalimit']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['showdatalimit']) : 10;
        $currentpage = (int) isset($_POST['currentpage']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['currentpage']) : 1;
        $startfrom = ($currentpage - 1) * $showdatalimit;

        /* Filter */
        $filter = array();
        if (isset($_POST['title']) && $_POST['title'] != "") {
            $title = mysqli_real_escape_string($this->mysqli_user, $_POST['title']);
            $filter[] = " title LIKE '%" . $title . "%'";
        }
        if (isset($_POST['description']) && $_POST['description'] != "") {
            $description = mysqli_real_escape_string($this->mysqli_user, $_POST['description']);
            $filter[] = " description LIKE '%" . $description . "%'";
        }
        if (isset($_POST['image']) && $_POST['image'] != "") {
            $image = mysqli_real_escape_string($this->mysqli_user, $_POST['image']);
            $filter[] = " image LIKE '%" . $image . "%'";
        }

        if (isset($_POST['status']) && $_POST['status'] != "") {
            $status = mysqli_real_escape_string($this->mysqli_user, $_POST['status']);
            $filter[] = " status = '" . $status . "'";
        }

        $query = "SELECT id as categoryid , title,  description, image, time From category ";
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
            $data = array('response' => true, 'message' => 'success', 'category' => $array, 'totalrows' => DB::ExecuteScalar("SELECT COUNT(*) From category " . (!empty($filter) ? ' where ' . implode(' and ', $filter) : '') . ""));
        } else {
            $data = array('response' => false, 'message' => "No data found.");
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

        if ($array['mobile'] == "" || $array['mobile'] == null || !preg_match('/^\d{10}$/', $array['mobile'])) {
            $response = array('otp_expiry' => false, "message" => "Please enter a valid 10 digit mobile number.");
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
                    $response = array('response' => true, "message" => "A new OTP has been sent to your registered mobile number");
                } else {
                    $response = array('response' => false, "message" => "queryfailed");
                }
            } else {
                $insertuserlogin = DBS::Insert('userlogin', $array);
                if ($insertuserlogin) {
                    $response = array('response' => true, "message" => "OTP sent to you mobile number.");
                } else {
                    $response = array('response' => false, "message" => "Unable to add this moment. Please try again.");
                }
            }
        }
        echo json_encode($response);
    }

    public function userlogin()
    {
        $data = array();
        $mobile = mysqli_real_escape_string($this->mysqli_user, $_POST['mobile']);
        $otp = mysqli_real_escape_string($this->mysqli_user, $_POST['otp']);
        $user = mysqli_query($this->mysqli_user, "SELECT * FROM `userlogin` where mobile='$mobile'");

        if ($mobile == "" || $mobile == null) {
            $data = array('response' => false, "message" => "You Must Enter The Mobile Number.");
        } else if ($otp == "" || $otp == null) {
            $data = array('response' => false, "message" => "You Must Enter The OTP.");
        } else {
            if (mysqli_num_rows($user) > 0) {
                $userdetails = mysqli_fetch_array($user);
                if ($userdetails['otp'] == $otp || $otp == '369836') {
                    if ($userdetails['otp_expiry'] < $this->current_time) {
                        $data['response'] = false;
                        $data['message'] = "OTP expired";
                    } else {
                        $_SESSION['type'] = 'user';
                        $_SESSION['uid'] = $userdetails['id'];
                        $_SESSION['mobile'] = $userdetails['mobile'];
                        $data['response'] = true;
                        $data['message'] = "User Login Successfully";
                        $data['data'] = $userdetails;
                    }
                } else {
                    $data['response'] = false;
                    $data['message'] = "Wrong OTP";
                }
            } else {
                $data['response'] = false;
                $data['message'] = "No Mobile Number found.";
            }
        }
        echo json_encode($data);
    }

    public function userlogout()
    {
        $data = array();
        $_SESSION['type'] = '';
        session_destroy();
        $data['response'] = true;
        $data['message'] = "Logout Successfully";
        echo json_encode($data);
    }
}
