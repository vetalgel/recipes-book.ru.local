<?php
/**
 * @package SJ JS Category Slider for JoomShopping
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */

defined('_JEXEC') or die;

JHtml::stylesheet('modules/' . $module->module . '/assets/css/slider.css');
if (!defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1") {
    JHtml::script('modules/' . $module->module . '/assets/js/jquery-1.8.2.min.js');
    JHtml::script('modules/' . $module->module . '/assets/js/jquery-noconflict.js');
    define('SMART_JQUERY', 1);
}
JHtml::script('modules/' . $module->module . '/assets/js/slider.js');

ImageHelper::setDefault($params);
$options = $params->toObject();
$uniqued = 'category_slider_' . rand() . time();

$start = $options->start;

if ($start <= 0 || $start > count($list)) {
    $start = 0;
} else {
    $start = $start - 1;
}
$jshopConfig = JSFactory::getConfig();
$image_cat_config = array(
    'type' => $params->get('imgcfgcat_type'),
    'width' => $params->get('imgcfgcat_width'),
    'height' => $params->get('imgcfgcat_height'),
    'quality' => 90,
    'function' => ($params->get('imgcfgcat_function') == 'none') ? null : 'resize',
    'function_mode' => ($params->get('imgcfgcat_function') == 'none') ? null : substr($params->get('imgcfgcat_function'), 7),
    'transparency' => $params->get('imgcfgcat_transparency', 1) ? true : false,
    'background' => $params->get('imgcfgcat_background'));

if ($params->get('show_image_cat', 1) && $params->get('show_sub_cat', 1) && !empty($list['category_tree'])) {
    $class_image_sub = 'show';
} elseif ($params->get('show_image_cat', 1) == 1 && $params->get('show_sub_cat', 1) == 0 || $params->get('show_image_cat', 1) == 1 && empty($list['category_tree'])) {
    $class_image_sub = 'show-image';
} elseif ($params->get('show_image_cat', 1) == 0 && $params->get('show_sub_cat', 1) == 1 && !empty($list['category_tree'])) {
    $class_image_sub = 'show-sub';
} else {
    $class_image_sub = '';
}

if (!empty($list)) {
    ?>
    <?php if (!empty($options->pretext)) { ?>
        <div class="pre-text"><?php echo $options->pretext; ?></div>
    <?php } ?>

    <div id="<?php echo $uniqued; ?>" class="container-slider">
        <div class="page-title"><?php echo $options->slider_title_text; ?></div>

        <div class="page-top">
            <div class="page-title-categoryslider">
                <span>
                    <?php echo SJJSCategorySliderHelper::truncate($list['category_parent']['name'], (int)$params->get('cat_title_maxcharacs', 25)); ?>
                </span>
            </div>

            <?php if ($options->button_display == 1) { ?>
                <div class="page-button">
                    <ul class="control-button preload">
                        <li class="preview">Prev</li>
                        <li class="next">Next</li>
                    </ul>
                </div>
            <?php } ?>
        </div>

        <div class="categoryslider-content <?php echo $class_image_sub; ?> <?php echo $options->deviceclass_sfx; ?> ">
            <?php $img = SJJSCategorySliderHelper::getJSCImage($list['category_parent'], $params, 'imgcfgcat');
            if ($img && $params->get('show_image_cat', 1)) {
                ?>
                <div class="item-cat-image">
                    <a href="<?php echo $list['category_parent']['cat_link']; ?>"
                       title="<?php echo $list['category_parent']['name']; ?>"
                       href="<?php echo $list['category_parent']['cat_link']; ?>" <?php echo SJJSCategorySliderHelper::parseTarget($options->item_link_target); ?> >
                        <img class="categories-loadimage"
                             title="<?php echo $list['category_parent']['name']; ?>"
                             alt="<?php echo $list['category_parent']['name']; ?>"
                             src="<?php echo SJJSCategorySliderHelper::imageSrc($img, $image_cat_config); ?>"/>
                    </a>
                </div>
            <?php } ?>

            <div class="slider not-js cols-6">
                <div class="vpo-wrap">
                    <div class="vp">
                        <div class="vpi-wrap">
                            <?php
                            if (!empty($list['product'])) {
                                foreach ($list['product'] as $item) {
                                    ?>
                                    <div class="item">
                                        <div class="item-wrap">

                                            <div class="item-img item-height">
                                                <?php   $img = SJJSCategorySliderHelper::getJSAImage($item, $params, 'imgcfg');
                                                if ($img) {
                                                    ?>
                                                    <div class="item-img-info">
                                                        <a href="<?php echo $item->product_link; ?>"
                                                            <?php echo SJJSCategorySliderHelper::parseTarget($options->item_link_target); ?> >
                                                            <img title="<?php echo $item->name; ?>"
                                                                 alt="<?php echo $item->name; ?>"
                                                                 src="<?php echo SJJSCategorySliderHelper::imageSrc($img); ?>"/>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>

                                            <div class="item-info">
                                                <div class="item-inner">

                                                    <?php if ($options->item_title_display == 1) { ?>
                                                        <div class="item-title">
                                                            <a href="<?php echo $item->product_link; ?>"
                                                               title="<?php echo $item->name; ?>"  <?php echo SJJSCategorySliderHelper::parseTarget($options->item_link_target); ?>>
                                                                <?php echo SJJSCategorySliderHelper::truncate($item->name, $options->item_title_max_characs); ?>
                                                            </a>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if ($params->get('item_votes_display', 1)) { ?>
                                                        <div class="item-review">
                                                            <?php print showMarkStar($item->average_rating); ?>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if ($params->get('item_price_display') == 1) { ?>
                                                        <div class="item-prices">

                                                            <?php if ($item->_display_price) { ?>
                                                                <div class="jshop_price">

                                                                    <?php if ($item->product_old_price > 0) { ?>
                                                                        <?php if ($jshopConfig->product_list_show_price_description) print _JSHOP_OLD_PRICE . ": "; ?>
                                                                        <span
                                                                            class="old-price"><?php print formatprice($item->product_old_price) . '&nbsp&nbsp'; ?></span>
                                                                    <?php } ?>
                                                                    <?php print $item->_tmp_var_bottom_old_price; ?>

                                                                    <?php if ($jshopConfig->product_list_show_price_description) print _JSHOP_PRICE . ": "; ?>
                                                                    <?php if ($item->show_price_from) print _JSHOP_FROM . " "; ?>
                                                                    <span><?php print formatprice($item->product_price); ?></span>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if ($params->get('item_buy_display') && !$item->hide_buy) { ?>
                                                        <div class="item-add-to-cart">
                                                            <a href="<?php echo $item->_buy_link; ?>">
                                                                <?php echo JText::_('ADD_TO_CART'); ?>
                                                            </a>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if ($params->get('item_desc_display', 1) == 1 && $item->description != '') { ?>
                                                        <div class="item-introtext">
                                                            <?php echo SJJSCategorySliderHelper::truncate($item->description, $params->get('item_des_maxlength', 200)); ?>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if ($options->item_detail_display == 1) { ?>
                                                        <div class="item-detail">
                                                            <a href="<?php echo $item->product_link; ?>"
                                                               title="<?php echo $item->name ?>"
                                                                <?php echo SJJSCategorySliderHelper::parseTarget($options->item_link_target); ?>>
                                                                <?php echo $options->item_detail_text; ?>
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($params->get('show_sub_cat', 1) && !empty($list['category_tree'])) { ?>
                <div class="item-sub-cat">
                    <ul>
                        <?php foreach ($list['category_tree'] as $cat_tree) { ?>
                            <li>
                                <a href="<?php echo $cat_tree->cat_link; ?>"
                                   title="<?php echo $cat_tree->name; ?>" <?php echo SJJSCategorySliderHelper::parseTarget($params->get('target')); ?>>
                                    <?php echo SJJSCategorySliderHelper::truncate($cat_tree->name, $params->get('category_title_max_characs', 25)); ?>
                                    <span><?php echo '(' . $cat_tree->_totalProduct . ')'; ?></span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <div class="icon-cate">
                <a title="<?php echo $list['category_parent']['name']; ?>"
                   href="<?php echo $list['category_parent']['cat_link']; ?>">
                    <?php echo 'text'; ?>
                </a>
            </div>
        </div>
    </div>


    <?php if (!empty($options->posttext)) { ?>
        <div class="post-text"><?php echo $options->posttext; ?></div>
    <?php } ?>
<?php
} else {
    echo JText::_('Has no content to show!');
} ?>
<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function ($) {
        ;
        (function (element) {
            var $element = $(element);
            $('.slider', $element).responsiver({
                interval: <?php echo (($options->play)?$options->delay:0);?>,
                speed: <?php echo $options->duration;?>,
                start: <?php echo $start;?>,
                step: <?php echo $options->scroll;?>,
                circular: true,
                preload: true,
                fx: '<?php echo $options->effect; ?>',
                pause: '<?php echo $options->pausehover ;?>',
                control: {
                    prev: '#<?php echo $uniqued;?> .control-button li[class="preview"]',
                    next: '#<?php echo $uniqued;?> .control-button li[class="next"]'
                },
                getColumns: function (el) {
                    var match = $(el).attr('class').match(/cols-(\d+)/);
                    if (match[1]) {
                        var column = parseInt(match[1]);
                    } else {
                        column = 1;
                    }
                    if (!column) column = 1;
                    return column;
                }
            });
            $('.control-button', $element).removeClass('preload');

        })('#<?php echo $uniqued ; ?>')
    });
    //]]>
</script>


