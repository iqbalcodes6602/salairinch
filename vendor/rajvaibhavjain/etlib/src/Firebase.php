<?php 
    namespace ETLAB;

    class Firebase {
        public function __construct()
        {
            include('db.php');
        }

        public static function PushNotificationSingle($token="",$title="No Title",$body="No Body",$imageurl="", $url=""){
                if($token==""){
                    $token=$GLOBALS['AppConfig']['FireBaseToken'];
                }
                if($imageurl==""){
                    $imageurl=$GLOBALS['AppConfig']['FireBaseImage'];
                }
                
				$path_to_fcm="https://fcm.googleapis.com/fcm/send";
				$headers=array(
				'Authorization:key='.$GLOBALS['AppConfig']['FireBaseServerKey'],
				'Content-Type:application/json'
				);
				
				$fields=array('to'=>$token,'notification'=>array('title'=>$title,'body'=>$body,"image"=>$imageurl,"click_action"=>$url));
				$payload=json_encode($fields);
				$curl_session=curl_init();
				curl_setopt($curl_session,CURLOPT_URL,$path_to_fcm);
				curl_setopt($curl_session,CURLOPT_POST,true);
				curl_setopt($curl_session,CURLOPT_HTTPHEADER,$headers);
				curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER,false);
				curl_setopt($curl_session,CURLOPT_IPRESOLVE,CURL_IPRESOLVE_V4);
				curl_setopt($curl_session,CURLOPT_POSTFIELDS,$payload);
				$result=curl_exec($curl_session);
				curl_close($curl_session);
				// print_r($result);
                return true;
        }

        public static function PushNotificationMultiDevice($tokenArray=array(),$title="No Title",$body="No Body",$imageurl="", $url=""){
            if(empty($tokenArray)){
                $tokenArray=array(  $GLOBALS['AppConfig']['FireBaseToken'],
                                    $GLOBALS['AppConfig']['FireBaseToken']);
            }  
            
            if($imageurl==""){
                $imageurl=$GLOBALS['AppConfig']['FireBaseImage'];
            }

            $path_to_fcm="https://fcm.googleapis.com/fcm/send";
            $headers=array(
            'Authorization:key='.$GLOBALS['AppConfig']['FireBaseServerKey'],
            'Content-Type:application/json'
            );
            
            $fields=array('registration_ids'=>$tokenArray,'notification'=>array('title'=>$title,'body'=>$body,"image"=>$imageurl,"click_action"=>$url,"sound"=> "default"));
            $payload=json_encode($fields);
            $curl_session=curl_init();
            curl_setopt($curl_session,CURLOPT_URL,$path_to_fcm);
            curl_setopt($curl_session,CURLOPT_POST,true);
            curl_setopt($curl_session,CURLOPT_HTTPHEADER,$headers);
            curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($curl_session,CURLOPT_IPRESOLVE,CURL_IPRESOLVE_V4);
            curl_setopt($curl_session,CURLOPT_POSTFIELDS,$payload);
            $result=curl_exec($curl_session);
            curl_close($curl_session);
            // print_r($result);
            return true;
        }

    }


?>