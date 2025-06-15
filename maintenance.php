<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Simple Map Example</title>

    <!-- Include Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>

<h3>My Simple Map</h3>
<div id="map"></div>

<!-- Include Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Dummy Latitude and Longitude
    var latitude = 6.9271;    // Colombo, Sri Lanka
    var longitude = 79.8612;

    // Initialize the map
    var map = L.map('map').setView([latitude, longitude], 13);

    // Set the map tiles (from OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Add a marker
    var marker = L.marker([latitude, longitude]).addTo(map)
        .bindPopup('Dummy Location: Colombo')
        .openPopup();
</script>

</body>
</html>