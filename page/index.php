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

?>

<div class="container pt-24 px-5 mx-auto flex flex-wrap">
  <h2 class="sm:text-3xl text-2xl text-gray-900 font-medium title-font mb-2 md:w-2/5">Последние нажатия по странице <a href="//<?=$site.$path['url']?>"><?=$site.$path['url']?></a>:</h2>
</div>
<?if (!$clicks_on_page || empty($clicks_on_page) || !is_array($clicks_on_page)) {
}
else {?>
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
				if ($current_page['page'] && !$current_page['is_separator']) {?>
					<a class="<?=($current_page['page'] == $page)?'text-gray-900 border-2 rounded-lg border-gray-200 border-opacity-50':'text-gray-500'?> px-3 py-1 mx-1 text-xl font-medium" href="?path=<?=$data['path']?>&page=<?=$current_page['page']?>"><?=$current_page['page']?></a>
				<?} else {?>
					<span class="text-gray-500 px-3 mx-1 text-xl font-medium">...</a>
				<?}
			}?>
		</div>
	</div>
</div>
<?}?>
<?require_once('../footer.php');?>