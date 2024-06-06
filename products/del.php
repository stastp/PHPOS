<?
include "auth.php";
if(!isset($_GET["id"])){
    header("Location: index.php");
}else{
    $id=$_GET["id"];
}

$sql = "DELETE FROM products WHERE id = '$id'";
if($conn->query($sql)){
    header("Location: index.php");
}else{
    echo "Ошибка: " . $conn->error;
}
?>
