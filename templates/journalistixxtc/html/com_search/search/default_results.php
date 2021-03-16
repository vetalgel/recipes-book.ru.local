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
?>

<ol start="<?php echo $this->pagination->limitstart + $result->count . '. '; ?>">
    <?php foreach ($this->results as $result) : ?>
        <li>
            <div style="width:98%;border:1px solid #EEEEEE;-moz-border-radius: 3px;-webkit-border-radius: 3px; padding:1%; margin-bottom:10px;">
                <?php if ($result->href) : ?>
                    <a href="<?php echo JRoute::_($result->href); ?>"<?php if ($result->browsernav == 1) : ?> target="_blank"<?php endif; ?>>
                        <?php echo $this->escape($result->title); ?>
                    </a>
                <?php else: ?>
                    <?php echo $this->escape($result->title); ?>
                <?php endif; ?>
                <?php if ($result->section) : ?>
                    <p class="info">
                        (<?php echo $this->escape($result->section); ?>)
                    </p>
                <?php endif; ?>
                <p>
                    <?php echo $result->text; ?>
                </p>
                <?php if ($this->params->get('show_date')) : ?>
                    <p>
                        <?php echo $result->created; ?>
                    </p>
                <?php endif; ?>
            </div>
        </li>
    <?php endforeach; ?>
</ol>

<div class="pagination">
    <?php echo $this->pagination->getPagesLinks(); ?>
</div>
