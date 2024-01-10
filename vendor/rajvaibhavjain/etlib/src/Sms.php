<?php
    namespace ETLAB;


    class Sms{

        public function __construct()
        {
        }
        
        public static function SendMessage($mobile,$msg){
            // $msg="Dear user, Your OTP is 1234 Regards ETECHMY.";
            $url = 'https://www.smsidea.co.in/sendsms.aspx?mobile='.$GLOBALS['AppConfig']['mobile'].'&pass='.$GLOBALS['AppConfig']['pass'].'&senderid='.$GLOBALS['AppConfig']['senderid'].'&to='.$mobile.'&msg='.urlencode($msg);
            $headers = array( 'Authorization' => 'Basic dXNlcm5hbWU6cGFzc3dvcmQ=', 'Content-Type' => 'application/json' );
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch,CURLOPT_POSTFIELDS, "PING=PONG");
            $result = curl_exec($ch);
            curl_close($ch);
            if($result=='1 SMS Sent.'){
                return true;
            }else{
                return false;
            }
        }
    }

?>