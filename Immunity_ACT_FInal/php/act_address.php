<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: POST');

header("Access-Control-Allow-Headers: X-Requested-With");
$myObj = new \stdClass();

$auth_token = $_POST['authtoken'];
$auth_token = "Bearer ".$auth_token;
$product_id = $_POST['product_id'];
$product_category_id = $_POST['product_category_id'];
$item_id = $_POST['item_id'];
//  $myObj->data = $auth_token;
//  echo json_encode($myObj);
//  return;
$books_auth = "";
$organization_id = 0;
$email_code = 0;
$mapmyIndiaKey = "";
// $action = $_POST['action'];


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://protect.immunityhealth.me/api/externalToken",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => array('source' => 'Zoho,mapmyindia'),
));

$response = curl_exec($curl);
$jsondecoded = json_decode($response);
curl_close($curl);
foreach ($jsondecoded->jsonData as $myData){
    if($myData->token_name=="Books"){
        $books_auth = $myData->token_value;
//        break;
    }
    if($myData->token_name=="Organization ID"){
        $organization_id = $myData->token_value;
    }
    if($myData->token_name=="MapMyIndia"){
        $mapmyIndiaKey = $myData->token_value;
    }
}


$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://protect.immunityhealth.me/api/getUserOrders",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "Authorization:".$auth_token.""  ),
));

$response = curl_exec($curl);
$jsondecoded = json_decode($response);
curl_close($curl);
//echo $response;
foreach ($jsondecoded->jsonData as $order){
    foreach ($order->order_item as $order_item){
        if($order_item->item_id==$item_id){
            $email_code = 1002;
            break;
        }
    }
    if($email_code==1002){
        break;
    }

}

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://protect.immunityhealth.me/api/getUser",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    // CURLOPT_POSTFIELDS => "composit_item_id=5",
    CURLOPT_HTTPHEADER => array(
        "Authorization: ".$auth_token.""
    ),
));
// if(zoho ID)-> store;->logs
// if(!zohoID)->create->DB->store->logs;
// adress->show addresses;

$response = curl_exec($curl);

curl_close($curl);
// echo $response;
$jsondecoded = json_decode($response);
// $jsondecoded->response = $myObj->status;
if($jsondecoded->status!="true"){
    $myObj = new \stdClass();
    $myObj->code = 1;
    $myObj->message = "Customer Details not found";
    echo json_encode($myObj);
    return;
}
//$jsondecoded->jsonData[0]->order_item

$myObj->full_name = $jsondecoded->jsonData->name;
$user_id_immunity = $jsondecoded->jsonData->id;
$customer_name = $jsondecoded->jsonData->name;
$customer_name_array = explode(" ",$customer_name);
$user_email = $jsondecoded->jsonData->email;
$customer_type = "customer";
$contact_number = $jsondecoded->jsonData->phone_number;
if(count($customer_name_array)>1){
    $first_name = $customer_name_array[0];
    $last_name = end($customer_name_array);
    array_pop($customer_name_array);
    $first_name = implode(" ", $customer_name_array);
}
else{
    $first_name = $customer_name_array[0];
    $last_name = ".";
}
if($jsondecoded->jsonData->zoho_id){
    $customer_zoho_id = $jsondecoded->jsonData->zoho_id;
    getUserAddressess($user_email,$email_code);
}
else{
    return;
    // echo "Entered Else";
    if(!$jsondecoded->jsonData->home_location->home_lat){
        $myObj = new \stdClass();
        $myObj->code = 1;
        $myObj->message = "lat long details not found";
        echo json_encode($myObj);
        return;
    }
    $latitude = $jsondecoded->jsonData->home_location->home_lat;
    $longitude = $jsondecoded->jsonData->home_location->home_lon;
    $code = getUserAddressAPI($myObj,$mapmyIndiaKey,$latitude,$longitude);
    if($code!=200){
        return;
    }
    $address = $myObj->address;
    $pinCode = $myObj->pinCode;
    $zip = $pinCode;
    // echo $zip;
    $city = $myObj->city;
    // echo $city;
    $state = $myObj->state;
    // echo $state;
    $country = $myObj->country;
    getPincodeDetails($myObj,$auth_token,$pinCode);
    $state_code = $myObj->state_code;
    // echo $state_code;
    createCustomer($user_id_immunity,$organization_id,$books_auth,$customer_name,$first_name,$last_name,$customer_type,$user_email,$contact_number,$address,$state_code,$city,$state,$zip,$country);
    return;
    // echo json_encode($myObj);
    // return;
}
function getPincodeDetails($myObj,$auth_token,$pinCode){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://protect.immunityhealth.me/api/getStateTin",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "pincode=".$pinCode."",
        CURLOPT_HTTPHEADER => array(
            "Authorization: ".$auth_token.""
        ),
    ));

    $response = curl_exec($curl); //json-response
    // echo $response;
    curl_close($curl);
    $jsondecoded = json_decode($response);
    if($jsondecoded->status!="true"){
        $myObj = new \stdClass();
        $myObj->code = 1;
        $myObj->message = "Customer Details not found";
        echo json_encode($myObj);
        return;
    }
    // $myObj->state = $jsondecoded->jsonData->state;
    $myObj->state_code = $jsondecoded->jsonData->state_code;
    return;
}
function getUserAddressAPI($myObj,$mapmyIndiaKey,$latitude,$longitude){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://apis.mapmyindia.com/advancedmaps/v1/".$mapmyIndiaKey."/rev_geocode?lat=".$latitude."&lng=".$longitude."",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;
    $jsondecoded = json_decode($response);
    if($jsondecoded->responseCode==200){
        $myObj->address = $jsondecoded->results[0]->formatted_address;
        $myObj->pinCode =  $jsondecoded->results[0]->pincode;
        $myObj->city =  $jsondecoded->results[0]->city;
        $myObj->state = $jsondecoded->results[0]->state;
        $myObj->country = $jsondecoded->results[0]->area;
        return 200;
    }else{
        $myObj = new stdClass();
        $myObj->code = 1;
        $myObj->message = "MapmyIndia Address API not functional";
        echo json_encode($myObj);
        return 0;
    }
    // echo $response;
}

// $last_name = $customer_name_array[1];
// $myObj->first_name = $first_name;
// $myObj->last_name = $last_name;
function createCustomer($user_id_immunity,$organization_id,$books_auth,$customer_name,$first_name,$last_name,$customer_type,$user_email,$contact_number,$address,$state_code,$city,$state,$zip,$country){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://books.zoho.in/api/v3/contacts?organization_id=".$organization_id."",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => array('JSONString' => '{
        "contact_name": "'.$customer_name.'",
        "contact_type": "'.$customer_type.'",
        "customer_sub_type": "individual",
        "billing_address": {
            "attention": "'.$customer_name.'",
            "address": "'.$address.'",
            "state_code": "'.$state_code.'",
            "state": "'.$state.'",
            "zip": '.$zip.',
            "country": "'.$country.'",
            "phone": "'.$contact_number.'"
        },
        "shipping_address": {
          "attention": "'.$customer_name.'",
          "address": "'.$address.'",
          "state_code": "'.$state_code.'",
          "state": "'.$state.'",
          "zip": '.$zip.',
          "country": "'.$country.'",
          "phone": "'.$contact_number.'"
        },
        "contact_persons": [
        {
              "first_name": "'.$first_name.'",
              "last_name": "'.$last_name.'",
              "email": "'.$user_email.'",
              "phone": "'.$contact_number.'",
              "mobile": "'.$contact_number.'",
              "is_primary_contact": true
        }
        ],
        "place_of_contact": '.$state_code.',
        "gst_treatment": "consumer",
        "custom_fields": [
        {
            "index": 1,
            "value": '.$user_id_immunity.'
        }
    ], 
    }'),
        CURLOPT_HTTPHEADER => array(
            "Content-Type: multipart/form-data",
            "Authorization: ".$books_auth."",
        ),
    ));

    $response = curl_exec($curl);
    // echo $response;
    $json = json_encode($response);
    $jsondecoded = json_decode($response);
    if($jsondecoded->code!=0){
        $myObj = new \stdClass();
        $myObj->code = 1;
        $myObj->message = "Customer Not created in Zoho";
        createErrorLogs($_POST['authtoken'],00,"Customer Creation Zoho",$myObj->message,$jsondecoded->message);
        echo json_encode($myObj);
        return;
    }
    $customer_id_zoho = $jsondecoded->contact->contact_id;
    $message = $jsondecoded->message;
    $code = $jsondecoded->code;
    $billing_address_code = $jsondecoded->contact->billing_address->address_id;
    $shipping_address_code = $jsondecoded->contact->shipping_address->address_id;
    $primary_contact_id = $jsondecoded->contact->primary_contact_id;
    // echo $response;
    updateZohoIDinDB($customer_id_zoho);
    updateAddressTable($customer_id_zoho,$billing_address_code,$customer_name,$contact_number,$address,$city,$state,$zip,$state_code,$country);//TODO ->logs, continue
    getUserAddressess($user_email,0);
    return;
    //$index = strpos($json, "code")+7;
    //echo $json{$index};

}
// echo json_encode($myObj);
function updateZohoIDinDB($customer_id_zoho){
    $curl = curl_init();
    $auth_token = $_POST['authtoken'];
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://protect.immunityhealth.me/api/updateZohoId",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "zoho_id=".$customer_id_zoho."",
        CURLOPT_HTTPHEADER => array(
            "Authorization: ".$auth_token.""
        ),
    ));

    $response = curl_exec($curl);
    $jsondecoded = json_decode($response);
    curl_close($curl);
    if($jsondecoded->status!="true"){
        $myObj = new \stdClass();
        $myObj->code = 1;
        $myObj->message = "Zoho ID not updated in DB";
        createErrorLogs($_POST['authtoken'],$customer_id_zoho,"Zoho ID updation in DB",$myObj->message,$jsondecoded->message);
        echo json_encode($myObj);
        return;
    }
    return;
    // echo $response;

}
function getUserAddressess($user_email,$email_code){
    $curl = curl_init();
    $auth_token = $_POST['authtoken'];
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://protect.immunityhealth.me/api/getUserAddresses",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        // CURLOPT_POSTFIELDS => "zoho_id=".$customer_id_zoho."",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$auth_token
        ),
    ));

    $response = curl_exec($curl);
    // echo $response;
    // return;
    $jsondecoded = json_decode($response);
    curl_close($curl);
    if($jsondecoded->status!="true"){
        $myObj = new \stdClass();
        $myObj->code = 1;
        $myObj->message = "Address not found";
        echo json_encode($myObj);
        return;
    }
//    $myObj = new stdClass();
//    $myObj->address = $jsondecoded;
//    $myObj->email = $user_email;
    $jsondecoded->email = $user_email;
    $jsondecoded->code = $email_code;
//    echo json_encode($myObj);
    echo json_encode($jsondecoded);
    return;

}
function updateAddressTable($customer_id_zoho,$billing_address_code,$customer_name,$contact_number,$address,$city,$state,$zip,$state_code,$country){
    $curl = curl_init();
    $auth_token = $_POST['authtoken'];
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://protect.immunityhealth.me/api/saveUserAddress",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => array('user_id_zoho'=>$customer_id_zoho,'address_id_zoho' => $billing_address_code,'full_name' => $customer_name,'mobile_number'=> $contact_number,'address'=>$address,'city'=>$city,'pincode'=>$zip,'state'=>$state,'state_code'=>$state_code,'country'=>$country,'pin_code'=>$zip,'status'=>1,'type'=>1),
        CURLOPT_HTTPHEADER => array(
            "Authorization: ".$auth_token.""
        ),
    ));

    $response = curl_exec($curl);
    // echo $response;
    $jsondecoded = json_decode($response);
    curl_close($curl);
    if($jsondecoded->status!="true"){
        $myObj = new \stdClass();
        $myObj->code = 1;
        $myObj->message = "Address Not updated in DB";
        createErrorLogs($_POST['authtoken'],$customer_id_zoho,"Adding address in DB",$myObj->message,$jsondecoded->message);
        echo json_encode($myObj);
        return;
    }
}


function createErrorLogs($auth_token,$customer_id,$log_category,$log_message,$actual_message){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://protect.immunityhealth.me/api/saveLogs",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => array('user_id_zoho' => $customer_id,'log_category' => $log_category,'log_message' => $log_message,'email' => '0','sms' => $actual_message),
        CURLOPT_HTTPHEADER => array(
            "Authorization: ".$auth_token.""
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
//    echo $response;

}
