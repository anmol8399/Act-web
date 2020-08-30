<?php

$myObj = new stdClass();

$auth_token = $_POST['authtoken'];
$item_id = $_POST['item_id'];
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://protect.immunityhealth.me/api/getItemDetail",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => array('product_category_id' => '1','product_id' => '1'),
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer ".$auth_token
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;
$jsondecoded = json_decode($response);
foreach($jsondecoded->jsonData as $myData){
    if($item_id==$myData->id){
        $myObj->item_id_zoho = $mydata->item_id_zoho;
        $myObj->display_name = $mydata->invoice_description;
        $myObj->actual_price = $mydata->actual_price;
        $myObj->discounted_price = $myData->discounted_price;
        break;
    }
}

echo json_encode($myObj);
return;