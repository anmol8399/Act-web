var i = 0;
$.post("https://sultry-tax.000webhostapp.com/act_myOrders.php",
{
  product_category_id: 1,
  authtoken: 123,
  product_id: 1,
  item_id: 1
},


function (data, status) {
  console.log("Data: " + data + "\nStatus: " + status);
  if (status == "success") {
    var dataParsed = JSON.parse(data);
    for(i = 0;i<dataParsed.count;i++){
        createCard(dataParsed.image_urls[i],dataParsed.headers[i],dataParsed.parameters[i],dataParsed.days_to_go[i]);
    }

  }
});

function createCard(img_url, header, parameter, days_to_go){
    var parentDiv = document.createElement('div');  
parentDiv.classList.add('card');
parentDiv.setAttribute('style','margin-top: 3%;padding-bottom: 10px; padding-top: 5%;width: 90%; display: block; margin-left: auto; margin-right: auto;');
document.getElementById('body').appendChild(parentDiv);



var childDiv = document.createElement('div');  
childDiv.classList.add('container');
childDiv.setAttribute('style','position: relative;');
parentDiv.appendChild(childDiv);


/* <img width="20%" style="display: inline-block;font-style: italic;"
height="200%" src="http://uat.immunityhealth.me/product-image/Breath-Free.png" />
*/
var img = document.createElement('img');
// img.width = "20px";
// img.height = "200px";
img.setAttribute('style','height:20%;width:20%;display: inline-block;font-style: italic;');
img.src = img_url;
childDiv.appendChild(img);
// document.getElementById('body').appendChild(parentDiv);
var childDiv1 = document.createElement('div');  
// childDiv1.classList.add('container');
childDiv1.setAttribute('style','display: inline-block; position: absolute; top: 0; margin-left: 12px; margin-right: 12px;');
childDiv.appendChild(childDiv1);

var h2 = document.createElement('h2');
h2.innerHTML = header;  
// childDiv1.classList.add('h2');
h2.setAttribute('style','font-size: 150%; margin-top: -2%;margin-bottom: 0px;');
childDiv1.appendChild(h2);
/* <span style="font-size: 150%;margin-top: -100px;">27 Aug 2020 - 30 Aug 2020 at</span> */

var span = document.createElement('span');
span.innerHTML = parameter;  
// childDiv1.classList.add('h2');
span.setAttribute('style','font-size: 100%;margin-top: -100px;');
childDiv1.appendChild(span);

var br = document.createElement('br');
childDiv1.appendChild(br);

{/* <span style="font-size: 150%;">06:00AM-07:00AM</span> */}
var span1 = document.createElement('span');
span1.innerHTML = "Breathe Litejdhjaskdhjkshdhsdhsahkd";  
// childDiv1.classList.add('h2');
span1.setAttribute('style','font-size: 100%;margin-top: -100px;');
childDiv1.appendChild(span);
// console.log('gadha');

var innerSpan = document.createElement('span');
innerSpan.setAttribute('style', 'color: #ff4769;');
innerSpan.id = "number_of_days";
innerSpan.innerHTML = days_to_go;
var outerspan = document.createElement('span');
outerspan.setAttribute('style', 'font-size: 100%;margin-bottom: 100%; margin-left: 12px;');
outerspan.appendChild(innerSpan);
if(days_to_go==0){
outerspan.innerHTML = "Expired";
}else{
outerspan.innerHTML = outerspan.innerHTML + " days to go";

}
outerspan.appendChild(document.createElement('br'));
childDiv.appendChild(outerspan);
}

// var parentDiv = document.createElement('div');  
// parentDiv.classList.add('card');
// parentDiv.setAttribute('style','margin-top: 3%;padding-bottom: 10px; padding-top: 5%;width: 90%; display: block; margin-left: auto; margin-right: auto;');
// document.getElementById('body').appendChild(parentDiv);



// var childDiv = document.createElement('div');  
// childDiv.classList.add('container');
// childDiv.setAttribute('style','position: relative;');
// parentDiv.appendChild(childDiv);


// /* <img width="20%" style="display: inline-block;font-style: italic;"
// height="200%" src="http://uat.immunityhealth.me/product-image/Breath-Free.png" />
// */
// var img = document.createElement('img');
// // img.width = "20px";
// // img.height = "200px";
// img.setAttribute('style','height:20%;width:20%;display: inline-block;font-style: italic;');
// img.src = "http://uat.immunityhealth.me/product-image/Breath-Free.png";
// childDiv.appendChild(img);
// // document.getElementById('body').appendChild(parentDiv);
// var childDiv1 = document.createElement('div');  
// // childDiv1.classList.add('container');
// childDiv1.setAttribute('style','display: inline-block; position: absolute; top: 0; margin-left: 12px; margin-right: 12px;');
// childDiv.appendChild(childDiv1);

// var h2 = document.createElement('h2');
// h2.innerHTML = "Breathe Lite";  
// // childDiv1.classList.add('h2');
// h2.setAttribute('style','font-size: 230%; margin-top: -2%;margin-bottom: 10px;');
// childDiv1.appendChild(h2);
// /* <span style="font-size: 150%;margin-top: -100px;">27 Aug 2020 - 30 Aug 2020 at</span> */

// var span = document.createElement('span');
// span.innerHTML = "Breathe Lite";  
// // childDiv1.classList.add('h2');
// span.setAttribute('style','font-size: 150%;margin-top: -100px;');
// childDiv1.appendChild(span);

// var br = document.createElement('br');
// childDiv1.appendChild(br);

// {/* <span style="font-size: 150%;">06:00AM-07:00AM</span> */}
// var span1 = document.createElement('span');
// span1.innerHTML = "Breathe Litejdhjaskdhjkshdhsdhsahkd";  
// // childDiv1.classList.add('h2');
// span1.setAttribute('style','font-size: 150%;margin-top: -100px;');
// childDiv1.appendChild(span);
// // console.log('gadha');

// var innerSpan = document.createElement('span');
// innerSpan.setAttribute('style', 'color: #ff4769;');
// innerSpan.id = "number_of_days";
// innerSpan.innerHTML = 5;
// var outerspan = document.createElement('span');
// outerspan.setAttribute('style', 'font-size: 150%;margin-bottom: 100%; margin-left: 12px;');
// outerspan.appendChild(innerSpan);
// outerspan.innerHTML = outerspan.innerHTML + " days to go";
// outerspan.appendChild(document.createElement('br'));
// childDiv.appendChild(outerspan);




