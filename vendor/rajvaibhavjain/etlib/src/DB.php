<?php
    namespace ETLAB;


    class DB{

        public function __construct()
        {
            include('db.php');
            $this->$conn=$GLOBALS['AppConfig']['mysqli_conn'];
        }
        
        public static function Execute($query){
            $data=array();
            $count=mysqli_query($GLOBALS['AppConfig']['mysqli_conn'], $query);
            if(mysqli_num_rows($count)>0){
                while($row=mysqli_fetch_assoc($count)){
                    $data[]=$row; 
                }
                return $data;
            }else{
                return false;
            }
        }

        public static function ExecuteOnly($query){
            $execute_query=mysqli_multi_query($GLOBALS['AppConfig']['mysqli_conn'], $query);
            if($execute_query){
                return true;
            }else{
                return false;
            }
        }
        
        public static function ExecuteScalar($query){
            $count=mysqli_query($GLOBALS['AppConfig']['mysqli_conn'], $query);
            if(mysqli_num_rows($count)>0){
                $data=mysqli_fetch_array($count); 
                return isset($data[0])?$data[0]:false;
            }else{
                return 0;
            }
        }

        public static function ExecuteScalarRow($query){
            $mysqlquery=mysqli_query($GLOBALS['AppConfig']['mysqli_conn'], $query);
            if(mysqli_num_rows($mysqlquery)>0){
                $data=mysqli_fetch_assoc($mysqlquery); 
                return $data;
            }else{
                return false;
            }
        }

        public static function Update($tablename,$values,$condition){

            $columnlist = [];
            foreach (array_keys($values) as $k) {
                $columnlist[]=$k."='".$values[$k]."'";
            }

            $conditionlist = [];
            foreach (array_keys($condition) as $k) {
                $conditionlist[]="".$k."='".$condition[$k]."'";
            }
            $query = "Update `$tablename` set ".implode(",", $columnlist)." where ".implode(' and ', $conditionlist)."";
            // print_r($query);
            $update=mysqli_query($GLOBALS['AppConfig']['mysqli_conn'],$query);
            return $update;
        }

        public static function Insert($tablename,$values){
            $key = [];
            foreach (array_keys($values) as $k) {
                $key[]=$k;
            }
        
            $val = [];
            foreach (array_keys($values) as $k) {
                $val[]=mysqli_real_escape_string($GLOBALS['AppConfig']['mysqli_conn'], $values[$k]);
            }
        
            $query = "Insert into `$tablename` (`".implode("`,`", $key)."`) VALUES ('".implode("','", $val)."')";
            $insert=mysqli_query($GLOBALS['AppConfig']['mysqli_conn'],$query);
            return $GLOBALS['AppConfig']['mysqli_conn']->insert_id;
        }

        public static function BulkInsert($tablename,$values){
            // print_r($values);
            $key = [];
            $bulkval = [];
            foreach($values as $i=>$row){
                if($i==0){
                    foreach (array_keys($row) as $k) {
                        $key[]=$k;
                    }
                }
            }
            foreach (array_keys($values) as $k) {
                $bulkval[]="('".implode("','", $values[$k])."')";
            }

            $query = "Insert into `$tablename` (`".implode("`,`", $key)."`) VALUES ".implode(",", $bulkval)."";
            // echo $query;
            mysqli_query($GLOBALS['AppConfig']['mysqli_conn'],$query);
            return $GLOBALS['AppConfig']['mysqli_conn']->insert_id;
        }

        public static function KeyValuePair($query){
            $data=array();
            $count=mysqli_query($GLOBALS['AppConfig']['mysqli_conn'], $query);
            if(mysqli_num_rows($count)>0){
                while($row=mysqli_fetch_array($count)){
                    $data[$row[0]]=$row[1]; 
                }
                return $data;
            }else{
                return false;
            }
        }
    }

?>