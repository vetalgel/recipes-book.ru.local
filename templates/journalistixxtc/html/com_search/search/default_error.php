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

<?php if($this->error): ?>
<div class="error">
			<?php echo $this->escape($this->error); ?>
</div>
<?php endif; ?>
