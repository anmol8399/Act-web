const queryString = window.location.search;
console.log(queryString);
const urlParams = new URLSearchParams(queryString);
const product = urlParams.get('product_cat_id');
const auth_token = urlParams.get('u');
var button_1_url,button_2_url;
$(document).ready(function(){
    $.post("https://sultry-tax.000webhostapp.com/action_id.php",
    {
      action_id: 3,
      product_category_id: product,
      authtoken: auth_token
    },
    
    function(data,status){
      console.log("Data: " + data + "\nStatus: " + status);
      if(status=="success"){
        
          var dataParsed = JSON.parse(data);
        if(dataParsed.header_1==null){
          document.getElementById('error_page').style.display = 'block';
          document.getElementById('spinner').style.display = 'none';
          return;
        }
          document.getElementById('spinner').style.display = 'none';
          document.getElementById("header_1").innerText = dataParsed.header_1; 
          document.getElementById("content_1").innerText = dataParsed.content_1;
          document.getElementById("myImg").src = dataParsed.img_url_1;
          
          document.getElementById("line_item_1").innerText = dataParsed.objective_1;
  document.getElementById("line_item_2").innerText = dataParsed.objective_2;
  document.getElementById("line_item_3").innerText = dataParsed.objective_3;
  document.getElementById("requirement_1").innerText = dataParsed.requirement_1;
  document.getElementById("requirement_2").innerText = dataParsed.requirement_2;
  document.getElementById("requirement_3").innerText = dataParsed.requirement_3;
  document.getElementById("requirement_4").innerText = dataParsed.requirement_4;
  //alert(dataParsed.button_id_1);
        button_1_id = dataParsed.button_id_1;
        button_2_id = dataParsed.button_id_2;
        button_1_url = dataParsed.button_1;
        button_2_url = dataParsed.button_2;
  document.getElementById('main_body').style.display = 'block';


        // window.location.href = "https://sultry-tax.000webhostapp.com/act_seeDetails.html";
      }
    });
  });
  $("#foot-button1").click(function () {
    var product_id = this.value;
    window.location.href = button_1_url+"?product_id="+button_1_id+"&product_cat_id="+product+"&u="+auth_token;
  });

  $("#foot-button2").click(function () {
    var product_id = this.value;
    window.location.href = button_2_url+"?product_id="+button_2_id+"&product_cat_id="+product+"&u="+auth_token;
  });
// if(product==1){
  // document.getElementById("myImg").src = "https://protect.immunityhealth.me/product-image/Breath-Free.png";
// //   document.getElementById("about_para").innerText = "Prana (breath) is the source through which our body is replenished, and the mind is nourished. Ayama means control. Learn to control the most important function of your body. This course is for you if:"
//   // document.getElementById("line_item_1").innerText = 'You are looking to enhance your lung function and endurance';
//   document.getElementById("line_item_2").innerText = 'You are looking to beat stress and initiate a calmer living';
//   document.getElementById("line_item_3").innerText = 'You are looking to restart your practice under the guidance of an experienced teacher';
// }else{
  // document.getElementById("myImg").src = "https://protect.immunityhealth.me/product-image/Stress_Pack.png";    
//   document.getElementById('about_para').innerText = "Back and neck muscles are essential components of the muscular network of the spine, helping the body maintain proper upright posture and movement. Whether you are suffering from a chronic back / neck pain or are just suffering from “lockdown” strain, this pack will help you get started on your journey to strengthen your back and neck. This is for you if:"
//   document.getElementById("line_item_1").innerText = 'You are looking to enhance your lung function and endurance';
//   document.getElementById("line_item_2").innerText = 'You are looking to beat stress and initiate a calmer living';
//   document.getElementById("line_item_3").innerText = 'You are looking to restart your practice under the guidance of an experienced teacher';
// }
function goBack() {
window.history.back();
}