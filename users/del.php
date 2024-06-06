<?
include "../boot.php";
if(!isset($_GET["id"])){
    header("Location: index.php");
}else{
    $id=$_GET["id"];
}

$sql = "DELETE FROM users WHERE id = '$id'";
if($conn->query($sql)){
    header("Location: index.php");
}else{
    echo "Ошибка: " . $conn->error;
}
?>
