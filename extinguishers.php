<?php include 'init.php'; ?>
<!DOCTYPE html>
<html lang="de">

<?php include 'head.php'; ?>

<body>
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <?php include 'config.php'; ?>
            <?php include 'header.php'; ?>
            <?php include 'sidebar.php';
            function displayAlert()
            {
                $msg = isset($_GET['msg']) ? $_GET['msg'] : '';

                switch ($msg) {
                    case '5':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Feuerlöscher wurde gelöscht';
                        break;
                    case '6':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Feuerlöscher wurde nicht gelöscht';
                        break;
                    case '2':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Feuerlöscher wurde erstellt';
                        break;
                    case '1':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Feuerlöscher wurde nicht erstellt';
                        break;
                    case '4':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Feuerlöscher wurde aktualisiert';
                        break;
                    case '3':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Feuerlöscher wurde nicht aktualisiert';
                        break;
                    // default:
                    //     $alertType = 'alert-secondary';
                    //     $icon = 'anticon-info-o';
                    //     $message = 'Something went wrong!';
                }

                echo '<div class="alert ' . $alertType . '">
                         <div class="d-flex align-items-center justify-content-start">
                             <span class="alert-icon">
                                 <i class="anticon ' . $icon . '"></i>
                             </span>
                             <span>' . $message . '</span>
                         </div>
                       </div>';
            }

            // Call the function to display the alert
            
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
                                <span class="breadcrumb-item active">Feuerlöscher Liste</span>
                            </nav>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-8">
                                    <?php isset($_GET['msg']) ? displayAlert() : ''; ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <!-- <div class="col">
                                    <input type="text" class="form-control" placeholder="First name">
                                </div> -->
                                <div class="col">
                                    <input type="text" id="customSearchInput" class="form-control"
                                        placeholder="Search Feuerlöscher..." />
                                </div>
                                <div class="col">
                                    <button id="searchButton" class="btn btn-primary m-l-10">Search</button>
                                </div>
                            </div><br><br>

                            <div class="table-responsive">
                                <table id="extinguisherTable" class="table table-hover ">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>NFC Seriennummer</th>
                                            <th>Hersteller</th>
                                            <th>Typ</th>
                                            <th>Löschmittel</th>
                                            <th>Inhalt</th>
                                            <th>BJ</th>
                                            <th>Nächste Wartung</th>
                                            <th>Standort</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                </table>
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
    <?php include 'foot.php'; ?>
    <script>
        $('#extinguisherTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "fetch_extinguisher.php",
                "data": function (d) {
                    d.customSearch = $('#customSearchInput').val();
                }
            },
            "searching": false, // disable default search box
            "columns": [
                { "data": "image" },
                { "data": "nfcadresse" },
                { "data": "hersteller" },
                { "data": "typ" },
                { "data": "loeschmittel" },
                { "data": "inhalt" },
                { "data": "bj" },
                { "data": "naechstepruefung" },
                { "data": "beschreibungstandort" },
                { "data": "action" }
            ]
        });

        $('#searchButton').click(function () {
            $('#extinguisherTable').DataTable().ajax.reload();
        });
    </script>
</body>

</html>