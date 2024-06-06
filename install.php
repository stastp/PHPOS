<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<!-- Скрипт проверки принятия соглашения / лицензии -->
<script type="text/javascript">
function agreeForm(f) {    // Если поставлен флажок, снимаем блокирование кнопки    
if (f.agree.checked) f.install.disabled = 0 // В противном случае вновь блокируем кнопку    
else f.install.disabled = 1   }  
</script>
<!-- Кодировка -->
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<!-- Название установщика -->
<title>Установка</title>
<!-- Подключаем CSS (оформление) -->
<link rel="stylesheet" type="text/css" href="i.css">

<?
//Если файл конфигураций пресуцтвует то просим его удалить :D
$filename = 'install.lock';/* Папка/Файл.php */
if (file_exists($filename)) {
  print "<div><h2>Ошибка</h2><h5>Для того что бы продолжить установку удалите $filename и <a href=install.php >обновите</a> страницу.</h5></div>";
} else {
?>

<body>
<h5> PHPOS </h5>
<?php
if(!$_GET['go']) {
?>

<form method="post" action="install.php?go=true"><!--Форма ( необходимо для шага 2)-->



<div>
<h2>Конфигурации</h2>
<table>
</td></tr>        
<tr><td align=right>Хост</td><td align=left><input type=text name=mysql_host >        
</td></tr>        
<tr><td align=right>Логин</td><td align=left><input type=text name=mysql_user>
</td></tr>        
<tr><td align=right>Пароль</td><td align=left><input type=password name=mysql_password>        
</td></tr>        
<tr><td align=right>База</td><td align=left><input type=text name=my_database >        
</td></tr>
</td></tr> 
</table>
</div>
<div>
<h2>Лицензия</h2>
<p><center><textarea cols="60" rows="4" readonly>
1. Авторские права
Программное обеспечение охраняется авторскими правами и международными законами об авторском праве. Любое изменение кода Программного обеспечения без письменного разрешения правообладателя запрещено.

2. Копирайт
Программное обеспечение содержит копирайт, который не должен быть изменен или удален без письменного разрешения правообладателя.

3. Ограничения
Вы не имеете права распространять, продавать, сублицензировать или передавать Программное обеспечение третьим лицам без письменного разрешения правообладателя.

4. Отказ от гарантий
Программное обеспечение предоставляется "как есть" без каких-либо гарантий. Правообладатель не несет ответственности за любые убытки, возникшие в результате использования или невозможности использования Программного обеспечения.

5. Прочие условия
Настоящее Соглашение является полным и окончательным соглашением между вами и правообладателем относительно использования Программного обеспечения.

</textarea></center></p>   <p><input type="checkbox" name="agree"  onclick="agreeForm(this.form)">     Я согласен</p>   <p> <input type="submit" name="install" value="Далее" disabled>  <input type="submit"  value="Обновить" disabled>  
</div>
</form>
<?php
} else {
?>
<div>
<h2>Установка...</h2>




<?
echo 'Файл cfg.php '; 
$fp = fopen ("cfg.php","w");  //Желательно не менять , но если заменили то ниже там где заполнение бд укажите путь к конфигу
        
fputs($fp,"<?php\n\r");        
fputs($fp,'return array('."\n");
fputs($fp,'    "db_host" => "'.$_POST['mysql_host'].'"'.",\n");
fputs($fp,'    "db_name" => "'.$_POST['my_database'].'"'.",\n");
fputs($fp,'    "db_user" => "'.$_POST['mysql_user'].'"'.",\n");
fputs($fp,'    "db_pass" => "'.$_POST['mysql_password'].'"'.",\n");
fputs($fp,'    "nds" => '."10"."\n");

fputs($fp,');'."\n");            
fputs($fp,"?>\n\r"); 
      
fclose($fp);
echo '<font color=green>создан</font><BR>';
// Создадим файл .htaccess и укажем в нем
// что по умолчанию нужно открывать файл index.php
echo 'Файл .htaccess ';
$f=fopen('.htaccess','w');
flock($f,LOCK_EX);
fputs($f,"DirectoryIndex index.php\n");
fputs($f,"php_flag display_startup_errors off\n");
fputs($f,"php_flag display_errors off\n");
fputs($f,"php_flag html_errors off\n");
flock($f,LOCK_UN);
fclose($f);
echo '<font color=green>создан</font><BR>';

echo 'Файл install.lock '; 
file_put_contents('install.lock', '');
echo '<font color=green>создан</font><BR>';

echo 'Импорт базы данных ';

$cfg = require 'cfg.php'; //путь к конфигу указаному при создании файла


$mysqli = new mysqli($cfg["db_host"], $cfg["db_user"], $cfg["db_pass"], $cfg["db_name"]);

// Проверяем соединение
if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}

// Считываем содержимое файла .sql
$sql_file = 'i.sql';
$sql = file_get_contents($sql_file);

// Разделение запросов по точке с запятой
$queries = explode(';', $sql);

// Выполнение каждого запроса
foreach($queries as $query) {
    if(trim($query) != '') {
        if(!$mysqli->query($query)) {
            echo "Ошибка выполнения запроса: " . $mysqli->error;
            die();
        }
    }
}

// Закрываем соединение
$mysqli->close();
echo '<font color=green>выполнен</font><BR>';
?>

</div>
<div>
<h2>Проверка файлов...</h2>
<h5>Файлы <BR></h5>
<?
$filename = 'cfg.php'; //Путь и файл который проверяем
if (file_exists($filename)) {
  print "Файл <b>$filename</b> существует"; //Если найден
} else {
  print "Файл <b>$filename</b>  
        НЕ существует";
}
Echo '<BR>';
$filename = '.htaccess';//Путь и файл который проверяем
if (file_exists($filename)) {
  print "Файл <b>$filename</b> существует"; //Если найден
} else {
  print "Файл <b>$filename</b>  
        НЕ существует";
}
Echo '<BR>';
$filename = 'boot.php';//Путь и файл который проверяем
if (file_exists($filename)) {
  print "Файл <b>$filename</b> существует"; //Если найден
} else {
  print "Файл <b>$filename</b>  
        НЕ существует";
}
Echo '<BR>';
$filename = 'install.lock';//Путь и файл который проверяем
if (file_exists($filename)) {
  print "Файл <b>$filename</b> существует"; //Если найден
} else {
  print "Файл <b>$filename</b>  
        НЕ существует";
}
Echo '<BR>';
?>
<h5>Папки</h5>
<?php
$catname = 'phpmods'; //Название папки
if (is_dir("$catname")) {
  print "Папка <b>$catname</b> существует"; //Если найдена
} else {
  print "Файл <b>$catname</b> 
        НЕ существует";
}

Echo '<BR>';

?>


</div>
<div class="<?php if($error) print 'error'; else print 'success'; ?>">
<h2>Установка окончена!</h2>
<?php
if($error)
print 'Ошибка при установки!';
else
print 'Установка движка окончена! <a href="index.php">главная</a> Код сотрудника: 0000, кода доступа нет, не забудбте удалить пользователей без паролья и с правами выше 1';

?>

</div>
<?php } ?>
<?php } ?>

</body>
</html>
