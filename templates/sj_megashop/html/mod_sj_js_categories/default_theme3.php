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
<div class="cat-wrap theme3">
    <?php $j = 0;
    foreach ($list as $key => $items) {
        $j++;
        $cat_child = $items->child_cat;?>
        <div class="content-box">
            <?php $img = SJJSCategoriesHelper::getJSCImage($items, $params, 'imgcfgcat');
            if ($img) {
                ?>
                <div class="image-cat">
                    <a href="<?php echo $items->cat_link; ?>"
                       title="<?php echo $items->name; ?>" <?php echo SJJSCategoriesHelper::parseTarget($options->target); ?> >
                        <img title="<?php echo $items->name; ?>"
                             alt="<?php echo $items->name; ?>"
                             src="<?php echo SJJSCategoriesHelper::imageSrc($img, $image_config); ?>"/>
                    </a>
                </div>
            <?php } ?>
            <?php if ($options->cat_title_display == 1) { ?>
                <div class="cat-title">
                    <a href="<?php echo $items->cat_link; ?>"
                       title="<?php echo $items->name; ?>" <?php echo SJJSCategoriesHelper::parseTarget($options->target); ?> >
                        <?php echo SJJSCategoriesHelper::truncate($items->name, (int)$params->get('cat_title_maxcharacs', 25)); ?>
                    </a>
                </div>
            <?php } ?>
            <div class="child-cat">
                <?php if (!empty($cat_child)) {
                    if ($options->cat_sub_title_display == 1) {
                        $i = 1;
                        foreach ($cat_child as $key1 => $item) {
                            $count = count($cat_child);?>
                            <div class="child-cat-title">
                                <a title="<?php echo $item->name; ?>"
                                   href="<?php echo $item->cat_link; ?>" <?php echo SJJSCategoriesHelper::parseTarget($options->target); ?>>
                                    <?php if ($params->get('cat_all_product') == 1) { ?>
                                        <?php echo SJJSCategoriesHelper::truncate($item->name, (int)$params->get('cat_sub_title_maxcharacs', 25)); ?>
                                        <?php echo '(' . $item->_totalProduct . ')' . ','; ?>
                                    <?php } else { ?>
                                        <?php echo SJJSCategoriesHelper::truncate($item->name, (int)$params->get('cat_sub_title_maxcharacs', 25)) . ',&nbsp'; ?>
                                    <?php } ?>
                                </a>

                            </div>
                            <?php $i++;
                        }
                    }
                } else {
                    echo JText::_('No sub-categories to show!');
                } ?>
            </div>
        </div>
        <?php
        $clear = 'clr1';
        if ($j % 2 == 0) $clear .= ' clr2';
        if ($j % 3 == 0) $clear .= ' clr3';
        if ($j % 4 == 0) $clear .= ' clr4';
        if ($j % 5 == 0) $clear .= ' clr5';
        if ($j % 6 == 0) $clear .= ' clr6';
        ?>
        <div class="<?php echo $clear; ?>"></div>
    <?php } ?>
</div>
 
 