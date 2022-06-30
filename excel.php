

<?php

session_start();

//zmienna sesyjna , po kliknięciu w stronę zapamiętuje parametr
if (isset($_SESSION["logid"])) {
   $logid = $_SESSION['logid'];
 } else {
   header("location:login.php");
};

require_once "config.php";

$filename = "baza_przetargowa" . date("Y/m/d")  . ".txt"; // File Name
// Download file
header('Content-Encoding: windows-1250');
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/plain; charset=windows-1250");

$user_query = mysqli_query($link,'SELECT * FROM tenders.export_to_excel;');
// Write data to file
$flag = false;
while ($row = mysqli_fetch_assoc($user_query)) {
    if (!$flag) {
        // display field/column names as first row
        echo implode(",", array_keys($row)) . "\r\n";
        $flag = true;
    }
    echo implode(",", array_values($row)) . "\r\n";
    

}
?>

