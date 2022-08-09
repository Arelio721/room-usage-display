<?php
session_start()
?>

<?php
include_once "../database/connection.php";

if (isset($_POST['btn_insert'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $room_name = $_POST['room_name'];

    $sql = "INSERT INTO admin (username, password, room_name) VALUES ('$username', '$password', '$room_name')";

    $inserted = false;
    if ($conn->query($sql) === TRUE) {
        $inserted = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql_query = "select * from admin where username != 'admin'";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        $arr_admin = array();
        while($row = mysqli_fetch_array($result)) {
            array_push($arr_admin, $row);
        }
    }

    $conn->close();

    echo json_encode($arr_admin);
}
else if (isset($_POST['btn_edit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $room_name = $_POST['room_name'];
    $old_username = $_POST['old_username'];

    $sql = "UPDATE admin SET password='$password', room_name='$room_name', username='$username' WHERE username='$old_username'";

    $inserted = false;
    if ($conn->query($sql) === TRUE) {
        $inserted = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql_query = "select * from admin where username != 'admin'";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        $arr_admin = array();
        while($row = mysqli_fetch_array($result)) {
            array_push($arr_admin, $row);
        }
    }

    $conn->close();

    echo json_encode($arr_admin);
}
else if (isset($_POST['btn_delete'])) {
    $username = $_POST['username'];

    $sql = "DELETE FROM admin where username = '$username'";

    $inserted = false;
    if ($conn->query($sql) === TRUE) {
        $inserted = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql_query = "select * from admin where username != 'admin'";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        $arr_admin = array();
        while($row = mysqli_fetch_array($result)) {
            array_push($arr_admin, $row);
        }
        $conn->close();
        echo json_encode($arr_admin);
    }
    else {
        $conn->close();
        echo "no data";
    }
}