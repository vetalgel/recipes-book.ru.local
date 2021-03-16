<?php
/**
 * @package SJ JS Categories for JoomShopping
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */
defined('_JEXEC') or die;
?>
<div class="cat-wrap theme4">
    <?php $i = 0;
    foreach ($list as $key => $items) {
        $i++;
        $cat_child = $items->child_cat;?>
        <div class="sj-categories-inner">
            <div class="sj-categories-heading">
                <div class="icon_left"></div>
                <?php if ($options->cat_title_display == 1) { ?>
                    <div class="cat-title">
                        <a style="font-weight: bold" title="<?php echo $items->name; ?>"
                           href="<?php echo $items->cat_link; ?>" <?php echo SJJSCategoriesHelper::parseTarget($options->target); ?> >
                            <?php echo SJJSCategoriesHelper::truncate($items->name, (int)$params->get('cat_title_maxcharacs', 25)); ?>
                        </a>
                    </div>
                <?php } ?>
                <div class="icon_right"></div>
            </div>
            <div class="sj-categories-content cf">
                <?php if (!empty($cat_child)) {
                    $k = 0;
                    foreach ($cat_child as $key1 => $item) {
                        $k++;
                        $count = count($cat_child);
                        ?>
                        <div class="sj-categories-content-inner">
                            <div class="child-cat <?php echo ($k == $count) ? 'cat-lastitem' : ''; ?>">
                                <div class="child-cat-info">
                                    <?php $img = SJJSCategoriesHelper::getJSCImage($item, $params, 'imgcfgcat');
                                    if ($img) {
                                        ?>
                                        <div class="image-cat"
                                             style="max-width:<?php echo $params->get('imgcfgcat_width'); ?>px;">
                                            <a href="<?php echo $item->cat_link; ?>"
                                               title="<?php echo $item->name; ?>" <?php echo SJJSCategoriesHelper::parseTarget($options->target); ?> >
                                                <?php echo SJJSCategoriesHelper::imageTag($img, $image_config); ?>
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <div class="child-cat-desc">
                                        <?php if ($options->cat_sub_title_display == 1) { ?>
                                            <div class="child-cat-title">
                                                <a href="<?php echo $item->cat_link; ?>"
                                                   title="<?php echo $item->name; ?>" <?php echo SJJSCategoriesHelper::parseTarget($options->target); ?> >
                                                    <?php echo SJJSCategoriesHelper::truncate($item->name, $options->cat_sub_title_maxcharacs); ?>
                                                </a>
                                            </div>
                                        <?php } ?>
                                        <?php if ($options->cat_all_product == 1) { ?>
                                            <div class="num_items" style="float:left;color: #737373;">
                                                <?php echo '(' . $item->_totalProduct . ')'; ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="sj-categories-content-inner">
                        <div class="child-cat subcat-empty">
                            <div class="child-cat-info">
                                <?php echo JText::_('No sub-categories to show!'); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>