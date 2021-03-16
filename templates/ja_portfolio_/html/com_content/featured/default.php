<?php
defined('_JEXEC') or die('Restricted access');
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space
$pageClass = $this->params->get('pageclass_sfx');
?>

<?php 

if ( $this->params->get('show_page_heading')!=0) : ?>
<h1 class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<span><span><?php echo $this->escape($this->params->get('page_heading')); ?></span></span>
</h1>
<?php endif; ?>

<div class="blog<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
    
    <?php $leadingcount=0 ; ?> 
	<?php  if (!empty($this->lead_items)) : ?>
	<div class="items-leading">
	<?php foreach ($this->lead_items as &$item) : ?>
		<div class="leading<?php echo $this->params->get('pageclass_sfx'); ?> clearfix">
			<?php $this->item =&$item;
			echo $this->loadTemplate('item'); ?>
		</div>
    <?php
		 $leadingcount++;
    ?> 		 
	<?php endforeach; ?>
	</div>
   
    <?php endif; ?>
    
    <?php
	$introcount=(count($this->intro_items));
    $counter=0;
    ?>
    <?php if (!empty($this->intro_items)) : ?>
	
	<?php 
	
	   if ($introcount) :
		
		if ($this->columns == 0) :
			$this->columns = 1;
		endif;
		$rowcount = ceil ($introcount / $this->columns);
		$ii = $leadingcount;
		for ($y = 0; $y < $rowcount ; $y++) : 
	
			
		?>
			<div class="article_row<?php echo $this->escape($this->params->get('pageclass_sfx')); ?> cols<?php echo $this->columns; ?> clearfix">
				<?php for ($z = 0; $z < $this->columns && $ii < ($introcount+$leadingcount) ; $z++, $ii++) : ?>
					<div class="article_column column<?php echo $z + 1; ?>" >
						<?php $this->item =&$this->intro_items[$ii];
						echo $this->loadTemplate('item'); ?>
					</div>
				<?php endfor; ?>
			</div>
		<?php endfor;
	   endif;
     endif;
	?>

	<?php $numlinks = $this->params->def('num_links', 4);
	if ($numlinks && $i < $this->total) : ?>
	<div class="blog_more<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<?php $this->links = array_slice($this->items, $i - $this->pagination->limitstart, $i - $this->pagination->limitstart + $numlinks);
		echo $this->loadTemplate('links'); ?>
	</div>
	<?php endif; ?>

	<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
		<div class="pagination clearfix">
			<?php if( $this->pagination->get('pages.total') > 1 ) : ?>
			<p class="counter">
				<span><?php echo $this->pagination->getPagesCounter(); ?></span>
			</p>
			<?php endif; ?>
			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<?php echo $this->pagination->getPagesLinks(); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>

</div>
