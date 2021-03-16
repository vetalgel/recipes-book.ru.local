<?php
	$columnArray = array();
	$columnArray['user7'] = '<jdoc:include type="modules" name="user7" style="xtc" />';
	$columnArray['user8'] = '<jdoc:include type="modules" name="user8" style="xtc" />';
	$columnArray['user9'] = '<jdoc:include type="modules" name="user9" style="xtc" />';
	$columnArray['user10'] = '<jdoc:include type="modules" name="user10" style="xtc" />';

	$areaWidth = $gridParams->wrapperwidth;
	$gutter = 30;
	$order = 'user7,user8,user9,user10';
    $debug = 0;
	$grid = xtcGrid($areaWidth,$gutter,$order,$columnArray,$customWidths,$columnClass,$debug);

	if (!empty($grid)) {
		echo '<div id="region5wrap">';
		echo '<div id="region5" class="clearfix xtc-wrapper">';
		echo $grid;
		echo '</div></div>';
	}
?>