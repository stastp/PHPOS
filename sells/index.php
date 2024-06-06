<? include "../boot.php" ?>
<meta charset="UTF-8">
<?
$sql = "SELECT * FROM sells";
if($result = $conn->query($sql)){
    $rowsCount = $result->num_rows; // количество полученных строк
    echo "<table id='myTable'><tr><th>Имя клиента</th><th>Дата</th><th>ID</th><th></th></tr>";
    echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Поиск по имени">';
    echo '<input type="text" id="myInput1" onkeyup="myFunction1()" placeholder="Поиск по id">';
    foreach($result as $row){
        echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["datetime"] . " </td>";
            echo "<td>" . $row["id"] . " </td>";
            echo "<td><a href='info.php?id=".$row["id"]."'><button>Информация</button></td>";
        echo "</tr>";
    }
    echo "</table>";
    $result->free();
} else{
    echo "Ошибка: " . $conn->error;
}
?>
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
function myFunction1() {
  // Declare variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput1");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
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


<div id="chart">
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
<?
$sql = 'SELECT count(`id`) FROM `sells` WHERE id != 1 GROUP BY DATE(datetime)';

$result = $conn->query($sql);
echo "var values=[";
while($row = mysqli_fetch_array($result))
{
echo $row["count(`id`)"].",";
}
echo "];";

$sql = 'SELECT datetime FROM `sells` WHERE id != 1 GROUP BY DATE(datetime)';

$result = $conn->query($sql);
echo "var rows=[";
while($row = mysqli_fetch_array($result))
{
$dt = explode(" ", $row["datetime"]);
echo "'".$dt[0]."', ";
}
echo "];";
?>

var options = {
    chart: {
        height: 280,
        type: "area"
    },
    dataLabels: {
        enabled: false
    },
    series: [
        {
            name: "Кол-во продаж",
            data: values
        }
    ],
    fill: {
        type: "gradient",
        show: false,
        gradient: {}
    },
    xaxis: {
        categories: rows
    }
};

var chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();
</script>
<a href="/"><button>На главную</button></a>
