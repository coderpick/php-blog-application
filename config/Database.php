<?php 
    define("SERVER_NAME",'localhost');
    define("USER_NAME",'root');
    define("PASSWORD",'');
    define("DB_NAME", 'blog23_db');
   
    try{
        $conn = new PDO("mysql:host=".SERVER_NAME.";dbname=".DB_NAME, USER_NAME, PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       // echo "success";
    }catch(PDOException $e){
        die("ERROR: Could not connect. " . $e->getMessage());
    }
?>