<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: POST');

header("Access-Control-Allow-Headers: X-Requested-With");
$myObj = new stdClass();
$auth_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMGU4ZDIzMTMyNzY1YWIzNTllYWMzNDJlNzI3ZTY2ZTZlMDk4MDI0YTM4NDU3NDlhM2YyZDMwYzU2MWUxMzZlNDc1Mzg4MGJiNTc5MmVkZGMiLCJpYXQiOjE1OTcyMTAwNjQsIm5iZiI6MTU5NzIxMDA2NCwiZXhwIjoxNzU0OTc2NDY0LCJzdWIiOiI4Iiwic2NvcGVzIjpbXX0.opeW1Soy6Sei5Arpga3Tp8bMcrw_95-Z03EYrbMsaI6iMH0sXTU6dij4jLHUaGOqaZHeEw7DV1UvFYBWymtHQPKEuRlSv0stQqky_Q3oAnUiZzO9yMaW_JAZtp6BjxU9Q3MKmg4FWpifOria24C0kYHMI_oJ7o39nHN5m8XtmqAc1wDSY4hS73-LZGqUcapWdrgzXqoXMWxcZ3gm-X8_EaOBn85QqS1c5iuvMEowb6kq2K79i7klCs2jtLy_DAvzqOx-UOwQN6ov3QMhAunNQlfmtKccE0pl7TPMdrNFc-JYaEd_eS5nJU5gOTnwuK2otul_KztgpQ--8fz0sfAkpjO9VpT9k0M5hcER6y6qIbMmOUPyF73TYPwHUFFWC4ORhb1UhonRmohPJIPqPgpg-qCaVB-ztvGqDeEmSD4vSeiUCYFjFiglpeVQyvUf4GHP22ivjofodZXd4zStc31aPKoYSvyy23RnHvsb2MEDFRZfBNJG4pFFhunNkrDAaJlNKw97fc2NdLQzeUJYBApQPVBspcd0ADL_Ox_rla4E9d0fbUGySd_gcylvXHO_GDLa_yMTQVWZsInVKJ_FwpzctLCQ3q0CEz3z2bhFq2KeEBoi-feNzCKr_2wnMNYdGrJeWjDg7th8yUTtUzJegwxQ8ziOr7pLlmqD1oo3jEDufyo";
// if($action_id==1){

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://uat.immunityhealth.me/api/getUserOrders",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
//   CURLOPT_POSTFIELDS => array('items' => '1','id' => '5','payment' => '1234','quantity' => '1'),
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer ".$auth_token
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

$jsondecoded = json_decode($response);
$img_urls = [];
$headers = [];
$parameters = [];
$days_to_go = [];
$dates_arr = [];
foreach($jsondecoded->jsonData as $myData){
    if($myData->status=="1"){
        array_push($img_urls,$myData->image_url);
        array_push($parameters,$myData->date.$myData->parameter_2);
        array_push($dates_arr,$myData->date);
        array_push($headers,$myData->invoice_description);
    }
}
$myObj->image_urls = $image_urls;
$myObj->headers = $headers;
$myObj->parameters = $parameters;
$myObj->days_to_go = $days_to_go;

echo $json_encode($myObj);