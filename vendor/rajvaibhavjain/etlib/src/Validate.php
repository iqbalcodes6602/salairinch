<?php
    namespace ETLAB;


    class Validate{

        public function __construct()
        {
        }
        
        public static function Mobile($mobile){
            return preg_match('/^[0-9]{10}+$/', $mobile);
        }

        public static function Email($email){
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        public static function Trim($array){
            $data=array();
            if(!empty($array)){
                foreach ($array as $key => $value) {
                    $data[$key]=trim($value);
                } 
            }
            return $data;
        }

        public static function findSpecialCharactor($string){
            $isok=true;
            if (preg_match('/[\'^£$%&*()}{#~?><>,|=_+¬-]/', $string))
            {
                $isok=false;
            }
            return $isok;
        }
        
        /* 
            $findSpecialCharactor=Validate::findSpecialCharactorForAll($_POST, array('password'));
        */
        public static function findSpecialCharactorForAll($array,$except)
        {
            $isok=true;
            if(!empty($array)){
                foreach ($array as $key => $value) {
                    $index=array_search($key, $except);
                    if($index<0){
                        if (preg_match('/[\'^£$%&*()}{#~?><>,|=_+¬-]/', $value))
                        {
                            $isok=false;
                        }
                    }
                } 
            }
            return $isok;
        }


        public static function removeScriptTag($array)
        {
            $data=array();
            if(!empty($array)){
                foreach ($array as $key => $value) {
                    $pattern = '/(script.*?(?:\/|&#47;|&#x0002F;)script)/ius';
                    $value=preg_replace($pattern, "", $value) ? : $value;
                    $data[$key]=$value;
                } 
            }
            return $data;
        }

        public static function removeHtmlTag($array)
        {
            $data=array();
            if(!empty($array)){
                foreach ($array as $key => $value) {
                    $value=strip_tags($value);
                    $data[$key]=$value;
                } 
            }
            return $data;
        }
        
        public static function Required($array){
            $data=array();
            if(!empty($array)){
                $allok=true;
                $msg=array();
                foreach ($array as $key => $value) {
                    $x=trim($value);
                    if($x!=""){
                        $data=array('response'=>true,'message'=>'All value are ok.');
                    }else{
                        $msg[]=$key." is required. \r\n";
                        $allok=false;
                    }
                } 
                if($allok!=true){
                    $data=array('response'=>false,'message'=>implode(' ',$msg));
                }
            }else{
                $data=array('response'=>false,'message'=>'Value not found.');
            }
            return $data;
        }

        
    }

?>