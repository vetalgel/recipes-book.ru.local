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
$lang = JFactory::getLanguage();
$upper_limit = $lang->getUpperLimitSearchWord();
?>
<div style="float:left; width:100%;">
    <form id="searchForm" action="<?php echo JRoute::_('index.php?option=com_search'); ?>" method="post">

        <fieldset class="word">
            <legend><?php echo JText::_('COM_SEARCH_FOR'); ?>
            </legend>
            <div>
                <label for="search-searchword">
                    <?php echo JText::_('COM_SEARCH_SEARCH_KEYWORD'); ?>
                </label>
                <input type="text" name="searchword" id="search-searchword" size="30" maxlength="<?php echo $upper_limit; ?>" value="<?php echo $this->escape($this->origkeyword); ?>" class="inputbox" />
                <button name="Search" onclick="this.form.submit()" class="button"><?php echo JText::_('COM_SEARCH_SEARCH'); ?></button>
                <input type="hidden" name="task" value="search" />
            </div>

            <div>
                <?php echo $this->lists['searchphrase']; ?>
            </div>
            <div style="float:left; width:100%; margin-top:10px;padding-right:14px; border-top:1px solid #eee;" class="filter">
                <?php echo JText::_('COM_SEARCH_ORDERING'); ?>
                <?php echo $this->lists['ordering']; ?>
            </div>
        </fieldset>

        <?php if ($this->params->get('search_areas', 1)) : ?>
            <div style="width:100%; float:left; font-weight:bold;padding-bottom:10px; border:0px; border-bottom:1px solid #eee;">
                <?php echo JText::_('COM_SEARCH_SEARCH_ONLY'); ?>
                <?php
                foreach ($this->searchareas['search'] as $val => $txt) :
                    $checked = is_array($this->searchareas['active']) && in_array($val, $this->searchareas['active']) ? 'checked="checked"' : '';
                    ?>
                    <input type="checkbox" name="areas[]" value="<?php echo $val; ?>" id="area-<?php echo $val; ?>" <?php echo $checked; ?> />
                    <label for="area-<?php echo $val; ?>">
                        <?php echo JText::_($txt); ?>
                    </label>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="searchintro<?php echo $this->params->get('pageclass_sfx'); ?>">
            <?php if (!empty($this->searchword)): ?>
                <p><?php echo JText::plural('COM_SEARCH_SEARCH_KEYWORD_N_RESULTS', $this->total); ?></p>
            <?php endif; ?>
        </div>

        <?php if ($this->total > 0) : ?>

            <div class="form-limit">
                <label for="limit">
                    <?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
                </label>
                <?php echo $this->pagination->getLimitBox(); ?>
            </div>
            <p class="counter">
                <?php echo $this->pagination->getPagesCounter(); ?>
            </p>

        <?php endif; ?>

    </form>
</div>