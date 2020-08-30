<?php
$auth_token = $_POST['authtoken'];
$address_id = $_POST['address_id'];
$address_id_zoho = $_POST['address_id_zoho'];
$address = $_POST['address'];
$name = $_POST['name'];
$city = $_POST['city'];
$state = $_POST['state'];
$state_code = $_POST['state_code'];
$phone_number = $_POST['contact_number'];
$zip = $_POST['pinCode'];
$country = "India";
$books_auth = "";
$organization_id = 0;


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
    CURLOPT_POSTFIELDS => array('source' => 'Zoho'),
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
    CURLOPT_HTTPHEADER => array(
        "Authorization: ".$auth_token.""
    ),
));
$response = curl_exec($curl);

curl_close($curl);
// echo $response;
$jsondecoded = json_decode($response);
if($jsondecoded->status!="true"){
    $myObj = new \stdClass();
    $myObj->code = 1;
    $myObj->message = "Customer Details not found";
    echo json_encode($myObj);
    return;
}
// $myObj->full_name = $jsondecoded->jsonData->name;
$customer_id = $jsondecoded->jsonData->zoho_id;
$id = $jsondecoded->jsonData->id;
$customer_name = $jsondecoded->jsonData->name;

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://books.zoho.in/api/v3/contacts/".$customer_id."?organization_id=".$organization_id."",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS => array('JSONString' => '{
    "contact_name": "'.$customer_name.'",
    "contact_type": "customer",
    "billing_address": {
        "attention": "'.$name.'",
        "address": "'.$address.'",
        "state_code": "'.$state_code.'",
        "state": "'.$state.'",
        "zip": '.$zip.',
        "country": "'.$country.'",
        "phone": "'.$contact_number.'"
    },
     "shipping_address": {
        "attention": "'.$name.'",
        "address": "'.$address.'",
        "state_code": "'.$state_code.'",
        "state": "'.$state.'",
        "zip": '.$zip.',
        "country": "'.$country.'",
        "phone": "'.$contact_number.'"
    },
    "place_of_contact": '.$state_code.'
  }'),
    CURLOPT_HTTPHEADER => array(
        "Content-Type: multipart/form-data",
        "Authorization: ".$books_auth."",
    ),
));

$response = curl_exec($curl);
$json = json_encode($response);
$jsondecoded = json_decode($response);
if($jsondecoded->code!=0){
    $myObj = new \stdClass();
    $myObj->code = 1;
    $myObj->message = "Customer Address not updated in Zoho";
    createErrorLogs($auth_token,$customer_id,"Address",$myObj->message,$jsondecoded->message);
    echo json_encode($myObj);
    return;
}
// echo $response;



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
    CURLOPT_POSTFIELDS => array('id'=>$address_id,'address_id_zoho'=>$address_id_zoho,'user_id_zoho'=>$customer_id,'full_name' => $name,'mobile_number'=> $phone_number,'address'=>$address,'city'=>$city,'pincode'=>$zip,'state'=>$state,'state_code'=>$state_code,'country'=>$country,'pin_code'=>$zip,'status'=>1,'type'=>1),
    CURLOPT_HTTPHEADER => array(
        "Authorization: ".$auth_token.""
    ),
));

$response = curl_exec($curl);
$jsondecoded = json_decode($response);
// echo $response;
curl_close($curl);
if($jsondecoded->status!="true"){
    $myObj = new \stdClass();
    $myObj->code = 1;
    $myObj->message = "User Address not saved";
    createErrorLogs($auth_token,$customer_id,"Address",$myObj->message,$jsondecoded->message);
    echo json_encode($myObj);
    return;
}

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
        "Authorization: ".$auth_token.""
    ),
));

$response = curl_exec($curl);
$jsondecoded = json_decode($response);
curl_close($curl);
if($jsondecoded->status!="true"){
    $myObj = new \stdClass();
    $myObj->code = 1;
    $myObj->message = "Customer Address not found";
    echo json_encode($myObj);
    return;
}
echo $response;
return;
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
    return;
//    echo $response;

}
