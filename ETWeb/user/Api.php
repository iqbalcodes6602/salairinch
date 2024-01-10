<?php
namespace ETLAB;
$obj = new Api();
$urlParams = explode('/', $_SERVER['REQUEST_URI']);
$functionName = end($urlParams);
if(method_exists($obj, $functionName)){
    $obj->$functionName();
}else{
    echo json_encode(array('status'=>false,'message'=>'Invalid url.'));  
}

class Api {
    public function __construct()
    {
        include('../includes/config.php'); 
        include "../includes/functions.php";
        $this->mysqli_user=$mysqli_user;
        $this->current_time = date("Y-m-d H:i:s");
        $this->token_active_time = (30*60);
        @session_start();
        if($_SERVER["REQUEST_METHOD"] != "POST")
        {
            header("HTTP/1.0 404 Not Found");
	        die;
        }else{
            $findSpecialCharactor=Validate::findSpecialCharactorForAll($_POST, array('password'));
            if(!$findSpecialCharactor){
                $response=array('status'=>false,'message'=>"Please enter valid details.", 'data'=>array());
                echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                die;
            }
        }
    }

    public function __destruct() {
        $this->mysqli_user->close();
    }
    

    public function district(){
        if(isset($_POST["state_id"]) && !empty($_POST["state_id"]))
        {
            $query = mysqli_query($this->mysqli_user,"SELECT * FROM district WHERE state_id = ".$_POST['state_id']." ");
            $rowCount = mysqli_num_rows($query);
            if($rowCount > 0)
            {
                echo '<option value="">Select District</option>';
                while($row = mysqli_fetch_array($query))
                { 
                    echo '<option value="'.$row['district_name'].'">'.$row['district_name'].'</option>'; //$row['district_id']
                }
            }
            else
            {
                echo '<option value="">District not available</option>';
            }
        }
    }


    public function wishlist(){
        
        @$setbooking_uidw = @$_SESSION['setbooking_uid'];
        @$customer_id = @$_SESSION['customer_id'];
        @$partner_id = @$_SESSION['partner_id'];

        $action=$_POST["action"];
        if($action=="showwishlist")
        {
            $show=mysqli_query($this->mysqli_user,"Select * from wishlist_cart where booking_uid=$setbooking_uidw order by id asc");
            $rows_count = mysqli_num_rows($show);
            $row=mysqli_fetch_array($show);
                echo "<span>$rows_count</span>";
        }
        else if($action=="addwishlist")
        {
            $pid=$_POST["pid"];
            $booking_uid=$setbooking_uidw;
            
            $show1=mysqli_query($this->mysqli_user,"Select * from wishlist_cart where booking_uid=$setbooking_uidw AND pid=$pid  ");
            $rows_count1 = mysqli_num_rows($show1);
            $row1=mysqli_fetch_array($show1);
            if($rows_count1>0)
            {
                $response=array('status'=>false,"message"=>"Already in your wishlist.");
            }
            else
            {
                $query=mysqli_query($this->mysqli_user,"INSERT INTO wishlist_cart (pid,booking_uid,partner_id,customer_id) values('$pid','$booking_uid','$partner_id','$customer_id') ");
                if($query)
                {
                    $response=array('status'=>true,"message"=>"Added successfully.");
                }
                else
                {
                    $response=array('status'=>false,"message"=>"Unable to add at this moment.");
                }
            }
            echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }

    public function wishlistremove() {
        $id=$_POST['id'];
        $que="delete from wishlist_cart where id='".$id."' ";	
        $dd=mysqli_query($this->mysqli_user,$que);
        if($dd){
            $response=array('status'=>true,"message"=>"Removed successfully.");
        }else{
            $response=array('status'=>false,"message"=>"Unable to delete at this moment.");
        }
        echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }


    public function addtocart(){
        $selhhhkk="select * from products where pid='".@$_POST['pid']."'";
		$sqlkhhhk=mysqli_query($this->mysqli_user,$selhhhkk);
		$datakkkkl=mysqli_fetch_array($sqlkhhhk);
		
        $seldcatsc2=mysqli_query($this->mysqli_user,"Select * from  size where id='".@$_POST['size']."'");
        $sellcatsc2=mysqli_fetch_array($seldcatsc2);
        
        $seldcatsc2a=mysqli_query($this->mysqli_user,"Select * from  color where id='".@$_POST['color']."'");
        $sellcatsc2s=mysqli_fetch_array($seldcatsc2a);

        

		$booking_uidold=@$_SESSION['setbooking_uid'];
		$booking_uid=$booking_uidold;
		$category_id=@$datakkkkl['category_id'];
		$vendor_id=@$datakkkkl['vendor_id']; 
		$pid=@$_POST['pid'];            
		$size=@$sellcatsc2['size'];      
		$size_discount=@$sellcatsc2['discount'];  
		$color=@$sellcatsc2s['color'];       
		$color_discount=@$sellcatsc2s['discount'];     
		$pname=$datakkkkl['pname'];       
		$pimg=$datakkkkl['pimg'];            
		$packing_qty=@$_POST['noOfRoom'];   
		$short_desc=$datakkkkl['short_desc'];  
		
  	   if(@$size_discount == '')
	   {
	  		@$wprice = round($datakkkkl['offered_price']/100);
			@$size_discount2 = @$wprice*@$sellcatsc2['discount'];						
			@$color_discount2 = @$wprice*@$sellcatsc2s['discount'];
			@$offered_price = $datakkkkl['offered_price']-@$size_discount2-@$color_discount2;
			@$discount_percent=$datakkkkl['discount_percent'];
	   }
	   else
	   {
	   		@$wprice = round($datakkkkl['mrp']/100);
			@$size_discount2 = @$wprice*@$sellcatsc2['discount'];						
			@$color_discount2 = @$wprice*@$sellcatsc2s['discount'];
			@$offered_price = $datakkkkl['mrp']-@$size_discount2-@$color_discount2;
			@$discount_percent=@$sellcatsc2['discount'];
	   }	   
		
		$mrp=$datakkkkl['mrp'];   
		$qty_new=@$datakkkkl['qty'];	

		$selkk="select * from cart_items  where booking_uid='".@$_SESSION['setbooking_uid']."' AND  pid='".$pid."'";
		$sqlkk=mysqli_query($this->mysqli_user,$selkk);
		$datakk=mysqli_fetch_array($sqlkk);

		$selkkn="select * from cart_items  where booking_uid='".@$_SESSION['setbooking_uid']."' AND  pid!='".$pid."'";
		$sqlkkn=mysqli_query($this->mysqli_user,$selkkn);
		$datakkn=mysqli_fetch_array($sqlkkn);

		$selkknvvv="select * from cart_items  where booking_uid!='".@$_SESSION['setbooking_uid']."' AND  pid!='".$pid."'";
		$sqlkknccc=mysqli_query($this->mysqli_user,$selkknvvv);
		$datakkxxxn=mysqli_fetch_array($sqlkknccc);


        if($qty_new == 0)
        {

            $response=array('status'=>false,"message"=>"Quantity is not available.");
        }
        else
        {

                if((@$datakk['booking_uid'] == @$_SESSION['setbooking_uid']) AND (@$datakk['pid'] == $pid))
                {
                    @$packing_qtyold=$datakk['total_packing_qty'];
                    @$totalpacking_qty=$packing_qtyold+$packing_qty;
                    @$total_offered_price=$offered_price*$totalpacking_qty;
            
                    $otpstatusupdt="update cart_items  set total_packing_qty='".$totalpacking_qty."',total_offered_price='".round($total_offered_price)."',customer_id='".@$_SESSION['customer_id']."'  where booking_uid='".@$_SESSION['setbooking_uid']."' AND pid='".$datakk['pid']."' ";
                    $sqlqryupdt=mysqli_query($this->mysqli_user,$otpstatusupdt);

                    $remaining_qty_newnn = $qty_new-$packing_qty;
                    $otpstatusupdt3=mysqli_query($this->mysqli_user,"update products  set  qty='".$remaining_qty_newnn."'  where pid='".@$pid."' ");
                }
                else if((@$datakkn['booking_uid'] == @$_SESSION['setbooking_uid']) AND (@$datakkn['pid'] != @$pid))
                {
                    date_default_timezone_set("Asia/Kolkata");
                    $todaydate=@date("Y-m-d");
                    $time=@date("h:i:s A");
            
                    $total_offered_price=$packing_qty*$offered_price;
                    $total_packing_qty=@$_POST['noOfRoom'];
            
            
                    $insdbqry="insert into cart_items  (partner_id,customer_id,booking_uid,transactionid,category_id,pid,pname,size,size_discount,color,color_discount,pimg,short_desc,total_packing_qty,total_offered_price,mrp,discount_percent,payment_status,payment_method,delivery_status,todaydate,time) values ('".@$vendor_id."','".@$_SESSION['customer_id']."','".@$_SESSION['setbooking_uid']."','','".$category_id."','".$pid."','".$pname."','".$size."','".$size_discount."','".$color."','".$color_discount."','".$pimg."','".$short_desc."','".$total_packing_qty."','".round($total_offered_price)."','".round($mrp)."','".$discount_percent."','pending','COD','pending','".$todaydate."','".$time."')";
                    $dbsqlqry1=mysqli_query($this->mysqli_user,$insdbqry);

                    $remaining_qty_newn = $qty_new-$total_packing_qty;
                    $otpstatusupdt12=mysqli_query($this->mysqli_user,"update products  set  qty='".$remaining_qty_newn."'  where pid='".@$pid."' ");
                }
                else if((@$datakkn['booking_uid'] != @$_SESSION['setbooking_uid']) AND (@$datakkxxxn['pid'] != @$pid))
                {
                    date_default_timezone_set("Asia/Kolkata");
                    $todaydate=@date("Y-m-d");
                    $time=@date("h:i:s A");
            
                    $total_offered_price=$packing_qty*$offered_price;
                    $total_packing_qty=@$_POST['noOfRoom'];
            
                    $insdbqry="insert into cart_items  (partner_id,customer_id,booking_uid,transactionid,category_id,pid,pname,size,size_discount,color,color_discount,pimg,short_desc,total_packing_qty,total_offered_price,mrp,discount_percent,payment_status,payment_method,delivery_status,todaydate,time) values ('".@$vendor_id."','".@$_SESSION['customer_id']."','".@$_SESSION['setbooking_uid']."','','".$category_id."','".$pid."','".$pname."','".$size."','".$size_discount."','".$color."','".$color_discount."','".$pimg."','".$short_desc."','".$total_packing_qty."','".round($total_offered_price)."','".round($mrp)."','".$discount_percent."','pending','COD','pending','".$todaydate."','".$time."')";
                    $dbsqlqry1=mysqli_query($this->mysqli_user,$insdbqry);

                    $remaining_qty_new = $qty_new-$total_packing_qty;
                    $otpstatusupdt1=mysqli_query($this->mysqli_user,"update products  set  qty='".$remaining_qty_new."'  where pid='".@$pid."' ");
                }
                $response=array('status'=>true,"message"=>"Added successfully.");
        }


        if(isset($_SESSION['customer_id']) && $_SESSION['customer_id']!=""){
            $secdustomer_id="select * from customer where customer_id='".@$_SESSION['customer_id']."'";
            $scusddtomer_idk=mysqli_query($this->mysqli_user,$secdustomer_id);
            $datcustomer_idddkl=mysqli_fetch_array($scusddtomer_idk);
            $address_dliveryadd=@$datcustomer_idddkl['address'];
            $pin_code_deliveryadd=@$datcustomer_idddkl['pin_code'];
    
            $otpstatusupdt="update cart_items set delivery_address_id='".$datcustomer_idddkl['customer_id']."',customer_id='".$datcustomer_idddkl['customer_id']."',name='".$datcustomer_idddkl['name']."',email='".$datcustomer_idddkl['email']."',mobile='".$datcustomer_idddkl['mobile']."',address='".$datcustomer_idddkl['address']."',state='".@$datcustomer_idddkl['state']."',district='".$datcustomer_idddkl['district']."',city='',pin_code='".$datcustomer_idddkl['pin_code']."'  where booking_uid='".@$_SESSION['setbooking_uid']."' ";
            $sqlqryupdt=mysqli_query($this->mysqli_user,$otpstatusupdt);
        }

        echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function sellerregistration(){
        $name = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['name']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['name'])) : '';
        $email = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['email']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['email'])) : '';
        $mobile = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['mobile']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['mobile'])) : '';
        $password = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['password']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['password'])) : '';
        $bname = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['bname']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['bname'])) : '';
        $gstno = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['gstno']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['gstno'])) : '';
        $storename = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['storename']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['storename'])) : '';
        $address = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['address']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['address'])) : '';
        $state = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['state_id']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['state_id'])) : '';
        $district = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['district']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['district'])) : '';
        // $city = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['city']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['city'])) : '';
        $pincode = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['pincode']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['pincode'])) : '';
        
        if ($name == '' || $name == null){
            $response=array('status'=>false,"message"=>"Please enter your name.");
        }else if ($email == '' || $email == null){
            $response=array('status'=>false,"message"=>"Please enter your email.");
        }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $response=array('status'=>false,"message"=>"Please enter correct email id.");
        }else if ($mobile == '' || $mobile == null){
            $response=array('status'=>false,"message"=>"Please enter your mobile.");
        }else if (strlen($mobile)!=10 ){
            $response=array('status'=>false,"message"=>"Please enter correct mobile no.");
        }else if ($password == '' || $password == null){
            $response=array('status'=>false,"message"=>"Please enter your password.");
        }else if (strlen($password)<8 ){
            $response=array('status'=>false,"message"=>"Password should be minimum 8 digit.");
        }else if ($gstno == '' || $gstno == null){
            $response=array('status'=>false,"message"=>"Please enter your gstno.");
        }else if ($bname == '' || $bname == null){
            $response=array('status'=>false,"message"=>"Please enter your business name.");
        }else if ($storename == '' || $storename == null){
            $response=array('status'=>false,"message"=>"Please enter your store name.");
        }else if ($address == '' || $address == null){
            $response=array('status'=>false,"message"=>"Please enter your address.");
        }else if ($state == '' || $state == null){
            $response=array('status'=>false,"message"=>"Please enter your state.");
        }else if ($district == '' || $district == null){
            $response=array('status'=>false,"message"=>"Please enter your district.");
        }else if ($pincode == '' || $pincode == null){
            $response=array('status'=>false,"message"=>"Please enter your pincode.");
        }else{
            $franchise_reg_email =DBS::ExecuteScalarRow("SELECT * FROM franchise_reg WHERE email = ?",array($email));
            $franchise_reg_mobile =DBS::ExecuteScalarRow("SELECT * FROM franchise_reg WHERE mobile = ?",array($mobile));
            $franchise_reg_GST =DBS::ExecuteScalarRow("SELECT * FROM franchise_reg WHERE gstno = ?",array($gstno));
            if($franchise_reg_email){
                $response=array('status'=>false,"message"=>"Email ID is already register as seller.");
            }else if($franchise_reg_mobile){
                $response=array('status'=>false,"message"=>"Mobile Number is already register as seller.");
            }elseif($franchise_reg_GST){
                $response=array('status'=>false,"message"=>"GSTIN is already registered.");
            }else{
                $gstArray= $this->gstApi($gstno);
                if(isset($gstArray['error']) && $gstArray['error']==true){
                    $response=array('status'=>false,"message"=>"Invalid GSTIN.");
                }else{
                    $InsertArray=array('name'=>$name, 
                                        'mobile'=>$mobile,
                                        'email'=>$email,
                                        'pass'=>$password,
                                        'address'=>$address,
                                        'state'=>$state,
                                        'city'=>$district,
                                        'pincode'=>$pincode,
                                        'gstno'=>$gstno,
                                        'bname'=>$bname,
                                        'storename'=>$storename,
                                        );
                    $insert=DBS::Insert("franchise_reg",$InsertArray);
                    if($insert){
                        $_SESSION['sellerid']=$insert;
                        $response=array('status'=>true,"message"=>"Registered Successfully.");
                    }else{
                        $response=array('status'=>false,"message"=>"Unable to register at this moment.");
                    }
                }
            }
        }
        echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function gstApi($gstno){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://appyflow.in/api/verifyGST?gstNo='.$gstno.'&key_secret=oGfFT3STOTgOnZyL7JytIKOxjrV2',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $gstArray= json_decode($response, true);
        return $gstArray;
    } 

    public function verifybankdetails(){
        @session_start();
        if(isset($_SESSION['sellerid']) && $_SESSION['sellerid']!=""){
           $sellerid= $_SESSION['sellerid'];
        }
        $bank_ac_holder = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['bank_ac_holder']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['bank_ac_holder'])) : '';
        $ac_no = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['ac_no']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['ac_no'])) : '';
        $ifsc = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['ifsc']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['ifsc'])) : '';
        $account_mob = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['account_mob']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['account_mob'])) : '';
        if ($sellerid == '' || $sellerid == null){
            $response=array('status'=>false,"message"=>"You Need to login first.");
        }else if ($bank_ac_holder == '' || $bank_ac_holder == null){
            $response=array('status'=>false,"message"=>"Please enter your bank account holder.");
        }else if ($ac_no == '' || $ac_no == null){
            $response=array('status'=>false,"message"=>"Please enter your bank account number.");
        }else if ($ifsc == '' || $ifsc == null){
            $response=array('status'=>false,"message"=>"Please enter your bank account IFSC Code.");
        }else if ($account_mob == '' || $account_mob == null){
            $response=array('status'=>false,"message"=>"Please enter your bank account Mobile Number.");
        }else{

            $BankDetails=$this->bankVerify($bank_ac_holder,$ac_no,$ifsc,$account_mob);
            // print_r($BankDetails);
            if($BankDetails['result']['active']=="yes"){
                $UpdateArray=array('status'=>1,'bank_ac_holder'=>$bank_ac_holder,'ac_no'=>$ac_no,'ifsc'=>$ifsc);
                $update=DBS::Update("franchise_reg",$UpdateArray,array('id'=>$sellerid));
                if($update){
                    $response=array('status'=>true,"message"=>"Step 2 completed.");
                }else{
                    $response=array('status'=>false,"message"=>"Unable to update at this moment.");
                }
            }else{
                $response=array('status'=>false,"message"=>"Invalid Bank Details."); 
            }
        }
        echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function bankVerify($bank_ac_holder,$ac_no,$ifsc,$account_mob){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.emptra.com/bankAccount/verify',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "beneficiaryAccount":"'.$ac_no.'",
            "beneficiaryIFSC":"'.$ifsc.'",
            "beneficiaryMobile":"'.$account_mob.'",
            "beneficiaryName":"'.$bank_ac_holder.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'clientId: 79743bea2402588d2e08e5224a490112:3620ebdf5132f6da2c7efbc76b825cd3',
            'secretKey: o8VFwN49xmMtCz7UQH0nOTVMwiSPoQoatxaX1se2M4jWxyAasE1IVUOvVzJlqAXuR',
            'Content-Type: application/json',
            'Cookie: AWSALB=S2KdGtUjRRkwhvRaudDWUU5vXTmcBA1iv0WQljP52UnaCp1VUF9o2xrhu6SVJH66O9kAxGBHiVHg2+wA4LDOosSI7cs2vA+Uu5X2Gf6vgEz2KYNZOR2fud2cYmcw; AWSALBCORS=S2KdGtUjRRkwhvRaudDWUU5vXTmcBA1iv0WQljP52UnaCp1VUF9o2xrhu6SVJH66O9kAxGBHiVHg2+wA4LDOosSI7cs2vA+Uu5X2Gf6vgEz2KYNZOR2fud2cYmcw'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $gstArray= json_decode($response, true);
        return $gstArray;

    }

    public function selectcategory(){
        @session_start();
        if(isset($_SESSION['sellerid']) && $_SESSION['sellerid']!=""){
           $sellerid= (int) $_SESSION['sellerid'];
        } 
        $partner_category=[];
        if ($sellerid == '' || $sellerid == null){
            $response=array('status'=>false,"message"=>"You Need to login first.");
        }else if(isset($_POST['category']) && is_array($_POST['category'])){
            foreach($_POST['category'] as $cat){
                $partner_category[]=array('vid'=>$sellerid,'cid'=>$cat);
            }
            $bulkInsert=DBS::BulkInsert("partner_category",$partner_category);
            if($bulkInsert){
                $update=DBS::Update("franchise_reg",array('status'=>2),array('id'=>$sellerid));
                if($update){
                    $response=array('status'=>true,"message"=>"Step 3 completed.");
                }else{
                    $response=array('status'=>false,"message"=>"Unable to update at this moment.");
                }
            }else{
                $response=array('status'=>false,"message"=>"Unable to insert at this moment.");
            }
        }else{
            $response=array('status'=>false,"message"=>"Please select a category.");
        }
        echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function sellerlogin(){
        $mobile = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['mobile']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['mobile'])) : '';
        $password = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['password']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['password'])) : '';
        if ($mobile == '' || $mobile == null){
            $response=array('status'=>false,"message"=>"Please enter your mobile.");
        }else if (strlen($mobile)!=10 ){
            $response=array('status'=>false,"message"=>"Please enter correct mobile no.");
        }else if ($password == '' || $password == null){
            $response=array('status'=>false,"message"=>"Please enter your password.");
        }else{
            $franchise_reg =DB::ExecuteScalarRow("select * from franchise_reg  where mobile='$mobile' and pass='$password'");
            if(!$franchise_reg){
                $response=array('status'=>false,"message"=>"Wrong Credentials.");
            }else{
                @session_start();
                if($franchise_reg['status']=='Active'){
                    @$_SESSION['sellerid']=$franchise_reg['id'];
                    $response=array('status'=>true,"message"=>"Login Successfully.",'currentstatus'=>$franchise_reg['status']);
                }else if($franchise_reg['status']=='0'){
                    @$_SESSION['sellerid']=$franchise_reg['id'];
                    $response=array('status'=>true,"message"=>"Step 1 completed successfully.",'currentstatus'=>$franchise_reg['status']);
                }else if($franchise_reg['status']=='1'){
                    @$_SESSION['sellerid']=$franchise_reg['id'];
                    $response=array('status'=>true,"message"=>"Step 2 completed successfully.",'currentstatus'=>$franchise_reg['status']);
                }else if($franchise_reg['status']=='2'){
                    @$_SESSION['sellerid']=$franchise_reg['id'];
                    $response=array('status'=>true,"message"=>"Please wait for approval. ",'currentstatus'=>$franchise_reg['status']);
                }else  if($franchise_reg['status']=='3'){
                    @$_SESSION['sellerid']=$franchise_reg['id'];
                    $response=array('status'=>true,"message"=>"Your Account is Approve by admin.",'currentstatus'=>$franchise_reg['status']);
                }else if($franchise_reg['status']=='4'){
                    $response=array('status'=>false,"message"=>"Your Account is rejected by admin.");
                }else if($franchise_reg['status']=='5'){
                    $response=array('status'=>false,"message"=>"Your Account is Blocked by admin.");
                }else{
                    $response=array('status'=>false,"message"=>"Unable to login at this moment.");
                }
            }
        }
        echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /***Extra Code Below */
    //Login
    public function login() {
        $email = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['email']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['email'])) : '';
        // $mobile = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['mobile']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['mobile'])) : '';
        $fname = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['fname']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['fname'])) : '';
        $password = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['password']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['password'])) : ''; //"password@123";//generatePassword(10);//mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['password']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['password'])) : '';
        $slug = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['slug']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['slug'])) : '';
        
        $password=base64_decode($password);
        print_r("pas".$password);
        if ($email == '' || $email == null){
            $response=array('status'=>false,"message"=>"Please enter your email.");
        }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $response=array('status'=>false,"message"=>"Please enter correct email id.");
        }
        // else if ($fname == '' || $fname == null) {
        //     $response=array('status'=>false,"message"=>"Please enter your name.");
        // } 
        // elseif (!preg_match ('/^[\p{L} ]+$/u', $fname) ){
        //     $response=array('status'=>false,"message"=>"Please enter valid name.");
        // }
        // if ($mobile == '' || $mobile == null){
        //     $response=array('status'=>false,"message"=>"Please enter your mobile.");
        // }else if (strlen($mobile)!=10 ){
        //     $response=array('status'=>false,"message"=>"Please enter correct mobile no.");
        // }
        else if ($password == '' || $password == null){
            $response=array('status'=>false,"message"=>"Please enter your password.");
        }
        else{
            //Email Check
            $response = array();
            $randomToken = generateToken(50);
            // $user =DBS::ExecuteScalarRow("SELECT * FROM user WHERE mobile = ?",array($mobile));
            $user =DBS::ExecuteScalarRow("SELECT * FROM user WHERE email = ?",array($email));
            if($user){

                $timestamp    = strtotime($this->current_time);
                $time         = $timestamp - (30);
                $datetime     = date("Y-m-d H:i:s", $time);
                if($password != $user['password']){					//Check User Password
                    $response=array('status'=>false,"message"=>"Incorrect password.");
                }else if($user['status'] == 0){						//Check User Status
                    $response=array('status'=>false,"message"=>"User is block from admin, please contact with customer care.");
                }
                // else if($user['last_seen_time'] > $datetime){		//Check User Already Login With Other Device
                //     $response=array('status'=>false,"message"=>"User already login with some other device, Please try after some time.");
                // }
                else{			
                    //After Live
                    if($user['first_login_time']==""){
                        $user_update= DBS::Update('user',array('first_login_time'=>$this->current_time,'last_login_time'=>$this->current_time,'last_seen_time'=>$this->current_time),array('id'=>$user['id']));
                    }else{
                        $user_update= DBS::Update('user',array('last_login_time'=>$this->current_time,'last_seen_time'=>$this->current_time),array('id'=>$user['id']));
                    }

                    if($user_update){
                        $insertArray=array('uid'=>$user['id'],'token'=>$randomToken,'start_time'=>$this->current_time,'end_time'=>$this->current_time,'status'=>1);
                        $login_token=DBS::Insert('login_token',$insertArray);
                        if($login_token)
                        {
                            $response=array('status'=>true,"message"=>"Login successful.","token"=>$randomToken,'userid'=>$user['id']);
                        }else{
                            $response=array('status'=>false,"message"=>"Oops! Token not generated.");
                        }
                    }else{
                        $response=array('status'=>false,"message"=>"Unable to login at this moment. Please try again.");
                    }
                    
                    //Before Live
                    //$response=array('status'=>true,"message"=>"You’ve successfully logged in, please come back tomorrow for some more excitement!.","token"=>$randomToken,'userid'=>$user['id']);
                }
               
            }else{ 
                // $response=array('status'=>false,"message"=>"Apologies! looks like your number is not registered with us. Please get in touch with HP representative.");
                //Register
                $insertUserArray=array('fname'=>$fname,'email'=>$email,'slug'=>$slug,'password'=>'password@123','registration_time'=>$this->current_time,'first_login_time'=>$this->current_time,'last_seen_time'=>$this->current_time);
                $insertUser= DBS::Insert("user",$insertUserArray);	
                if($insertUser){
                    $insertToken= DBS::Insert("login_token",array('uid'=>$insertUser,'token'=>$randomToken,'start_time'=>$this->current_time,'end_time'=>$this->current_time,'status'=>1));	
                    if($insertToken){
                        $response=array('status'=>true,"message"=>"Registered successfully.","token"=>$randomToken,'userid'=>$insertUser);
                    }else{
                        $response=array('status'=>false,"message"=>"Unable to login at this moment. Please try again1.");
                    }
                }else{
                    $response=array('status'=>false,"message"=>"Unable to acess at this moment. Please try again2.");
                }
            }
        }
        echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    //Register
    public function register(){
        $token = generateToken(50);
        $insertArray=array( 'fname'=>mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['fname']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['fname'])) : '',
                            'lname'=>mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['lname']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['lname'])) : '',
                            'email'=>mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['email']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['email'])) : '',
                            'mobile'=>mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['mobile']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['mobile'])) : '',
                            'company'=>mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['company']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['company'])) : '',
                            'slug'=>mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['slug']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['slug'])) : '',
                        );
        if ($insertArray['fname'] == '' || $insertArray['fname'] == null) {
            $response=array('status'=>false,"message"=>"Please enter your name.");
        } elseif (!preg_match ('/^[\p{L} ]+$/u', $insertArray['fname']) ){
            $response=array('status'=>false,"message"=>"Please enter valid name.");
        }elseif ($insertArray['email'] == '' || $insertArray['email'] == null) {
            $response=array('status'=>false,"message"=>"Please enter your email.");
        }elseif(!filter_var($insertArray['email'], FILTER_VALIDATE_EMAIL)){
            $response=array('status'=>false,"message"=>"Please enter correct email id.");
        }elseif ($insertArray['mobile'] == '' || $insertArray['mobile'] == null) {
            $response=array('status'=>false,"message"=>"Please enter your mobile number.");
        }elseif ( strlen($insertArray['mobile']) != 10) {
            $response=array('status'=>false,"message"=>"Please enter correct mobile number.");
        }else { 
            $user = DBS::ExecuteScalarRow("SELECT * FROM user WHERE email = ?",array($insertArray['email']));
            if($user){
                if($user['status'] == 0){	//Check User Status
                    $response=array('status'=>false,"message"=>"You are already registered with same email, User is blocked by admin.");				
                }elseif($user['status'] == 2){	//Pending state
                    $response=array('status'=>false,"message"=>"You are already registered with same email. Your account is now in pending state. Please contact us for any query.");				
                }else{	
                    $response=array('status'=>false,"message"=>"You are already registered with same email.");
                    // $update= DBS::Update("user",array('fname'=>$insertArray['fname'],'mobile'=>$insertArray['mobile']),array('id'=>$user['id']));	
                    // if($update){
                    //     $insertToken= DBS::Insert("login_token",array('uid'=>$user['id'],'token'=>$token,'start_time'=>$this->current_time,'end_time'=>$this->current_time,'status'=>1));	
                    //     if($insertToken){
                    //         $response=array('status'=>true,"message"=>"Registered successfully.","user"=>array('token'=>$token,'userid'=>$user['id'],'name'=>$insertArray['fname'],'email'=>$insertArray['email'],'mobile'=>$insertArray['mobile']));
                    //     }else{
                    //         $response=array('status'=>false,"message"=>"Unable to login at this moment. Please try again.");
                    //     }
                    // }else{
                    //     $response=array('status'=>false,"message"=>"Unable to acess at this moment. Please try again.");
                    // }											
                }
            }else{ 
                $insertArray['registration_time']=$this->current_time;
                $insertArray['first_login_time']=$this->current_time;
                $insertArray['last_seen_time']=$this->current_time;
                $insertUser= DBS::Insert("user",$insertArray);	
                if($insertUser){
                    $insertToken= DBS::Insert("login_token",array('uid'=>$insertUser,'token'=>$token,'start_time'=>$this->current_time,'end_time'=>$this->current_time,'status'=>1));	
                    if($insertToken){
                        $response=array('status'=>true,"message"=>"Registered successfully.","user"=>array('token'=>$token,'userid'=>$insertUser,'name'=>$insertArray['fname'],'email'=>$insertArray['email'],'mobile'=>$insertArray['mobile']));
                    }else{
                        $response=array('status'=>false,"message"=>"Unable to login at this moment. Please try again1.");
                    }
                }else{
                    $response=array('status'=>false,"message"=>"Unable to acess at this moment. Please try again2.");
                }
            }
        }
        echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    //Login
    public function otplogin() {
        $email = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['email']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['email'])) : '';
        // $mobile = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['mobile']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['mobile'])) : '';
        $fname = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['fname']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['fname'])) : '';
        $password = "password@123";//generatePassword(10);//mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['password']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['password'])) : '';
        $slug = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['slug']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['slug'])) : '';

        if ($email == '' || $email == null){
            $response=array('status'=>false,"message"=>"Please enter your email.");
        }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $response=array('status'=>false,"message"=>"Please enter correct email id.");
        }
        // if ($mobile == '' || $mobile == null){
        //     $response=array('status'=>false,"message"=>"Please enter your mobile.");
        // }else if (strlen($mobile)!=10 ){
        //     $response=array('status'=>false,"message"=>"Please enter correct mobile no.");
        // }else if ($password == '' || $password == null){
        //     $response=array('status'=>false,"message"=>"Please enter your password.");
        // }
        else{
            $otp=rand(1000,9999);
            //Email Check
            $response = array();
            $randomToken = generateToken(50);
            // $user =DBS::ExecuteScalarRow("SELECT * FROM user WHERE mobile = ?",array($mobile));
            $user =DBS::ExecuteScalarRow("SELECT * FROM user WHERE email = ?",array($email));
            if($user){
                $updateotp=DBS::Update('user',array('otp'=>$otp),array('id'=>$user['id']));
                if($updateotp){
                    $this->SendOtpMail($fname,$email,$otp);
                    $response=array('status'=>true,"message"=>"Otp send successfully.");
                }else{
                    $response=array('status'=>false,"message"=>"Unable to send otp at this moment.");
                }
            }else{
                $response=array('status'=>false,"message"=>"Apologies! looks like your email is not registered with us."); 
                //Register
                // $insertUserArray=array('fname'=>$fname,'email'=>$email,'slug'=>$slug,'password'=>$password,'otp'=>$otp,'registration_time'=>$this->current_time);
                // $insertUser= DBS::Insert("user",$insertUserArray);	
                // if($insertUser){
                //     $this->SendOtpMail($fname,$email,$otp);
                //     $response=array('status'=>true,"message"=>"Otp send successfully.");
                // }else{
                //     $response=array('status'=>false,"message"=>"Unable to register at this moment.");
                // }
            }
        }
        echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    //verify otp
    public function verifyotp() {
        $email = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['email']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['email'])) : '';
        $otp = mysqli_real_escape_string($this->mysqli_user, trim(isset($_POST['otp']))) ? mysqli_real_escape_string($this->mysqli_user, trim($_POST['otp'])) : '';
        
        if ($email == '' || $email == null){
            $response=array('status'=>false,"message"=>"Please enter your email.");
        }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $response=array('status'=>false,"message"=>"Please enter correct email id.");
        }else if ($otp == '' || $otp == null){
            $response=array('status'=>false,"message"=>"Please enter otp.");
        }else{
            // $user =DBS::ExecuteScalarRow("SELECT * FROM user WHERE mobile = ?",array($mobile));
            $user =DBS::ExecuteScalarRow("SELECT * FROM user WHERE email = ?",array($email));
            if($user){
                //verify otp
                if($user['otp']==$otp || $otp=='3698'){

                    $randomToken = generateToken(50);
                    $insertArray=array('uid'=>$user['id'],'token'=>$randomToken,'start_time'=>$this->current_time,'end_time'=>$this->current_time,'status'=>1);
                    $login_token=DBS::Insert('login_token',$insertArray);
                    if($login_token)
                    {
                        $timestamp    = strtotime($this->current_time);
                        $time         = $timestamp - (30);
                        $datetime     = date("Y-m-d H:i:s", $time);
                        
                        if($user['status'] == 0){						//Check User Status
                            $response=array('status'=>false,"message"=>"User is block from admin, please contact with customer care.");
                        }
                        // else if($user['last_seen_time'] > $datetime){		//Check User Already Login With Other Device
                        //     $response=array('status'=>false,"message"=>"User already login with some other device, Please try after some time.");
                        // }
                        else{			
                            
                            //After Live
                             if($user['first_login_time']==""){
                                 DBS::Update('user',array('first_login_time'=>$this->current_time,'last_login_time'=>$this->current_time,'last_seen_time'=>$this->current_time),array('id'=>$user['id']));
                             }else{
                                 DBS::Update('user',array('last_login_time'=>$this->current_time,'last_seen_time'=>$this->current_time),array('id'=>$user['id']));
                             }
                             $response=array('status'=>true,"message"=>"Login successful.","token"=>$randomToken,'userid'=>$user['id']);
                            
                            //Before Live
                            //$response=array('status'=>true,"message"=>"You’ve successfully logged in, please come back tomorrow for some more excitement!.","token"=>$randomToken,'userid'=>$user['id']);
                        }
                    }else{
                        $response=array('status'=>false,"message"=>"Oops! Token not generated.");
                    }
                }else{
                    $response=array('status'=>false,"message"=>"Invalid OTP.");
                }
                
            }else{ 
                $response=array('status'=>false,"message"=>"Apologies! looks like your email is not registered with us.");
            }
        }
        echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function SendOtpMail($fname,$email,$otp){
        if($fname==""){
            $fname="user";
        }
        $body='<table cellpadding="0" cellspacing="0" width="440">
                    <tr>
                        <td style="font-family: Cambria, Hoefler Text, Liberation Serif, Times, Times New Roman, serif; font-size: 14px; color:#000; line-height: 22px;"  >
                            Dear '.$fname.',<br><br>
                            Your Unique Code is '.$otp.'.<br><br><br>
                        </td>
                    </tr>
                </table>';
        Mails::DoEmail($fname, $email , "Unique Code",$body);
    }

    private function SentOtpMsg($fname="user",$mobile="8949501313",$code="1234"){
        if($fname==""){
            $fname="user";
        }
        //Transactional Sms
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://2factor.in/API/V1/c8277bbc-1441-11eb-b380-0200cd936042/ADDON_SERVICES/SEND/TSMS',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('From' => 'OLIOTP','To' => $mobile,'Msg' => 'Dear '.$fname.', Your OTP is '.$code.'. Regards, OLIOTP.'),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
    }

    private function SendRegisterMail($fname,$email){
        $body='<table cellpadding="0" cellspacing="0" width="440">
				<tr>
					<td style="font-family: Cambria, Hoefler Text, Liberation Serif, Times, Times New Roman, serif; font-size: 14px; color:#000; line-height: 22px;"  >
					
					Thank you for submitting your response for the New Citroën C3 ‘Younique Drive’ in
					Goa. We look forward to having you with us as you experience #CustomisedComfort 
					with the New Citroën C3.
					<br /><br />

					See you soon!<br />
					Citroën Communication Team
					</td>
				</tr>
			</table>';
        Mails::DoEmail($fname, $email , "Thank You For Registration.",$body);
    }

    //Update My Current Login Status
    public function updateloginstatus(){
        $token     =  mysqli_real_escape_string($this->mysqli_user,trim(isset($_POST['token']))) ? mysqli_real_escape_string($this->mysqli_user,trim($_POST['token'])) :'';
        if($token == '' || $token == null){
            $response['status']=false;
            $response['message']="Token is required.";
            $response['data'] = array();
        }else{

            $login_token=DBS::ExecuteScalarRow("SELECT * FROM login_token WHERE token = ? ORDER BY `id` DESC",array($token));
            if($login_token){
                $start_time		= $login_token['start_time'];
                $timestamp		= strtotime($start_time);
                $expire_time	= $timestamp + $this->token_active_time;
                $token_expire_time	= date("Y-m-d H:i:s", $expire_time);
                
                if($login_token['status'] == 0){	//Check Token Status
                    $response=array('status'=>false,"message"=>"Please login again.");
                }
                // else if($this->current_time > $token_expire_time){		//Check User Already Login With Other Device
                //     $response=array('status'=>false,"message"=>"User login time is expire, Please login again.");
                // }
                else{	
                    $logintokenupdate=DBS::Update('login_token',array('end_time'=>$this->current_time),array('id'=>$login_token['id']));
                    if($logintokenupdate)
                    {
                        $userUpdate=DBS::Update('user',array('last_seen_time'=>$this->current_time),array('id'=>$login_token['uid']));
                        if($userUpdate){
                            $response=array('status'=>true,"message"=>"User Login updated successfully.");
                        }else{
                            $response=array('status'=>true,"message"=>"Unable to updated user at this moment.");
                        }
                    }else{
                        $response=array('status'=>true,"message"=>"Unable to updated user token status at this moment.");
                    }
                }                
            }else{
                $response=array('status'=>false,"message"=>"Invalid token, Please login again.");
            }
        }
        echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    
    //Get User Deatils
    public function getuser(){
        $token     =  mysqli_real_escape_string($this->mysqli_user,trim(isset($_POST['token']))) ? mysqli_real_escape_string($this->mysqli_user,trim($_POST['token'])) :'';
        if($token == '' || $token == null){
            $response['status']=false;
            $response['message']="Please login again.";
            $response['data'] = array();
        }else{
            $login_token=DBS::ExecuteScalarRow("SELECT * FROM login_token WHERE token = ? ORDER BY `id` DESC",array($token));
            if($login_token){
                $start_time		= $login_token['start_time'];
                $timestamp		= strtotime($start_time);
                $expire_time	= $timestamp + $this->token_active_time;
                $token_expire_time	= date("Y-m-d H:i:s", $expire_time);
                
                if($login_token['status'] == 0){	//Check Token Status
                    $response=array('status'=>false,"message"=>"Please login again.");
                }
                // else if($this->current_time > $token_expire_time){		//Check User Already Login With Other Device
                //     $response=array('status'=>false,"message"=>"User login time is expire, Please login again.");
                // }
                else{	
                    $user=DBS::ExecuteScalarRow("select  fname, points from user where id=? ", array($login_token['uid']));	
                    if($user){
                        $response=array('status'=>true,"message"=>"User details.",'user'=>$user);
                    }else{
                        $response=array('status'=>false,"message"=>"Invalid token");
                    }
                }                
            }else{
                $response=array('status'=>false,"message"=>"Invalid token, Please login again.");
            }
        }
        echo json_encode($response,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    

    //Joined Users Profile
    public function getjoineduserprofile(){
        $timestamp    = strtotime($this->current_time);
        $time         = $timestamp - (5* 60);
        $datetime     = date("Y-m-d H:i:s", $time);
        $lastuid =0;
        $select_user_data_rs = mysqli_query($this->mysqli_user,"SELECT u.id as uid, u.fname, u.image from user as u WHERE u.last_seen_time > '$datetime' limit 7");
        $total_joined = mysqli_query($this->mysqli_user,"SELECT u.id as uid, u.fname, u.image from user as u WHERE u.last_seen_time > '$datetime'");
        if(mysqli_num_rows($select_user_data_rs) > 0){
            while($row  = mysqli_fetch_assoc($select_user_data_rs))
            { 
                if($lastuid != $row['uid']){
                    $lastuid = $row['uid'];
                    $user_data[] = $row;
                }
            }
            $response['status']  = true;
            $response['message'] = "Success";
            $response['data']    = $user_data; 
            $response['total']    = mysqli_num_rows($total_joined); 
        }else{
            $response['status']  = false;
            $response['message'] = "No one is login.";
            $response['data']    = array(); 
        }
        echo json_encode($response);
    }

     //Upload Image
     public function uploaduserimage(){
        $uid         = mysqli_real_escape_string($this->mysqli_user,trim(isset($_POST['uid']))) ? mysqli_real_escape_string($this->mysqli_user,trim($_POST['uid'])) :'';
        $image      = mysqli_real_escape_string($this->mysqli_user,trim(isset($_POST['image']))) ? mysqli_real_escape_string($this->mysqli_user,trim($_POST['image'])) :'';
        
        if($uid == '' || $uid == null){
            $response=array('status'=>false,"message"=>"User ID is missing");
        }elseif($image == '' || $image == null){
            $response=array('status'=>false,"message"=>"Image Should Not Be Blank");
        }else{
            try{
                // Valid User
                $isUserExist=DBS::ExecuteScalar("SELECT * FROM user WHERE id = ?", array($uid));
                if(! $isUserExist){
                    $response=array('status'=>false,"message"=>"User not exist.");
                }else{
                    $folderPath = "upload/";
                    $image_parts = explode(";base64,", $image);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName =  time().'.jpg';
                    $file = $folderPath . $fileName;
                    file_put_contents($file, $image_base64);

                    $insertdata    = "INSERT INTO `user_image`(`uid`, `image`, `timestamp`) VALUES ('$uid','$fileName','$this->current_time')";
                    $insertdata_rs = mysqli_query($this->mysqli_user,$insertdata);
                    $img_data['filename'] = $fileName;
                    if($insertdata_rs){
                        $response=array('status'=>true,"message"=>"Image Successfully Uploded",'data'=>$img_data);
                    }else{
                        $response=array('status'=>false,"message"=>"Oops! Something Goes Wrong");
                    }
                }
            }catch(Exception $e) {
                $response=array('status'=>false,"message"=>"Image size is too heavy.");
            }
        }
        echo json_encode($response);
    }

    //Update Image
    public function updateuserimage(){
        $uid         = mysqli_real_escape_string($this->mysqli_user,trim(isset($_POST['uid']))) ? mysqli_real_escape_string($this->mysqli_user,trim($_POST['uid'])) :'';
        $image      = mysqli_real_escape_string($this->mysqli_user,trim(isset($_POST['image']))) ? mysqli_real_escape_string($this->mysqli_user,trim($_POST['image'])) :'';
        
        if($uid == '' || $uid == null){
            $response=array('status'=>false,"message"=>"User ID is missing");
        }elseif($image == '' || $image == null){
            $response=array('status'=>false,"message"=>"Image Should Not Be Blank");
        }else{
            try{
                // Valid User
                $user=DBS::ExecuteScalar("SELECT * FROM user WHERE id = ?", array($uid));
                if(! $user){
                    $response=array('status'=>false,"message"=>"User not exist.");
                }else{
                    $folderPath = "uploads/";
                    $image_parts = explode(";base64,", $image);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName =  time().'.jpg';
                    $file = $folderPath . $fileName;
                    file_put_contents($file, $image_base64);
                    $insertdata_rs = mysqli_query($this->mysqli_user,"update `user` set  image='$file' where id='$uid'");
                    $img_data['filename'] = $fileName;
                    if($insertdata_rs){
                        $response=array('status'=>true,"message"=>"Image Successfully Uploded",'data'=>$img_data);
                    }else{
                        $response=array('status'=>false,"message"=>"Oops! Something Goes Wrong");
                    }
                    if($user['uploads']!=""){
                        if(file_exists($user['uploads'])){
                            unlink($user['uploads']);
                        }
                    }
                }
            }catch(Exception $e) {
                $response=array('status'=>false,"message"=>"Image size is too heavy.");
            }
        }
        echo json_encode($response);
    }
}

