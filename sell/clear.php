<? include "../boot.php";
$sql = 'DELETE FROM `cart` WHERE `cart`.`ip` = "'.$_SERVER['REMOTE_ADDR'].'"';
if($conn->query($sql)){
header('Location: index.php', true, 301);
exit();
} else{
    echo "Ошибка: " . $conn->error;
}


