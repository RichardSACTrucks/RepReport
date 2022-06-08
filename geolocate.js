function getLocation() 
{
    if (navigator.geolocation) 
    {
        navigator.geolocation.watchPosition(showPosition);
    } 
    else 
    { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) 
{
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    var gac = position.coords.accuracy;
    document.cookie="lat=" + lat;
    document.cookie="lng=" + lng;
    document.cookie="gac=" + gac;
}