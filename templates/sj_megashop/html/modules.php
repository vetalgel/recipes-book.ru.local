<?php
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2013 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/

defined('_JEXEC') or die;
/*
 * Module chrome that allows for ytmod corners by wrapping in nested div tags
 */
function modChrome_ytmod($module, &$params, &$attribs){ ?>
    <?php
	$badge = preg_match ('/badge/', $params->get('moduleclass_sfx')) ? "<span class=\"badge\"></span>\n" : "";
	$scrollreveal = $params->get('header_class');
	
	$icons = '';
	if(strpos($params->get('moduleclass_sfx'), 'fa')===false){
       $modclass_sfx = $params->get('moduleclass_sfx');
    }else{
        $modclass_sfx = explode("fa-", $params->get('moduleclass_sfx'));
        $icons = "<i class='fa fa-".trim($modclass_sfx[1])."'></i>";
        $modclass_sfx = "style-icon ".trim($modclass_sfx[0]);
    }
	?>
	
	<div class="module <?php echo $modclass_sfx ?> clearfix" <?php echo ($scrollreveal !='')?  'data-scroll-reveal="'. $scrollreveal.'"' : '' ; ?>>
	    <?php if ((bool) $module->showtitle) : ?>
		    <h3 class="modtitle"><?php echo $icons; ?><?php echo $module->title; ?><?php echo $badge; ?></h3>
	    <?php endif; ?>
	    <div class="modcontent clearfix">
			<?php echo $module->content; ?>
	    </div>
	</div>
    <?php
}

function modChrome_ytmod2($module, &$params, &$attribs){ ?>
    <div class="module<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
    <div class="module-inner">
        <?php if ((bool) $module->showtitle) : ?>
            <h3 class="title"><?php echo $module->title; ?></h3>
        <?php endif; ?>
        <div class="module-content clearfix">
        	<?php echo $module->content; ?>
        </div>
    </div>
    </div>
<?php
}

function modChrome_special($module, &$params, &$attribs){ ?>
    <?php
	$badge = preg_match ('/badge/', $params->get('moduleclass_sfx')) ? "<span class=\"badge\"></span>\n" : "";
	$icons = preg_match ('/icon/', $params->get('moduleclass_sfx'))?"<span class=\"icon\">&nbsp;</span>\n":"";
    if(strpos($params->get('moduleclass_sfx'), '@')===false){
        $moduleclass_sfx = $params->get('moduleclass_sfx');
        $ico_sfx = 'icon-pushpin';
    }else{
        $moduleclass_sfx = explode("@", $params->get('moduleclass_sfx'));
        $ico_sfx = 'fa fa-'.trim($moduleclass_sfx[1]);
        $moduleclass_sfx = trim($moduleclass_sfx[0]);
    }
    
	?>
	
	<div class="module <?php echo $moduleclass_sfx ?>">
    	<div class="module-inner1">
            <span class="btn-special" title="<?php echo $module->title;?>"><span class="<?php echo $ico_sfx ?>"></span><?php echo (isset($attribs['title']) && ($attribs['title']==1))?$module->title:''; ?></span>
            <div class="module-inner2">
                <div class="module-inner3">
                    <?php if ((bool) $module->showtitle) : ?>
                        <h3 class="modtitle" ><?php //echo $icons; ?><?php echo $module->title; ?><?php echo $badge; ?></h3>
                    <?php endif; ?>
                    <div class="modcontent clearfix">
                    <?php echo $module->content; ?>
                    </div>
                </div>
            </div>
    	</div>
	</div>
    <?php
}

?>


