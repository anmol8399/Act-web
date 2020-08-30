<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: POST');

header("Access-Control-Allow-Headers: X-Requested-With");

$myObj = new stdClass();

$action_id = $_POST['action_id'];
$auth_token = $_POST['auth'];

if($action_id==3){
    $curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://uat.immunityhealth.me/api/dynamicScreenDetail",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => array('product_category_id' => 1, 'screen_number' => 3),
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".$auth_token
    ),
));

$response = curl_exec($curl);
$jsondecoded = json_decode($response);
curl_close($curl);
foreach($jsondecoded->jsonData as $myData){
    $type = $myData->type;
    $num = $myData->number;
    $myObj->{$type."_".$num} = $myData->value; 
}
$myObj->data = 123;

// $myObj->data = $response;
echo json_encode($myObj);
// echo $data;
}
if($action_id==1){
    $curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://protect.immunityhealth.me/api/getItems",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => array('product_category_id' => 1, 'product_id' => 1),
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".$auth_token
    ),
));

$response = curl_exec($curl);
$jsondecoded = json_decode($response);
curl_close($curl);
// foreach($jsondecoded->jsonData as $myData){
//     $type = $myData->type;
//     $num = $myData->number;
//     $myObj->{$type."_".$num} = $myData->value; 
// }
// $myObj->data = 123;

$myObj->groups = $jsondecoded->jsonData->groups;
echo json_encode($myObj);
// echo $data;
}