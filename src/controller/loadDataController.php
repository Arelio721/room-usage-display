<?php
session_start()
?>

<?php
include_once "../database/connection.php";

$table_name = $_POST['table_name'];
if($table_name == "admin") {
    $sql_query = "select * from $table_name where username != 'admin'";
}
else{
    $sql_query = "select * from $table_name order by id";
}

$result = mysqli_query($conn, $sql_query);

if (mysqli_num_rows($result) > 0) {
    $arr_data = array();
    while($row = mysqli_fetch_array($result)) {
        array_push($arr_data, $row);
    }

    $conn->close();
//    var_dump($arr_data);
    echo json_encode($arr_data);
}
else {
    $conn->close();
    echo "no data";
}