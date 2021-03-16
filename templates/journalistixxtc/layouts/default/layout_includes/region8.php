<?php
	$columnArray = array();
	$columnArray['user11'] = '<jdoc:include type="modules" name="user11" style="xtc" />';
	$columnArray['user12'] = '<jdoc:include type="modules" name="user12" style="xtc" />';
	$columnArray['user13'] = '<jdoc:include type="modules" name="user13" style="xtc" />';
	$columnArray['user14'] = '<jdoc:include type="modules" name="user14" style="xtc" />';

	$areaWidth = $gridParams->wrapperwidth;
	$gutter = $gridParams->columnseparatorwidth;
	$order = 'user11,user12,user13,user14';
    $debug = 0;
	$grid = xtcGrid($areaWidth,$gutter,$order,$columnArray,$customWidths,$columnClass,$debug);

	if (!empty($grid)) {
		echo '<div id="region8wrap">';
		echo '<div id="region8" class="xtc-wrapper clearfix">';
		echo $grid;
		echo '</div></div>';
	}
?>