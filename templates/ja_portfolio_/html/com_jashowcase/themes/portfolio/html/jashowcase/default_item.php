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
<div class="ja-showcase module clearfix">	
	<div class="jasc-item-header">
		<div class="jasc-tools-wrap clearfix">
			<h3 class="<?php echo $this->item->params->get('suffix_class');?>"><span><?php echo $this->item->name; ?></span></h3>
			<?php if($this->item->ishot):?>
				<span class="badge">&nbsp;</span>   
			<?php endif;?>
		</div>
		
		<!-- check for show description -->
		<?php if($this->paramsSetting->get('general_show_description') && $this->item->description!='') :?>
		
	  	<div class="jasc-item-desc"><?php echo htmlentities($this->item->description);?></div>
		<?php endif;?>
	
	</div>
		
	<div class='ja-showcase-thumb'>
		<?php  echo $this->item->imageThumb;?>
	</div>
	<div class="jasc-item-rating clearfix">
		<strong><?php echo JText::_("Rating");?>:</strong>
		<div class="jasc-item-rating-list">
			<div class="jasc-current-rating" style="width: <?php 				
				if( isset($this->item->rating)) {					
					echo number_format(intval($this->item->rating[1])/intval($this->item->rating[2]), 2)*20;
				} else echo "0"; ?>%;">&nbsp;</div>
		</div>
	</div>
	
	<div class="jasc-tools clearfix"> 		
	  	<?php if ($this->paramsSetting->get('general_show_more_info') && $this->item->info_url ) :?>
			<span class="jasc-more-info">
				<a href="<?php echo $this->item->info_url; ?>" title="<?php echo JText::_('MORE INFO');?>" target="_<?php echo $this->paramsSetting->get('general_show_more_info-1-general_open_more');?>" class="more_info">
					<?php echo JText::_('MORE INFO');?>
				</a>
			</span>
		<?php endif;?>
		
		<?php if($this->paramsSetting->get('general_show_live_demo') && $this->item->demo_url) :?>					
			<span class="jasc-demo">
				<a href="<?php echo $this->item->demo_url;?>" title="<?php echo JText::_('LIVE DEMO');?>" target="_<?php echo $this->paramsSetting->get('general_show_live_demo-1-general_open_live');?>" class="live_demo">
					<?php echo JText::_('LIVE DEMO');?>
				</a>
			</span>
	  <?php endif; ?>
	  
	  
	  <?php if($this->paramsSetting->get('general_allow_add_favorites')) :?>	
	  <span id="jasc-action-favorites-<?php echo $this->item->id;?>" class="jasc-action-favorites">
			<?php 
			 $styleAdd    = '';
			 $styleRemove = '';
			 if(isset($this->jascFavoritesTemplate) && in_array($this->item->id, $this->jascFavoritesTemplate)):
				$styleAdd       = 'style="display:none;"';				
			 else:
			    $styleRemove    = 'style="display:none;"';
			 endif;			 	
			?>		
			<a href="javascript:void(0)" <?php echo $styleRemove;?> class="jasc-favorites-active" onclick="saveToFavorites('remove',<?php echo $this->item->id;?>);return false;" title="<?php echo JText::_("Remove from my favorites");?>"><?php echo JText::_("Remove from my favorites");?></a>
			<a href="javascript:void(0)" <?php echo $styleAdd;?> class="jasc-favorites-unactive" onclick="saveToFavorites('save',<?php echo $this->item->id;?>);return false;" title="<?php echo JText::_("Add to favorites");?>"><?php echo JText::_("Add to favorites");?></a>			
  		</span> 
  		<?php endif;?>  		  	
    </div>	
</div>