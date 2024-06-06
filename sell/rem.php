<? include "../boot.php";
$sql = "DELETE FROM `cart` WHERE `cart`.`id` = ".$_GET["id"];
if($conn->query($sql)){
header('Location: index.php', true, 301);
exit();
} else{
    echo "Ошибка: " . $conn->error;
}


