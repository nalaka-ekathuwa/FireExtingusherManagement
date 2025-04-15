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
                        $message = 'Extinguisher was deleted';
                        break;
                    case '6':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Extinguisher was not deleted';
                        break;
                    case '2':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Extinguisher was Created';
                        break;
                    case '1':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Extinguisher was not created';
                        ;
                        break;
                    case '4':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Extinguisher was Updated';
                        break;
                    case '3':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Extinguisher was not Updated';
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
                        <h2 class="header-title">Planted Extinguishers List</h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                                <span class="breadcrumb-item active">Planted Extinguishers List</span>
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
                                    <a href="manage_cus_ext.php" class="btn btn-primary"><i
                                            class="anticon anticon-plus-square m-r-5"></i>Plant Extinguisher</a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover e-commerce-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>serial_no</th>
                                            <th>Buit year</th>
                                            <th>Last Check</th>
                                            <th>next Check</th>
                                            <th>Owner</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //get Instrument Rating detials
                                        $sql = "SELECT e.image, e.brand, e.size, c.`id`, bj, `ext_id`, `serial_no`,  `location_img`, `checked_on`,`next_check`, u.`name` FROM `ext_customer` c JOIN users u ON c.cus_id=u.id JOIN extinguisher e ON e.id=c.ext_id";
                                        //echo $sql;
                                        $conn = $GLOBALS['con'];
                                        $result = mysqli_query($conn, $sql);
                                        $no = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $image = !empty($row['image']) ? $row['image'] : 'assets/images/extinguisher/dummy_ext.jpg';
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><div class="d-flex align-items-center">
                                                        <div class="avatar avatar-image avatar-sm m-r-10">
                                                            <img src="<?php echo $image; ?>" alt="">
                                                        </div>
                                                        <h6 class="m-b-0"><?php echo '('. $row['serial_no']. ')'; ?></h6>
                                                    </div></td>
                                                <td><?php echo $row['bj']; ?></td>
                                                <td><?php echo $row['checked_on']; ?></td>
                                                <td><?php echo $row['next_check']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <!-- <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="badge badge-success badge-dot m-r-10"></div>
                                                        <div>Approved</div>
                                                    </div>
                                                </td> -->
                                                <td class="text-right">
                                                    <a href="manage_cus_ext.php?key=<?php echo $row['id']; ?>"
                                                        class="btn btn-icon btn-hover btn-sm btn-rounded pull-right"><i
                                                            class="anticon anticon-edit"></i></a>
                                                    <a onclick="return confirm('Are you sure you want to delete this item?');"
                                                        href="control/cus_ext_process.php?key=<?php echo $row['id']; ?>&action=delete"
                                                        class="btn btn-icon btn-hover btn-sm btn-rounded"><i
                                                            class="anticon anticon-delete"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
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

</body>

</html>