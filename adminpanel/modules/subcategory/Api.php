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

    public function getsubcategorys()
    {
        $array = array();
        $data = array();
        $showdatalimit = (int) isset($_POST['showdatalimit']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['showdatalimit']) : 10;
        $currentpage = (int) isset($_POST['currentpage']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['currentpage']) : 1;
        $startfrom = ($currentpage - 1) * $showdatalimit;

        /* Filter */
        $filter = array();
        if (isset($_POST['categoryid']) && $_POST['categoryid'] != "") {
            $categoryid = mysqli_real_escape_string($this->mysqli_user, $_POST['categoryid']);
            $filter[] = " sc.categoryid LIKE '%" . $categoryid . "%'";
        }
        if (isset($_POST['title']) && $_POST['title'] != "") {
            $title = mysqli_real_escape_string($this->mysqli_user, $_POST['title']);
            $filter[] = " sc.title LIKE '%" . $title . "%'";
        }
        if (isset($_POST['description']) && $_POST['description'] != "") {
            $description = mysqli_real_escape_string($this->mysqli_user, $_POST['description']);
            $filter[] = " sc.description LIKE '%" . $description . "%'";
        }

        $query = "SELECT sc.id as subcategoryid, c.title as categroytitle, sc.title,  sc.description, sc.image,sc.status, sc.time From subcategory as sc left join category as c on sc.categoryid = c.id";
        $where = " order by  sc.id desc LIMIT $startfrom, $showdatalimit";

        if (!empty($filter)) {
            $where = " where " . implode(' and ', $filter) . "  order by  sc.id desc LIMIT $startfrom, $showdatalimit";
        }
        // print_r($query . $where);
        //  exit;
        $document = mysqli_query($this->mysqli_user, $query . $where);
        if (mysqli_num_rows($document) > 0) {
            while ($row = mysqli_fetch_assoc($document)) {
                $array[] = $row;
            }
            $data = array('response' => true, 'message' => 'success', 'subcategory' => $array, 'totalrows' => DB::ExecuteScalar("SELECT * From subcategory as sc " . (!empty($filter) ? ' where ' . implode(' and ', $filter) : '') . ""));
        } else {
            $data = array('response' => false, 'message' => "No data found.");
        }
        echo json_encode($data);
    }

    public function getsubcategory()
    {
        $data = array();
        $key = (int) isset($_POST['key']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['key']) : 0;
        if ($key > 0) {
            $subcategory = DBS::ExecuteScalarRow("select id as subcategoryid, categoryid , title,  description, image, status, time from subcategory where id=? ", array($key));
            if ($subcategory) {
                $data = array('response' => true, 'message' => 'success', 'subcategory' => $subcategory);
            } else {
                $data = array('response' => false, 'message' => "No data found.");
            }
        } else {
            $data = array('response' => false, 'message' => "Invalid subcategory ID.");
        }
        echo json_encode($data);
    }

    public function deletesubcategory()
    {
        $subcategoryid = mysqli_real_escape_string($this->mysqli_user, $_POST['key']);
        $data = array();
        $subcategory = DBS::ExecuteScalarRow("SELECT * FROM subcategory where id=?", array($subcategoryid));
        if ($subcategory) {
            $deletesubcategory = DBS::Delete('subcategory', array('id' => $subcategoryid));
            if ($deletesubcategory) {
                if ($subcategory['image'] != "") {
                    if (file_exists("../../../assets/img/" . $subcategory['image'])) {
                        unlink("../../../assets/img/" . $subcategory['image']);
                    }
                }
                $data = array('response' => true, "message" => "Delete successfully.");
            } else {
                $data = array('response' => false, "message" => "queryfailed");
            }
        } else {
            $data = array('response' => false, "message" => "Invalid subcategory");
        }
        echo json_encode($data);
    }


    public function setsubcategory()
    {
        $array = array(
            'title' => isset($_POST['title']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['title']) : '',
            'categoryid' => isset($_POST['categoryid']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['categoryid']) : '',
            'description' => isset($_POST['description']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['description']) : '',
            'status' => isset($_POST['status']) ? mysqli_real_escape_string($this->mysqli_user, $_POST['status']) : 0,
            'time' => $this->current_time
        );
        if ($array['categoryid'] == "" || $array['categoryid'] == null) {
            $response = array('status' => false, "message" => "Please enter your category id.");
        } else if ($array['title'] == "" || $array['title'] == null) {
            $response = array('status' => false, "message" => "Please enter your title.");
        } else if ($array['description'] == "" || $array['description'] == null) {
            $response = array('status' => false, "message" => "Please enter your description.");
        } else {

            /*Image */
            if (isset($_FILES["image"]["size"]) && $_FILES["image"]["size"] > 0) {
                $image = "image_" . date('Y_m_d_H_i_s');
                $sourcePath = $_FILES['image']['tmp_name'];
                $extension = explode("/", $_FILES["image"]["type"]);
                $targetPath = "../../../assets/img/subcategory/" . $image . "." . $extension[1]; // Target path where file is to be stored
                $dbPath = "subcategory/" . $image . "." . $extension[1];
                if (move_uploaded_file($sourcePath, $targetPath)) {
                    $array['image'] = $dbPath;
                }
            }
            /*Image End */

            $insertsubcategory = DB::Insert('subcategory', $array);
            if ($insertsubcategory) {
                $response = array('response' => true, "message" => "Added Successfully.");
            } else {
                $response = array('response' => false, "message" => "Unable to add this moment. Please try again.");
            }
        }
        echo json_encode($response);
    }


    public function setsubcategoryupdate()
    {
        $data = array();
        $subcategoryid = mysqli_real_escape_string($this->mysqli_user, $_POST['subcategoryid']);
        $categoryid = mysqli_real_escape_string($this->mysqli_user, $_POST['categoryid']);
        $title = mysqli_real_escape_string($this->mysqli_user, $_POST['title']);
        $description = mysqli_real_escape_string($this->mysqli_user, $_POST['description']);
        $status = mysqli_real_escape_string($this->mysqli_user, $_POST['status']);
        $result = mysqli_query($this->mysqli_user, "SELECT * FROM subcategory where id='$subcategoryid'");
        if (mysqli_num_rows($result) > 0) {
            $subcategory = mysqli_fetch_assoc($result);
            $updatearray = array(
                'categoryid' => $categoryid,
                'title' => $title,
                'description' => $description,
                'status' => $status,
            );

            /*Image */
            if (isset($_FILES["image"]["size"]) && $_FILES["image"]["size"] > 0) {
                $image = "image_" . date('Y_m_d_H_i_s');
                $sourcePath = $_FILES['image']['tmp_name'];
                $extension = explode("/", $_FILES["image"]["type"]);
                $targetPath = "../../../assets/img/subcategory/" . $image . "." . $extension[1]; // Target path where file is to be stored
                $dbPath = "subcategory/" . $image . "." . $extension[1];
                if (move_uploaded_file($sourcePath, $targetPath)) {
                    $updatearray['image'] = $dbPath;

                    if ($subcategory['image'] != "") {
                        if (file_exists("../../../assets/img/" . $subcategory['image'])) {
                            unlink("../../../assets/img/" . $subcategory['image']);
                        }
                    }
                }
            }
            /*Image End */

            $updatearray = DBS::Update('subcategory', $updatearray, array('id' => $subcategoryid));
            if ($updatearray) {
                $data = array('response' => true, "message" => "subcategory Update Successfully");
            } else {
                $data = array('response' => false, "message" => "queryfailed");
            }
        } else {
            $data = array('response' => false, "message" => "Invalid subcategory");
        }
        echo json_encode($data);
    }
}
