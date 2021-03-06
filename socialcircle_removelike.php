<?php
/**
 * Created by PhpStorm.
 * User: rainnka
 * Date: 2017/5/14
 * Time: 23:08
 */

include "access_allow_origin.php";

$id = $_POST["id"];
$id_socialcircle = $_POST["id_socialcircle"];

list($t1, $t2) = explode(' ', microtime());
$timestamp = $t2 . ceil( ($t1 * 1000) );

include 'connect_mysql.php';
include 'UTF8.php';

$resultData = [];
$resultStatus = "";

$queryRemoveLike = "delete from user_sociallike where user_sociallike.id_user='{$id}' and user_sociallike.id_socialcircle='{$id_socialcircle}'";
$updateLikeCount = "update user_socialcircle set likecount=likecount-1 where id='{$id_socialcircle}'";

// 开启事务
$conn->query("SET AUTOCOMMIT=0");
$conn->begin_transaction();

$removeLikeRes = $conn->query($queryRemoveLike);
if(mysqli_affected_rows($conn) == 0) {
    $resultStatus = "fail";
    $resultData = "操作失败";
    $conn->rollback();
    echo json_encode(array("resultData"=>$resultData,"resultStatus"=>$resultStatus));
    exit(0);
}

$updateLikeCountRes = $conn->query($updateLikeCount);
if(mysqli_affected_rows($conn) == 0) {
    $resultStatus = "fail";
    $resultData = "操作失败";
    $conn->rollback();
    echo json_encode(array("resultData"=>$resultData,"resultStatus"=>$resultStatus));
    exit(0);
}

$conn->commit();

$resultData = "操作成功";
$resultStatus = "success";

echo json_encode(array("resultData"=>$resultData,"resultStatus"=>$resultStatus));

mysqli_close($conn);
