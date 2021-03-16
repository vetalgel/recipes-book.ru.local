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
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');
if (isset($this->error)) :
    ?>
    <div class="contact-error">
        <?php echo $this->error; ?>
    </div>
<?php endif; ?>

<div style="width:98%; float:left;border-bottom:1px solid #cccccc;padding:1%; padding-bottom:15px; margin-bottom:10px;">
    <form id="contact-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate">
        <fieldset>
            <legend><?php echo JText::_('COM_CONTACT_FORM_LABEL'); ?></legend>
            <div style="float:left; clear:both; margin-bottom:5px; ">    
                <div style="float:left; width:150px;">
                    <?php echo $this->form->getLabel('contact_name'); ?>
                </div>
                <div style="float:left;">
                    <?php echo $this->form->getInput('contact_name'); ?>
                </div>
            </div>
            <div style="float:left; clear:both; margin-bottom:5px; ">    
                <div style="float:left; width:150px;">
                    <?php echo $this->form->getLabel('contact_email'); ?>
                </div>
                <div style="float:left;">
                    <?php echo $this->form->getInput('contact_email'); ?>
                </div>
            </div>
            <div style="float:left; clear:both; margin-bottom:5px; ">    
                <div style="float:left; width:150px;">
                    <?php echo $this->form->getLabel('contact_subject'); ?>
                </div>
                <div style="float:left;">
                    <input type="text" size="30" class="required" value="" id="jform_contact_emailmsg" name="jform[contact_subject]" aria-required="true" required="required" />
                </div>
            </div>
            <div style="float:left; clear:both; margin-bottom:5px; ">    
                <div style="float:left; width:150px;">
                    <?php echo $this->form->getLabel('contact_message'); ?>
                </div>
                <div style="float:left;">
                    <?php echo $this->form->getInput('contact_message'); ?>
                </div>
            </div>
                <?php if ($this->params->get('show_email_copy')) { ?>
                    <div style="float:left; clear:both; margin-bottom:5px; ">    
                        <div style="float:left;">
                            <?php echo $this->form->getInput('contact_email_copy'); ?>
                        </div>
                        <div style="float:left; width:150px;">
                            <?php echo $this->form->getLabel('contact_email_copy'); ?>
                        </div>
                    </div>
                <?php } ?>
                <?php //Dynamically load any additional fields from plugins. ?>
                <?php foreach ($this->form->getFieldsets() as $fieldset): ?>
                    <?php if ($fieldset->name != 'contact'): ?>
                        <?php $fields = $this->form->getFieldset($fieldset->name); ?>
                        <?php foreach ($fields as $field): ?>
                            <?php if ($field->hidden): ?>
                                <?php echo $field->input; ?>
                            <?php else: ?>
                                <div style="float:left; clear:both; margin-bottom:5px; ">    
                                    <?php echo $field->label; ?>
                                    <?php if (!$field->required && $field->type != "Spacer"): ?>
                                        <div style="float:left; width:150px;"><?php echo JText::_('COM_CONTACT_OPTIONAL'); ?></div>
                                    <?php endif; ?>
                                    <div style="float:left;"><?php echo $field->input; ?></div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif ?>
                <?php endforeach; ?>
                <div style="margin-left:150px;margin-bottom:5px; clear:both; ">
                    <button class="button validate" type="submit"><?php echo JText::_('COM_CONTACT_CONTACT_SEND'); ?></button>
                </div>
            
                <input type="hidden" name="option" value="com_contact" />
                <input type="hidden" name="task" value="contact.submit" />
                <input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
                <input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />
                <?php echo JHtml::_('form.token'); ?>
        </fieldset>
    </form>
</div>
