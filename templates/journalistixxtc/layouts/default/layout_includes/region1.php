<?php
	$columnArray = array();
	$columnArray['icon1'] = '<jdoc:include type="modules" name="icon1" style="xtc" />';
	$columnArray['icon2'] = '<jdoc:include type="modules" name="icon2" style="xtc" />';

	$areaWidth = $gridParams->wrapperwidth;
	$gutter = $gridParams->columnseparatorwidth;
	$order = 'icon1,icon2';
    $debug = 0;
    $customWidths = '';
    $columnClass = '';
	$grid = xtcGrid($areaWidth,$gutter,$order,$columnArray,$customWidths,$columnClass,$debug);

	if (!empty($grid)) {
		echo '<div id="region1wrap">';
		echo '<div id="region1" class="xtc-wrapper clearfix">';
		echo $grid;
		echo '</div></div>';
	}
?>