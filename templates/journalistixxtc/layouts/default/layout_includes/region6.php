<?php
	$columnArray = array();
	$columnArray['bottom'] = '<jdoc:include type="modules" name="bottom" style="xtc" />';

	$areaWidth = $gridParams->wrapperwidth;
	$gutter = $gridParams->columnseparatorwidth;
	$order = 'bottom';
    $debug = 0;
	$grid = xtcGrid($areaWidth,$gutter,$order,$columnArray,$customWidths,$columnClass,$debug);

	if (!empty($grid)) {
		echo '<div id="region6wrap">';
		echo '<div id="region6" class="xtc-wrapper clearfix">';
		echo $grid;
		echo '</div></div>';
	}
?>