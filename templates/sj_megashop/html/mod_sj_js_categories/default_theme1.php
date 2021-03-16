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

<div class="cat-wrap theme1">
    <?php $i = 0;
    foreach ($list as $key => $items) {
        $i++;
        $cat_child = $items->child_cat;?>
        <div class="content-box">
            <?php if ($options->cat_title_display == 1) { ?>
                <div class="cat-title">
                    <a style="font-weight: bold" title="<?php echo $items->name; ?>"
                       href="<?php echo $items->cat_link; ?>" <?php echo SJJSCategoriesHelper::parseTarget($options->target); ?> >
                        <?php echo SJJSCategoriesHelper::truncate($items->name, (int)$params->get('cat_title_maxcharacs', 25)); ?>
                    </a>
                </div>
            <?php } ?>
            <div class="child-cat">
                <?php if (!empty($cat_child)) {
                    foreach ($cat_child as $key1 => $item) {
                        ?>
                        <?php if ($options->cat_sub_title_display == 1) { ?>
                            <div class="child-cat-title">
                                <a href="<?php echo $item->name; ?>"
                                   title="<?php echo $item->name; ?>" <?php echo SJJSCategoriesHelper::parseTarget($options->target); ?>>
                                    <?php echo SJJSCategoriesHelper::truncate($item->name, $options->cat_sub_title_maxcharacs); ?>
                                </a>
                                <?php if ($options->cat_all_product == 1) { ?>
                                    <span class="num_items"><?php echo '(' . $item->_totalProduct . ')'; ?></span>
                                <?php } ?>
                            </div>

                        <?php
                        }
                    }
                } else {
                    echo JText::_('No sub-categories to show!');
                } ?>
            </div>
        </div> <!-- END sub_content -->
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
       

