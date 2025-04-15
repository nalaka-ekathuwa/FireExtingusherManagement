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
            if(isset($_GET['key'])){
                $key = $_GET['key'];
                $action = 'edit';
                $sql = "SELECT * FROM `ext_customer` e WHERE e.id=$key";
                //echo $sql;
                $conn = $GLOBALS['con'];
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $image = !empty($row['image']) ? $row['image'] : 'assets/images/extinguisher/dummy_ext.jpg';
            }else{
                $action = 'add';
                $key = '';
            }
            
            ?>

            <!-- Page Container START -->
            <div class="page-container">

                <!-- Content Wrapper START -->
                <div class="main-content">
                    <div class="page-header">
                        <h2 class="header-title">Planted Extinguisher List </h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                                <span class="breadcrumb-item active"><?php echo ucfirst($action); ?> Extinguisher for customer</span>
                            </nav>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-12">
                                <form action="control/ext_maintenance.php?action=<?php echo $action; ?>" method="post" enctype= multipart/form-data >
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="serial_no">Serial Number</label>
                                                <input name="serial_no" type="text" class="form-control" id="serial_no" value="<?php echo isset($_GET['key'])?$row['serial_no']:''; ?>" disabled >
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="build">Installed Date</label>
                                                <input disabled name="bj" type="number" class="form-control" id="build" min="1850" max="2500"  value="<?php echo isset($_GET['key'])?$row['bj']:''; ?>" >
                                                <?php if(isset($_GET['key'])){ ?><input type="hidden" name="key" value="<?php echo $key; ?>" > <?php } ?>
                                            </div>
                                        </div>
                                       
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="location_img">location Image</label>
                                                <input disabled name="location_img" type="file" class="form-control" id="location_img" value="<?php echo isset($_GET['key'])?$row['location_img']:''; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="gps">GPS</label>
                                                <input disabled name="gps" type="text" class="form-control" id="gps" placeholder="gps" value="<?php echo isset($_GET['key'])?$row['gps']:''; ?>" >
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="desc_short">Short Description</label>
                                                <input name="desc_short" type="text" class="form-control" id="desc_short" value="<?php echo isset($_GET['key'])?$row['desc_short']:''; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="dec_long">Long Description</label>
                                                <input name="dec_long" type="text" class="form-control" id="dec_long" placeholder="dec_long" value="<?php echo isset($_GET['key'])?$row['dec_long']:''; ?>" required >
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="damage">Damage</label>
                                                <input name="damage" type="text" class="form-control" id="damage" value="<?php echo isset($_GET['key'])?$row['damage']:''; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="test_interval">Test Interval</label>
                                                <input name="test_interval" type="text" class="form-control" id="test_interval" placeholder="test_interval" value="<?php echo isset($_GET['key'])?$row['test_interval']:''; ?>" >
                                            </div>
                                        </div> 
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="checked_on">Last Checked</label>
                                                <input disabled name="checked_on" type="date" class="form-control" id="checked_on" placeholder="checked_on" value="<?php echo isset($_GET['key'])?$row['checked_on']:''; ?>" >
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="next_check">Next Check</label>
                                                <input disabled name="next_check" type="date" class="form-control" id="next_check" value="<?php echo isset($_GET['key'])?$row['next_check']:''; ?>">
                                            </div>
                                        </div> 
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="location">Owner</label>
                                                <select disabled name="cus_id" id="cus_id" class="form-control" required >
                                                    <option >Choose...</option>
                                                    <?php
                                                    //get User Roles
                                                    $sql1 = "SELECT `id`, `name` FROM `users` WHERE `role_id` ='2'";
                                                    //echo $sql;
                                                    $conn = $GLOBALS['con'];
                                                    $result1 = mysqli_query($conn, $sql1);
                                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                                        ?>
                                                        <option value="<?php echo $row1['id']; ?>" 
                                                        <?php if(isset($_GET['key'])){
                                                             echo ($row['cus_id'] ==$row1['id']) ? 'selected': '';
                                                        }  ?> ><?php echo $row1['name']; ?></option> <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="address">Fire Extinguisher</label>
                                                <select disabled required name="ext_id" id="ext_id" class="form-control" >
                                                    <option >Choose...</option>
                                                    <?php
                                                    //get User Roles 
                                                    $sql2 = "SELECT * FROM `extinguisher`";
                                                    //echo $sql;
                                                    $conn = $GLOBALS['con'];
                                                    $result2 = mysqli_query($conn, $sql2);
                                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                                        ?>
                                                        <option value="<?php echo $row2['id']; ?>"  <?php if(isset($_GET['key'])){
                                                             echo ($row['ext_id'] ==$row2['id']) ? 'selected': '';
                                                        }  ?> ><?php echo $row2['brand']. ' '.  $row2['color']. ' '.  $row2['type']; ?></option> <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="image">Image</label>
                                                <input name="image" type="file" class="form-control" id="image" >
                                            </div>
                                            <div class="form-group col-md-6">
                                               <?php if(isset($_GET['key'])){  ?><img src="<?php echo $image; ?>" style="height:150px; width: auto;" /> <?php } ?>
                                            </div>
                                        </div>   -->

                                        <button type="submit" class="btn btn-primary"><?php echo ($action =='add')?'Create':'Update'; ?></button> &nbsp; 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php  if(isset($_GET['key'])){ ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-8"> The Routine Carried out for this Fire Extinguisher

                                    <?php // isset($_GET['msg']) ? displayAlert() : ''; ?>

                                </div>
                                <div class="col-lg-4 text-right">
                                    <a href="manage_routine_check.php" class="btn btn-info"><i
                                            class="anticon anticon-plus-square m-r-5"></i> New Routine Check</a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover e-commerce-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Checked Date</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //get Instrument Rating detials
                                        $sql1 = "SELECT * FROM `routine_check`";
                                        //echo $sql;
                                        $conn = $GLOBALS['con'];
                                        $result1 = mysqli_query($conn, $sql1);
                                        $no = 1;
                                        while ($row1 = mysqli_fetch_assoc($result1)) {
                                           
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $row1['checked_date']; ?></td>
                                                <td><?php echo $row1['description']; ?></td>
                                                <td><?php echo $row1['status']; ?></td>
                                                <!-- <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="badge badge-success badge-dot m-r-10"></div>
                                                        <div>Approved</div>
                                                    </div>
                                                </td> -->
                                                <td class="text-right">
                                                    <a href="manage_cus_ext.php?key=<?php echo $row1['id']; ?>&ext_id=<?php echo $key; ?>"
                                                        class="btn btn-icon btn-hover btn-sm btn-rounded pull-right"><i
                                                            class="anticon anticon-edit"></i></a>
                                                    <a onclick="return confirm('Are you sure you want to delete this item?');"
                                                        href="control/cus_ext_process.php?key=<?php echo $row1['id']; ?>&ext_id=<?php echo $key; ?>&action=delete"
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
                    <?php  } ?>                           
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