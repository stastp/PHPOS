<?
session_start();
if(!file_exists("install.lock")){
    header("Location: /install.php");
}
$cfg = include "cfg.php";
$conn = new mysqli($cfg["db_host"], $cfg["db_user"], $cfg["db_pass"], $cfg["db_name"]);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 


if(!isset($_SESSION["authcode"]) and !isset($noauth)){
    header("Location: /auth.php");
}