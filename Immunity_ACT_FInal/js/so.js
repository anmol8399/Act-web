var total = 0;
const queryString = window.location.search;
console.log(queryString);
const urlParams = new URLSearchParams(queryString);
const product = urlParams.get('product_id');
const product_cat = urlParams.get('product_category_id');
const item_id = urlParams.get('item_id');
const auth_token = urlParams.get('u');
const address_id = urlParams.get('addr_id');



var description,salesOrder_id;
$.post("https://sultry-tax.000webhostapp.com/cart-SO.php",
  {
    //   product_category_id: 1,
    authtoken: auth_token,
    address_id: address_id,
    //   product_id: 1,
    item_id: item_id,
    product_id: product,
    product_category_id: product_cat
  },

  function (data, status) {
    console.log("Data: " + data + "\nStatus: " + status);
    // return;
    if (status == "success") {
      var dataParsed = JSON.parse(data);
      // if(dataParsed.so_details.code==1001){
      // document.getElementById('spinner').style.display = 'none';
      // document.getElementById('error_page').innerText = "Sorry! This item is no longer available";
      // document.getElementById('error_page').style.display = 'block';
      // document.getElementById('footer-div').style.display = 'block';
      // document.getElementById('savenCont').innerText = "Buy Now";
      // return;
      // }
      // if(dataParsed.code==1){
      //   document.getElementById('spinner').style.display = 'none';
      //   document.getElementById('error_page').innerText = "Some error occured!";
      //   document.getElementById('error_page').style.display = 'block';
      //   document.getElementById('footer-div').style.display = 'block';
      //   document.getElementById('savenCont').innerText = "Buy Now";
      //   return;
      //   }
        // if(dataParsed.email_code==1){
        //   document.getElementById('email').style.display = 'block';
        // }
      document.getElementById('display_name').innerText = dataParsed.display_name;
      document.getElementById('actual_price').innerText = dataParsed.display_actual_price;
      document.getElementById('date').innerText = dataParsed.display_date+" from "+dataParsed.display_time;
      if(dataParsed.tncArr[0]==null){
        document.getElementById('tnc').style.display = 'none';
      }
      document.getElementById('tnc').innerText = dataParsed.tncArr[0];
      description = dataParsed.display_name+" from "+dataParsed.display_date+" at "+dataParsed.display_time;
      var discount = parseFloat(dataParsed.display_actual_price) - parseFloat(dataParsed.display_discount_price);
      var gst = dataParsed.tax;
      salesOrder_id = dataParsed.salesOrder_id;
      console.log(salesOrder_id);
      total = parseFloat(dataParsed.display_actual_price) + gst - discount;
      document.getElementById('discount').innerText = discount;
      // document.getElementById('date').innerText = "29 Aug 2020 at 06:00AM";
      document.getElementById('GST').innerText = gst+"/-";
      document.getElementById('total_price').innerText = total;
      // document.getElementById('tnc').innerText = "jhdjkshdjkskd";
      document.getElementById('spinner').style.display = 'none';
      //document.getElementById('footer-div').style.display = 'block';
      document.getElementById('main_content').style.display = 'block';
      //console.log("passed");

      // document.getElementById('display_name').innerText = dataParsed.item_id_zoho;


    }
  });

function confirmPay() {
  document.getElementById('spinner').style.display = 'block';
  document.getElementById('main_content').style.display = 'none';

  console.log(total);
  $.post("https://sultry-tax.000webhostapp.com/act_pay.php",
    {
      amount: total,
      salesOrder_id: salesOrder_id,
        product_category_id: product_cat,
      authtoken: auth_token,
      //   product_id: 1,
      item_id: item_id,
      description: description
    },


    function (data, status) {
      console.log("Data: " + data + "\nStatus: " + status);
      if (status == "success") {

        var dataParsed = JSON.parse(data);
        alert(dataParsed);
        var url = dataParsed.payment_url;
        window.location.replace(url);

        // document.getElementById('display_name').innerText = dataParsed.item_id_zoho;


      }
    });

}

