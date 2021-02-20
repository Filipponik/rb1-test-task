<?
header('Content-Type: application/json');
require_once('config.php');

function is_normal_int($number, $is_timestamp = false) {
	if (!is_numeric($number))
		return false;

	$number = intval($number);
	if ($number < 0)
		return false;

	// вряд ли будут данные о клике до 2000 года
	if ($is_timestamp && $number < 946684800)
		return false;
	return true;
}
$data = $_GET;
/*
	В $data получаем массив 
	[
		'x' => int, 
		'y' => int,
		'ts' => int,
		'site' => string, 
		'page' => string
	]
*/
if (!is_normal_int($data['x']) || !is_normal_int($data['y']) || !is_normal_int($data['ts'], true)) {
	exit(json_encode(['status' => 'error','error_text' => 'Некорректный ввод данных']));
}
else {
	$data['x'] = intval($data['x']);
	$data['y'] = intval($data['y']);
	$data['ts'] = intval($data['ts']);
}

$site = R::getRow('SELECT `id` FROM `sites` WHERE `url` = ?', array($data['site']));

if (empty($site) || !is_array($site) || !$site) {
	$site = R::dispense('sites');
	$site->url = $data['site'];

	try {
		$site_id = R::store($site);
	}
	catch (Exception $e) {
		exit(json_encode(['status' => 'error', 'error_text' => 'Ошибка добавления сайта в БД']));
	}
}
else
	$site_id = $site['id'];

$sitepage = R::getRow('SELECT `id` FROM `sitepage` WHERE `url` = ? AND `site_id` = ?', array($data['page'], $site_id));

if (empty($sitepage) || !is_array($sitepage) || !$sitepage) {
	$sitepage = R::dispense('sitepage');
	$sitepage->url = $data['page'];
	$sitepage->site_id = $site_id;

	try {
		$sitepage_id = R::store($sitepage);
	}
	catch (Exception $e) {
		exit(json_encode(['status' => 'error', 'error_text' => 'Ошибка добавления страницы в БД']));
	}
}
else
	$sitepage_id = $sitepage['id'];



$click = R::dispense('clicks');
$click->x = $data['x'];
$click->y = $data['y'];
$click->timestamp = $data['ts'];
$click->sitepage_id = $sitepage_id;

try {
	R::store($click);
	exit(json_encode(['status' => 'success']));
}
catch (Exception $e) {
	exit(json_encode(['status' => 'error', 'error_text' => 'Ошибка добавления нажатия в БД']));
}

?>