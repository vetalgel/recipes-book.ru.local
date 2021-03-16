<?php
/**
 * @package Sj Slider for JoomShopping
 * @version 1.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;

ImageHelper::setDefault($params);
$options = $params->toObject();
$uniqued ='container_slider_'.rand().time();

if(!empty($list)){?>
	<?php if(!empty($options->pretext)) { ?>
		<div class="pre-text"><?php echo $options->pretext; ?></div>
	<?php } ?>
	<div id="<?php echo $uniqued; ?>" class="container-slider" style="<?php if( $options->anchor == "bottom" ){ echo "margin-bottom:40px;"; }?>">
			<div class="page-title"><?php echo $options->slider_title_text;?></div>
			<?php if($options->anchor =="top"){?>
			<?php if($options->button_display == 1){?>
			<div class="page-button <?php echo $options->anchor;?> <?php echo $options->control;?>">
				<ul class="control-button">
					<li class="preview">Prev</li>
					<li class="next">Next</li>
				</ul>
			</div>
			<?php }}?>

		<div class="slider not-js cols-6 <?php echo $options->deviceclass_sfx; ?>">
			<div class="vpo-wrap">
				<div class="vp">
					<div class="vpi-wrap">
					<?php foreach($list as $item){?>
						<div class="item">
							<div class="item-wrap">

								<?php if ($item->label_id){?>
                <div class="product_label">
                    <?php if ($item->_label_image){?>
                        <img src="<?php print $item->_label_image?>" alt="<?php print htmlspecialchars($item->_label_name)?>" />
                    <?php }else{?>
                        <span class="label_name"><?php print $item->_label_name;?></span>
                    <?php }?>
                </div>
            <?php }?>

	    <div class="item-img item-height">
									<div class="item-img-info">
										<a href="<?php echo $item->link;?>" <?php echo JsSlider::parseTarget($params->get('target'));?>>
											<?php $img = JsSlider::getAImage($item, $params);
	    										echo JsSlider::imageTag($img);?>
										</a>
									</div>

									<div class="hover-links clearfix">
			<?php print $item->_tmp_var_top_buttons;?>
			<div class="buttons">
			    <?php if ($item->buy_link){?>
			    <a class="button_buy" href="<?php print $item->link?>"><i class="icon_cart"></i><?php print _JSHOP_ADD_TO_CART?></a>
			    <?php }?>
			    <a class="button_detail" href="<?php print $item->link?>"><i class="icon_cart"></i><?php print _JSHOP_DETAIL?></a>
			    <?php print $item->_tmp_var_buttons;?>
			</div>
		</div>
								</div>

								<div class="item-info <?php if( $options->theme == "theme2" ){ echo "item-spotlight"; }?> ">
									<div class="item-inner">
									<?php if( $options->show_title == 1 ){?>
										<div class="item-title">
											<a href="<?php echo $item->link;?>" <?php echo JsSlider::parseTarget($params->get('target'));?>>
												<?php echo $item->title;?>
											</a>
										</div>
									<?php }?>
										<div class="item-content">
										<?php if( $options->show_desc == 1 ){?>
											<div class="item-des">
												<?php echo $item->short_description;?>
											</div>
										<?php }?>
										<?php if( $params->get('show_review') ){?>
								        	<table class="review_mark"><tr><td><?php echo showMarkStar($item->average_rating);?></td></tr></table>
								        <?php }
										if( $item->_display_price && (int)$params->get('show_price', 1) ){ ?>
											<div class="item-price">
								                <?php if ($item->_display_price) { ?>
                                                                    <?php if ($item->product_old_price > 0) { ?>
                                                                        <?php if ($jshopConfig->product_list_show_price_description) print _JSHOP_OLD_PRICE . ": "; ?>
                                                                        <span class="old-price"><?php print formatprice($item->product_old_price) . '&nbsp;&nbsp;'; ?></span>
                                                                    <?php } ?>
                                                                    <?php print $item->_tmp_var_bottom_old_price; ?>

                                                                    <?php if ($jshopConfig->product_list_show_price_description) print _JSHOP_PRICE . ": "; ?>
                                                                    <?php if ($item->show_price_from) print _JSHOP_FROM . " "; ?>
                                                                    <span class="product-price"><?php print formatprice($item->product_price); ?></span>
                                                            <?php } ?>
											</div>
										<?php }?>
										<?php if( $options->show_read_more == 1 ){?>
											<div class="item-read">
												<a href="<?php echo $item->link;?>" <?php echo JsSlider::parseTarget($params->get('target'));?>>
													<?php echo $options->read_more_text; ?>
												</a>
											</div>
										<?php }?>
										</div>
										<?php if( $options->theme == "theme2" ){
											if( $options->show_title == 1 || $options->show_desc == 1 || $options->show_read_more == 1 || $options->show_price == 1 || $options->show_review == 1 ){?>
											<div class="item-bg"></div>
										<?php }}?>
									</div>
								</div>

							</div>
						</div>
					<?php }?>
					</div>
				</div>
			</div>
		</div>

		<?php if($options->anchor !="top"){?>
			<?php if($options->button_display == 1){?>
			<div class="page-button <?php echo $options->anchor;?> <?php echo $options->control;?>">
				<ul class="control-button">
					<li class="preview">Prev</li>
					<li class="next">Next</li>
				</ul>
			</div>
		<?php }}?>

	</div>
	<?php if(!empty($options->posttext)) {  ?>
		<div class="post-text"><?php echo $options->posttext; ?></div>
	<?php } ?>
<?php }else {echo JText::_('Has no content to show!');}?>

<script type="text/javascript">
//<![CDATA[
    jQuery(document).ready(function($){
        $('#<?php echo $uniqued;?> .slider').responsiver({
            interval: <?php echo $options->delay;?>,
            speed: <?php echo $options->duration;?>,
            start: <?php echo $options->start -1;?>,
            step: <?php echo $options->scroll;?>,
            circular: true,
            preload: true,
			fx: 'slide',
            pause: 'hover',
            control:{
				prev: '#<?php echo $uniqued;?> .control-button li[class="preview"]',
				next: '#<?php echo $uniqued;?> .control-button li[class="next"]'
            },
			getColumns: function(element){
				var match = $(element).attr('class').match(/cols-(\d+)/);
				if (match[1]){
					var column = parseInt(match[1]);
				} else {
					var column = 1;
				}
				if (!column) column = 1;
				return column;
			}
        });
    });
//]]>
</script>
