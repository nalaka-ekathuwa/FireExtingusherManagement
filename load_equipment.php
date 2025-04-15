<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "config.php";

$clicked_id = $_POST['clicked_id'];
$sql1 = "SELECT e.image, e.brand, e.size, c.`id`, bj, `ext_id`, `serial_no`,  `location_img`, `checked_on`,`next_check`, u.`name` FROM `ext_customer` c JOIN users u ON c.cus_id=u.id JOIN extinguisher e ON e.id=c.ext_id WHERE c.cus_id = $clicked_id";
$conn = $GLOBALS['con'];
$result1 = mysqli_query($conn, $sql1);

$output = '<div id="equipment_section" class="card">
              <div class="card-body">
                  <div class="row m-b-30">
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
                              <tbody>';

if (mysqli_num_rows($result1) > 0) {
    $no1 = 1;
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $image = !empty($row1['image']) ? $row1['image'] : 'assets/images/extinguisher/dummy_ext.jpg';
        $output .= '<tr>
                        <td>' . $no1++ . '</td>
                        <td><div class="d-flex align-items-center">
                            <div class="avatar avatar-image avatar-sm m-r-10">
                                <img src="'. $image .'" alt="">
                            </div>
                            <h6 class="m-b-0">'. $row1['serial_no']. '</h6>
                        </div></td>
                        <td>' . $row1['bj'] . '</td>
                        <td>' . $row1['checked_on'] . '</td>
                        <td>' . $row1['next_check'] . '</td>
                        <td>' . $row1['name'] . '</td>
                        <td class="text-right">
                            <a href="maintenance.php?key=' . $row1['id'] . '" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right">
                                <i class="anticon anticon-edit"></i>
                            </a>
                        </td>
                    </tr>';
    }
} else {
    $output .= '<tr><td class="text-center" colspan="6">No Fire Equipments here</td></tr>';
}

$output .= '</tbody>
            </table>
          </div>
      </div>
  </div>
</div>';

echo $output;
?>