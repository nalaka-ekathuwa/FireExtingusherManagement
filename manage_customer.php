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
                $sql = "SELECT * FROM `customers` c WHERE c.id=$key";
                //echo $sql;
                $conn = $GLOBALS['con'];
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $image = !empty($row['img']) ? $row['img'] : 'assets/images/users/default.jpg';
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
                        <h2 class="header-title">Customers List </h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                                <span class="breadcrumb-item active"><?php echo ucfirst($action); ?> Customer</span>
                            </nav>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-12">
                                    <form action="control/customer_process.php?action=<?php echo $action; ?>" method="post" >
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="contact_person">Contact Person</label>
                                                <input name="contact_person" type="text" class="form-control" id="contact_person" value="<?php echo isset($_GET['key'])?$row['contact_person']:''; ?>"  >
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="cus_number">Customer Number</label>
                                                <input name="cus_number" type="text" class="form-control" id="cus_number" value="<?php echo isset($_GET['key'])?$row['cus_number']:''; ?>" required >
                                                <?php if(isset($_GET['key'])){ ?><input type="hidden" name="key" value="<?php echo $key; ?>" > <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="postal_code">Postal Code</label>
                                                <input name="postal_code" type="text" class="form-control" id="postal_code" value="<?php echo isset($_GET['key'])?$row['postal_code']:''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="salutation">Salutation</label>
                                                <input name="salutation" type="text" class="form-control" id="salutation" placeholder="salutation" value="<?php echo isset($_GET['key'])?$row['salutation']:''; ?>" required >
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="last_name">Last Name</label>
                                                <input name="last_name" type="text" class="form-control" id="last_name" value="<?php echo isset($_GET['key'])?$row['last_name']:''; ?>" required >
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="first_name">First Name</label>
                                                <input name="first_name" type="text" class="form-control" id="first_name" placeholder="first_name" value="<?php echo isset($_GET['key'])?$row['first_name']:''; ?>" required >
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="street">Street</label>
                                                <input name="street" type="text" class="form-control" id="street" value="<?php echo isset($_GET['key'])?$row['street']:''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="place">Place</label>
                                                <input name="place" type="text" class="form-control" id="place" placeholder="place" value="<?php echo isset($_GET['key'])?$row['place']:''; ?>" >
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="mobile_company">Company Mobile</label>
                                                <input name="mobile_company" type="tel" class="form-control" id="mobile_company" value="<?php echo isset($_GET['key'])?$row['mobile_company']:''; ?>" required >
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="mobile_private">mobile private</label>
                                                <input name="mobile_private" type="tel" class="form-control" id="mobile_private" placeholder="mobile_private" value="<?php echo isset($_GET['key'])?$row['mobile_private']:''; ?>" required >
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="phone_company">Company Phone</label>
                                                <input name="phone_company" type="tel" class="form-control" id="phone_company" value="<?php echo isset($_GET['key'])?$row['phone_company']:''; ?>" required >
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="phone_private">Phone private</label>
                                                <input name="phone_private" type="tel" class="form-control" id="phone_private" value="<?php echo isset($_GET['key'])?$row['phone_private']:''; ?>" required >
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="location">Owner</label>
                                                <select name="owner" id="owner" class="form-control" required >
                                                    <option >Choose...</option>
                                                    <?php
                                                    //get User Roles
                                                    if($action == 'add'){
                                                    $sql1 = "SELECT * FROM `users` WHERE `id` NOT IN (SELECT `owner` FROM `customers`) AND role_id = 2";
                                                    } else {
                                                    $sql1 = "SELECT `id`, `name` FROM `users` WHERE `role_id` ='2'";
                                                    }
                                                    //echo $sql;
                                                    $conn = $GLOBALS['con'];
                                                    $result1 = mysqli_query($conn, $sql1);
                                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                                        ?>
                                                        <option value="<?php echo $row1['id']; ?>" 
                                                        <?php if(isset($_GET['key'])){
                                                             echo ($row['owner'] ==$row1['id']) ? 'selected': '';
                                                        }  ?> ><?php echo $row1['name']; ?></option> <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="address">Safety Officer</label>
                                                <select name="safety_off" id="safety_off" class="form-control"  >
                                                    <option value="" selected disabled >Not Available</option>
                                                    <?php
                                                    //get User Roles 
                                                    $sql2 = "SELECT `id`, `name` FROM `users` WHERE `role_id` ='3'";
                                                    //echo $sql;
                                                    $conn = $GLOBALS['con'];
                                                    $result2 = mysqli_query($conn, $sql2);
                                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                                        ?>
                                                        <option value="<?php echo $row2['id']; ?>"  <?php if(isset($_GET['key'])){
                                                             echo ($row['safety_officer'] ==$row2['id']) ? 'selected': '';
                                                        }  ?> ><?php echo $row2['name']; ?></option> <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary"><?php echo ($action =='add')?'Create':'Update'; ?></button> &nbsp; 
                                    </form>
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

    <?php include 'foot.php'; ?>

</body>

</html>