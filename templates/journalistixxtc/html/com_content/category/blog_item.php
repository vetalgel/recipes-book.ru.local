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

// Create a shortcut for params.
$params = &$this->item->params;
$canEdit = $this->item->params->get('access-edit');
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
?>

<div class="item <?php if ($this->item->state == 0)
    echo "unpublished"; ?>">

    <?php if ($this->item->params->get('show_create_date')) : ?>
        <?php
        // echo $row->date;
        $month = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
        list($date, $time) = explode(' ', $this->item->created);
        list($yy, $mm, $dd) = explode('-', $date);
        ?>
        <div class="articlebadgeWrap">
            <acronym class="published" title="<?php echo ''; ?>">
                <span class="articlebadgeDay"><?php echo $dd; ?></span>
                <span class="articlebadgeMonth"><?php echo $month[$mm]; ?></span>
            </acronym>   
        </div>
    <?php endif; ?>
    <?php if ($params->get('show_title')) : ?>
        <div class="blogArticleTitle" >
            <?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
                <a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>">
                    <?php echo $this->escape($this->item->title); ?></a>
            <?php else : ?>
                <?php echo $this->escape($this->item->title); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div style="clear:both"></div>

    <div class="blogItem-bg">
        <div class="article_info_container">
            <div class="article_text">
                <?php if (!$params->get('show_intro')) : ?>
                    <?php echo $this->item->event->afterDisplayTitle; ?>
                <?php endif; ?>

                <?php echo $this->item->introtext; ?>
            </div>

            <?php echo $this->item->event->beforeDisplayContent; ?>
            <?php // to do not that elegant would be nice to group the params ?>

            <?php if (($params->get('show_author')) or ($params->get('show_category')) or ($params->get('show_create_date')) or ($params->get('show_modify_date')) or ($params->get('show_publish_date')) or ($params->get('show_parent_category')) or ($params->get('show_hits'))) : ?>
                <div class="blogArticleInfo">
                <?php endif; ?>
                <?php if ($params->get('show_author') && !empty($this->item->author)) : ?>
                    <span class="blogInfo">
                        <?php $author = $this->item->author; ?>
                        <?php $author = ($this->item->created_by_alias ? $this->item->created_by_alias : $author); ?>
                        <?php echo JText::_('Written by'); ?>
                    </span>
                    <?php if (!empty($this->item->contactid) && $params->get('link_author') == true): ?>
                        <?php echo JHtml::_('link', JRoute::_('index.php?option=com_contact&view=contact&id=' . $this->item->contactid), $author); ?>
                    <?php else : ?>
                        <?php echo JText::_($author); ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($params->get('show_parent_category') && $this->item->parent_id != 1) : ?>
                    <span class="blogInfo">
                        <?php $title = $this->escape($this->item->parent_title);
                        $url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_id)) . '">' . $title . '</a>'; ?>
                        <?php echo JText::_('COM_CONTENT_PARENT'); ?>
                    </span>
                    <?php if ($params->get('link_parent_category')) : ?>
                        <?php echo JText::_($url); ?>
                    <?php else : ?>
                        <?php echo JText::_($title); ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($params->get('show_category')) : ?>
                    <span class="blogInfo">
                        <?php $title = $this->escape($this->item->category_title);
                        $url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)) . '">' . $title . '</a>'; ?>
                    <?php echo JText::_('Published in'); ?>
                    </span>
                        <?php if ($params->get('link_category')) : ?>
                            <?php echo JText::_($url); ?>
                        <?php else : ?>
                            <?php echo JText::_($title); ?>
                        <?php endif; ?>
                <?php endif; ?>
                <?php if ($params->get('show_modify_date')) : ?>
                    <span class="blogInfo">
                        <?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $this->item->modified, JText::_('DATE_FORMAT_LC2'))); ?>
                    </span>
                <?php endif; ?>
                
                <?php if ($params->get('show_hits')) : ?>
                    <span class="blogInfo">
                        <?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?>
                    </span>
                <?php endif; ?>
                <?php if (($params->get('show_author')) or ($params->get('show_category')) or ($params->get('show_create_date')) or ($params->get('show_modify_date')) or ($params->get('show_publish_date')) or ($params->get('show_parent_category')) or ($params->get('show_hits'))) : ?>
                </div>
            <?php endif; ?>  
            <?php if ($params->get('show_print_icon') || $params->get('show_email_icon') || $canEdit) : ?>
                <div class="blogIcons">
                    <?php if ($params->get('show_print_icon')) : ?>
                        <div class="icon3">
                            <?php echo JHtml::_('icon.print_popup', $this->item, $params); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($params->get('show_email_icon')) : ?>
                        <div class="icon3">
                            <?php echo JHtml::_('icon.email', $this->item, $params); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($canEdit) : ?>
                        <div class="icon3">
                            <?php echo JHtml::_('icon.edit', $this->item, $params); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php
            if ($params->get('show_readmore') && $this->item->readmore) :
                if ($params->get('access-view')) :
                    $link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
                else :
                    $menu = JFactory::getApplication()->getMenu();
                    $active = $menu->getActive();
                    $itemId = $active->id;
                    $link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
                    $returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
                    $link = new JURI($link1);
                    $link->setVar('return', base64_encode($returnURL));
                endif;
                ?>
                <p class="readmore">
                    <a href="<?php echo $link; ?>">
                        <?php
                        if (!$params->get('access-view')) :
                            echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
                        elseif ($readmore = $this->item->alternative_readmore) :
                            echo $readmore;
                            if ($params->get('show_readmore_title', 0) != 0) :
                                echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
                            endif;
                        elseif ($params->get('show_readmore_title', 0) == 0) :
                            echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
                        else :
                            echo JText::_('COM_CONTENT_READ_MORE');
                            echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
                        endif;
                        ?></a>
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="item-separator"></div>
<?php echo $this->item->event->afterDisplayContent; ?>
