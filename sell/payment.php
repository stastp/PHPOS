<meta charset="UTF-8">
<? include "../boot.php" ?>
<?
$sql = "SELECT * FROM sells ORDER BY itemsid DESC LIMIT 1";
if($result = $conn->query($sql)){
    foreach($result as $row){
        $itemsid = $row["itemsid"]+1;
    }
}
if(!isset($itemsid)){
    $itemsid=1;
}
$name=$_GET["firstname"];
$mail=$_GET["email"];
$sql = "INSERT INTO `sells` (`id`, `name`, `email`, `itemsid`) VALUES (NULL, '$name', '$mail', $itemsid)";
if($conn->query($sql)){
    echo "";
} else{
    echo "Ошибка: " . $conn->error;
}


$sql = 'SELECT * FROM cart WHERE `ip` = "'.$_SERVER['REMOTE_ADDR'].'"';
if($result = $conn->query($sql)){
    foreach($result as $row){
        $id = $row["item"];
        $sql1 = "INSERT INTO `items` (`id`, `itemsid`, `item`) VALUES (NULL, '$itemsid', '$id');";
        if($conn->query($sql1)){
            echo "";
        } else{
            echo "Ошибка: " . $conn->error;
        }
    }
    $result->free();
} else{
    echo "Ошибка: " . $conn->error;
}
$ip = $_SERVER['REMOTE_ADDR'];
$sql = "DELETE FROM cart WHERE ip = '$ip'";
if(mysqli_query($conn, $sql)){
echo "";
} else{
    echo "Ошибка: " . mysqli_error($conn);
}
?>


<!DOCTYPE html>

<html>
  <style>
    body {
        background: white }
    section {
        background: white;
        color: black;
        border-radius: 1em;
        border: 3px solid black;
        padding: 1em;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%) }
  </style>
  <section>
    <h1>Успешно</h1>
    <p>Продажа выполнена
    <a href="schet.php?id=<? echo $itemsid ?>"><button>Счёт</button></a>
    <a href="/"><button>На главную</button></a>
  </section>

