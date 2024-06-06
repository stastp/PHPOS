<?
include "auth.php";
include "gui.html";
?>
<?
$sql = "SELECT * FROM products";
if($result = $conn->query($sql)){
    $rowsCount = $result->num_rows; // количество полученных строк
    echo "<table id='myTable'><tr><th>Имя</th><th>Цена</th><th>Статус</th><th></th><th></th></tr>";
    echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Поиск по имени">';
    foreach($result as $row){
        echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["price"] . " ₽</td>";
            if($row["enable"]==1){
                echo "<td>" . "Включено" . "</td>";
            }
            if($row["enable"]==0){
                echo "<td>" . "Выключено" . "</td>";
            }
            if($row["enable"]==1){
                echo "<td><a href='sta.php?id=".$row["id"]."&status=0'><button>Выключить</button></td>";
            }
            if($row["enable"]==0){
                echo "<td><a href='sta.php?id=".$row["id"]."&status=1'><button>Включить</button></td>";
            }
            echo "<td><a href='del.php?id=".$row["id"]."'><button>Удалить</button></td>";
        echo "</tr>";
    }
    echo "</table>";
    $result->free();
} else{
    echo "Ошибка: " . $conn->error;
}
?>

<button id="myBtn">Создать товар</button>
<a href="/"><button>На главную</button></a>


<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">×</span>
    <h3>Создание товара</h3>
<form class="form-horizontal" action="add.php">
    <div class="form-group">
        <label for="name" class="control-label col-sm-2">Имя товара<span>*</span></label>
        <div class="col-sm-10">
            <input type="text" name="name" id="name" required placeholder="Введите имя товара">
        </div>
    </div>
    <div class="form-group">
        <label for="price" class="control-label col-sm-2">Цена<span>*</span></label>
        <div class="col-sm-10">
            <input type="number" name="price" id="price" required placeholder="Укажите цену">
        </div>
    </div>
    <div class="form-group">
        <label for="status" class="control-label col-sm-2">Статус<span>*</span></label>
        <div class="col-sm-10">
            <select name="status" id="status" required>
                <option value="1" selected>Включено</option>
                <option value="0">Выключено</option>
            </select>
        </div>
    </div><br>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Добавить</button>
        </div>
    </div>
</form>

  </div>
</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
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
