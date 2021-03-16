<?php
	$columnArray = array();
	$columnArray['footer'] = '<jdoc:include type="modules" name="footer" style="xtc" />';
	$columnArray['legals'] = '<jdoc:include type="modules" name="legals" style="xtc" />';

	$areaWidth = $gridParams->wrapperwidth;
	$gutter = $gridParams->columnseparatorwidth;
	$order = 'footer,legals';
$debug = 0;
	$grid = xtcGrid($areaWidth,$gutter,$order,$columnArray,$customWidths,$columnClass,$debug);

	if (!empty($grid)) {
		echo '<div id="region10wrap">';
		echo '<div id="region10" class="clearfix xtc-wrapper">';
		echo $grid;
		echo '</div></div>';
	}
?>