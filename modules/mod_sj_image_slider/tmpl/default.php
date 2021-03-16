<?php
/**
 * @package Sj Image Slider
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;

JHtml::stylesheet('modules/' . $module->module . '/assets/css/style.css');
JHtml::stylesheet('modules/' . $module->module . '/assets/css/owl.carousel.css');
if (!defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1") {
    JHtml::script('modules/' . $module->module . '/assets/js/jquery-1.8.2.min.js');
    JHtml::script('modules/' . $module->module . '/assets/js/jquery-noconflict.js');
    define('SMART_JQUERY', 1);
}
JHtml::script('modules/' . $module->module . '/assets/js/owl.carousel.js');

ImageHelper::setDefault($params);
$options = $params->toObject();
$tag_id = 'sj_image_slider' . rand() . time();

//effect
$center = $options->center == 1 ? 'true' : 'false';
$nav = $options->nav == 1 ? 'true' : 'false';
$loop = $options->loop == 1 ? 'true' : 'false';
$margin = $options->margin >= 0 ? $options->margin : 5;
$slideBy = $options->slideBy > 0 ? $options->slideBy : 1;
$autoplay = $options->autoplay == 1 ? 'true' : 'false';
$autoplayTimeout = $options->autoplayTimeout >= 0 ? $options->autoplayTimeout : 5000;
$autoplayHoverPause = $options->autoplayHoverPause == 1 ? 'true' : 'false';
$autoplaySpeed = $options->autoplaySpeed >= 0 ? $options->autoplaySpeed : 5000;
$navSpeed = $options->navSpeed >= 0 ? $options->navSpeed : 5000;
$smartSpeed = $options->smartSpeed >= 0 ? $options->smartSpeed : 5000;
$startPosition = $options->startPosition > 0 ? $options->startPosition : 1;
$mouseDrag = $options->mouseDrag == 1 ? 'true' : 'false';
$touchDrag = $options->touchDrag == 1 ? 'true' : 'false';
$pullDrag = $options->pullDrag == 1 ? 'true' : 'false';
$freeDrag = $options->freeDrag == 1 ? 'true' : 'false';

$count_item = count($list);
$nb_column1 = ($params->get('nb-column1', 6) >= $count_item) ? $count_item : $params->get('nb-column1', 6);
$nb_column2 = ($params->get('nb-column2', 4) >= $count_item) ? $count_item : $params->get('nb-column2', 4);
$nb_column3 = ($params->get('nb-column3', 2) >= $count_item) ? $count_item : $params->get('nb-column3', 2);
$nb_column4 = ($params->get('nb-column4', 1) >= $count_item) ? $count_item : $params->get('nb-column4', 1);

$jshopConfig = JSFactory::getConfig();
?>
<?php if (!empty($list)) { ?>
    <div id="<?php echo $tag_id; ?>" class="sj-slc">
        <?php if (!empty($options->pretext)) { ?>
            <div class="pre-text"><?php echo $options->pretext; ?></div>
        <?php } ?>
		<div class="slc-loading"></div>
        <!--Begin clas slc-wrap-->
        <div class="slc-wrap">
            <?php foreach ($list as $item) {
				$title = (isset($item['title']) && $item['title'] != '')?SJImageSliderHelper::truncate($item['title'],$params->get('item_title_max_characs',100)):'';
				$desc = (isset($item['desc']) && $item['desc'] != '')?SJImageSliderHelper::truncate($item['desc'],$params->get('item_des_maxlength',100)):'';
				$link = (isset($item['link']) && $item['link'] != '')?$item['link']:'#';
				$target = (isset($item['target']) && $item['target'] != '')?$item['target']:'';
                $img = SJImageSliderHelper::getJSAImage($item, $params);
                if ($img) {
                    ?>
                    <div class="item">
                        <div class="item-inner">
                            <div class="item-image">
                                <a href="<?php echo $link; ?>"
                                   title="<?php echo $title; ?>"
								   target="<?php echo $target; ?>">
                                    <img title="<?php echo $title; ?>"
                                         alt="<?php echo $title; ?>"
                                         src="<?php echo SJImageSliderHelper::imageSrc($img); ?>"/>
                                </a>
                            </div>
                            <?php if (($options->item_title_display == 1 || $options->item_desc_display == 1 || $options->item_detail_display == 1) && ( $title != '' || $desc != '' ) ) { ?>
                                <div class="item-info">

                                    <?php if ( $options->item_title_display == 1 && $title != '' ) { ?>
                                        <div class="item-title">
                                            <a href="<?php echo $link; ?>"
                                               title="<?php echo $title; ?>" target="<?php echo $target; ?>">
                                                <?php echo $title; ?>
                                            </a>
                                        </div>
                                    <?php } ?>

                                    <?php if ($params->get('item_desc_display', 1) == 1 && $desc != '') { ?>
                                        <div class="item-desc">
                                            <?php echo $desc; ?>
                                        </div>
                                    <?php } ?>

                                    <?php if ( $options->item_detail_display == 1 && ( $title != '' || $desc != '' ) ) { ?>
                                        <div class="item-detail">
                                            <a href="<?php echo $link; ?>"
                                               title="<?php echo $title ?>"
											   target="<?php echo $target; ?>">
                                                <?php echo $options->item_detail_text; ?>
                                            </a>
                                        </div>
                                    <?php } ?>

                                </div>
                            <?php } ?>
                        </div>

                    </div>
                <?php
                }
            } ?>
        </div>
        <!--End clas slc-wrap-->
        <?php if (!empty($options->posttext)) { ?>
            <div class="post-text"><?php echo $options->posttext; ?></div>
        <?php } ?>
    </div>
<?php
} else {
    echo 'Has no content to show';
} ?>

<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function ($) {
        ;
        (function (element) {
            var $element = $(element) , _time = 0;
			$(window).on('load', function () {
				if(_time) clearTimeout(_time);
				_time = setTimeout(function(){
					$('.slc-loading',$element).remove();
				},1000);
			});

            var $slc_wrap = $('.slc-wrap', $element);
			$slc_wrap.owlCarousel({
                center: <?php echo $center; ?>,
                nav: <?php echo $nav; ?>,
                loop: <?php echo $loop; ?>,
                margin: <?php echo $margin; ?>,
                navText: [ 'prev', 'next' ],
                slideBy: <?php echo $slideBy; ?>,
                autoplay: <?php echo $autoplay; ?>,
                autoplayHoverPause: <?php echo $autoplayHoverPause; ?>,
                autoplayTimeout: <?php echo $autoplayTimeout; ?>,
                autoplaySpeed: <?php echo $autoplaySpeed; ?>,
                navSpeed: <?php echo $navSpeed; ?>,
                smartSpeed: <?php echo $smartSpeed;?>,
                startPosition: <?php echo $startPosition; ?>,
                mouseDrag:<?php echo $mouseDrag; ?>,
                touchDrag:<?php echo $touchDrag; ?>,
                pullDrag:<?php echo $pullDrag; ?>,
                dots: false,
                responsive: {
                    0: {
                        items:<?php echo $nb_column4;?> },
                    480: {
                        items:<?php echo $nb_column3;?> },
                    768: {
                        items:<?php echo $nb_column2;?> },
                    1200: {
                        items:<?php echo $nb_column1;?> }
                }
            });
        })('#<?php echo $tag_id; ?>');
    });
    //]]>
</script>