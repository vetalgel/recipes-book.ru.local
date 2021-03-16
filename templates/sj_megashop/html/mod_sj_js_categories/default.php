<?php
/**
 * @package SJ JS Categories for JoomShopping
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */
defined('_JEXEC') or die;

JHtml::stylesheet('modules/' . $module->module . '/assets/css/style.css');
$image_config = array(
    'type' => $params->get('imgcfgcat_type'),
    'width' => $params->get('imgcfgcat_width'),
    'height' => $params->get('imgcfgcat_height'),
    'quality' => 90,
    'function' => ($params->get('imgcfgcat_function') == 'none') ? null : 'resize',
    'function_mode' => ($params->get('imgcfgcat_function') == 'none') ? null : substr($params->get('imgcfgcat_function'), 7),
    'transparency' => $params->get('imgcfgcat_transparency', 1) ? true : false,
    'background' => $params->get('imgcfgcat_background')
);
ImageHelper::setDefault($params);
$uniqued = 'sj_categories_' . rand() . time();
$options = $params->toObject();
$theme = $params->get('theme', 'theme1');
$nb_column1 = ($params->get('nb-column1', 6) >= $params->get('count', 6)) ? $params->get('count', 6) : $params->get('nb-column1', 6);
$nb_column2 = ($params->get('nb-column2', 4) >= $params->get('count', 6)) ? $params->get('count', 6) : $params->get('nb-column2', 4);
$nb_column3 = ($params->get('nb-column3', 2) >= $params->get('count', 6)) ? $params->get('count', 6) : $params->get('nb-column3', 2);
$nb_column4 = ($params->get('nb-column4', 1) >= $params->get('count', 6)) ? $params->get('count', 6) : $params->get('nb-column4', 1);
$class_respl = 'preset01-' . $nb_column1 . ' preset02-' . $nb_column2 . ' preset03-' . $nb_column3 . ' preset04-' . $nb_column4;

if ($theme == 'theme4') {
    if (!defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1") {
        JHtml::script('modules/' . $module->module . '/assets/js/jquery-1.8.2.min.js');
        JHtml::script('modules/' . $module->module . '/assets/js/jquery-noconflict.js');
        define('SMART_JQUERY', 1);
    }

    JHtml::script('modules/' . $module->module . '/assets/js/jquery.imagesloaded.js');
    JHtml::script('modules/' . $module->module . '/assets/js/jquery.sj_accordion.js');

    ?>

    <script type="text/javascript">
        //<![CDATA[
        jQuery(document).ready(function ($) {
            ;
            (function (element) {
                var $element = $(element);
                $(window).load(function () {
                    $element.imagesLoaded(function () {
                    });
                });
                $element.imagesLoaded(function () {

                    $element.sj_accordion({
                        items: '.sj-categories-inner',
                        heading: '.sj-categories-heading',
                        content: '.sj-categories-content',
                        active_class: 'selected',
                        event: '<?php echo $params->get('accmouseenter','click'); ?>',
                        delay: 300,
                        duration: 500,
                        active: '1'
                    });

                    var height_content = function () {
                        $('.sj-categories-inner', $element).each(function () {
                            var $inner = $('.sj-categories-content', $(this).filter('.selected'));
                            $inner.css('height', 'auto');
                            if ($inner.length) {
                                var inner_height = $inner.height();
                                $inner.css('height', inner_height);
                            }
                        });
                    }

                    if ($.browser.msie && parseInt($.browser.version, 10) <= 8) {

                    } else {
                        $(window).resize(function () {
                            height_content();
                        });
                        $(window).load(function () {
                            height_content();
                        });
                    }
                });
            })('#<?php echo $uniqued;?>')

        });
        //]]>

    </script>
<?php } ?>

<?php if (!empty($options->pretext)) { ?>
    <p class="intro_text"><?php echo $options->pretext; ?></p>
<?php } ?>
<?php if (!empty($list)) { ?>
    <!--[if lt IE 9]>
    <div id="<?php echo $uniqued; ?>" class="sj-categories <?php echo $class_respl; ?> msie lt-ie9"><![endif]-->
    <!--[if IE 9]>
    <div id="<?php echo $uniqued; ?>" class="sj-categories <?php echo $class_respl; ?> msie"><![endif]-->
    <!--[if gt IE 9]><!-->
    <div id="<?php echo $uniqued; ?>" class="sj-categories <?php echo $class_respl; ?>"><!--<![endif]-->
        <?php include JModuleHelper::getLayoutPath($module->module, $layout . '_' . $theme); ?>
    </div>
<?php
} else {
    echo JText::_('Has no content to show!');
} ?>
<?php if (!empty($options->posttext)) { ?>
    <p class="footer_text"><?php echo $options->posttext; ?></p>
<?php } ?>
 