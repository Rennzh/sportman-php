<?php
/**
 * Created by PhpStorm.
 * User: rainnka
 * Date: 2017/1/23
 * Time: 11:45
 */
include "access_allow_origin.php";

include 'connect_mysql.php';
include 'UTF8.php';

$queryBanner = "select * from activity_banner";
$queryActivity = "select * from activity order by id DESC";
$resultStatus = "";

$activityArr = $conn->query($queryActivity);
$activityList = [];
for ($i = 0; $i < mysqli_affected_rows($conn); $i++) {
    $activityList[] = mysqli_fetch_assoc($activityArr);
}

$bannerArr = $conn->query($queryBanner);
$bannerList = [];
for ($j = 0; $j < mysqli_affected_rows($conn); $j++) {
    $bannerList[] = mysqli_fetch_assoc($bannerArr);
}
$resultStatus = "success";

echo json_encode(array("resultData" => array("activityList" => $activityList, "bannerList" => $bannerList), "resultStatus" => $resultStatus));

mysqli_close($conn);
