<!DOCTYPE html>
<html lang="en">

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
                        $message = 'Location was deleted';
                        break;
                    case '6':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Location was not deleted';
                        break;
                    case '2':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Location was Created';
                        break;
                    case '1':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Location was not created';
                        ;
                        break;
                    case '4':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Location was Updated';
                        break;
                    case '3':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Location was not Updated';
                        ;
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
                        <h2 class="header-title">Locations List</h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                                <span class="breadcrumb-item active">Locations List</span>
                            </nav>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-8">

                                    <?php isset($_GET['msg']) ? displayAlert() : ''; ?>

                                </div>
                                <div class="col-lg-4 text-right">
                                    <a href="manage_Location.php" class="btn btn-primary"><i
                                            class="anticon anticon-plus-square m-r-5"></i>Add Location</a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover e-commerce-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Cus Number</th>
                                            <th>Name</th>
                                            <th>Postal Code</th>
                                            <th>Contact Person</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //get Instrument Rating detials
                                        $sql = "SELECT * FROM `customers` WHERE safety_officer = '$sesssion_uid' ";
                                        //echo $sql;
                                        $conn = $GLOBALS['con'];
                                        $result = mysqli_query($conn, $sql);
                                        $no = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                             ?>
                                             <tr>
                                                 <td><?php echo $no++; ?></td>
                                                 <td><?php echo $row['cus_number']; ?></td>
                                                 <td><?php echo $row['salutation'].'. '.$row['first_name'].' '.$row['last_name']; ?></td>
                                                 <td><?php echo $row['postal_code']; ?></td>
                                                 <td><?php echo $row['contact_person']; ?></td>
                                                <td class="text-right">
                                                    <a href="#" id="view_customer"
                                                        onclick="loadEquipmentTable(<?php echo $row['owner']; ?>)"
                                                        class="btn btn-icon btn-hover btn-sm btn-secondary btn-rounded pull-right"><i
                                                            class="fas fa-eye"></i></a>
                                                    <a href="#" id="view_equipments"
                                                        class="btn btn-icon btn-hover btn-sm btn-secondary btn-rounded pull-right"><i
                                                            class="fas fa-fire-extinguisher"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="equipment_section">

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function loadEquipmentTable(clicked_id) {
            $.ajax({
                url: 'load_equipment.php', // This is the URL to your PHP script
                type: 'POST',
                data: { clicked_id: clicked_id },
                success: function (response) {
                    $('#equipment_section').html(response);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>

</body>

</html>