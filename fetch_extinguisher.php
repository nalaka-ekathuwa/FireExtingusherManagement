<?php
include 'init.php';
include 'config.php';
$conn = $GLOBALS['con'];

$columnIndex = $_GET['order'][0]['column']; // Column index
$columnName = $_GET['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_GET['order'][0]['dir']; // 'asc' or 'desc'

// Pagination parameters from DataTables
$start = $_GET['start'];
$length = $_GET['length'];
$searchValue = $_GET['search']['value']; // Search box value

// Search filter
$customSearch = isset($_GET['customSearch']) ? $_GET['customSearch'] : '';

$searchQuery = "";
if (!empty($customSearch)) {
    $searchQuery = "WHERE inhalt LIKE '%" . $customSearch . "%' OR typ LIKE '%" . $customSearch . "%' OR  interneseriennummer LIKE '%" . $customSearch . "%' OR loeschmittel LIKE '%" . $customSearch . "%' OR hersteller LIKE '%" . $customSearch . "%'";
}
// Total records
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM kundenbestand";
$totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['total'];

// Total filtered records
$totalFilteredQuery = "SELECT COUNT(*) AS total FROM kundenbestand $searchQuery";
$totalFilteredResult = mysqli_query($conn, $totalFilteredQuery);
$totalFiltered = mysqli_fetch_assoc($totalFilteredResult)['total'];

$columns = array(
    'fotofeuerloescher',
    'interneseriennummer',
    'hersteller',
    'typ',
    'loeschmittel',
    'inhalt',
    'bj',
    'naechstepruefung',
    'beschreibungstandort',
    'idkundenbestand',
);

$columnName = isset($columns[$columnIndex]) ? $columns[$columnIndex] : 'id';

// Fetch records
$query = "SELECT t.idkunde,t.idkundenbestand, fotofeuerloescher, loeschmittel, datumangelegt, hersteller, typ, inhalt, bj, interneseriennummer,beschreibungstandort 
          FROM kundenbestand t JOIN kundenadressen k ON t.idkunde= k.idkunde
          $searchQuery 
          ORDER BY $columnName $columnSortOrder
          LIMIT $start, $length";

$result = mysqli_query($conn, $query);

$data = [];
$no = $start + 1;
while ($row = mysqli_fetch_assoc($result)) {
    $image = !empty($row['fotofeuerloescher']) ? $row['fotofeuerloescher'] : 'assets/images/extinguisher/dummy_ext.jpg';

    $data[] = [
        "image" => "<div class='d-flex align-items-center'>
        <div class='avatar avatar-image avatar-sm m-r-10'>
            <img src='" . $image . "' alt=''>
        </div>
        </div>",
        "interneseriennummer" => $row['interneseriennummer'],
        "hersteller" => $row['hersteller'],
        "typ" => $row['typ'],
        "loeschmittel" => $row['loeschmittel'],
        "inhalt" => $row['inhalt'],
        "bj" => !is_null($row['bj'])?(new DateTime($row['bj']))->format('Y'):'',
        "naechstepruefung" => !is_null($row['datumangelegt'])?(new DateTime($row['datumangelegt']))->format('Y'):'',
        "beschreibungstandort" => $row['beschreibungstandort'],
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