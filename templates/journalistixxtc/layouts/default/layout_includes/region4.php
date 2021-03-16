<?php

$left = $this->countModules('left');
$right = $this->countModules('right');
$newsflash = $this->countModules('newsflash');
$centerWidth = $gridParams->wrapperwidth;

if ($left) {
    $centerWidth -= ($gridParams->leftwidth + $gridParams->columnseparatorwidth);
}
if ($right) {
    $centerWidth -= ($gridParams->rightwidth + $gridParams->columnseparatorwidth);
}

$columnArray = array();
$columnArray['user1'] = '<jdoc:include type="modules" name="user1" style="xtc" />';
$columnArray['user2'] = '<jdoc:include type="modules" name="user2" style="xtc" />';
$columnArray['user3'] = '<jdoc:include type="modules" name="user3" style="xtc" />';
$columnArray['user4'] = '<jdoc:include type="modules" name="user4" style="xtc" />';
$gutter = 14;
$order = 'user1,user2,user3,user4';
$customWidths = array();
$columnClass = '';
$columnPadding = 0;
$grid1 = xtcGrid($centerWidth, $gutter, $order, $columnArray, $customWidths, $columnClass, $columnPadding, 0);

$columnArray = array();
$columnArray['user5'] = '<jdoc:include type="modules" name="user5" style="xtc" />';
$columnArray['user6'] = '<jdoc:include type="modules" name="user6" style="xtc" />';
$gutter = 14;
$order = 'user5,user6';
$grid2 = xtcGrid($centerWidth, $gutter, $order, $columnArray, $customWidths, $columnClass, $columnPadding, 0);
if ($left || $newsflash || $grid1 || $grid2 || $right || xtcCanShowComponent()) {
    echo '<div id="region4wrap" class="clearfix">';
    echo '<div id="region4wrappad">';
    echo '<div id="region4" class="xtc-wrapper clearfix">';
    if ($left) {
        echo '<div id="left" style="float:left;width:' . $gridParams->leftwidth . 'px;margin-right:' . $gridParams->columnseparatorwidth . 'px;"><jdoc:include type="modules" name="left" style="xtc" /></div>';
    }

    echo '<div id="center" style="float:left; width:' . $centerWidth . 'px;">';
    if ($newsflash) {
        echo '<div class="newsflash"><jdoc:include type="modules" name="newsflash" /></div>';
    }

    $messages = JFactory::getApplication()->getMessageQueue();
        if ($messages) {
        echo '<div id="xtcmessage"><div id="xtcmessagepad" class="xtc-wrapper clearfix"><jdoc:include type="message" /></div></div>';
    }

    if (xtcCanShowComponent()) {
        echo '<div id="maincontent"><div id="maincontent-inner" class="clearfix"><div class="component"><jdoc:include type="component" /></div></div></div>';
    }
    if ($grid1) {
        echo '<div id="userMods1-4" class="clearfix">' . $grid1 . '</div>';
    }
    if ($grid2) {
        echo '<div id="userMods5-6" class="clearfix">' . $grid2 . '</div>';
    }
    echo '</div>';
    if ($right) {
        echo '<div id="right" style="float:left;width:' . $gridParams->rightwidth . 'px;margin-left:' . $gridParams->columnseparatorwidth . 'px;"><jdoc:include type="modules" name="right" style="xtc" /></div>';
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>

