<?php

$filepath = dirname(__FILE__);
include ($filepath ."/../config/Database.php");

if (isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    /*Delete record*/
    try {
        $sql = "DELETE FROM category WHERE id=:id";
        $deleteStmt = $conn->prepare($sql);
        $deleteStmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($deleteStmt->execute()) {
            session_start();
            $_SESSION['success'] = "Category delete successfully";
            header("location:category.php");
        }
    }catch (PDOException $e) {
        die("ERROR: Could not prepare/execute query: $sql. " . $e->getMessage());
    }
}

?>