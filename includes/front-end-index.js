jQuery(document).ready(function(){





   jQuery(".main-container").css("height", window.innerHeight);

   
  

    var rightStatus = "open";

jQuery(function(){

  jQuery('.slider-arrow-right').click(function(){
  
        if(rightStatus === "closed"){
  
      jQuery( ".slider-arrow-right, .right-panel" ).animate({
  
          right: "+=240"
  
      }, 700, function() {
        
 rightStatus = "open";
      

          });
  
        jQuery(this).html('&raquo;');
  
        }
  
        else {    
  
      jQuery( ".slider-arrow-right, .right-panel" ).animate({
  
          right: "-=240"
  
      }, 700, function() {
           

            rightStatus = "closed";
            
          });
  
      jQuery(this).html('&laquo;');    
  
        }
  
    });

});

var leftStatus = "open";

jQuery(function(){

  jQuery('.slider-arrow').click(function(){
  
        if(leftStatus === "closed"){
  
      jQuery( ".slider-arrow, .left-panel" ).animate({
  
          left: "+=240"
  
      }, 700, function() {
        
 leftStatus = "open";
      

          });
  
        jQuery(this).html('&laquo;');
  
        }
  
        else {    
  
      jQuery( ".slider-arrow, .left-panel" ).animate({
  
          left: "-=240"
  
      }, 700, function() {
           

            leftStatus = "closed";

          });
  
      jQuery(this).html('&raquo;');    
  
        }
  
    });

});

});


var typeofb = [];

var typeofc ;

var typeofs = [];

var typeofIntin = [] ;

var mapmarkers = [] ;

var fin = [] ;

var marker;


jQuery(document).ready(function(jQuery) {


jQuery( window ).load(function() {
 

var country = document.getElementById("country"); 


typeofc  = document.getElementById("map").getAttribute("data-id") ;


setupMap(typeofc,'map');


    for (iLoop = 0; iLoop< country.options.length; iLoop++)

  
  {    
      

        if (country.options[iLoop].value == document.getElementById("map").getAttribute("data-id"))

      {

        country.options[iLoop].selected = true;
       
        break;

      }


    }


});

function setupMap(para,para1) {

var geocoder;

geocoder = new google.maps.Geocoder();

geocoder.geocode( { 'address': para}, function(results, status) {



if (status == google.maps.GeocoderStatus.OK) {



 map = new google.maps.Map(document.getElementById("map"),{
            
         center: results[0].geometry.location,
          
          zoom: 9
  
        });


}



 });




}



jQuery(document).on("click",".dbtob",function(event){


 var action = (event.target.checked ? 'add' : 'remove');


 updateSelected(action,event.target.value,typeofb);



});


var updateSelected = function(action,id,para) {


  if (action === 'add' && para.indexOf(id) === -1) {

    para.push(id);

  }


  if (action === 'remove' && para.indexOf(id) !== -1) {

    para.splice(para.indexOf(id), 1);

  }


var data = {
    

                'action': 'filter_serviceactionfe',
                'typeofb[]': para,
                security:'<?php jQueryajax_nonce = wp_create_nonce( "travel_light_secure" ); echo jQueryajax_nonce; ?>',
               

  };


jQuery.post(ajax_object.ajax_url, data, function(response) {


jQuery(".typeofservice").html(response);


});


}



document.getElementById('country').addEventListener('change', function() {

typeofc = this.value ;

setupMap(this.value,'map');

}, false);



jQuery(document).on("click",".dbserchk",function(event){


 var action = (event.target.checked ? 'add' : 'remove');



if (action === 'add' && typeofs.indexOf(this.value) === -1) {

    typeofs.push(this.value);


var data = {
    'action': 'filter_placehldersactionfe',
                'typeofs[]': typeofs,
                'typeofc':typeofc,
                'dataType':'json',
                 security:'<?php jQueryajax_nonce = wp_create_nonce( "travel_light_secure" ); echo jQueryajax_nonce; ?>',
               

  };




jQuery.getJSON(ajax_object.ajax_url, data, function(response) {


drop(response);


});



  }

if (action === 'remove' && typeofs.indexOf(this.value) !== -1) {

   
var ser = typeofs[typeofs.indexOf(this.value)]


mapmarkers = jQuery.grep(mapmarkers, function( a,i ) { 


if((a.metadata.service === ser) && (a.metadata.set === 'false'))

{


 a.setMap(null);


}


return a;


});


typeofs.splice(typeofs.indexOf(this.value), 1);




  }





});






jQuery(document).on("click","#placetag",function(event){

var data = {

    'action': 'filter_plcbrd_action',
              'typeofb':this.innerHTML,
              'typeofc':typeofc,
              'dataType':'json',
               security:'<?php jQueryajax_nonce = wp_create_nonce( "travel_light_secure" ); echo jQueryajax_nonce; ?>',
                
  };


jQuery.getJSON(ajax_object.ajax_url, data, function(response) {


drop(response);



});




});


jQuery("#place").keydown(function(){



var data = {

    'action': 'filter_actionfilter',
                'typeofb':jQuery(".target").val(),
'typeofc':typeofc,
                
  };


jQuery.post(ajax_object.ajax_url, data, function(response) {

jQuery(".brandservice").html(response);

});



});


jQuery(document).on("click",".addTobtn",function(event){


var pos = this.value;
var child = this.parentNode.parentNode;

child.parentNode.removeChild(child);



typeofIntin.splice(typeofIntin.indexOf(this.value), 1);

mapmarkers = jQuery.grep(mapmarkers, function( a , i) { 



if(a.metadata.companyID == pos)

{

 a.setMap(null);


}



return a.metadata.companyID != pos; 


});



});

function randomString(length, chars) {
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}


jQuery(document).on("click","#booktrip",function(event){

var token = randomString(5,'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

jQuery(".chktoken").val(token);

  var data = {

    'action': 'booktrip',
    'itinerary':typeofIntin,
    'token':token,
     security:'<?php jQueryajax_nonce = wp_create_nonce( "travel_light_secure" ); echo jQueryajax_nonce; ?>',

                
  };


jQuery.post(ajax_object.ajax_url, data, function(response) {


document.getElementById("tripconfirmform").submit();

});


});



});

function geTcORDS (para)

{


var latlng = para.latlng.replace("(","");

latlng = latlng.replace(")","");

latlng = latlng.split(",");

var myCenter = new google.maps.LatLng(latlng[0],latlng[1]);

return myCenter;


}


function geTcORDSPlc (para)

{

var latlng = String(para).replace("(","");


latlng = String(latlng).replace(")","");


return latlng;


}



function removeMarkers() {

    for(i=0; i < mapmarkers.length; i++){

        mapmarkers[i].setMap(null);

    }

}



function drop (response) {



  for (var i = 0; i < response.length; i++) {


    var myCenter = geTcORDS(response[i]);


    addMarkerWithTimeout(myCenter, i * 200,response[i]);


  }




}



function geTlat (para)

{


var latlng = String(para).replace("(","");

latlng = latlng.replace(")","");

latlng = latlng.split(",");

return latlng[0];


}


function geTlng (para)

{

var latlng = String(para).replace("(","");

latlng = latlng.replace(")","");

latlng = latlng.split(",");

return latlng[1];


}

function setContent (para,content) 


{


logo = content.appendChild(document.createElement('img'));

logo.src= para.image;

logo.setAttribute("style","width:100%;padding:10px;height:50%");

logo.setAttribute("class","img-responsive");

title = content.appendChild(document.createElement('h3'));

title.innerHTML = para.company;

address = content.appendChild(document.createElement('h4'));

address.innerHTML = para.address;

phone = content.appendChild(document.createElement('h5'));

phone.innerHTML = para.phone;

email = content.appendChild(document.createElement('h5'));

email.innerHTML = para.email;

url = content.appendChild(document.createElement('h5'));

url.innerHTML = para.website;

return  content;


}


function addMarkerWithTimeout(position,timeout,para) {


window.setTimeout(function() {

var infowindow = new google.maps.InfoWindow();

var marker = new google.maps.Marker({

      position: position,

      draggable: true,

      map: map,

      title:para.company,

      icon:para.icon,

      metadata: {


            service:para.service,

            set:'false',

            lat:geTlat(position) , 
 
            lng:geTlng(position),

            companyID:para.companyID

   },

      animation: google.maps.Animation.DROP

    });




    mapmarkers.push(marker);


var content = document.createElement('div');

setContent(para,content);


button = content.appendChild(document.createElement('P'));
                      
                      button.innerHTML =  (chkB(para) == -1) ? 'Add to itinerary!' : 'Delete from itinerary';

                      button.setAttribute("style","float:right;padding:2px;cursor:pointer;");

   google.maps.event.addDomListener(button, 'click', function () {

                           showMore(para,this,marker,infowindow);

                      });


  google.maps.event.addListener(marker, 'click', function () {


                           infowindow.setOptions({

                              content:content ,

                              map: map,

                              position:position

                          });



});

google.maps.event.addListener(marker, 'dragstart', function() {


     marker.setPosition(position);


  });

google.maps.event.addListener(marker, 'drag', function() {


    marker.setPosition(position);


  });

  }, timeout);


                      
                  

}


function chkB(para) {


return typeofIntin.indexOf(para.company);


              }


function showMore(para,button,marker,infowindow) 

{

if (typeofIntin.indexOf(para.company) === -1) 

{

var pos = null;

typeofIntin.push(para.companyID);

button.innerHTML =  (chkB(para) === -1) ? 'Add to itinerary!' : 'Delete from itinerary';

mapmarkers = jQuery.grep(mapmarkers, function(a , i) { 

if(a.title === para.company )

{


a.metadata.set = 'true';

pos = a.metadata.companyID;


}


return a; 


});



addPlaceDetails(para.company,para.compDescription,pos);




}

else

{


typeofIntin.splice(typeofIntin.indexOf(para.companyID), 1);

button.innerHTML =  (chkB(para) === -1) ? 'Add to itinerary!' : 'Delete from itinerary';

infowindow.close();

mapmarkers = jQuery.grep(mapmarkers, function( a , i) { 

idx = i ;

if(a.title === para.company && a.metadata.set === 'true')

{


 a.setMap(null);
 a.metadata.set = 'false';


}


return a; 


});


mapmarkers.splice(idx, 1);


}



}


function addPlaceDetails(para,para1,para2) {

var place , header, content , paragraph, logo ,subtitle ,addTo;

var newItem = document.createElement("li");  

place = document.createElement("div");

place.setAttribute("style","position:relative; width: 100%;");

place.setAttribute("class","w3-card-4");

header = document.createElement("header");

header.setAttribute("class","w3-container w3-light-grey");

header.appendChild(document.createTextNode(para));

content = document.createElement("div");

content.setAttribute("class","w3-container");

content.setAttribute("style","padding:10px;");

paragraph = document.createElement("p");

paragraph.appendChild(document.createTextNode(para1));

logo = document.createElement("img");

logo.setAttribute("class","w3-left w3-circle");

logo.setAttribute("style","width:20%;padding-right:10px;");

subtitle = document.createElement("p");

subtitle.setAttribute("style","padding-left:15px!important;position:relative;");

content.appendChild(subtitle);

content.appendChild(logo);

content.appendChild(paragraph);

header.appendChild(content);

addTo = document.createElement("button");
    
addTo.appendChild(document.createTextNode("Remove from Itinerary"));           

addTo.setAttribute("class","w3-btn-block w3-dark-grey addTobtn");

addTo.setAttribute("value",para2);

place.appendChild(header);

place.appendChild(addTo);

newItem.appendChild(place); 

newItem.appendChild(document.createElement("br"));


var list = document.getElementById("side-panel-right-list");  



list.appendChild(newItem);



}

