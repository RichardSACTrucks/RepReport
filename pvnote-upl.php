<?php
$cmpyid = $_POST['id'];
$pvnote = $_POST['pvnote'];
require_once "../globals/dbcon.inc";
$sql = "INSERT INTO clients_notes (clients_main_id,clients_previsit_note) VALUES ('$cmpyid','$pvnote') ON DUPLICATE KEY UPDATE clients_previsit_note = '$pvnote';";
if ( mysqli_query($dbcon,$sql) ){
    echo "SAVED";
}
else {
    //echo "<b>ERROR</b>: " . $sql . "<br>" . mysqli_error($dbcon);
    echo "<b>ERROR</b>";
}
?>