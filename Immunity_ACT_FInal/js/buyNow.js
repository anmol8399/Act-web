
var options = [];

// $.post("https://sultry-tax.000webhostapp.com/action_id.php",
// {
//   action_id: 1,
//   auth: "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNDBlMzFiYTM3Y2QyMjQ4MjFkNDRjZTRjMDMxOWE2ZDliZDc0MGM3NDBkMzkzMjk1M2M2YzRjNTZjNTQ1Y2VmYWE4NDYxNDc0YjhjZDQzYjYiLCJpYXQiOjE1OTc3NTYyOTEsIm5iZiI6MTU5Nzc1NjI5MSwiZXhwIjoxNzU1NTIyNjkxLCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.sVQHdb6IymEN3crlDiBWwpji5iuYKStCpoazWB3t9-45G5Du8JabrUcT_UhK2olMY415fHdUkj5PjBt1vf7A1cStvhF7biqae5BIbyDGCUmtvPBx9jIcIyTDF2i7O24AzfNUyMHvl7TdBWMtSHpQerPr-w3IB_L7ds6_uH9rMrWIQP-nbyQfNFxWyQOuFcxUHt4zwL57PsEU7wpvXKqgx1U4C4VbUXgechRESESxettKQsnhCXvJ3pRk-1WU0Ys_eMOOtTWmlCg2eCoo0veATo4_E7BKKvE5nBUyLZgkED0lFGE5R-3visbFO5Uh5qeZPfL9hXfyyeqW7K5STvVVqjW_GZJ47_kEKdpc4Vacwkz48F37uLlZxhXcHt_1Eb1PniDoNtg6vyhsT24aSrhm4V_MXB4ltDc2II3DIeSBSAWubLGIyFpo2DffZFVm52aWhpyacH0hmf1d0x7OgBYB8PBLhErE6ez_pHov5G69DueiQeU85juEHrnehs1VdlvEDog5WPc9whBvF-m5XbLT5WqDCN74oiXVoPLAZI79S475KT3RxZxS7ILPECHNTxZ375s7LCYsEa_ihHlkt3CTfCENTwRMnCHqt2ejE5TONl6ac42eSqse1HjaqfE4JfmWvhnvKsmmQ4H4dTJ6J7tXP1rk_JPvD8j9N1rW3fVnYAo"
// },


// function(data,status){
//   // console.log("Data: " + data + "\nStatus: " + status);
//   if(status=="success"){
//     var dataParsed = JSON.parse(data);
//     options = dataParsed.groups;
//     var select = document.getElementById("selectNumber");
// // console.log("HAHA");
// // var options = ["1", "2", "3", "4", "03 Aug 2020"];
// // for(var i = 0; i < options.length; i++) {
// //     var opt = options[i];
// //     var el = document.createElement("option");
// //     document.getElementById('default-option').style.display = 'none';
// //     el.textContent = opt;
// //     el.value = opt;
// //     select.appendChild(el);
// // }
//     // window.location.href = "https://sultry-tax.000webhostapp.com/act_seeDetails.html";
//   }
// });



function DropDown(el) {
    this.dd = el;
    this.initEvents();
}
DropDown.prototype = {
    initEvents : function() {
        var obj = this;

        obj.dd.on('click', function(event){
            $(this).toggleClass('active');
            event.stopPropagation();
        }); 
    }
}

function optionChange(){
    selectElement = document.querySelector('#selectNumber'); 
    output = selectElement.options[selectElement.selectedIndex].value; 
    alert(output);
}

$(document).ready(function() {
    console.log('dom_loaded');
    $('#submit').click(function() {
        console.log('clicked');
  
      var radios = ['Email', 'Phone', 'Mail'];
  
      for (var value of radios)
      {
        $('#container').append(
          $('<input>').prop({
            type: 'radio',
            id: value,
            name: 'contact',
            value: value
          })
        ).append(
          $('<label>').prop({
            for: value
          }).html(value)
        )
      }
    })
  });