<?php
$myObj = new stdClass();
$auth_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNDBlMzFiYTM3Y2QyMjQ4MjFkNDRjZTRjMDMxOWE2ZDliZDc0MGM3NDBkMzkzMjk1M2M2YzRjNTZjNTQ1Y2VmYWE4NDYxNDc0YjhjZDQzYjYiLCJpYXQiOjE1OTc3NTYyOTEsIm5iZiI6MTU5Nzc1NjI5MSwiZXhwIjoxNzU1NTIyNjkxLCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.sVQHdb6IymEN3crlDiBWwpji5iuYKStCpoazWB3t9-45G5Du8JabrUcT_UhK2olMY415fHdUkj5PjBt1vf7A1cStvhF7biqae5BIbyDGCUmtvPBx9jIcIyTDF2i7O24AzfNUyMHvl7TdBWMtSHpQerPr-w3IB_L7ds6_uH9rMrWIQP-nbyQfNFxWyQOuFcxUHt4zwL57PsEU7wpvXKqgx1U4C4VbUXgechRESESxettKQsnhCXvJ3pRk-1WU0Ys_eMOOtTWmlCg2eCoo0veATo4_E7BKKvE5nBUyLZgkED0lFGE5R-3visbFO5Uh5qeZPfL9hXfyyeqW7K5STvVVqjW_GZJ47_kEKdpc4Vacwkz48F37uLlZxhXcHt_1Eb1PniDoNtg6vyhsT24aSrhm4V_MXB4ltDc2II3DIeSBSAWubLGIyFpo2DffZFVm52aWhpyacH0hmf1d0x7OgBYB8PBLhErE6ez_pHov5G69DueiQeU85juEHrnehs1VdlvEDog5WPc9whBvF-m5XbLT5WqDCN74oiXVoPLAZI79S475KT3RxZxS7ILPECHNTxZ375s7LCYsEa_ihHlkt3CTfCENTwRMnCHqt2ejE5TONl6ac42eSqse1HjaqfE4JfmWvhnvKsmmQ4H4dTJ6J7tXP1rk_JPvD8j9N1rW3fVnYAo";
// if($action_id==1){
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
$date_arr = array();
$time_arr = array();
$zoho_id_arr = array();
$id_arr = array();
$group_arr = $jsondecoded->jsonData->groups;
print_r($group_arr);
// for($i=0;$i<count($group_arr);$i++){

    foreach($jsondecoded->jsonData->item_attribute as $myData){
        // echo "Chala foreach         ";
        for($i=0;$i<count($group_arr);$i++){
            // echo "Chala for             ";
            if($group_arr[$i]==$myData->attribute_value){
                // echo 1;
                array_push($date_arr,$myData->attribute_value);
                array_push($id_arr,$myData->item_id);
                array_push($zoho_id_arr,$myData->item_id_zoho);
                // $zoho_id_arr[$i] = $myData->item_id_zoho;
            }
        }
        
    }
    
    for($i=0;$i<count($id_arr);$i++){
        // echo "For chala";
        foreach($jsondecoded->jsonData->item_attribute as $myData){
            if($myData->item_id==$id_arr[$i] && $myData->attribute_key=="time"){
                array_push($time_arr,$myData->attribute_value);
            }
        }
        }
        $myObj->dateGroup = $group_arr;
        $myObj->dateArray = $date_arr;
        $myObj->timeArray = $time_arr;
        $myObj->idArray = $id_arr;
        $myObj->zohoIdArray = $zoho_id_arr;
echo json_encode($myObj);
// print_r($time_arr);
// print_r($date_arr);
// print_r($id_arr);
// print_r($zoho_id_arr);
// echo $response;
return;