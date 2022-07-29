<?php
session_start()
?>

<?php
include_once "../database/connection.php";

if (isset($_POST['btn_insert'])) {
    $time = $_POST['time'];

    $sql = "INSERT INTO schedule (time) VALUES ('$time')";

    $inserted = false;
    if ($conn->query($sql) === TRUE) {
        $inserted = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql_query = "select * from schedule order by id";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        $arr_schedule = array();
        while($row = mysqli_fetch_array($result)) {
            array_push($arr_schedule, $row);
        }
    }

    $conn->close();

    echo json_encode($arr_schedule);
}
else if (isset($_POST['btn_edit'])) {
    $time = $_POST['time'];
    $id = $_POST['id'];

    $sql = "UPDATE schedule SET time='$time' WHERE id='$id'";

    $inserted = false;
    if ($conn->query($sql) === TRUE) {
        $inserted = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql_query = "select * from schedule order by id";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        $arr_schedule = array();
        while($row = mysqli_fetch_array($result)) {
            array_push($arr_schedule, $row);
        }
    }

    $conn->close();

    echo json_encode($arr_schedule);
}
else if (isset($_POST['btn_delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM schedule WHERE id='$id'";

    $inserted = false;
    if ($conn->query($sql) === TRUE) {
        $inserted = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql_query = "select * from schedule order by id";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        $arr_schedule = array();
        while($row = mysqli_fetch_array($result)) {
            array_push($arr_schedule, $row);
        }
        $conn->close();
        echo json_encode($arr_schedule);
    }
    else {
        $conn->close();
        echo "no data";
    }
}
else if(isset($_POST['btn_select'])) {
    $id = $_POST['id'];

    $sql = "SELECT schedule.time FROM schedule WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $schedule = "";
        while($row = mysqli_fetch_array($result)) {
            $schedule = $row;
        }

        $conn->close();
        $schedule = $schedule['time'];

        // save to txt file
        $room_name = strtolower($_SESSION['room_name']);
        $room_name = str_replace('-', '', $room_name);
        $schedule_file = fopen("../../room/{$room_name}-schedule.txt", "w+") or die("Unable to open file!");
        fwrite($schedule_file, $schedule);
        fclose($schedule_file);

        echo $schedule;
    }
    else {
        $conn->close();
        echo "no data";
    }
}