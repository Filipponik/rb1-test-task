<?
session_start();
require 'rb.php';
$db_conn_string = 'mysql:host=localhost;dbname=DB_NAME';
$db_user = 'USER';
$db_pass = 'PASS';
R::setup($db_conn_string, $db_user, $db_pass);
R::freeze(true);
if (!R::testConnection()) {
	exit('Нет подключения к базе данных');
}