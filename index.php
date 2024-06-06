<? include "boot.php" ?><meta charset="UTF-8">
<style>
.filterDiv {
  float: left;
  background-color: #2196F3;
  color: #ffffff;
  width: 100px;
  line-height: 100px;
  text-align: center;
  margin: 2px;
}

.container {
  margin-top: 20px;
  overflow: hidden;
}
</style>
<body>

<h2>Приложения</h2>

<?
$sql = "SELECT * FROM modules WHERE `enable` = 1";
if($result = $conn->query($sql)){
    echo '<div class="container">';
    foreach($result as $row){
        if($row["reqacc"] <= $_SESSION["authcode"]){
            echo '<a href="'.$row["link"].'"><div class="filterDiv">'.$row["btn_text"]."</div></a>";
        }
    }
    echo "</div>";
    $result->free();
} else{
    echo "Ошибка: " . $conn->error;
}?>