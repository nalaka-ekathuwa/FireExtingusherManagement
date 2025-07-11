<?php include 'init.php'; ?>
<!DOCTYPE html>
<html lang="de">
<?php include 'head.php'; ?>

<body>
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <?php include 'header.php'; ?>
            <?php include 'sidebar.php'; ?>

            <!-- Page Container START -->
            <div class="page-container">

                <!-- Content Wrapper START -->
                <div class="main-content">

                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="m-b-0">Nettoumsatz</p>
                                            <h2 class="m-b-0">
                                                <span>$14,966</span>
                                            </h2>
                                        </div>
                                        <div class="avatar avatar-icon avatar-lg avatar-blue">
                                            <i class="anticon anticon-dollar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="m-b-0">Absprungrate</p>
                                            <h2 class="m-b-0">
                                                <span>26.80%</span>
                                            </h2>
                                        </div>
                                        <div class="avatar avatar-icon avatar-lg avatar-cyan">
                                            <i class="anticon anticon-bar-chart"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="m-b-0">Bestellungen</p>
                                            <h2 class="m-b-0">
                                                <span>3057</span>
                                            </h2>
                                        </div>
                                        <div class="avatar avatar-icon avatar-lg avatar-red">
                                            <i class="anticon anticon-profile"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="m-b-0">Gesamtausgaben</p>
                                            <h2 class="m-b-0">
                                                <span>$6,138</span>
                                            </h2>
                                        </div>
                                        <div class="avatar avatar-icon avatar-lg avatar-gold">
                                            <i class="anticon anticon-bar-chart"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>Overall Rating</h5>
                                    </div>
                                    <div class="d-flex align-items-center m-t-20">
                                        <h1 class="m-b-0 m-r-10 font-weight-normal">4.5</h1>
                                        <div class="star-rating m-t-15">
                                            <input type="radio" id="star1-5" name="rating-1" value="5" checked
                                                disabled /><label for="star1-5" title="5 star"></label>
                                            <input type="radio" id="star1-4" name="rating-1" value="4" disabled /><label
                                                for="star1-4" title="4 star"></label>
                                            <input type="radio" id="star1-3" name="rating-1" value="3" disabled /><label
                                                for="star1-3" title="3 star"></label>
                                            <input type="radio" id="star1-2" name="rating-1" value="2" disabled /><label
                                                for="star1-2" title="2 star"></label>
                                            <input type="radio" id="star1-1" name="rating-1" value="1" disabled /><label
                                                for="star1-1" title="1 star"></label>
                                        </div>
                                    </div>
                                    <p><span class="text-success font-weight-bold">+1.5</span> point from last month</p>
                                    <div class="m-t-30" style="height: 150px">
                                        <canvas class="chart" id="rating-chart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-md-flex justify-content-between align-items-center">
                                        <h5>Total Sales</h5>
                                        <div class="d-flex">
                                            <div class="m-r-10">
                                                <span class="badge badge-secondary badge-dot m-r-10"></span>
                                                <span class="text-gray font-weight-semibold font-size-13">Revenue</span>
                                            </div>
                                            <div class="m-r-10">
                                                <span class="badge badge-purple badge-dot m-r-10"></span>
                                                <span class="text-gray font-weight-semibold font-size-13">Margin</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-t-50" style="height: 225px">
                                        <canvas class="chart" id="sales-chart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>Monthly Target</h5>
                                    </div>
                                    <div class="d-flex align-items-center position-relative m-v-50"
                                        style="height:150px;">
                                        <div class="w-100 position-absolute" style="height:150px; top:0;">
                                            <canvas class="chart m-h-auto" id="porgress-chart"></canvas>
                                        </div>
                                        <h2 class="w-100 text-center text-large m-b-0 text-success font-weight-normal">
                                            $3,531</h2>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <span class="badge badge-success badge-dot m-r-10"></span>
                                        <span><span class="font-weight-semibold">70%</span> of Your Goal</span>
                                    </div>
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
    <!-- page js -->
    <script src="assets/vendors/chartjs/Chart.min.js"></script>
    <script src="assets/js/pages/dashboard-crm.js"></script>

</body>

</html>