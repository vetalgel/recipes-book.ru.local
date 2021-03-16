<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
    <?php
    defined('_JEXEC') or die;

    JHtml::_('behavior.framework', true);

    $document = JFactory::getDocument();
    $params = $templateParameters->group->$layout; // We got $layout from the index.php
// This layout uses custom stuff, so we need to get some extra vars
    $user = JFactory::getUser();

// For the columns, we want to know the wrapper width of the layout grid in use, so we pull its group to peek at its parameters.
    $grid = $params->xtcgrid; // Because the grid is a parameter in the layout config.xml
    $gridParams = $templateParameters->group->$grid; // Parameters for the selected grid

    $headjs = $gridParams->headjs;
    $footjs = $gridParams->footjs;

// Get Xtc Menu library
    $document->addScript($xtc->templateUrl . 'js/xtcMenu.js');
    $document->addScriptDeclaration("window.addEvent('load', function(){ xtcMenu(null, 'menu', 200,100,'h', new Fx.Transition(Fx.Transitions.Quint.easeInOut), 80, true, true); });");
    $document->addScript($xtc->templateUrl . 'js/xtcMenuFade.js');

// Include the Menu files, if any
//echo xtcMenu($params->xtcmenu);
// Now with the HTML...
    ?>
    <head>
        <?php echo xtcCSS($params->xtcstyle, $params->xtcgrid, $params->xtctypo); ?>
        <jdoc:include type="head" />
        <!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo $xtc->templateUrl; ?>css/ie7.css" /><![endif]-->
        <!--[if IE 8]><link rel="stylesheet" type="text/css" href="<?php echo $xtc->templateUrl; ?>css/ie8.css" /><![endif]-->
        <?php if ($headjs) { ?>
            <script type="text/javascript">
                <?php echo $headjs; ?>
            </script>
        <?php } ?>
    </head>
    <body>
        <?php
        // Draw the regions in the specified order
        $regioncfg = $gridParams->regioncfg;
        foreach (explode(",", $regioncfg) as $region) {
            if ($region == '')
                continue;
            require 'layout_includes/region'.$region.'.php';
        }
        ?>
        <?php if ($footjs) { ?>
            <script type="text/javascript">
                <?php echo $footjs; ?>
            </script>
        <?php } ?>
    </body>
</html>