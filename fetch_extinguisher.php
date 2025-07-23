<?php
include 'init.php';
include 'config.php';
$conn = $GLOBALS['con'];
if(!isset($_SESSION)){session_start();}
$sesssion_firma = $_SESSION['idfirma'];

// Column sorting
$columnIndex = $_GET['order'][0]['column'];
$columnSortOrder = $_GET['order'][0]['dir']; 
$columns = array(
    'fotofeuerloescher',
    'nfcadresse',
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

// Pagination
$start = $_GET['start'];
$length = $_GET['length'];
$searchValue = $_GET['search']['value'];
$customSearch = isset($_GET['customSearch']) ? $_GET['customSearch'] : '';

// Firm filter (use session if needed)
$filterFirma = "k.idfirma='$sesssion_firma'"; 

// Build search condition
$searchConditions = [$filterFirma];

if (!empty($customSearch)) {
    $searchConditions[] = "(inhalt LIKE '%" . $customSearch . "%' 
                            OR typ LIKE '%" . $customSearch . "%' 
                            OR nfcadresse LIKE '%" . $customSearch . "%' 
                            OR loeschmittel LIKE '%" . $customSearch . "%' 
                            OR hersteller LIKE '%" . $customSearch . "%')";
}

$searchQuery = "WHERE " . implode(" AND ", $searchConditions);

// ✅ Total records (without search but filtered by firm)
$totalRecordsQuery = "SELECT COUNT(*) AS total 
                      FROM kundenbestand t 
                      JOIN kundenadressen k ON t.idkunde= k.idkunde 
                      WHERE $filterFirma";
$totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['total'];

// ✅ Total filtered records (search + firm)
$totalFilteredQuery = "SELECT COUNT(*) AS total 
                       FROM kundenbestand t 
                       JOIN kundenadressen k ON t.idkunde= k.idkunde 
                       $searchQuery";
$totalFilteredResult = mysqli_query($conn, $totalFilteredQuery);
$totalFiltered = mysqli_fetch_assoc($totalFilteredResult)['total'];

// ✅ Fetch Data
$query = "SELECT t.idkunde, t.idkundenbestand, fotofeuerloescher, loeschmittel, datumangelegt, hersteller, typ, inhalt, bj, nfcadresse, beschreibungstandort, naechstepruefung 
          FROM kundenbestand t 
          JOIN kundenadressen k ON t.idkunde= k.idkunde 
          $searchQuery 
          ORDER BY $columnName $columnSortOrder 
          LIMIT $start, $length";

$result = mysqli_query($conn, $query);

// ✅ Build Data Array
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
        "nfcadresse" => $row['nfcadresse'],
        "hersteller" => $row['hersteller'],
        "typ" => $row['typ'],
        "loeschmittel" => $row['loeschmittel'],
        "inhalt" => $row['inhalt'],
        "bj" => !is_null($row['bj']) ? (new DateTime($row['bj']))->format('Y') : '',
        "naechstepruefung" => !is_null($row['naechstepruefung']) ? (new DateTime($row['naechstepruefung']))->format('m/Y') : '',
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

// ✅ Final JSON Response
$response = [
    "draw" => intval($_GET['draw']),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalFiltered,
    "data" => $data
];

echo json_encode($response);
?>
