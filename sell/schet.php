<?
function calc_percent($price, $percent)
{
	return $price * ($percent / 100); 
}
include "../boot.php";
$prods = array();
$sql = "SELECT *, count(item) FROM items WHERE itemsid = ".$_GET["id"]." GROUP BY item";
if($result = $conn->query($sql)){
    foreach($result as $row){
        $sql2 = "SELECT * FROM products WHERE `id` = ".$row["item"];
        if($result1 = $conn->query($sql2)){
            foreach($result1 as $item){
                $price = $item["price"];
                $name = $item["name"];
            }
        }
        array_push($prods, 
            array(
            'name' => $name,
            'count' => $row["count(item)"],
            'unit'  => 'шт',
            'price' => $price,
            'nds'   => calc_percent($price, $cfg["nds"]),
            )
        );
    }
}




// Форматирование цен.
function format_price($value)
{
	return number_format($value, 2, ',', ' ');
}
 
// Сумма прописью.
function str_price($value)
{
	$value = explode('.', number_format($value, 2, '.', ''));
 
	$f = new NumberFormatter('ru', NumberFormatter::SPELLOUT);
	$str = $f->format($value[0]);
 
	// Первую букву в верхний регистр.
	$str = mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1, mb_strlen($str));
 
	// Склонение слова "рубль".
	$num = $value[0] % 100;
	if ($num > 19) { 
		$num = $num % 10; 
	}	
	switch ($num) {
		case 1: $rub = 'рубль'; break;
		case 2: 
		case 3: 
		case 4: $rub = 'рубля'; break;
		default: $rub = 'рублей';
	}	
	
	return $str . ' ' . $rub . ' ' . $value[1] . ' копеек.';
}


include "tpl.php";
// Если на сайте используется автозагрузка классов
//spl_autoload_unregister('autoload');
 
include_once '../phpmods/dompdf/autoload.inc.php';
$dompdf = new Dompdf\Dompdf();
$dompdf->set_option('isRemoteEnabled', TRUE);
$dompdf->setPaper('A4', 'portrait');
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->render();
 
// Вывод файла в браузер:
$dompdf->stream('schet'); 
 
