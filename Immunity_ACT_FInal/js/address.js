$(document).ready(function () {
  console.log('domaa');
  $('#dates li').click(function (e) {
    $(this).addClass('active').siblings().removeClass('active');
    console.log('acvive');


    // var nameInput = document.getElementById("input-name");

  });
});

var quer = window.location.search;
// console.log(queryString);
var urlParams = new URLSearchParams(quer);
var item_id = urlParams.get('item_id');
var product_cat = urlParams.get('product_cat_id');
var product_id = urlParams.get('product_id');
var auth_token = urlParams.get('u');

// alert("hahahaha");

$.post("https://sultry-tax.000webhostapp.com/act-post_address.php",
  {
    product_category_id: product_cat,
    authtoken: auth_token,
    product_id: product_id,
    item_id: item_id
  },


  function (data, status) {
    console.log("Data: " + data + "\nStatus: " + status);
    if (status == "success") {
      var dataParsed = JSON.parse(data);
      // options = dataParsed.groups;
      
      if(dataParsed.code)
      {
      document.getElementById('main_body').style.display = 'block';
          
      document.getElementById('spinner').style.display = "none";

        editAddress();
        setEditable();
        return;
      }
      var address_id = dataParsed.jsonData[0].id;
      var address_id_zoho = dataParsed.jsonData[0].address_id_zoho;
      var full_name = dataParsed.jsonData[0].full_name;
      var address = dataParsed.jsonData[0].address;
      var pinCode = dataParsed.jsonData[0].pincode;
      var contact_no = dataParsed.jsonData[0].mobile_number;
      var state = dataParsed.jsonData[0].state;
      document.getElementById('loader').style.display = "none";
      document.getElementById('spinner').style.display = 'none';
      document.getElementById('main_body').style.display = 'block';
      document.getElementById('name').innerText = full_name;
      document.getElementById('contact_info').innerText = contact_no;
      document.getElementById('address_line').innerText = address;
      document.getElementById('input-name').value = full_name;
      //  document.getElementById("input-name");
      document.getElementById("input-contact-number").value = contact_no;
      document.getElementById("input-address").value = address;
      document.getElementById("input-pincode").value = pinCode;
      document.getElementById("input-state").value = state;
      var y = document.getElementsByClassName('anchors')[0];
      y.id = address_id;
      var y = document.getElementsByClassName('anc')[0];
      y.id = address_id_zoho;
      console.log(y.id);
      var x = document.getElementsByClassName("anchors")[0].id;
      var z = document.getElementsByClassName("anc")[0].id;

      // document.getElementById("demo").innerHTML = x;
      console.log(x);
      console.log(z);
      //  document.getElementsByClassName('haha').id = "a"+address_id;
      //  document.getElementById().innerText = 
      //  document.getElementById().innerText = 
      // var select = document.getElementById("selectNumber");
      // console.log("HAHA");
    }
  });

function editAddress() {
  console.log('editAddrCalled');
  document.getElementById('loader1').style.display = 'none';
  document.getElementById('address_card').style.display = 'none';
  document.getElementById('editAdd').style.display = 'block';
  var x = document.getElementsByClassName("anchors")[0].id;
};

function setEditable()
{
  var nameInput = document.getElementById("input-name");
  var contactInput = document.getElementById("input-contact-number");
  var stateInput = document.getElementById("input-state");

  nameInput.style.color = "black";
  nameInput.onfocus = function () {
    
  }

  stateInput.style.color = "black";
  stateInput.onfocus = function () {
    
  }

  contactInput.style.color = "black";
  contactInput.onfocus = function () {
    
  } 
}

function saveAddress() {
  document.getElementById('main_body').style.display = 'none';
          
  document.getElementById('spinner').style.display = "block";
  document.getElementById('loader1').style.display = 'block';
  document.getElementById('savenCont').style.display = 'none';
  var contact_no = document.getElementById("input-contact-number").value;
  var address = document.getElementById("input-address").value;
  var pinCode = document.getElementById("input-pincode").value;
  var state = document.getElementById("input-state").value;
  var address_id = document.getElementsByClassName("anchors")[0].id;
  var address_id_zoho = document.getElementsByClassName("anc")[0].id;
  $.post("https://sultry-tax.000webhostapp.com/act-editAddress.php",
    {
      address_id: address_id,
      address_id_zoho: address_id_zoho,
      address: address,
      state: state,
      state_code: "PB",
      contact_number: contact_no,
      pinCode: pinCode,
      // product_category_id: 1,
      authtoken: auth_token,
      // product_id: 1,
      // item_id: 1
    },


    function (data, status) {
      console.log("Data: " + data + "\nStatus: " + status);
      if (status == "success") {
        var dataParsed = JSON.parse(data);
        if(dataParsed.status=="true"){
          var address_id_zoho = dataParsed.jsonData[0].address_id_zoho; 
        window.location.replace("/so.html?product_cat_id="+product_cat+"&product_id="+product_id+"&addr_id="+address_id_zoho+"&item_id="+item_id+"&product_id=1&product_category_id=1&u="+auth_token);

        }
        // windowF.location.replace("/so.html?product_cat_id="+product_cat+"&product_id="+product_id+"&addr_id="+address_id_zoho+"&item_id="+item_id+"&product_id=1&product_category_id=1&u="+auth_token);
      }
    });
}

function findGetParameter(parameterName) {
  var result = null,
    tmp = [];
  location.search
    .substr(1)
    .split("&")
    .forEach(function (item) {
      tmp = item.split("=");
      if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    });
  return result;
}

function proceed() {
  var x =document.getElementsByClassName('anc')[0].id;
  window.location.replace("/so.html?addr_id="+x+"&item_id="+item_id+"&product_id=1&product_category_id=1&u="+auth_token);
}

$(document).ready(function () {
  document.getElementById('editAdd').style.display = 'none';

  var nameInput = document.getElementById("input-name");
  var contactInput = document.getElementById("input-contact-number");
  var addressInput = document.getElementById("input-address");
  var pincodeInput = document.getElementById("input-pincode");
  var stateInput = document.getElementById("input-state");

  nameInput.style.color = "gray";
  nameInput.onfocus = function () {
    nameInput.blur();
  }

  stateInput.style.color = "gray";
  stateInput.onfocus = function () {
    stateInput.blur();
  }

  contactInput.style.color = "gray";
  contactInput.onfocus = function () {
    contactInput.blur();
  }

  var name = findGetParameter("name");
  var contact = findGetParameter("contact");
  var address = findGetParameter("address");


  contactInput.value = contact;
  addressInput.value = address;

});

function findGetParameter(parameterName) {
  var result = null,
    tmp = [];
  location.search
    .substr(1)
    .split("&")
    .forEach(function (item) {
      tmp = item.split("=");
      if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    });
  return result;
}