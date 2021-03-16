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
  
  $cols = $this->cols;
  $div_width= round ( 100/$cols, 1 );
  $end = $this->paramsSetting->get('general_show_description-1-max_chars', '256'); 
?>
<?php	
	if( !isset($this->categories) && empty($this->categories) ){		 
		$showMessage = true;		
	}
?>

  <?php if( count($this->themes) ) : ?>
  <?php  
      $i = 1;
      foreach ($this->themes as $item) :
	    $item->description = JascHelper::trimString( $item->description, 0, $end  );
        if ($i == 1) echo "<div class=\"ja-showcase-row clearfix\">";
        if ($cols == 1) $class = 'full';
        else if ($i == 1) $class = 'left';
        else if ($i < $cols) $class = 'center';
        else $class = 'right';
		$this->assign("item", $item);
        echo "<div id=\"ja_showcase_item_".$item->id."\" class=\"ja-showcase-$class\" style=\"width: {$div_width}%\">";        
        	echo $this->loadTemplate('item');                        
        echo "</div>";
        if ($i == $cols) echo "</div>";
        $i = ($i < $cols)?$i+1:1;
      endforeach; 
      if ($i>1) echo "</div>";
   ?>
   <?php elseif( isset($showMessage) && $showMessage ): ?>
  	<div class="ja-showcase-inner"><h3><?php echo JText::_('NO RESULT FOR THIS CATEGORY'); ?></h3></div>
   <?php endif ;    $itemid = JRequest::getVar('Itemid', 0);?>