
const quer = window.location.search;
// console.log(queryString);
const urlParams = new URLSearchParams(quer);
// const product = urlParams.get('product_id');
// const product_cat = urlParams.get('product_cat_id');
const auth_token = urlParams.get('u');

$.post("https://sultry-tax.000webhostapp.com/act_product_categories.php",
    {
        // action_id: this.value,
        auth: auth_token
    },
    function (data, status) {
        console.log("Data: " + data + "\nStatus: " + status);
        if(Error){
            document.getElementById('spinner').style.display = 'none';
            document.getElementById('error_msg').style.display = 'block';
        }
        if (status == "success") {
          var dataParsed = JSON.parse(data);
          document.getElementById('error_msg').style.display = 'none';

            
            // window.location.href = "https://sultry-tax.000webhostapp.com/act_seeDetails.html";
            createCards(dataParsed);
        }
        // console.error("Error aaya hai");
    });







$(document).ready(function () {
    $("button").click(function () {
        var product_id = this.value;
        window.location.href = "/seeDetails.html?product_id=" + product_id + "&u=" + 1;

        //     $.post("https://sultry-tax.000webhostapp.com/action_id.php",
        //         {
        //             action_id: this.value,
        //             auth: "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMGU4ZDIzMTMyNzY1YWIzNTllYWMzNDJlNzI3ZTY2ZTZlMDk4MDI0YTM4NDU3NDlhM2YyZDMwYzU2MWUxMzZlNDc1Mzg4MGJiNTc5MmVkZGMiLCJpYXQiOjE1OTcyMTAwNjQsIm5iZiI6MTU5NzIxMDA2NCwiZXhwIjoxNzU0OTc2NDY0LCJzdWIiOiI4Iiwic2NvcGVzIjpbXX0.opeW1Soy6Sei5Arpga3Tp8bMcrw_95-Z03EYrbMsaI6iMH0sXTU6dij4jLHUaGOqaZHeEw7DV1UvFYBWymtHQPKEuRlSv0stQqky_Q3oAnUiZzO9yMaW_JAZtp6BjxU9Q3MKmg4FWpifOria24C0kYHMI_oJ7o39nHN5m8XtmqAc1wDSY4hS73-LZGqUcapWdrgzXqoXMWxcZ3gm-X8_EaOBn85QqS1c5iuvMEowb6kq2K79i7klCs2jtLy_DAvzqOx-UOwQN6ov3QMhAunNQlfmtKccE0pl7TPMdrNFc-JYaEd_eS5nJU5gOTnwuK2otul_KztgpQ--8fz0sfAkpjO9VpT9k0M5hcER6y6qIbMmOUPyF73TYPwHUFFWC4ORhb1UhonRmohPJIPqPgpg-qCaVB-ztvGqDeEmSD4vSeiUCYFjFiglpeVQyvUf4GHP22ivjofodZXd4zStc31aPKoYSvyy23RnHvsb2MEDFRZfBNJG4pFFhunNkrDAaJlNKw97fc2NdLQzeUJYBApQPVBspcd0ADL_Ox_rla4E9d0fbUGySd_gcylvXHO_GDLa_yMTQVWZsInVKJ_FwpzctLCQ3q0CEz3z2bhFq2KeEBoi-feNzCKr_2wnMNYdGrJeWjDg7th8yUTtUzJegwxQ8ziOr7pLlmqD1oo3jEDufyo"
        //         },

        //         function (data, status) {
        //             console.log("Data: " + data + "\nStatus: " + status);
        //             if (status == "success") {
        //                 window.location.href = "https://sultry-tax.000webhostapp.com/act_seeDetails.html";

        //             }
        //         });
    });
    // $('img').click(function(){
    //     var id = $(this).attr('id').substring(1);
    //     window.location.href = "/seeDetails.html?product_id="+id;

    // });
});



function getId() {
    console.log(this.event.target.id);
    window.location.href = "/seeDetails.html?product_id=1222&product_cat_id=" + this.event.target.id + "&u=" + auth_token;
}







// createCards();
function createCards(dataParsed) {
//product_cat_product_id
if(dataParsed.category_num==0){
    document.getElementById('spinner').style.display = 'none';
    document.getElementById('error_msg').style.display = 'block';
    console.log('Something went wrong!');
}

    const scrollersCount = dataParsed.category_num;
    var body = document.getElementById('body');
    var links = dataParsed.category_urls;
    var rowsCount = scrollersCount;
    var product_ids = dataParsed.product_ids;
    var imageCounts = dataParsed.image_numbers;
    var linkCounter = 0;
    for (var i = 0; i < rowsCount; i++) {
        body.appendChild(document.createElement('br'));
        var h2 = document.createElement('h1');
        h2.setAttribute('style','padding-left: 2%; font-family: "Playfair Display", serif;font-size: 55px');
        h2.innerHTML = dataParsed.category_names[i];
        body.appendChild(h2);
        var div = document.createElement('div');
        div.classList.add('scrolling-wrapper');
        for (var j = 0; j < imageCounts[i]; j++) {
            var imageDiv = document.createElement('div');
            imageDiv.classList.add('container', 'card');
            var img = document.createElement('img');
            img.id = product_ids[j];
            img.src = links[linkCounter++]; //use linkCounter++
            img.setAttribute("onclick", "getId()");
            //img.onclick = getId();
            imageDiv.appendChild(img);
            div.appendChild(imageDiv);
        }
        body.appendChild(div);
        document.getElementById('spinner').style.display = 'none';

    }
}




// function imgClick(){
//     $('img').click
//                     window.location.href = "https://www.google.com";

// }


//eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNDBlMzFiYTM3Y2QyMjQ4MjFkNDRjZTRjMDMxOWE2ZDliZDc0MGM3NDBkMzkzMjk1M2M2YzRjNTZjNTQ1Y2VmYWE4NDYxNDc0YjhjZDQzYjYiLCJpYXQiOjE1OTc3NTYyOTEsIm5iZiI6MTU5Nzc1NjI5MSwiZXhwIjoxNzU1NTIyNjkxLCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.sVQHdb6IymEN3crlDiBWwpji5iuYKStCpoazWB3t9-45G5Du8JabrUcT_UhK2olMY415fHdUkj5PjBt1vf7A1cStvhF7biqae5BIbyDGCUmtvPBx9jIcIyTDF2i7O24AzfNUyMHvl7TdBWMtSHpQerPr-w3IB_L7ds6_uH9rMrWIQP-nbyQfNFxWyQOuFcxUHt4zwL57PsEU7wpvXKqgx1U4C4VbUXgechRESESxettKQsnhCXvJ3pRk-1WU0Ys_eMOOtTWmlCg2eCoo0veATo4_E7BKKvE5nBUyLZgkED0lFGE5R-3visbFO5Uh5qeZPfL9hXfyyeqW7K5STvVVqjW_GZJ47_kEKdpc4Vacwkz48F37uLlZxhXcHt_1Eb1PniDoNtg6vyhsT24aSrhm4V_MXB4ltDc2II3DIeSBSAWubLGIyFpo2DffZFVm52aWhpyacH0hmf1d0x7OgBYB8PBLhErE6ez_pHov5G69DueiQeU85juEHrnehs1VdlvEDog5WPc9whBvF-m5XbLT5WqDCN74oiXVoPLAZI79S475KT3RxZxS7ILPECHNTxZ375s7LCYsEa_ihHlkt3CTfCENTwRMnCHqt2ejE5TONl6ac42eSqse1HjaqfE4JfmWvhnvKsmmQ4H4dTJ6J7tXP1rk_JPvD8j9N1rW3fVnYAo