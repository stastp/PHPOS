<?
include "../boot.php";
if(!isset($_GET["login"]) and !isset($_GET["code"]) and !isset($_GET["acc"])){
    header("Location: index.php");
}else{
    $login=$_GET["login"];
    $code=$_GET["code"];
    $acc=$_GET["acc"];
    $sql = "INSERT INTO users VALUES (NULL, '$login', '$code', $acc)";
    if($conn->query($sql)){
        header("Location: index.php");
    } else{
        echo "Ошибка: " . $conn->error;
    }
}