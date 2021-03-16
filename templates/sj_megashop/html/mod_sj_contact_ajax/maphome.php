<?php
/**
 * @package Sj Contact Ajax
 * @version 1.0.1
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;

$tag_id = 'contact_ajax'.time().rand();

JHtml::stylesheet('modules/'.$module->module.'/assets/css/styles.css');
JHtml::stylesheet('modules/'.$module->module.'/assets/css/font-awesome.css');
if( !defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1" ){
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-1.8.2.min.js');
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-noconflict.js');
	define('SMART_JQUERY', 1);
}

JHtml::script('modules/'.$module->module.'/assets/js/bootstrap-tooltip.js');

ob_start();
?>

#<?php echo $tag_id ?> #map-canvas {
	height:<?php echo $params->get('map_height')?>px;
	width:<?php echo $params->get('map_width')?>px;
	max-width:100%;
};

<?php
$css = ob_get_contents();
ob_end_clean();
$document =  JFactory::getDocument();
$document->addStyleDeclaration($css);
?>

<?php if($params->get('maps_display') == 1) { ?>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
<script type="text/javascript">
     function showLatLgn() {
		var geocoder = new google.maps.Geocoder();
		var sLat = "<?php echo $params->get('sLat'); ?>";
		var sLong = "<?php echo $params->get('sLong'); ?>";

		var latlng = new google.maps.LatLng(sLat, sLong);

		geocoder.geocode({"latLng":latlng},function(data,status){
			if(status == google.maps.GeocoderStatus.OK){
				var add = data[1].formatted_address; //this is the full address
				var myOptions = {
				  zoom: <?php echo $params->get('map_zoom'); ?>,
				  center: latlng,
				  mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
				var marker = new google.maps.Marker({
				  map: map,
				  position: latlng
				});
				marker.setTitle('Address');
				attachSecretMessage(marker, add);
			}else {
			try {
			  alert("Address not found");
			} catch(e) {}
		  }

		})
    }

	function attachSecretMessage(marker, message) {
		var infowindow = new google.maps.InfoWindow(
			{ content: message
			});
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(marker.get('map'),marker);
		});
	}

	function showLocation(){
		var address = '<?php echo $params->get('address_text','Hanoi, Viet nam'); ?>';
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode( { "address": address }, function(results, status) {
		  // If the Geocoding was successful
		  if (status == google.maps.GeocoderStatus.OK) {
			var myOptions = {
			  zoom: <?php echo $params->get('map_zoom'); ?>,
			  center: results[0].geometry.location,
			  mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

			// Add a marker at the address.
			var marker = new google.maps.Marker({
			  map: map,
			  position: results[0].geometry.location
			});
			marker.setTitle('Address');
			attachSecretMessage(marker, address);
		  } else {
			try {
			  alert(address + " not found");
			} catch(e) {}
		  }
		});
	}

	<?php if($params->get('select_type') == 0){ ?>
		google.maps.event.addDomListener(window, 'load', showLocation);
	<?php } else { ?>
		google.maps.event.addDomListener(window, 'load', showLatLgn);
	<?php } ?>

</script>
<?php } ?>

<?php
	$uri=JURI::getInstance();
	$uri->setVar('contact_ajax', rand(100000,999999).time());
	$uri->setVar('ctajax_modid',$module->id);

 ?>

<!--[if lt IE 9]><div class="contact-ajax msie lt-ie9 maphome" id="<?php echo $tag_id; ?>" ><![endif]-->
<!--[if IE 9]><div class="contact-ajax msie maphome" id="<?php echo $tag_id; ?>" ><![endif]-->
<!--[if gt IE 9]><!--><div class="contact-ajax maphome" id="<?php echo $tag_id; ?>" ><!--<![endif]-->
	<div class="ctajax-wrap">
		<div class="ctajax-element">
			<div class="el-inner">
				<div class="el-map">
					<?php if($params->get('maps_display') == 1) { ?>
						<div id="map-canvas"></div>
					<?php } ?>
				</div>
				<div class="el-map-info">
				<?php
				$desc = trim($list->misc);
				if($desc != '' ) ?>
				<div class="el-desc">
					<?php //echo $desc; ?>
					<img src="templates/<?php echo JFactory::getApplication()->getTemplate(); ?>/images/logo_white.png" alt=""/>
				</div>
				<div class="el-info-contact">
					<?php $address = trim($list->address);
					if($address != '') {
					?>
					<div class="info-address cf">
						<span class="info-label"><span class="icon-label"><img src="templates/<?php echo JFactory::getApplication()->getTemplate(); ?>/images/icon/icon_map1.png" alt=""/></span><?php echo $address; ?></span>
					</div>
					<?php }
						$mobile = trim($list->telephone);
					if($mobile != '' ){
					?>
					<div class="info-mobie cf">
						<span class="info-label"><span class="icon-label"><img src="templates/<?php echo JFactory::getApplication()->getTemplate(); ?>/images/icon/icon_map3.png" alt=""/></span><?php echo JText::_('TEL_LABEL') ?>: <?php echo $mobile; ?></span>
					</div>
					<?php }
					$mail_to = trim($list->email_to);
					if($mail_to != '' ){
					?>
					<div class="info-mail cf">
						<a href="mailto:<?php echo $mail_to; ?>" class="info-label"><span class="icon-label"><img src="templates/<?php echo JFactory::getApplication()->getTemplate(); ?>/images/icon/icon_map2.png" alt=""/></span><?php echo JText::_('MAIL_LABEL') ?>: <?php echo $mail_to; ?></a>
					</div>
					<?php } ?>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>
