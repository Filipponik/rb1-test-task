<?
require_once('config.php');
require_once('header.php');
$page = $_REQUEST['page'];
if (!$page) {
	$page = 1;
}
else if (is_numeric($page)) {
	$page = intval($page);
}
$pages = get_pages($page, 'SELECT COUNT(*) as `count` FROM `sites`');
$sites_on_page = R::getAll('SELECT * FROM `sites` LIMIT ?, ?', pagination($page));
?>

<div class="container pt-24 px-5 mx-auto flex flex-wrap">
<h2 class="sm:text-3xl text-2xl text-gray-900 font-medium title-font mb-2 md:w-2/5">Выберите отслеживаемый сайт:</h2>
</div>
<div class="container px-5 py-10 mx-auto flex flex-wrap">
  <div class="flex flex-wrap -m-4">
	<?foreach ($sites_on_page as $site) {?>
    <div class="p-4 <?=count($sites_on_page) > 1?'lg:w-1/2':'lg:w-full'?> md:w-full">
      <div class="flex border-2 rounded-lg border-gray-200 border-opacity-50 p-8 sm:flex-row flex-col">
        <div class="w-16 h-16 sm:mr-8 sm:mb-0 mb-4 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0">
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10" viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
          </svg>
        </div>
        <div class="flex-grow">
          <h2 class="text-gray-900 text-lg title-font font-medium mb-3"><?=$site['url']?></h2>
          <p class="leading-relaxed text-base">Вы можете перейти на страницу со статистикой по данному сайту </p>
          <a href="/site?site=<?=$site['url']?>" class="mt-3 text-indigo-500 inline-flex items-center">Перейти
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
              <path d="M5 12h14M12 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
	<?}?>
   	</div>
	<div class="container py-10 mx-auto flex flex-wrap">
	    <div style="flex flex-wrap -m-4">
			<?
			foreach ($pages as $current_page) {
				if ($current_page['page'] && !$current_page['is_separator']) {?>
					<a class="<?=($current_page['page'] == $page)?'text-gray-900 border-2 rounded-lg border-gray-200 border-opacity-50':'text-gray-500'?> px-3 py-1 mx-1 text-xl font-medium" href="?page=<?=$current_page['page']?>"><?=$current_page['page']?></a>
				<?} else {?>
					<span class="text-gray-500 px-3 mx-1 text-xl font-medium">...</a>
				<?}
			}?>
		</div>
	</div>
</div>
<?require_once('footer.php');?>