// Docs at http://simpleweatherjs.com

/* Does your browser support geolocation? */
if ("geolocation" in navigator) {
  $('.js-geolocation').show(); 
} else {
  $('.js-geolocation').hide();
}

  var geocoder;

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
} 
//Get the latitude and the longitude;
function successFunction(position) {
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    codeLatLng(lat, lng);
}

function errorFunction(){
    alert("Geocoder failed");
}

  function initialize() {
    geocoder = new google.maps.Geocoder();



  }

/* 
* Test Locations
* Austin lat/long: 30.2676,-97.74298
* Austin WOEID: 2357536
*/
function codeLatLng(lat, lng) {

    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
      console.log(results)
        if (results[1]) {
         //formatted address
         alert(results[0].formatted_address)
        //find country name
             for (var i=0; i<results[0].address_components.length; i++) {
            for (var b=0;b<results[0].address_components[i].types.length;b++) {

            //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                if (results[0].address_components[i].types[b] == "administrative_area_level_1") {
                    //this is the object you are looking for
                    city= results[0].address_components[i];
                    break;
                }
            }
        }
        //city data
        return city;


        } else {
          alert("No results found");
        }
      } else {
        alert("Geocoder failed due to: " + status);
      }
    });
  }

$(document).ready(function() {
  loadWeather('London',''); //@params location, woeid
//    navigator.geolocation.getCurrentPosition(function(position) {
//        console.log(position);
//      loadWeather(codeLatLng(position.coords.latitude,position.coords.longitude)); //load weather using your lat/lng coordinates
//    });
});

function loadWeather(location, woeid) {
  $.simpleWeather({
    location: location,
    woeid: woeid,
    unit: 'c',
    success: function(weather) {
      $('.header-weather .report').html(weather.temp+'&deg;'+weather.units.temp);
      $('.header-weather .city small').html(weather.currently);
      $('.header-weather .city b').html(weather.city+', '+weather.country);
      
      
      var cloudImage;
      if(weather.currently=='Mostly Cloudy'){
          cloudImage = '/assets/images/weather-cloudy.png';
      }
      
      if(weather.currently=='Partly Cloudy'){
          cloudImage = '/assets/images/weather-sun-cloud.png';
      }
      
      $('.header-weather img').attr('src',cloudImage);
    },
    error: function(error) {
      $("#weather").html('<p>'+error+'</p>');
    }
  });
}
