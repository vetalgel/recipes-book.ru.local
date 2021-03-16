<?php
/** 
 * YouTech menu template file.
 * 
 * @author The YouTech JSC
 * @package menusys
 * @filesource default.php
 * @license Copyright (c) 2011 The YouTech JSC. All Rights Reserved.
 * @tutorial http://www.smartaddons.com
 */
global $yt;
if ($this->isRoot()){
	$menucssid = $this->params->get('menustyle') . 'navigator' . $this->params->get('cssidsuffix');
	$addCssRight = $this->params->get('direction', 'ltr')=='rtl' ? "rtl" : "";
	echo '<ul id="'.$menucssid.'" class="navi'.($addCssRight=='rtl' ? ' navirtl':'').'">';
	if($this->haveChild()){
		$idx = 0;
		foreach($this->getChild() as $child){
			$child->addClass('level'.$child->get('level',1));
			++$idx;
			if ($idx==1){
				$child->addClass('first');
			} else if ($idx==$this->countChild()){
				$child->addClass('last');
			}
			if ($child->haveChild()){
				$child->addClass('havechild');
			}
			$child->getContent();
		}
	}
	echo "</ul>";
	
	// import assets
	$fancyMenu				    = $yt->getParam('fancyMenu');
	
	$document = JFactory::getDocument();
	$document->addScript($yt->templateurl().'menusys/class/common/js/jquery.easing.1.3.js');
	$document->addScript($yt->templateurl().'menusys/class/moo/assets/jquery.moomenu.js');
	if($fancyMenu) $document->addScript($yt->templateurl().'menusys/class/common/js/gooeymenu.js');
	
	$duration   = $this->params->get('moofxduration', '300');
	$transition = $this->params->get('moofx', 'linear');

	$activeSlider = intval($this->params->get('activeslider', '0')) ? 1 : 0;	
	
	
	?>
	
	<script type="text/javascript">
		jQuery(function($){
			<?php if($fancyMenu) {?>
				gooeymenu.setup({id:'<?php echo $menucssid?>', fx:'swing'})
			<?php };?>
			
            $('#moonavigator').moomenu({ 
            	'wrap':'#yt_menuwrap .container',
            	'easing': '<?php echo $transition ?>',
				'speed': '<?php echo $duration ?>'
            });
	    });
	</script>
	<?php
} else if ( $this->canAccess() ){
	$haveChild = $this->haveChild();
	$liClass = $this->haveClass() ? "class=\"{$this->getClass()}\"" : "";
?>

<li <?php echo $liClass; ?>>
	<?php echo $this->getLink(); ?>
	<?php
		if($haveChild){
			$levelClassName = 'level'.($this->get('level',1)+1);
			$subStyleWidth = $this->getSubmenuWidth();
			
			echo "<ul class=\"{$levelClassName} subnavi\" $subStyleWidth>";
			$cidx = 0;
			foreach($this->getChild() as $child){
				$child->addClass($levelClassName);
				++$cidx;
				if ($cidx==1){
					$child->addClass('first');
				} else if ($cidx==$this->countChild()){
					$child->addClass('last');
				}
				if ($child->haveChild()){
					$child->addClass('havechild');
				}
				$child->getContent();
			}
			echo "</ul>";
		}
	?>
</li>

<?php 
}
?>