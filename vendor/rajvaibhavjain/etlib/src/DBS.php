<?php
    namespace ETLAB;
    
    class DBS{

        /*
            DBS::Execute("SELECT * FROM user WHERE email = ?",array($email));
            Return All Data
        */
        public static function Execute($query, $value){
            $stmt = $GLOBALS['AppConfig']['mysqli_conn']->prepare($query); 
            if(isset($value) && is_array($value) && count($value)>0){
                $datatype='';
                $val = [];
                for($i=0; $i< count($value); $i++){
                    $datatype.='s';
                    $val[] = &$value[$i];
                }
                $datatypeArray[] = &$datatype;
                $executeScalarValue = array_merge($datatypeArray, $val);
                call_user_func_array([&$stmt,'bind_param'], $executeScalarValue);
            }
            $stmt->execute();
            $result=$stmt->get_result();
            $data=array();
            if(mysqli_num_rows($result)>0){
                while($row=mysqli_fetch_assoc($result)){
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
        
        /*
            $isUserExist=DBS::ExecuteScalar("SELECT * FROM user WHERE id = ?", array($uid));
        */
        public static function ExecuteScalar($query,$value=[]){
            $stmt = $GLOBALS['AppConfig']['mysqli_conn']->prepare($query); 
            
            if(isset($value) && is_array($value) && count($value)>0){
                $datatype='';
                $val = [];
                for($i=0; $i< count($value); $i++){
                    $datatype.='s';
                    $val[] = &$value[$i];
                }
                $datatypeArray[] = &$datatype;
                $executeScalarValue = array_merge($datatypeArray, $val);
                call_user_func_array([&$stmt,'bind_param'], $executeScalarValue);
            }

            $stmt->execute();
            if(!$stmt->error){
                return mysqli_num_rows($stmt->get_result());
            }else{
                return 0;
            }
        }

        /*
            DBS::ExecuteScalarRow("SELECT * FROM user WHERE email = ?",array($email));
            Return Single Data
        */
        public static function ExecuteScalarRow($query,$value){
            $stmt = $GLOBALS['AppConfig']['mysqli_conn']->prepare($query); 
           
            if(isset($value) && is_array($value) && count($value)>0){
                $datatype='';
                $val = [];
                for($i=0; $i< count($value); $i++){
                    $datatype.='s';
                    $val[] = &$value[$i];
                }
                $datatypeArray[] = &$datatype;
                $executeScalarValue = array_merge($datatypeArray, $val);
                call_user_func_array([&$stmt,'bind_param'], $executeScalarValue);       //It look like $stmt->bind_param('sss',$email, $name, $mobile );
            }
            
            $stmt->execute(); 
            $result=$stmt->get_result();
           
            if(!empty($result)){
                return mysqli_fetch_assoc($result);
            }else{
                return false;
            }
        }

        /*
            DBS::Update('user',array('first_login_time'=>$this->current_time,'last_login_time'=>$this->current_time),array('id'=>$user['id']));
        */
        public static function Update($tablename,$values,$condition){

            //Remove HTML TAG
            $values=Validate::removeHtmlTag($values);

            $columnlist = [];
            $datatype='';
            $val = [];
            foreach (array_keys($values) as $k) {
                $columnlist[]=$k."=?";
                $datatype.='s';
                $val[] = &$values[$k];
            }

            $conditionlist = [];
            foreach (array_keys($condition) as $k) {
                $conditionlist[]="".$k."=?";
                $datatype.= is_numeric($condition[$k]) ? 'i' : 's';
                $val[] = &$condition[$k];
            }
            $datatypeArray[] = &$datatype;
            $updateValue = array_merge($datatypeArray, $val);


            $query = "Update `$tablename` set ".implode(",", $columnlist)." where ".implode(' and ', $conditionlist)."";
            
            $stmt = $GLOBALS['AppConfig']['mysqli_conn']->prepare($query); 
            call_user_func_array([&$stmt,'bind_param'], $updateValue);       //It look like $stmt->bind_param('sss',$email, $name, $mobile );
            $update=$stmt->execute();  

            return $update;
        }

        /*
            DBS::Insert('user',array('name'=>'Test','email'=>'test@test.com'));
        */
        public static function Insert($tablename,$values){
            
            //Remove HTML TAG
            $values=Validate::removeHtmlTag($values);

            $key = [];
            foreach (array_keys($values) as $k) {
                $key[]=$k;
            }
        
            $val = [];
            $datatype='';
            foreach (array_keys($values) as $k) {
                $datatype.='s';
                $val[] = &$values[$k];
            }
            $datatypeArray[] = &$datatype;
            $refs = array_merge($datatypeArray, $val);

            $q='?';
            for($i=0 ; $i < count($key)-1; $i++){
                $q.=',?';
            }
            $query = "Insert into `$tablename` (`".implode("`,`", $key)."`) VALUES (".$q.")";


            $stmt = $GLOBALS['AppConfig']['mysqli_conn']->prepare($query); 
            call_user_func_array([&$stmt,'bind_param'], $refs);       //It look like $stmt->bind_param('sss',$email, $name, $mobile );

            $stmt->execute();
            return $stmt->insert_id;
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

        public static function Delete($tablename,$condition){
            if(isset($condition) && is_array($condition) && count($condition)>0){
                $datatype='';
                $val = [];
                $conditionlist = [];
                foreach (array_keys($condition) as $k) {
                    $conditionlist[]="".$k."=?";
                    $datatype.= is_numeric($condition[$k]) ? 'i' : 's';
                    $val[] = &$condition[$k];
                }
                $datatypeArray[] = &$datatype;
                $deleteValue = array_merge($datatypeArray, $val);
                $query = "DELETE FROM  `$tablename` where ".implode(' and ', $conditionlist)."";
                $stmt = $GLOBALS['AppConfig']['mysqli_conn']->prepare($query); 
                call_user_func_array([&$stmt,'bind_param'], $deleteValue);       //It look like $stmt->bind_param('sss',$email, $name, $mobile );
                $delete=$stmt->execute(); 
            }else{
                $query = "DELETE FROM  `$tablename`";
                $stmt = $GLOBALS['AppConfig']['mysqli_conn']->prepare($query); 
                $delete=$stmt->execute(); 
            }
            return $delete;
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