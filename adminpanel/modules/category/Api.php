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

        $query = "SELECT id as categoryid , title,  description, image,status, time From category ";
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

    public function getcategory()
    {
        $data = array();
        $key = (int) isset($_POST['key']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['key']) : 0;
        if ($key > 0) {
            $category = DBS::ExecuteScalarRow("select id as categoryid , title,  description, image, status, time from category where id=? ", array($key));
            if ($category) {
                $data = array('response' => true, 'message' => 'success', 'category' => $category);
            } else {
                $data = array('response' => false, 'message' => "No data found.");
            }
        } else {
            $data = array('response' => false, 'message' => "Invalid category ID.");
        }
        echo json_encode($data);
    }

    public function deletecategory()
    {
        $categoryid = mysqli_real_escape_string($this->mysqli_user, $_POST['key']);
        $data = array();
        $category = DBS::ExecuteScalarRow("SELECT * FROM category where id=?", array($categoryid));
        if ($category) {
            $deletecategory = DBS::Delete('category', array('id' => $categoryid));
            if ($deletecategory) {
                if ($category['image'] != "") {
                    if (file_exists("../../../assets/img/" . $category['image'])) {
                        unlink("../../../assets/img/" . $category['image']);
                    }
                }
                $data = array('response' => true, "message" => "Delete successfully.");
            } else {
                $data = array('response' => false, "message" => "queryfailed");
            }
        } else {
            $data = array('response' => false, "message" => "Invalid category");
        }
        echo json_encode($data);
    }


    public function setcategory()
    {
        $array = array(
            'title' => isset($_POST['title']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['title']) : '',
            'description' => isset($_POST['description']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['description']) : '',
            'status' => isset($_POST['status']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['status']) : 0,
            'time' => $this->current_time
        );

        if ($array['title'] == "" || $array['title'] == null) {
            $response = array('status' => false, "message" => "Please enter your title.");
        } else if ($array['description'] == "" || $array['description'] == null) {
            $response = array('status' => false, "message" => "Please enter your description.");
        } else {

            /*Image */
            if (isset($_FILES["image"]["size"]) && $_FILES["image"]["size"] > 0) {
                $image = "image_" . date('Y_m_d_H_i_s').'_'.rand(1000,9999);
                $sourcePath = $_FILES['image']['tmp_name'];
                $extension = explode("/", $_FILES["image"]["type"]);
                $targetPath = "../../../assets/img/category/" . $image . "." . $extension[1]; // Target path where file is to be stored
                $dbPath = "category/" . $image . "." . $extension[1];
                if (move_uploaded_file($sourcePath, $targetPath)) {
                    $array['image'] = $dbPath;
                }
            }
            /*Image End */

            $insertcategory = DBS::Insert('category', $array);
            if ($insertcategory) {
                $response = array('response' => true, "message" => "Added Successfully.");
            } else {
                $response = array('response' => false, "message" => "Unable to add this moment. Please try again.");
            }
        }
        echo json_encode($response);
    }


    public function setcategoryupdate()
    {
        $data = array();
        $categoryid = mysqli_real_escape_string($this->mysqli_user, $_POST['categoryid']);
        $title = mysqli_real_escape_string($this->mysqli_user, $_POST['title']);
        $description = mysqli_real_escape_string($this->mysqli_user, $_POST['description']);
        $status = mysqli_real_escape_string($this->mysqli_user, $_POST['status']);
        $result = mysqli_query($this->mysqli_user, "SELECT * FROM category where id='$categoryid'");
        if (mysqli_num_rows($result) > 0) {
            $category = mysqli_fetch_assoc($result);
            $updatearray = array(
                'title' => $title,
                'description' => $description,
                'status' => $status,
            );

            /*Image */
            if (isset($_FILES["image"]["size"]) && $_FILES["image"]["size"] > 0) {
                $image = "image_" . date('Y_m_d_H_i_s');
                $sourcePath = $_FILES['image']['tmp_name'];
                $extension = explode("/", $_FILES["image"]["type"]);
                $targetPath = "../../../assets/img/category/" . $image . "." . $extension[1]; // Target path where file is to be stored
                $dbPath = "category/" . $image . "." . $extension[1];
                if (move_uploaded_file($sourcePath, $targetPath)) {
                    $updatearray['image'] = $dbPath;

                    if ($category['image'] != "") {
                        if (file_exists("../../../assets/img/" . $category['image'])) {
                            unlink("../../../assets/img/" . $category['image']);
                        }
                    }
                }
            }
            /*Image End */

            $updatearray = DBS::Update('category', $updatearray, array('id' => $categoryid));
            if ($updatearray) {
                $data = array('response' => true, "message" => "category Update Successfully");
            } else {
                $data = array('response' => false, "message" => "queryfailed");
            }
        } else {
            $data = array('response' => false, "message" => "Invalid category");
        }
        echo json_encode($data);
    }
}
