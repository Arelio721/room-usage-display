<?php
session_start()
?>

<?php
include_once "../database/connection.php";

if (isset($_POST['btn_insert'])) {
    $name = $_POST['name'];

    $sql = "INSERT INTO activity (name) VALUES ('$name')";

    $inserted = false;
    if ($conn->query($sql) === TRUE) {
        $inserted = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql_query = "select * from activity order by id";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        $arr_activity = array();
        while($row = mysqli_fetch_array($result)) {
            array_push($arr_activity, $row);
        }
    }

    $conn->close();

    echo json_encode($arr_activity);
}
else if (isset($_POST['btn_edit'])) {
    $name = $_POST['name'];
    $id = $_POST['id'];

    $sql = "UPDATE activity SET name='$name' WHERE id='$id'";

    $inserted = false;
    if ($conn->query($sql) === TRUE) {
        $inserted = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql_query = "select * from activity order by id";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        $arr_activity = array();
        while($row = mysqli_fetch_array($result)) {
            array_push($arr_activity, $row);
        }
    }

    $conn->close();

    echo json_encode($arr_activity);
}
else if (isset($_POST['btn_delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM activity WHERE id='$id'";

    $inserted = false;
    if ($conn->query($sql) === TRUE) {
        $inserted = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql_query = "select * from activity order by id";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        $arr_activity = array();
        while($row = mysqli_fetch_array($result)) {
            array_push($arr_activity, $row);
        }
        $conn->close();
        echo json_encode($arr_activity);
    }
    else {
        $conn->close();
        echo "no data";
    }
}
else if(isset($_POST['btn_select'])) {
    $id = $_POST['id'];

    $sql = "SELECT name FROM activity WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $activity = "";
        while($row = mysqli_fetch_array($result)) {
            $activity = $row;
        }

        $conn->close();
        $activity = $activity['name'];

        // save to txt file
        $room_name = strtolower($_SESSION['room_name']);
        $room_name = str_replace('-', '', $room_name);
        $activity_file = fopen("../../room/{$room_name}-activity.txt", "w+") or die("Unable to open file!");
        fwrite($activity_file, $activity);
        fclose($activity_file);

        echo $activity;
    }
    else {
        $conn->close();
        echo "no data";
    }
}