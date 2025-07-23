<?php include 'init.php'; ?>
<!DOCTYPE html>
<html lang="de">

<?php include 'head.php'; ?>
<!-- page css -->
<link href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    #map_view {
        height: 400px;
        /* or 500px, whatever you like */
        width: 100%;
    }
</style>

<body>
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <?php include 'config.php'; ?>
            <?php include 'header.php'; ?>
            <?php include 'sidebar.php';
            $action = 'update';
            $sql = "SELECT k.idkunde,k.nachname ,k.anrede ,k.vorname ,e.werksende ,  e.gps, e.feuerloescher,e.rwa, e.wandhydrant, e.brandschutztuer, e.rauchmelder,e.notleuchten,             
            e.interneseriennummer,e.idkundenbestand,e.loeschmittel,e.hersteller,e.typ,e.inhalt,e.bj,e.beschreibungstandort 
            FROM user_logins u JOIN kundenadressen k ON u.company_id=k.idkunde JOIN kundenbestand e ON e.idkunde=u.company_id 
            WHERE Foto1 IS NOT NULL  OR Foto2 IS NOT NULL OR Foto3 IS NOT NULL OR beschreibungstandort1  <> '' OR beschaedigung <> '' OR entsorgt =1 ";
            // echo $sql; $sesssion_uid
            $conn = $GLOBALS['con'];
            $result = mysqli_query($conn, $sql);
            $gps_locations = [];
            while ($row = mysqli_fetch_assoc($result)) {
                if (!empty($row['gps']) && strpos($row['gps'], ',') !== false) {
                    list($lat, $lng) = explode(',', $row['gps']);
                    $color = '';
                    if ($row['feuerloescher'] == '1') {
                        $color = 'red';
                    } else if ($row['rwa'] == '1') {
                        $color = 'orange';
                    } else if ($row['wandhydrant'] == '1') {
                        $color = 'blue';
                    } else if ($row['brandschutztuer'] == '1') {
                        $color = 'black';
                    } else if ($row['rauchmelder'] == '1') {
                        $color = 'violet';
                    } else if ($row['notleuchten'] == '1') {
                        $color = 'green';
                    } else {
                        $color = 'grey';
                    }
                    list($lat, $lng) = explode(',', $row['gps']);
                    $gps_locations[] = [
                        'lat' => trim($lat),
                        'lng' => trim($lng),
                        'label' => $row['beschreibungstandort'] ?? 'Standort',
                        'color' => $color
                    ];
                }
            }
            ?>

            <!-- Page Container START -->
            <div class="page-container">

                <!-- Content Wrapper START -->
                <div class="main-content">
                    <div class="page-header">
                        <h2 class="header-title">Feuerlöscher Liste</h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i
                                        class="anticon anticon-home m-r-5"></i>Startseite</a>
                                <span class="breadcrumb-item active"><?php echo ucfirst($action); ?> Feuerlöscher</span>
                            </nav>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-12">

                                    <p class="card-title">Standort des Feuerlöschers</p>
                                    <?php
                                    // echo '<pre>';
                                    // var_dump($gps_locations);
                                    // echo '<pre>'; 
                                    ?>
                                    <div id="map_view"></div>
                                    <br>
                                    <div class="text-center" >
                                        <h5><span class="badge badge-pill badge-primary">Wandhydrant</span>
                                        <span class="badge badge-pill badge-secondary">Rauchmelder</span>
                                        <span class="badge badge-pill badge-success">Notleuchten</span>
                                        <span class="badge badge-pill badge-danger">Feuerloescher</span>
                                        <span class="badge badge-pill badge-warning">RWA</span>
                                        <span class="badge badge-pill badge-dark">Brandschutztuer</span></h5>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Content Wrapper END -->
                <!-- Footer START -->
                <?php include 'footer.php'; ?>
                <!-- Footer END -->
            </div>
            <!-- Page Container END -->
        </div>
    </div>
    <!-- Include Leaflet JS -->
    <script>
        var gpsLocations = <?php echo json_encode($gps_locations); ?>;
    </script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        function getColoredIcon(color) {
            return new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-' + color + '.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
        }

        if (gpsLocations.length > 0) {
            var map = L.map('map_view').setView([gpsLocations[0].lat, gpsLocations[0].lng], 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            gpsLocations.forEach(function (location, index) {
                const icon = getColoredIcon(location.color);
                const marker = L.marker([location.lat, location.lng], { icon: icon }).addTo(map)
                    .bindPopup(location.label);

                if (index === 0) {
                    marker.openPopup();
                }
            });

            var bounds = gpsLocations.map(loc => [loc.lat, loc.lng]);
            map.fitBounds(bounds);
        } else {
            document.getElementById('map_view').innerHTML = '<div class="alert alert-warning">❗ GPS sind noch nicht eingetragen.</div>';
        }
    </script>
    <?php include 'foot.php'; ?>
</body>

</html>