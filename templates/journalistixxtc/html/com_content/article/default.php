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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params = $this->item->params;
$canEdit = $this->item->params->get('access-edit');
$user = JFactory::getUser();
// Get {heading} tags
$headingContent = '';
if (($ini = strpos($this->item->text, "{heading}")) !== false) {
    $fin = strpos($this->item->text, "{/heading}", $ini);
    $headingContent = substr($this->item->text, $ini + 9, $fin - $ini - 9);
    $this->item->text = substr_replace($this->item->text, '', $ini, $fin - $ini + 10);
}
?>
<div class="joomla<?php echo $this->pageclass_sfx ?>">
    <div class="articles">
        <div class="headline">
            <?php if ($this->params->get('show_page_heading', 1)) : ?>
                <h1>
                    <?php echo $this->escape($this->params->get('page_heading')); ?>
                </h1>
            <?php endif; ?>

            <?php if ($this->params->get('show_create_date')) : ?>
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

            <div style="float:left">
            <?php if ($params->get('show_title')) : ?>
                    <div class="articleTitle">
                        <?php if ($params->get('link_titles') && !empty($this->item->readmore_link)) : ?>
                            <a href="<?php echo $this->item->readmore_link; ?>">
                                <?php echo $this->escape($this->item->title); ?></a>
                        <?php else : ?>
                            <?php echo $this->escape($this->item->title); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php
                $useDefList = (($params->get('show_author')) OR ($params->get('show_category')) OR ($params->get('show_parent_category'))
                        OR ($params->get('show_create_date')) OR ($params->get('show_modify_date')) OR ($params->get('show_publish_date'))
                        OR ($params->get('show_hits')));
                ?>

                <?php if ($useDefList) : ?>
                    <div class="article-info">
                    <?php endif; ?>
                    <?php if ($params->get('show_author') && !empty($this->item->author)) : ?>
                            <?php $author = $this->item->author; ?>
                            <?php $author = ($this->item->created_by_alias ? $this->item->created_by_alias : $author); ?>
                            <?php echo JText::_('Written by'); ?>
                        <?php if (!empty($this->item->contactid) && $params->get('link_author') == true): ?>
                            <?php echo JHtml::_('link', JRoute::_('index.php?option=com_contact&view=contact&id=' . $this->item->contactid), $author); ?>
                        <?php else : ?>
                            <?php echo JText::_($author); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($params->get('show_parent_category') && $this->item->parent_slug != '1:root') : ?>
                        <span class="articleInfo">
                            <?php $title = $this->escape($this->item->parent_title);
                            $url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)) . '">' . $title . '</a>'; ?>
                            <?php if ($params->get('link_parent_category') AND $this->item->parent_slug) : ?>
                                <?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
                            <?php else : ?>
                                <?php echo JText::sprintf('COM_CONTENT_PARENT', $title); ?>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($params->get('show_category')) : ?>
                        <span class="articleInfo">
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
                        <span class="articleInfo">
                            <?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $this->item->modified, JText::_('DATE_FORMAT_LC2'))); ?>
                        </span>
                    <?php endif; ?>
                  
                    <?php if ($params->get('show_hits')) : ?>
                        <span class="articleInfo">
                            <?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($useDefList) : ?>
                    </div>
                <?php endif; ?>
            </div>
            <div style="clear:both"></div>
            <div class="heading">
                <?php echo $headingContent; ?>
            </div>
        </div>

        <?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
            <div class="articletoolswrap clearfix">
                <div class="icon2">
                    <?php if (!$this->print) : ?>
                        <?php if ($params->get('show_print_icon')) : ?>
                            <div class="icon4">
                                <?php echo JHtml::_('icon.print_popup', $this->item, $params); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($params->get('show_email_icon')) : ?>
                            <div class="icon4">
                                <?php echo JHtml::_('icon.email', $this->item, $params); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($canEdit) : ?>
                            <div class="icon4">
                                <?php echo JHtml::_('icon.edit', $this->item, $params); ?>
                            </div>
                        <?php endif; ?>

                    <?php else : ?>
                        <div class="icon4">
                            <?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        <?php endif; ?>

        <div class="article_text">
            <?php
            if (!$params->get('show_intro')) :
                echo $this->item->event->afterDisplayTitle;
            endif;
            ?>
            
            <?php if (isset($this->item->toc)) : ?>
                <?php echo $this->item->toc; ?>
            <?php endif; ?>
            
            <?php echo $this->item->event->beforeDisplayContent; ?>
            <?php if ($params->get('access-view')): ?>
                <?php echo $this->item->text; ?>

                <?php //optional teaser intro text for guests ?>
            <?php elseif ($params->get('show_noauth') == true AND $user->get('guest')) : ?>
                <?php echo $this->item->introtext; ?>
                <?php //Optional link to let them register to see the whole article. ?>
                <?php
                if ($params->get('show_readmore') && $this->item->fulltext != null) :
                    $link1 = JRoute::_('index.php?option=com_users&view=login');
                    $link = new JURI($link1);
                    ?>
                    <p class="readmore">
                        <a href="<?php echo $link; ?>">
                            <?php $attribs = json_decode($this->item->attribs); ?>
                            <?php
                            if ($attribs->alternative_readmore == null) :
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
            <?php endif; ?>
            <?php echo $this->item->event->afterDisplayContent; ?>
        </div>
    </div>
</div>