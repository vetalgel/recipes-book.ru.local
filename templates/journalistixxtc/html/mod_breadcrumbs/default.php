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

<span class="breadcrumbs <?php echo $moduleclass_sfx; ?>">
    <?php
    if ($params->get('showHere', 1)) {
        echo '<span class="showHere">' . JText::_('MOD_BREADCRUMBS_HERE') . '</span>';
    }
    ?>
    <?php
    for ($i = 0; $i < $count; $i++) :

        // If not the last item in the breadcrumbs add the separator
        if ($i < $count - 1) {
            if (!empty($list[$i]->link)) {
                echo '<a href="' . $list[$i]->link . '" class="pathway">' . $list[$i]->name . '</a>';
            } else {
                echo '<span>';
                echo $list[$i]->name;
                echo '</span>';
            }
            if ($i < $count - 2) {
                echo ' ' . $separator . ' ';
            }
        } else if ($params->get('showLast', 1)) { // when $i == $count -1 and 'showLast' is true
            if ($i > 0) {
                echo ' ' . $separator . ' ';
            }
            echo '<span>';
            echo $list[$i]->name;
            echo '</span>';
        }
    endfor;
    ?>
</span>
