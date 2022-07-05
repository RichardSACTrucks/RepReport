<?php
    require_once ('../globals/dbcon.inc');

    //$br = $_GET['br'];
    //$q = $_REQUEST["term"]; 

    //$sql = "SELECT company_name FROM clients_main WHERE company_name LIKE '%$q%' AND assigned_branch = '$br';";
    //$qry = mysqli_query($dbcon,$sql);

    $stmt = $dbcon->prepare("SELECT company_name FROM clients_main WHERE company_name LIKE ? AND assigned_branch = ?;");
    $stmt->bind_param("ss", $q, $br);

    $br = $dbcon -> real_escape_string($_GET['br']);
    $q = "%{$dbcon -> real_escape_string($_REQUEST['term'])}%";

    $stmt->execute();
    $result = $stmt->get_result();

    $json=array();

    //while($row = mysqli_fetch_array($qry)) {
    while ($row = $result->fetch_assoc()) {
        $cp1 = $row['company_name'];
        array_push($json, $cp1);
    }

    echo json_encode($json);

    $sql = $dbcon -> real_escape_string("");
    $qry = $dbcon -> real_escape_string("");
    //mysqli_close($dbcon);
    $stmt->close();
    $dbcon->close();
?>