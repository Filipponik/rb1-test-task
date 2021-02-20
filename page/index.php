<?
require_once('../config.php');
require_once('../header.php');
$data = $_REQUEST;
$page = $data['page'];
if (!$page) {
	$page = 1;
}
else if (is_numeric($page)) {
	$page = intval($page);
}

$pages = get_pages($page, 'SELECT COUNT(*) as `count` FROM `clicks` WHERE `sitepage_id` = ?', array($data['path']), 10);
$clicks_on_page = R::getAll('SELECT * FROM `clicks` WHERE `sitepage_id` = ? ORDER BY `timestamp` DESC LIMIT ?, ?', [$data['path'], ...pagination($page, 10)]);
$path = R::getRow('SELECT * FROM `sitepage` WHERE `id` = ?', [$data['path']]);
$site = R::getRow('SELECT * FROM `sites` WHERE `id` = ?', [$path['site_id']])['url'];

// подборка для сегодняшнего графика
$today_arr = array();
for ($i = 0; $i <= 24; $i++) {
  $today_arr[$i] = intval(R::getRow('SELECT COUNT(*) as `count` FROM `clicks` WHERE `sitepage_id` = ? AND `timestamp` > ? AND `timestamp` < ?', array($data['path'], $statistic_dates['today']['start']+60*60*$i, $statistic_dates['today']['start']+60*60*($i+1)))['count']);
}


$alltime_data = R::getAll('SELECT `timestamp` FROM `clicks` WHERE `sitepage_id` = ?', [$data['path']]);
$alltime_data_chart = array();
for ($i = 0; $i <= 24; $i++) {
  $alltime_data_chart[$i] = 0;
}

for ($i = 0; $i <= 24; $i++) {
  foreach ($alltime_data as $data1) {
    if (date('H', $data1['timestamp']) == $i)
      $alltime_data_chart[$i]++;
  }
}
?>

<?if (!$clicks_on_page || empty($clicks_on_page) || !is_array($clicks_on_page)) {?>
    <h2 class="sm:text-3xl text-2xl pt-24 px-5 text-center mx-auto text-gray-900 font-medium title-font mb-2 md:w-2/5">К сожалению, клики по данной странице не были найдены<br><a href="/" class="sm:text-2xl text-xl text-gray-900 font-medium title-font mb-2 md:w-2/5">Вернуться на главную</a></h2>
<?}
else {?>

<section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-wrap -m-4 text-center">
      <?foreach ($statistic_dates as $date) {
        $result = R::getRow('SELECT COUNT(*) as `count` FROM `clicks` WHERE `sitepage_id` = ? AND `timestamp` > ? AND `timestamp` < ?', [$data['path'], $date['start'], $date['end']])['count'];?>
      <div class="p-4 sm:w-1/4 w-1/2">
        <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900"><?=$result?></h2>
        <p class="leading-relaxed"><?=$date['description']?></p>
      </div>
      <?}?>
    </div>
    <h2 class="sm:text-3xl text-2xl pt-24 px-5 text-center mx-auto text-gray-900 font-medium title-font mb-2 md:w-2/5">Клики за сегодня</h2>
    <canvas class="mx-auto" id="today_chart" width="800" height="400"></canvas>
    <h2 class="sm:text-3xl text-2xl pt-24 px-5 text-center mx-auto text-gray-900 font-medium title-font mb-2 md:w-2/5">Клики за все время</h2>
    <canvas  class="mx-auto" id="alltime_chart" width="800" height="400"></canvas>
  </div>
</section>

<div class="container pt-24 px-5 mx-auto flex flex-wrap">
  <h2 class="sm:text-3xl text-2xl text-gray-900 font-medium title-font mb-2 md:w-2/5">Последние нажатия по странице <a href="//<?=$site.$path['url']?>"><?=$site.$path['url']?></a>:</h2>
</div>
<div class="container px-5 py-10 mx-auto flex flex-wrap">
  <table class="border-collapse w-full">
    <thead>
        <tr>
            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">#</th>
            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">X координата</th>
            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Y координата</th>
            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Дата клика</th>
        </tr>
    </thead>
    <tbody>
        <?
        $i = pagination($page, 10)[0];
        foreach ($clicks_on_page as $click) {
          $i++;?>
        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">X координата</span>
                <?=$i?>
            </td>
            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">X координата</span>
                <?=$click['x']?>
            </td>
            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Y координата</span>
                <?=$click['y']?>
            </td>
            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Дата клика</span>
                <?=date('d.m.Y H:i:s', $click['timestamp'])?>
            </td>
        </tr>
        <?}?>
    </tbody>
  </table>
	<div class="container py-10 mx-auto flex flex-wrap">
	    <div style="flex flex-wrap -m-4">

			<?
			foreach ($pages as $current_page) {
				if ($current_page['page'] && !isset($current_page['is_separator'])) {?>
					<a class="<?=($current_page['page'] == $page)?'text-gray-900 border-2 rounded-lg border-gray-200 border-opacity-50':'text-gray-500'?> px-3 py-1 mx-1 text-xl font-medium" href="?path=<?=$data['path']?>&page=<?=$current_page['page']?>"><?=$current_page['page']?></a>
				<?} else {?>
					<span class="text-gray-500 px-3 mx-1 text-xl font-medium">...</a>
				<?}
			}?>
		</div>
	</div>
</div>
<script>
var ctx = document.getElementById('today_chart').getContext('2d');
var today_chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?=json_encode(array_keys($today_arr))?>,
        datasets: [{
            label: 'Кликов за час (сегодня)',
            data: <?=json_encode($today_arr)?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        responsive: false,
    }
});


var ctx = document.getElementById('alltime_chart').getContext('2d');
var alltime_chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?=json_encode(array_keys($alltime_data_chart))?>,
        datasets: [{
            label: 'Кликов за час (за все время)',
            data: <?=json_encode($alltime_data_chart)?>,
            backgroundColor: [
                'rgba(0, 0, 255, 0.2)',
            ],
            borderColor: [
                'rgba(0, 0, 255, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        responsive: false,
    }
});

</script>
<?}?>
<?require_once('../footer.php');?>