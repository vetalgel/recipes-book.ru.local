<?php
/*
 * ------------------------------------------------------------------------
 * JA Portfolio Template for Joomla 2.5
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
*/

defined ( '_JEXEC' ) or die ( 'Restricted access' );
?>
<form name="jascForm" method="post" id="jascForm" action="index.php?">

<div class="jashowcase-main" id="jashowcase-main">
<?php
//load template header
if($this->paramsSetting->get ( 'general_is_show_cat_filter', 0 ) || $this->paramsSetting->get ( 'general_allow_add_favorites', 0 )):
	echo $this->loadTemplate( 'filter' );
endif;
?>
<div id="jashowcase-result" style="display: none;">
	<?php echo JText::_("Added to favorites");?>
</div>
<?php if($this->paramsSetting->get("general_paging", "normal") != "normal"):?>
	<div id="jashowcase-items"><?php echo $this->loadTemplate('main_items');?></div>
<?php else:?>
	<?php for ($i = 1; $i <= ceil($this->totalPage); $i++):?>
		<?php if($i==1):?>
			<div id="jashowcase-items-<?php echo $i;?>" <?php if($this->paramsSetting->get("general_paging-normal-is_allow_display_by_page_link", 0)):?>style="display: none;"<?php else:?>class="loaded"<?php endif;?>><?php echo $this->loadTemplate('main_items');?></div>	
		<?php else:?>
			<div id="jashowcase-items-<?php echo $i;?>" style="display: none;"></div>	
		<?php endif;?>				
	<?php endfor;?>
<?php endif;?>
<?php echo $this->loadTemplate('footer');?>
</div>
</form>