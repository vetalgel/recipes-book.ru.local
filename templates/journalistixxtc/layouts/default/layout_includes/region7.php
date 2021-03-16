<?php
	$columnArray = array();
	$columnArray['bottom1'] = '<jdoc:include type="modules" name="bottom1" style="xtc" />';

	$areaWidth = $gridParams->wrapperwidth;
	$gutter = $gridParams->columnseparatorwidth;
	$order = 'bottom1';
    $debug = 0;
	$grid = xtcGrid($areaWidth,$gutter,$order,$columnArray,$customWidths,$columnClass,$debug);

	if (!empty($grid)) {
		echo '<div id="region7wrap">';
		echo '<div id="region7" class="xtc-wrapper clearfix">';
		echo $grid;
		echo '</div></div>';
	}
?>