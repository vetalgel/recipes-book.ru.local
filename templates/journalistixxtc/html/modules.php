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

defined('_JEXEC') or die;

function modChrome_xtc($module, $params, $moduleClass) {
    $content = $module->content;
    $suffix = $params->get('moduleclass_sfx', '');
    if ($module->showtitle) {
        $moduleClass = 'title-on';
    } else {
        $moduleClass = 'title-off';
    }
    ?>
    <div class="module <?php echo $moduleClass; ?> <?php echo $suffix; ?>">
        <?php if ($module->showtitle != 0) : ?>
            <?php echo '<h3>';

            $modtitle = explode("||", $module->title, 3);

            if (!empty($modtitle[0])) {
                echo '<span class="first_word">' . $modtitle[0] . '</span>';
            } else {
                echo '<span>' . $module->title . '</span>';
            }

            if (!empty($modtitle[1])) {
                echo '<span class="rest">' . $modtitle[1] . '</span>';
            }
            if (!empty($modtitle[2])) {
                echo '<br />' . $modtitle[2];
            }
            echo '</h3>'; ?>
    <?php endif; ?>
        <div class="modulecontent">
    <?php echo $content; ?>
        </div>
    </div>
<?php } ?>
	
