<?
include "auth.php";
if(!isset($_GET["name"]) and !isset($_GET["price"]) and !isset($_GET["status"])){
    header("Location: index.php");
}else{
    $name=$_GET["name"];
    $price=$_GET["price"];
    $status=$_GET["status"];
    $sql = "INSERT INTO products VALUES (NULL, '$name', $price, $status)";
    if($conn->query($sql)){
        header("Location: index.php");
    } else{
        echo "Ошибка: " . $conn->error;
    }
}