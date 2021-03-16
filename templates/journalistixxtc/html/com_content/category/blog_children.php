<?php
/*
  JoomlaXTC XTC Template Overrides

  Copyright (C) 2011  Monev Software LLC.	All Rights Reserved.

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  THIS LICENSE MIGHT NOT APPLY TO OTHER FILES CONTAINED IN THE SAME PACKAGE.

  Monev Software LLC
  www.joomlaxtc.com
 */
// no direct access
defined('_JEXEC') or die;
$class = ' class="first"';
?>

<?php if (count($this->children[$this->category->id]) > 0 && $this->maxLevel != 0) : ?>
    <ul>
        <?php foreach ($this->children[$this->category->id] as $id => $child) : ?>
            <?php
            if ($this->params->get('show_empty_categories') || $child->numitems || count($child->getChildren())) :
                if (!isset($this->children[$this->category->id][$id + 1])) :
                    $class = ' class="last"';
                endif;
                ?>
                <li<?php echo $class; ?>>
                    <?php $class = ''; ?>
                    <span class="item-title"><a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($child->id)); ?>">
                            <?php echo $this->escape($child->title); ?></a>
                    </span>
                    <?php if ($this->params->get('show_cat_num_articles', 1)) : ?>
                        <span class="number">
                            ( <?php if ($child->getNumItems(true) == 1) {
                                echo $child->getNumItems(true) ." ". JText::_( 'item' );}
                                else {
                                echo $child->getNumItems(true) ." ". JText::_( 'items' );} ?> )
                        </span>
                    <?php endif; ?>

                    <?php if ($this->params->get('show_subcat_desc') == 1) : ?>
                        <?php if ($child->description) : ?>
                            <br />
                                <?php echo JHtml::_('content.prepare', $child->description); ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php
                    if (count($child->getChildren()) > 0):
                        $this->children[$child->id] = $child->getChildren();
                        $this->category = $child;
                        $this->maxLevel--;
                        if ($this->maxLevel != 0) :
                            echo $this->loadTemplate('children');
                        endif;
                        $this->category = $child->getParent();
                        $this->maxLevel++;
                    endif;
                    ?>
                </li>
            <?php endif; ?>
    <?php endforeach; ?>
    </ul>
    <?php
 endif;