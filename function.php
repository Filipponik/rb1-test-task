<?
define('ELEMENTS_ON_PAGE', 2);
function pagination($page, $elements_on_page_custom = false) {
	if ($elements_on_page_custom == false) {
		$elements_on_page_custom = ELEMENTS_ON_PAGE;
	} 
	$offset = ($page - 1) * $elements_on_page_custom;
	return [$offset, $elements_on_page_custom];
}

function get_pages($current_page, $query, $data = array(), $elements_on_page_custom = false) {
	if ($elements_on_page_custom == false) {
		$elements_on_page_custom = ELEMENTS_ON_PAGE;
	} 
	$elements_count = R::getRow($query, $data)['count'];
	$pages_count = intval(ceil($elements_count / $elements_on_page_custom));
	$pages = array();
	if ($pages_count <= 5) {
		for ($i=1;$i<=$pages_count;$i++) {
			$pages['page_'.$i] = array(
				'page' => $i,
				'is_page' => true,
			);
		}
	} 
	else {
		// добавление первых двух страниц
		$pages['page_1'] = array('page' => 1);
		if (in_array($current_page, [1,2,3])) {
			$pages['page_2'] = array('page' => 2);
		}

		// добавление разделителя
		if ($current_page - 2 > 1) {
			$pages['separator_1'] = array('is_separator' => true);
		}

		if ($current_page > 1 && $current_page < $pages_count) {
			$pages['page_'.($current_page-1)] = array('page' => $current_page-1);
			$pages['page_'.$current_page] = array('page' => $current_page);
			$pages['page_'.($current_page+1)] = array('page' => $current_page+1);
		}

		// добавление разделителя
		if ($current_page + 2 < $pages_count) {
			$pages['separator_2'] = array('is_separator' => true);
		}

		// добавление последних двух страниц
		if (in_array($current_page, [$pages_count,$pages_count-1,$pages_count-2])) {
			$pages['page_'.($pages_count-1)] = array('page' => $pages_count-1);
		}

		$pages['page_'.$pages_count] = array('page' => $pages_count);
	}
	return $pages;
}
?>