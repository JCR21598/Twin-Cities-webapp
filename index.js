
// jQuery Function 
$(document).ready(function(){  
  
    //Additional Weather Function
    updateWeather()
  
    setTimeout("updateWeather()", 60000)
  
    //call once on doc load
    callPOIupdate();
    //update every 15min
    setTimeout("callPOIupdate()",900000);

    //execute on doc load
    update();
    //then call every 2min
    setInterval("update()",1200000);

    //RSS Toggling Button
    $(".RSS-button").click(function(){
      $("#rssfeed").fadeToggle();
    });
  
});


//Twitter jQuery functionality 

//ajax to populate twitter sentiment score for POIs on load and every 10 min
function callPOIupdate(){
  $.ajax({
    type: "GET",
    url:"twitter/SentimentAnalysis.php",
    success: function(result){
      //console log result for debugging
       console.log(result)                          
  }});
}

//ajax to populate twitter feeds onload and every 2mins
function update(){
  $.ajax({
      type: "GET",
      url:"twitter/RennesTwitter.php",
      success: function(result){
          $("#RTweets").html(result);                            

  }});

  $.ajax({
      type: "GET",
      url:"twitter/ExeterTwitter.php", 
      success: function(result){
          
      $("#ETweets").html(result);
  }});
}


//Weather functions for jQuery 

function updateWeather(){

  //Code uses an API made from OpenWeather at https://openweathermap.org/

  //Ajax call for Exeter
  $.ajax({
    url: "http://api.openweathermap.org/data/2.5/weather?q=Exeter,uk&units=metric&appid=d29cf117a0fb58b32079849c93c64387",
    type: "GET",
    dataType: "jsonp",
    success: function(data){    //the content of data will be what we get from the url 
      var exeterInfo = showData(data);
          
      $("#Exeter-WeatherAPI").html(exeterInfo);

      }
  });

  //Ajax call for Rennes
  $.ajax({
    url: "http://api.openweathermap.org/data/2.5/weather?q=Rennes,fr&units=metric&appid=d29cf117a0fb58b32079849c93c64387",
    type: "GET",
    dataType: "jsonp",
    success: function(data){    //the content of data will be what we get from the url 
      var rennesInfo = showData(data);
          
      $("#Rennes-WeatherAPI").html(rennesInfo);

    }
  });
}

function showData(data){
  return "<h4><strong>Location</strong>: </h4>" + data.name  + "<br>" +
         "<h4><strong>Long:</strong></h4>" + data.coord.lon + "<h4><strong> Lat:</strong></h4>" + data.coord.lat + "<br>" +
         "<h4><strong>Today's Weather Description</strong>: </h4>" + data.weather[0].description + "<br>" + 
         "<h4><strong>Humidity</strong>: </h4>" + data.main.humidity + "%<br>" +
         "<h4><strong>Wind Speed</strong>: </h4>" + data.wind.speed + " km/hour" + " at " + data.wind.deg + " degrees<br>"; 
}

//Code based on Google tutorials at:
//https://developers.google.com/maps/documentation/javascript/adding-a-google-map

//MAP FUNCTIONALITY 
function initMap() {

  //grabs both exeter and rennes id
   var emap = new google.maps.Map(document.getElementById('emap'), {
    center: {lat: 50.7269, lng: -3.533623},
    zoom: 13
  });
  
  var rmap = new google.maps.Map(document.getElementById('rmap'), {
    center: {lat: 48.1173, lng: -1.6778},
    zoom: 13
  });

  //initialise infowindow object
  var infoWindow = new google.maps.InfoWindow();

  //call function to be able to call php file asynchronously, returns the XMLHTTPREQUEST object 
  downloadUrl('getvars.php', function(data) {
  
  	var xml = data.responseXML;
    //going through the XML file and getting all its atttributes
    var markers = xml.documentElement.getElementsByTagName('marker');
    Array.prototype.forEach.call(markers, function(markerElem) {
      //getting the attributes of the XML file
      var id = markerElem.getAttribute('id');
      var name = markerElem.getAttribute('name');
      var type = markerElem.getAttribute('type');
      var city = markerElem.getAttribute('city');
      var country = markerElem.getAttribute('country');
      var woeid = markerElem.getAttribute('WOEID');
      var postcode = markerElem.getAttribute('postcode');
      var capacity = markerElem.getAttribute('capacity');
      var construction = markerElem.getAttribute('construction');
      var cityid = markerElem.getAttribute('cityid');
      var wikilink = markerElem.getAttribute('wikilink');
      var icon_name = markerElem.getAttribute('icon_name');
      var photo_path = markerElem.getAttribute('photo_path');
      var description = markerElem.getAttribute('description');
      var tweet = markerElem.getAttribute('tweet');
      var point = new google.maps.LatLng(
        parseFloat(markerElem.getAttribute('latitude')),
        parseFloat(markerElem.getAttribute('longitude')));
      
      //create content for map markers
      var infowincontent = document.createElement('div');

        //add marker name
        var strong = document.createElement('strong');
        strong.textContent = name;
        infowincontent.appendChild(strong);
        infowincontent.appendChild(document.createElement('br'));

        //add marker type
        var typeEl = document.createElement('typeEl');
        typeEl.textContent = type;
        infowincontent.appendChild(typeEl);
        infowincontent.appendChild(document.createElement('br'));

        //add marker postcode
        var postcodeEl = document.createElement('postcodeEl');
        postcodeEl.textContent = postcode;
        infowincontent.appendChild(postcodeEl);
        infowincontent.appendChild(document.createElement('br'));
        infowincontent.appendChild(document.createElement('br'));
      
      //Icons taken from:
      //https://mapicons.mapsmarker.com/

      //base url for marker icons
      var iconBase = 'icons/';
      
      //select which map to add marke to
      if(cityid == 1){
        //add to exeter
        var marker = new google.maps.Marker({
                map: emap,
                position: point,
                icon: iconBase + icon_name
              });
      }
      else{
        //add to rennes
      	var marker = new google.maps.Marker({
                map: rmap,
                position: point,
                icon: iconBase + icon_name
              });
      }

      //add listener for mouse over
      marker.addListener('mouseover', function() {
        infoWindow.setContent(infowincontent);
        if(cityid == 1){
          infoWindow.open(emap, marker);
        }
        else{
          infoWindow.open(rmap, marker);
        }
        
      });
      marker.addListener('mouseout', function() {
        if(cityid == 1){
          infoWindow.close();
        }
        else{
          infoWindow.close();
        }
        
      });

      //eventListener for when marker is clicked 
      marker.addListener('click', function() {
        
        document.getElementById("overlay").style.display = "block";
        //content for overlay
        $(".overlay-POI").html("<p>"+name+"</p>");
        $(".overlay-location").html("<p>"+city+" , "+country+"</p>");
        $(".overlay-postcode").html("<p>Postcode: "+postcode+"</p>");

        $(".overlay-image").html("<img class = 'overlay-img' src ='"+photo_path+"'>");

        $(".overlay-tweet").html("<p>"+tweet+"% of tweets tagging this have been positive"+"</p>");
        $(".overlay-description").html("<p>"+description+"</p>");
        $(".overlay-wiki").html("<a href='" + wikilink + "'>" + wikilink+"</a>");
      });
    });
  });
}

//close overlay funciton
function closeOverlay(){
  document.getElementById("overlay").style.display = "none";
}

function doNothing() {}

//function to determnine brower type and ajax call for url
function downloadUrl(url,callback) {
 var request = window.ActiveXObject ?
     new ActiveXObject('Microsoft.XMLHTTP') :
     new XMLHttpRequest;

 request.onreadystatechange = function() {
   if (request.readyState == 4) {
     request.onreadystatechange = doNothing;
     callback(request, request.status);
   }
 };

 request.open('GET', url, true);
 request.send(null);
}



