<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: POST');

header("Access-Control-Allow-Headers: X-Requested-With");
$amount = $_POST['amount'];
$amount = $amount*100;
$auth_token1 = $_POST['auth_token'];
$item_id = $_POST['item_id'];
$description = $_POST['description'];
$so_id = $_POST['salesOrder_id'];

// $amount = 300;
// $auth_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNDBlMzFiYTM3Y2QyMjQ4MjFkNDRjZTRjMDMxOWE2ZDliZDc0MGM3NDBkMzkzMjk1M2M2YzRjNTZjNTQ1Y2VmYWE4NDYxNDc0YjhjZDQzYjYiLCJpYXQiOjE1OTc3NTYyOTEsIm5iZiI6MTU5Nzc1NjI5MSwiZXhwIjoxNzU1NTIyNjkxLCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.sVQHdb6IymEN3crlDiBWwpji5iuYKStCpoazWB3t9-45G5Du8JabrUcT_UhK2olMY415fHdUkj5PjBt1vf7A1cStvhF7biqae5BIbyDGCUmtvPBx9jIcIyTDF2i7O24AzfNUyMHvl7TdBWMtSHpQerPr-w3IB_L7ds6_uH9rMrWIQP-nbyQfNFxWyQOuFcxUHt4zwL57PsEU7wpvXKqgx1U4C4VbUXgechRESESxettKQsnhCXvJ3pRk-1WU0Ys_eMOOtTWmlCg2eCoo0veATo4_E7BKKvE5nBUyLZgkED0lFGE5R-3visbFO5Uh5qeZPfL9hXfyyeqW7K5STvVVqjW_GZJ47_kEKdpc4Vacwkz48F37uLlZxhXcHt_1Eb1PniDoNtg6vyhsT24aSrhm4V_MXB4ltDc2II3DIeSBSAWubLGIyFpo2DffZFVm52aWhpyacH0hmf1d0x7OgBYB8PBLhErE6ez_pHov5G69DueiQeU85juEHrnehs1VdlvEDog5WPc9whBvF-m5XbLT5WqDCN74oiXVoPLAZI79S475KT3RxZxS7ILPECHNTxZ375s7LCYsEa_ihHlkt3CTfCENTwRMnCHqt2ejE5TONl6ac42eSqse1HjaqfE4JfmWvhnvKsmmQ4H4dTJ6J7tXP1rk_JPvD8j9N1rW3fVnYAo";
// $item_id = $_POST['item_id'];

$callback_url = "https://sultry-tax.000webhostapp.com/act_webview_redirect.html?item_id=".$item_id;

$myObj = new stdClass();

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "http://uat.immunityhealth.me/api/getUser",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".$auth_token
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
// $customer_id = $jsondecoded->jsonData->zoho_id;
// $id = $jsondecoded->jsonData->id;
$customer_name = $jsondecoded->jsonData->name;
$customer_email = $jsondecoded->jsonData->email;
$contact_num = $jsondecoded->jsonData->phone_number;






$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.razorpay.com/v1/invoices/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\r\n  \"customer\": {\r\n    \"name\": \"".$customer_name."\",\r\n    \"email\": \"".$customer_email."\",\r\n    \"contact\": \"".$contact_num."\"\r\n  },\r\n  \"type\": \"link\",\r\n  \"view_less\": 1,\r\n  \"amount\": ".$amount.",\r\n  \"currency\": \"INR\",\r\n  \"description\": \"".$description."\",\r\n  \"reminder_enable\": false,\r\n  \"sms_notify\": 0,\r\n  \"email_notify\": 0,\r\n  \"callback_url\": \"".$callback_url."\",\r\n  \"callback_method\": \"get\"\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Basic cnpwX3Rlc3RfcHhWMGNjSDBBOHROZGg6ZnlpNGZJcVdyajRSa05PbTRueTNwWjlv"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;

$jsondecoded = json_decode($response);
$myObj->order_id = $jsondecoded->id;
$myObj->customer_id = $jsondecoded->customer_id;
$myObj->order_id = $jsondecoded->order_id;
$myObj->payment_url = $jsondecoded->short_url;
curl_close($curl);


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://uat.immunityhealth.me/api/saveOrders",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => array('sale_order_id' => $so_id,'order_id' => $myObj->order_id),
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer ".$auth_token1
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;
$jsondecoded = json_decode($response);
$myObj->order_id = $jsondecoded->jsonData->id;

echo json_encode($myObj);
