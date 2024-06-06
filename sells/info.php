<? include "../boot.php" ?>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
  font-family: Arial;
  font-size: 17px;
  padding: 8px;
}

* {
  box-sizing: border-box;
}

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}

a {
  color: #2196F3;
}

hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>
<div class="container">
        <div class="row">
            <div class="col-75">
                <div class="container">
<?
$userid = mysqli_real_escape_string($conn, $_GET["id"]);
$sql = "SELECT * FROM sells WHERE id = '$userid'";
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){
        foreach($result as $row){
            $name = $row["name"];
            $mail = $row["email"];
            $itemsid = $row["itemsid"];
            $datetime = $row["datetime"];
            echo "<div>
                    <h3>Информация о продаже</h3>
                    <p>Имя: $name</p>
                    <p>Почта: $mail</p>
                    <p>Время: $datetime</p>
                </div>";
        }
    }
    else{
        echo "<div>Продажа не найдена</div>";
    }
    mysqli_free_result($result);
} else{
    echo "Ошибка: " . mysqli_error($conn);
}
?>
                </div>
            </div>        
<?
$sql = 'SELECT * FROM items WHERE `itemsid` = "'.$itemsid.'"';
if($result = $conn->query($sql)){
    $al=0;
    $rowsCount = $result->num_rows; // количество полученных строк
    echo '<div class="col-25"><div class="container">';
    echo '<h4>Товары <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> <b>'.$rowsCount.'</b></span></h4>';
    foreach($result as $row){
        $sql2 = "SELECT * FROM products WHERE `id` = ".$row["item"];
        if($result1 = $conn->query($sql2)){
            foreach($result1 as $item){
                $price = $item["price"];
                $name = $item["name"];
            }
        }
        $al=$al+$price;
        echo "<p>";
            echo ''.$name."";
            echo '<span class="price">₽' . $price . "</span>";
        echo "</p>";
    }
    echo '<hr><p>Всего <span class="price" style="color:black"><b>₽'.$al.'</b></span></p>';
    echo "</div></div></div>";
    $result->free();
} else{
    echo "Ошибка: " . $conn->error;
}
?>
<a href="index.php">Назад</a>