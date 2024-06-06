<? include "../boot.php" ?>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
* {
    box-sizing: border-box;
}

/* Create three equal columns that floats next to each other */
.column {
    float: left;
    width: 33.33%;
    padding: 10px;
    height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}
#myInput {
    background-image: url('/css/searchicon.png'); /* Add a search icon to input */
    background-position: 10px 12px; /* Position the search icon */
    background-repeat: no-repeat; /* Do not repeat the icon image */
    width: 100%; /* Full-width */
    font-size: 16px; /* Increase font-size */
    padding: 12px 20px 12px 40px; /* Add some padding */
    border: 1px solid #ddd; /* Add a grey border */
    margin-bottom: 12px; /* Add some space below the input */
}

#myTable {
    border-collapse: collapse; /* Collapse borders */
    width: 100%; /* Full-width */
    border: 1px solid #ddd; /* Add a grey border */
    font-size: 18px; /* Increase font-size */
}

#myTable th, #myTable td {
    text-align: left; /* Left-align text */
    padding: 12px; /* Add padding */
}

#myTable tr {
    /* Add a bottom border to all table rows */
    border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
    /* Add a grey background color to the table header and on hover */
    background-color: #f1f1f1;
}
.myTable {
    border-collapse: collapse; /* Collapse borders */
    width: 100%; /* Full-width */
    border: 1px solid #ddd; /* Add a grey border */
    font-size: 18px; /* Increase font-size */
}

.myTable th, #myTable td {
    text-align: left; /* Left-align text */
    padding: 12px; /* Add padding */
}

.myTable tr {
    /* Add a bottom border to all table rows */
    border-bottom: 1px solid #ddd;
}

.myTable tr.header, #myTable tr:hover {
    /* Add a grey background color to the table header and on hover */
    background-color: #f1f1f1;
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
<h1>Продажа</h1>
<div class="row">
  <div class="column">
<?
$sql = "SELECT * FROM products WHERE `enable` = 1";
if($result = $conn->query($sql)){
    $rowsCount = $result->num_rows; // количество полученных строк
    echo "<table id='myTable'><tr><th>Имя</th><th>Цена</th><th></th></tr>";
    echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Поиск по имени">';
    foreach($result as $row){
        echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["price"] . " ₽</td>";
            echo "<td><form action='add.php'><input type='hidden' name='id' value='".$row["id"]."'><input type='number' name='amount'><input type='submit' value='Добавить'></form></td>";
        echo "</tr>";
    }
    echo "</table>";
    $result->free();
} else{
    echo "Ошибка: " . $conn->error;
}
?>
  </div>
  <div class="column"></div>
  <div class="column">
<?
$sql = 'SELECT * FROM cart WHERE `ip` = "'.$_SERVER['REMOTE_ADDR'].'"';
if($result = $conn->query($sql)){
    $al=0;
    $rowsCount = $result->num_rows; // количество полученных строк
    echo '<div class="row"><div class="col-25"><div class="container">';
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
            echo '<a href="rem.php?id='.$row["id"].'">'.$name."</a>";
            echo '<span class="price">₽' . $price . "</span>";
        echo "</p>";
    }
    echo '<hr><p>Всего <span class="price" style="color:black"><b>₽'.$al.'</b></span></p>';
    echo "</div></div></div></div>";
    $result->free();
} else{
    echo "Ошибка: " . $conn->error;
}
?>
</div>

<a href="clear.php"><button>Очистить</button></a>
<a href="pay.php"><button>Оплата</button></a>


<script>
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>