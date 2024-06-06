<? include "../boot.php";
for ($i = 1; $i <= $_GET["amount"]; $i++) {
    $sql = "INSERT INTO `cart` (`id`, `ip`, `item`) VALUES (NULL, '".$_SERVER['REMOTE_ADDR']."', '".$_GET["id"]."');";
    $conn->query($sql);
}
header('Location: index.php');
exit();



