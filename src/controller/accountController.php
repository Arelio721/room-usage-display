<?php
session_start()
?>

<?php
include_once "../database/connection.php";

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $room_name = "";
    $sql_query = "select * from admin where username = '$username' and password = '$password'";
    $result = mysqli_query($conn, $sql_query);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            $room_name = $row['room_name'];
        }
        mysqli_free_result($result);

        $_SESSION['room_name'] = $room_name;

        header("Location: http://localhost/room-usage-display/src/view/dashboard.php?room_name=$room_name");
    }
    else {
        echo "0";
        header("Location: http://localhost/room-usage-display/src/index.php");
    }
}

