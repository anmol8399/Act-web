<?php
$myObj = new stdClass();
$address_id = $_POST['address_id'];
$auth_token = $_POST['authtoken'];
$customer_id = $_POST['customer_id'];
$item_id = $_POST['item_id'];
$date = $_POST['so_date'];
$shipment_date = $_POST['event_date'];
$notes = $_POST['invoice_description'];
$actual_price = $_POST['actual_price'];
$discounted_price = $_POST['discounted_price'];
$quantity = $_POST['quantity'];
$auth_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMGU4ZDIzMTMyNzY1YWIzNTllYWMzNDJlNzI3ZTY2ZTZlMDk4MDI0YTM4NDU3NDlhM2YyZDMwYzU2MWUxMzZlNDc1Mzg4MGJiNTc5MmVkZGMiLCJpYXQiOjE1OTcyMTAwNjQsIm5iZiI6MTU5NzIxMDA2NCwiZXhwIjoxNzU0OTc2NDY0LCJzdWIiOiI4Iiwic2NvcGVzIjpbXX0.opeW1Soy6Sei5Arpga3Tp8bMcrw_95-Z03EYrbMsaI6iMH0sXTU6dij4jLHUaGOqaZHeEw7DV1UvFYBWymtHQPKEuRlSv0stQqky_Q3oAnUiZzO9yMaW_JAZtp6BjxU9Q3MKmg4FWpifOria24C0kYHMI_oJ7o39nHN5m8XtmqAc1wDSY4hS73-LZGqUcapWdrgzXqoXMWxcZ3gm-X8_EaOBn85QqS1c5iuvMEowb6kq2K79i7klCs2jtLy_DAvzqOx-UOwQN6ov3QMhAunNQlfmtKccE0pl7TPMdrNFc-JYaEd_eS5nJU5gOTnwuK2otul_KztgpQ--8fz0sfAkpjO9VpT9k0M5hcER6y6qIbMmOUPyF73TYPwHUFFWC4ORhb1UhonRmohPJIPqPgpg-qCaVB-ztvGqDeEmSD4vSeiUCYFjFiglpeVQyvUf4GHP22ivjofodZXd4zStc31aPKoYSvyy23RnHvsb2MEDFRZfBNJG4pFFhunNkrDAaJlNKw97fc2NdLQzeUJYBApQPVBspcd0ADL_Ox_rla4E9d0fbUGySd_gcylvXHO_GDLa_yMTQVWZsInVKJ_FwpzctLCQ3q0CEz3z2bhFq2KeEBoi-feNzCKr_2wnMNYdGrJeWjDg7th8yUTtUzJegwxQ8ziOr7pLlmqD1oo3jEDufyo";



$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://sultry-tax.000webhostapp.com/address.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => array('product_id' => 1,'authtoken' => $auth_token,'product_category_id' => 1,'item_id' => '343178000000036202', 'so_date' => '2020-08-25', 'event_date' => '2020-08-25','invoice_description' => 'Heyy Invoice','actual_price' => 500,'discounted_price'=>200,'quantity'=>1),
));

$response = curl_exec($curl);
echo $response;
