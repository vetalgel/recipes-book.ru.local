<?php
	$columnArray = array();
	$columnArray['user15'] = '<jdoc:include type="modules" name="user15" style="xtc" />';
	$columnArray['user16'] = '<jdoc:include type="modules" name="user16" style="xtc" />';
	$columnArray['user17'] = '<jdoc:include type="modules" name="user17" style="xtc" />';
	$columnArray['user18'] = '<jdoc:include type="modules" name="user18" style="xtc" />';

	$areaWidth = $gridParams->wrapperwidth;
	$gutter = $gridParams->columnseparatorwidth;
	$order = 'user15,user16,user17,user18';
	$customWidths = array();
	$customWidths['user18'] = 310;
    $debug = 0;
	$grid = xtcGrid($areaWidth,$gutter,$order,$columnArray,$customWidths,$columnClass,$debug);

	if (!empty($grid)) {
		echo '<div id="region9wrap">';
		echo '<div id="region9" class="clearfix xtc-wrapper">';
		echo $grid;
		echo '</div></div>';
	}
?>