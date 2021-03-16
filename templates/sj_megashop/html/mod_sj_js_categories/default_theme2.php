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
<div class="cat-wrap theme2">
    <?php $i = 0;
    foreach ($list as $key => $items) {
        $i++;
        $cat_child = $items->child_cat;?>
        <div class="content-box">
            <div class="parent-cat">
                <?php
                $img = SJJSCategoriesHelper::getJSCImage($items, $params, 'imgcfgcat');
                if ($img) {
                    ?>
                    <div class="image_cat">
                        <a href="<?php echo $items->cat_link; ?>"
                           title="<?php echo $items->name; ?>" <?php echo SJJSCategoriesHelper::parseTarget($options->target); ?> >
                            <img class="categories-loadimage" title="<?php echo $items->name; ?>"
                                 alt="<?php echo $items->name; ?>"
                                 src="<?php echo SJJSCategoriesHelper::imageSrc($img, $image_config); ?>"/>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="child-cat">
                        <?php if ($options->cat_title_display == 1) { ?>
                            <div class="cat-title">
                                <a href="<?php echo $items->cat_link; ?>"
                                   title="<?php echo $items->name; ?>" <?php echo SJJSCategoriesHelper::parseTarget($options->target); ?> >
                                    <?php echo SJJSCategoriesHelper::truncate($items->name, (int)$params->get('cat_title_maxcharacs', 25)); ?>
                                </a>
                            </div>
                        <?php } ?>
                        <ul>
                <?php if (!empty($cat_child)) {
                    foreach ($cat_child as $key1 => $item) {
                        ?>
                        <?php if ($options->cat_sub_title_display == 1) { ?>
                            <li><a href="<?php echo $item->cat_link; ?>"
                                   title="<?php echo $item->name; ?>" <?php echo SJJSCategoriesHelper::parseTarget($options->target); ?>>
                                    <?php echo SJJSCategoriesHelper::truncate($item->name, $options->cat_sub_title_maxcharacs); ?>
                                    <?php if ($options->cat_all_product == 1) {
                                        echo '&nbsp;(' . $item->_totalProduct . ')';
                                    } ?>
                                </a></li>
                        <?php
                        }
                    }
                } else {
                ?>
                <li><?php echo JText::_('No sub-categories to show!'); ?> </li>
                    <?php
                    } ?>

                </ul>
            </div>
        </div>
        <?php
        $clear = 'clr1';
        if ($i % 2 == 0) $clear .= ' clr2';
        if ($i % 3 == 0) $clear .= ' clr3';
        if ($i % 4 == 0) $clear .= ' clr4';
        if ($i % 5 == 0) $clear .= ' clr5';
        if ($i % 6 == 0) $clear .= ' clr6';
        ?>
        <div class="<?php echo $clear; ?>"></div>
    <?php } ?>

</div>
