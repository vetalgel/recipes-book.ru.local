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

/* marker_class: Class based on the selection of text, none, or icons
 * jicon-text, jicon-none, jicon-icon
 */
?>

<?php if ($this->contact->misc && $this->contact->params->get('show_misc')) : ?>
    <div style="width:98%; float:left;border-bottom:1px solid #cccccc; padding:1%; padding-bottom:15px; margin-bottom:10px;">
        <div style="float:left;margin-right:10px;">
            <?php echo $this->contact->params->get('marker_misc'); ?>
        </div>
        <div style="float:left;">
            <?php echo nl2br($this->contact->misc); ?>
        </div>
    </div>
<?php endif; ?>

<?php if (($this->params->get('address_check') > 0) && ($this->contact->address || $this->contact->suburb || $this->contact->state || $this->contact->country || $this->contact->postcode)) : ?>
    <div style="width:98%; float:left;border-bottom:1px solid #cccccc; padding:1%; padding-bottom:15px; margin-bottom:10px;">
        <?php if ($this->params->get('address_check') > 0) : ?>
            <div class="<?php echo $this->params->get('marker_class'); ?>" >
                <?php echo $this->params->get('marker_address'); ?>
            </div>
            
            <?php endif; ?>
            <?php if ($this->contact->address && $this->params->get('show_street_address')) : ?>
                <div>
                    <?php echo nl2br($this->contact->address); ?>
                </div>
            <?php endif; ?>
            <?php if ($this->contact->suburb && $this->params->get('show_suburb')) : ?>
                <div>
                    <?php echo $this->contact->suburb; ?>
                </div>
            <?php endif; ?>
            <?php if ($this->contact->state && $this->params->get('show_state')) : ?>
                <div>
                    <?php echo $this->contact->state; ?>
                </div>
            <?php endif; ?>
            <?php if ($this->contact->postcode && $this->params->get('show_postcode')) : ?>
                <div>
                    <?php echo $this->contact->postcode; ?>
                </div>
            <?php endif; ?>
            <?php if ($this->contact->country && $this->params->get('show_country')) : ?>
                <div>
                    <?php echo $this->contact->country; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($this->params->get('address_check') > 0) : ?>
        
    </div>
<?php endif; ?>

<?php if ($this->params->get('show_email') || $this->params->get('show_telephone') || $this->params->get('show_fax') || $this->params->get('show_mobile') || $this->params->get('show_webpage')) : ?>
    <div class="contact-contactinfo">
    <?php endif; ?>
    <?php if ($this->contact->email_to && $this->params->get('show_email')) : ?>
        <div style="width:98%; float:left;border-bottom:1px solid #cccccc; padding:1%; padding-bottom:15px; margin-bottom:10px;">
            <div class="<?php echo $this->params->get('marker_class'); ?>">
                <?php echo $this->params->get('marker_email'); ?>
            </div>
            <div style="float:left;">
                <?php echo $this->contact->email_to; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($this->contact->telephone && $this->params->get('show_telephone')) : ?>
        <div style="width:98%; float:left;border-bottom:1px solid #cccccc; padding:1%; padding-bottom:15px; margin-bottom:10px;">
            <div class="<?php echo $this->params->get('marker_class'); ?>">
                <?php echo $this->params->get('marker_telephone'); ?>
            </div>
            <div style="float:left;">
                <?php echo nl2br($this->contact->telephone); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->contact->fax && $this->params->get('show_fax')) : ?>
        <div style="width:98%; float:left;border-bottom:1px solid #cccccc; padding:1%; padding-bottom:15px; margin-bottom:10px;">
            <div class="<?php echo $this->params->get('marker_class'); ?>">
                <?php echo $this->params->get('marker_fax'); ?>
            </div>
            <div style="float:left;">
                <?php echo nl2br($this->contact->fax); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->contact->mobile && $this->params->get('show_mobile')) : ?>
        <div style="width:98%; float:left;border-bottom:1px solid #cccccc; padding:1%; padding-bottom:15px; margin-bottom:10px;">
            <div class="<?php echo $this->params->get('marker_class'); ?>">
                <?php echo $this->params->get('marker_mobile'); ?>
            </div>
            <div style="float:left;">
                <?php echo nl2br($this->contact->mobile); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->contact->webpage && $this->params->get('show_webpage')) : ?>
        <div style="width:98%; float:left;border-bottom:1px solid #cccccc; padding:1%; padding-bottom:15px; margin-bottom:10px;">
            <div class="<?php echo $this->params->get('marker_class'); ?>" >
            </div>
            <div style="float:left;">
                <a href="<?php echo $this->contact->webpage; ?>" target="_blank">
                    <?php echo $this->contact->webpage; ?></a>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->params->get('show_email') || $this->params->get('show_telephone') || $this->params->get('show_fax') || $this->params->get('show_mobile') || $this->params->get('show_webpage')) : ?>
    </div>
<?php endif; ?>
