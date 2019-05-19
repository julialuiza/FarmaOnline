var map;
 
function initialize() {
    var latlng = new google.maps.LatLng(-3.107190, -60.026100);
 
    var options = {
        zoom: 12,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
 
    map = new google.maps.Map(document.getElementById("mapa"), options);
}
 
initialize();

function marcarPonto(Latitude,Longitude) {
    var latlng = new google.maps.LatLng(Latitude, Longitude);
 
    var options = {
        zoom: 15,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
 
    map = new google.maps.Map(document.getElementById("mapa"), options);

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(Latitude, Longitude),
        title: "Localização UBS",
        map: map
    }); 
}