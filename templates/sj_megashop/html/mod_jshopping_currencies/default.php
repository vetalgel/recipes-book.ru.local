<div class="mod-jcurrency">
    <?php
        print $currencies_display_list;
    ?>
</div>
<?php
$templateDir = JURI::base() . 'templates/' . $app->getTemplate();
JHtml::stylesheet($templateDir.'/css/bootstrap-select.min.css');
?>
<script type="text/javascript" src="<?php echo $templateDir.'/js/bootstrap-select.js' ?>"></script>

<script type="text/javascript">
	jQuery(document).ready(function($) {
            $('#id_currency').selectpicker();
	});
</script>