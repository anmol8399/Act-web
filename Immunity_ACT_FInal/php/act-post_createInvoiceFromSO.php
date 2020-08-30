<?php
$myObj = new stdClass();
$auth_token = $_POST['authtoken'];
$salesorder_id = $_POST['salesorder_id'];
$customer_id = $_POST['customer_id'];
$payment_mode = $_POST['payment_mode'];
$payment_mode = "Razorpay";
$payment_id = $_POST['payment_id'];
$payment_date = $_POST['payment_date'];
$amount = $_POST['amount'];
$reference_number = $_POST['payment_id'];
$dates = $_POST['course_date'];
$immunity_pack = $_POST['immunity_pack'];
$product_id = $_POST['product_id'];
$product_category_id = 1;
$product_id = 1;
$auth_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMGU4ZDIzMTMyNzY1YWIzNTllYWMzNDJlNzI3ZTY2ZTZlMDk4MDI0YTM4NDU3NDlhM2YyZDMwYzU2MWUxMzZlNDc1Mzg4MGJiNTc5MmVkZGMiLCJpYXQiOjE1OTcyMTAwNjQsIm5iZiI6MTU5NzIxMDA2NCwiZXhwIjoxNzU0OTc2NDY0LCJzdWIiOiI4Iiwic2NvcGVzIjpbXX0.opeW1Soy6Sei5Arpga3Tp8bMcrw_95-Z03EYrbMsaI6iMH0sXTU6dij4jLHUaGOqaZHeEw7DV1UvFYBWymtHQPKEuRlSv0stQqky_Q3oAnUiZzO9yMaW_JAZtp6BjxU9Q3MKmg4FWpifOria24C0kYHMI_oJ7o39nHN5m8XtmqAc1wDSY4hS73-LZGqUcapWdrgzXqoXMWxcZ3gm-X8_EaOBn85QqS1c5iuvMEowb6kq2K79i7klCs2jtLy_DAvzqOx-UOwQN6ov3QMhAunNQlfmtKccE0pl7TPMdrNFc-JYaEd_eS5nJU5gOTnwuK2otul_KztgpQ--8fz0sfAkpjO9VpT9k0M5hcER6y6qIbMmOUPyF73TYPwHUFFWC4ORhb1UhonRmohPJIPqPgpg-qCaVB-ztvGqDeEmSD4vSeiUCYFjFiglpeVQyvUf4GHP22ivjofodZXd4zStc31aPKoYSvyy23RnHvsb2MEDFRZfBNJG4pFFhunNkrDAaJlNKw97fc2NdLQzeUJYBApQPVBspcd0ADL_Ox_rla4E9d0fbUGySd_gcylvXHO_GDLa_yMTQVWZsInVKJ_FwpzctLCQ3q0CEz3z2bhFq2KeEBoi-feNzCKr_2wnMNYdGrJeWjDg7th8yUTtUzJegwxQ8ziOr7pLlmqD1oo3jEDufyo";
$item_id = 65;


$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://sultry-tax.000webhostapp.com/createInvoiceFromSO.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => array('salesorder_id' => $salesorder_id,'customer_id' => '343178000000120001','authtoken' => $auth_token,'payment_id' => $payment_id,'item_id' => '343178000000036202', 'payment_date' => '2020-08-25','course_date' => '2020-08-25', 'amount' => '500','immunity_pack' => 'Heyy Invoice','actual_price' => 500,'discounted_price'=>200,'product_id'=>1),
));

$response = curl_exec($curl);
echo $response;