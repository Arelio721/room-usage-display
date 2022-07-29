<?php
session_start()
?>

<?php
include_once "../database/connection.php";

$room_name = strtolower($_SESSION['room_name']);
$room_name = str_replace('-', '', $room_name);
$arr = array();
$lecturer_path = "../../room/{$room_name}-lecturer.txt";
$activity_path = "../../room/{$room_name}-activity.txt";
$schedule_path = "../../room/{$room_name}-schedule.txt";
$lecturer_file = fopen($lecturer_path, "a+") or die("Unable to open file!");
$activity_file = fopen($activity_path, "a+") or die("Unable to open file!");
$schedule_file = fopen($schedule_path, "a+") or die("Unable to open file!");
if(filesize($lecturer_path) == 0)
    $arr['lecturer'] = "(empty)";
else
    $arr['lecturer'] = fread($lecturer_file, filesize($lecturer_path));
if(filesize($activity_path) == 0)
    $arr['activity'] = "(empty)";
else
    $arr['activity'] = fread($activity_file, filesize($activity_path));
if(filesize($schedule_path) == 0)
    $arr['schedule'] = "(empty)";
else
    $arr['schedule'] = fread($schedule_file, filesize($schedule_path));
fclose($lecturer_file);
fclose($activity_file);
fclose($schedule_file);
echo json_encode($arr);