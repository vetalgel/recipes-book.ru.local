<?php
	$columnArray = array();
	$columnArray['inset'] = '<jdoc:include type="modules" name="inset" style="xtc" />';

	$areaWidth = $gridParams->wrapperwidth;
	$gutter = $gridParams->columnseparatorwidth;
	$order = 'inset';
	$columnClass = '';
    $gutter = 10;
	$grid = xtcGrid($areaWidth,$gutter,$order,$columnArray,$customWidths,$columnClass);

	if (!empty($grid)) {
		echo '<div id="region2wrap">';
		echo '<div id="region2wrappad" class="clearfix">';
		echo '<div id="region2shadow"></div>';
		echo '<div id="region2" class="xtc-wrapper">';
		echo $grid;
		echo '</div></div></div>';
	}
return;
?>