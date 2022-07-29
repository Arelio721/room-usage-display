<?php
session_start()
?>

<?php
include_once "../database/connection.php";

if (isset($_POST['btn_insert'])) {
    $name = $_POST['name'];

    $sql = "INSERT INTO lecturer (name) VALUES ('$name')";

    $inserted = false;
    if ($conn->query($sql) === TRUE) {
        $inserted = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql_query = "select * from lecturer order by id";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        $arr_lecturer = array();
        while($row = mysqli_fetch_array($result)) {
            array_push($arr_lecturer, $row);
        }
    }

    $conn->close();

    echo json_encode($arr_lecturer);
//    header("Location: http://localhost/room-usage-display/src/view/dashboard.php?room_name=".$_SESSION["room_name"]);
}
else if(isset($_POST['btn_edit'])) {
    $name = $_POST['name'];
    $id = $_POST['id'];

    $sql = "UPDATE lecturer SET name='$name' WHERE id='$id'";

    $inserted = false;
    if ($conn->query($sql) === TRUE) {
        $inserted = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql_query = "select * from lecturer order by id";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        $arr_lecturer = array();
        while($row = mysqli_fetch_array($result)) {
            array_push($arr_lecturer, $row);
        }
    }

    $conn->close();

    echo json_encode($arr_lecturer);
}
else if(isset($_POST['btn_delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM lecturer WHERE id='$id'";

    $inserted = false;
    if ($conn->query($sql) === TRUE) {
        $inserted = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql_query = "select * from lecturer order by id";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        $arr_lecturer = array();
        while($row = mysqli_fetch_array($result)) {
            array_push($arr_lecturer, $row);
        }

        $conn->close();
        echo json_encode($arr_lecturer);
    }
    else {
        $conn->close();
        echo "no data";
    }
}
else if(isset($_POST['btn_select'])) {
    $id = $_POST['id'];

    $sql = "SELECT name FROM lecturer WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $lecturer = "";
        while($row = mysqli_fetch_array($result)) {
            $lecturer = $row;
        }

        $conn->close();
        $lecturer = $lecturer['name'];

        // save to txt file
        $room_name = strtolower($_SESSION['room_name']);
        $room_name = str_replace('-', '', $room_name);
        $lecturer_file = fopen("../../room/{$room_name}-lecturer.txt", "w") or die("Unable to open file!");
        fwrite($lecturer_file, $lecturer);
        fclose($lecturer_file);

        echo $lecturer;
    }
    else {
        $conn->close();
        echo "no data";
    }
}