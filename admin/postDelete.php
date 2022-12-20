<?php

$filepath = dirname(__FILE__);
include ($filepath ."/../config/Database.php");

if (isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    /*select post image for delete */
    $sql = "SELECT * FROM post WHERE id=:id";
    $selectStmt = $conn->prepare($sql);
    $selectStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $selectStmt->execute();
    $row = $selectStmt->fetch(PDO::FETCH_OBJ);
    if ($row){
        unlink($row->image);
    }
    /*Delete record*/
    try {
        $sql = "DELETE FROM post WHERE id=:id";
        $deleteStmt = $conn->prepare($sql);
        $deleteStmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($deleteStmt->execute()) {
            session_start();
            $_SESSION['success'] = "Post delete successfully";
            header("location:post.php");
        }
    }catch (PDOException $e) {
        die("ERROR: Could not prepare/execute query: $sql. " . $e->getMessage());
    }
}

?>