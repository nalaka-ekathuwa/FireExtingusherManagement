<?php
include 'init.php';
include 'config.php';
$conn = $GLOBALS['con'];

// Pagination parameters from DataTables
$start = $_GET['start'];
$length = $_GET['length'];
$searchValue = $_GET['search']['value']; // Search box value

// Search filter
$customSearch = isset($_GET['customSearch']) ? $_GET['customSearch'] : '';

$searchQuery = "";
if (!empty($customSearch)) {
    $searchQuery = "WHERE loeschmittel LIKE '%" . $customSearch . "%' OR hersteller LIKE '%" . $customSearch . "%'";
}
// Total records
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM kundenbestand";
$totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['total'];

// Total filtered records
$totalFilteredQuery = "SELECT COUNT(*) AS total FROM kundenbestand $searchQuery";
$totalFilteredResult = mysqli_query($conn, $totalFilteredQuery);
$totalFiltered = mysqli_fetch_assoc($totalFilteredResult)['total'];

// Fetch records
$query = "SELECT idkundenbestand, fotofeuerloescher, loeschmittel, datumangelegt, anzahl, hersteller, typ, inhalt, bj, befund 
          FROM kundenbestand
          $searchQuery
          LIMIT $start, $length";
          
$result = mysqli_query($conn, $query);

$data = [];
$no = $start + 1;
while ($row = mysqli_fetch_assoc($result)) {
    $image = !empty($row['fotofeuerloescher']) ? $row['fotofeuerloescher'] : 'assets/images/extinguisher/dummy_ext.jpg';

    $data[] = [
        "no" => $no++,
        "loeschmittel" => "<div class='d-flex align-items-center'>
                                <div class='avatar avatar-image avatar-sm m-r-10'>
                                    <img src='" . $image . "' alt=''>
                                </div>
                                <h6 class='m-b-0'>(" . htmlspecialchars($row['loeschmittel']) . ")</h6>
                           </div>",
        "datumangelegt" => $row['datumangelegt'],
        "anzahl" => $row['anzahl'],
        "hersteller" => $row['hersteller'],
        "typ" => $row['typ'],
        "inhalt" => $row['inhalt'],
        "bj" => $row['bj'],
        "befund" => $row['befund'],
        "action" => "<a href='manage_extinguisher.php?key=" . $row['idkundenbestand'] . "' class='btn btn-icon btn-hover btn-sm btn-rounded'>
                        <i class='anticon anticon-edit'></i>
                    </a>
                    <a onclick=\"return confirm('Bist du sicher, dass du dieses Element löschen möchtest?');\" 
                        href='control/extinguishers_process.php?key=" . $row['idkundenbestand'] . "&action=delete' 
                        class='btn btn-icon btn-hover btn-sm btn-rounded'>
                        <i class='anticon anticon-delete'></i>
                    </a>"
    ];
}

$response = [
    "draw" => intval($_GET['draw']),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalFiltered,
    "data" => $data
];

echo json_encode($response);
?>
