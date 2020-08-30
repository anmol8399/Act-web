const queryString = window.location.search;
  console.log(queryString);
  const urlParams = new URLSearchParams(queryString);
  const product = urlParams.get('razorpay_invoice_status');
  const paymentID = urlParams.get('razorpay_payment_id');
  const order_id = urlParams.get('razorpay_invoice_id');
  const item_id = urlParams.get('item_id');
  const productID = urlParams.get('product_id');
  const so_id = urlParams.get('so_id');
  var auth_token = urlParams.get('u');
  var invoice_id;
//   document.getElementById('head').innerText = product;
//   document.getElementById('payment_id').innerText = paymentID;
//   document.getElementById('order_id').innerText = order_id;


var img_url,session_name;


$(document).ready(function(){
    $.post("https://sultry-tax.000webhostapp.com/action_id.php",
    {
      action_id: 4,
      product_category_id: 1,
      product_id: 1,
      authtoken: auth_token
    },
    
    function(data,status){
      console.log("Data: " + data + "\nStatus: " + status);
      if(status=="success"){
          var dataParsed = JSON.parse(data);
          document.getElementById('spinner').style.display = 'none';
          image_url = dataParsed.image_url;
  document.getElementById("myImg").src = image_url;    
session_name = dataParsed.name;
          document.getElementById("header_1").innerText = "Your "+dataParsed.name+" is Confirmed!"; 
        //   document.getElementById("content_1").innerText = "Date : ";
          
//           document.getElementById("line_item_1").innerText = dataParsed.objective_1;
//   document.getElementById("line_item_2").innerText = dataParsed.objective_2;
//   document.getElementById("line_item_3").innerText = dataParsed.objective_3;
  document.getElementById("requirement_1").innerText = dataParsed.requirement_1;
  document.getElementById("requirement_2").innerText = dataParsed.requirement_2;
  document.getElementById("requirement_3").innerText = dataParsed.requirement_3;
  document.getElementById("requirement_4").innerText = dataParsed.requirement_4;
  document.getElementById('main_body').style.display = 'block';


        // window.location.href = "https://sultry-tax.000webhostapp.com/act_seeDetails.html";
      }
    });


    $.post("https://sultry-tax.000webhostapp.com/act-test-test.php",
    {
      // order_id_table:6,
      // action_id: 4,
      order_id: order_id,
      product_category_id: 1,
      product_id: 1,
      payment_id: paymentID,
      payment_date: '2020-08-29',
      amount: 500,
      course_date: '2020-08-25',
      immunity_pack: "Breathe",
      customer_id: 1234,
      salesorder_id: so_id,
      authtoken: auth_token,
      // image_url: img_url,
      item_id: item_id

    },
    
    function(data,status){
      console.log("Data: " + data + "\nStatus: " + status);
      if(status=="success"){
          var dataParsedInv = JSON.parse(data);
          invoice_id = dataParsedInv.jsonData.invoice_id;
          console.log(invoice_id);
        // window.location.href = "https://sultry-tax.000webhostapp.com/act_seeDetails.html";
      }
    });
  });




  function emailInvoice(){
    document.getElementById('part').style.display = 'none';
    document.getElementById('spinner').style.display = 'block';
    console.log(invoice_id);

    $.post("https://sultry-tax.000webhostapp.com/emailInvoice.php",
    {
      inv_id: invoice_id,
      authtoken: auth_token

    },
    
    function(data,status){
      console.log("Data: " + data + "\nStatus: " + status);
      if(status=="success"){
          var dataParsedInv = JSON.parse(data);
          if(dataParsedInv.code==0){
            document.getElementById('spinner').style.display = 'none';

            document.getElementById('part').style.display = 'none';
            document.getElementById('email').innerText = dataParsedInv.email_id;
              document.getElementById('emailSuccess').style.display = 'block';
          }else{
            document.getElementById('part').style.display = 'block';

          }
        // window.location.href = "https://sultry-tax.000webhostapp.com/act_seeDetails.html";
      }
    });



        // window.location.href = "https://sultry-tax.000webhostapp.com/emailInvoice.php";
    
  }
  // $(document).ready(function(){

  // });






  $("#foot-button2").click(function () {
    var product_id = this.value;
    window.location.href = "/buyNow.html?product_id="+product_id+"&u="+auth_token;
  });
// if(product==1){
//   document.getElementById("myImg").src = "https://protect.immunityhealth.me/product-image/Breath-Free.png";
// //   document.getElementById("about_para").innerText = "Prana (breath) is the source through which our body is replenished, and the mind is nourished. Ayama means control. Learn to control the most important function of your body. This course is for you if:"
//   // document.getElementById("line_item_1").innerText = 'You are looking to enhance your lung function and endurance';
//   document.getElementById("line_item_2").innerText = 'You are looking to beat stress and initiate a calmer living';
//   document.getElementById("line_item_3").innerText = 'You are looking to restart your practice under the guidance of an experienced teacher';
// }else{
  document.getElementById("myImg").src = "https://protect.immunityhealth.me/product-image/Stress_Pack.png";    
//   document.getElementById('about_para').innerText = "Back and neck muscles are essential components of the muscular network of the spine, helping the body maintain proper upright posture and movement. Whether you are suffering from a chronic back / neck pain or are just suffering from “lockdown” strain, this pack will help you get started on your journey to strengthen your back and neck. This is for you if:"
//   document.getElementById("line_item_1").innerText = 'You are looking to enhance your lung function and endurance';
//   document.getElementById("line_item_2").innerText = 'You are looking to beat stress and initiate a calmer living';
//   document.getElementById("line_item_3").innerText = 'You are looking to restart your practice under the guidance of an experienced teacher';
// }
function goBack() {
window.history.back();
}





// https://sultry-tax.000webhostapp.com/act_webview_redirect.html?razorpay_payment_id=pay_FVFTkH9hLdLXqU&razorpay_invoice_id=inv_FVFT8yzb0UW0T0&razorpay_invoice_status=paid&razorpay_invoice_receipt=&razorpay_signature=30b93e75557c904c9d64e7cd8e8cb5a91cca1267980aa0608e12e08d7160de1d&item_id=65&so_id=343178000000139050&u=eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMGU4ZDIzMTMyNzY1YWIzNTllYWMzNDJlNzI3ZTY2ZTZlMDk4MDI0YTM4NDU3NDlhM2YyZDMwYzU2MWUxMzZlNDc1Mzg4MGJiNTc5MmVkZGMiLCJpYXQiOjE1OTcyMTAwNjQsIm5iZiI6MTU5NzIxMDA2NCwiZXhwIjoxNzU0OTc2NDY0LCJzdWIiOiI4Iiwic2NvcGVzIjpbXX0.opeW1Soy6Sei5Arpga3Tp8bMcrw_95-Z03EYrbMsaI6iMH0sXTU6dij4jLHUaGOqaZHeEw7DV1UvFYBWymtHQPKEuRlSv0stQqky_Q3oAnUiZzO9yMaW_JAZtp6BjxU9Q3MKmg4FWpifOria24C0kYHMI_oJ7o39nHN5m8XtmqAc1wDSY4hS73-LZGqUcapWdrgzXqoXMWxcZ3gm-X8_EaOBn85QqS1c5iuvMEowb6kq2K79i7klCs2jtLy_DAvzqOx-UOwQN6ov3QMhAunNQlfmtKccE0pl7TPMdrNFc-JYaEd_eS5nJU5gOTnwuK2otul_KztgpQ--8fz0sfAkpjO9VpT9k0M5hcER6y6qIbMmOUPyF73TYPwHUFFWC4ORhb1UhonRmohPJIPqPgpg-qCaVB-ztvGqDeEmSD4vSeiUCYFjFiglpeVQyvUf4GHP22ivjofodZXd4zStc31aPKoYSvyy23RnHvsb2MEDFRZfBNJG4pFFhunNkrDAaJlNKw97fc2NdLQzeUJYBApQPVBspcd0ADL_Ox_rla4E9d0fbUGySd_gcylvXHO_GDLa_yMTQVWZsInVKJ_FwpzctLCQ3q0CEz3z2bhFq2KeEBoi-feNzCKr_2wnMNYdGrJeWjDg7th8yUTtUzJegwxQ8ziOr7pLlmqD1oo3jEDufyo