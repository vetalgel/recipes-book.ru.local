// Reset Default Cpanel
function onCPResetDefault(_cookie){
	for (i=0;i<_cookie.length;i++) { 
		if(getCookie(TMPL_NAME+'_'+_cookie[i])!=undefined){
			createCookie (TMPL_NAME+'_'+_cookie[i], '', -1);
		}
	}
	window.location.reload(true);
}

// Apply  Cpanel
function onCPApply () {
	var elems = document.getElementById('cpanel_wrapper').getElementsByTagName ('*');
	var usersetting = {};
	for (i=0;i<elems.length;i++) {
		var el = elems[i]; 
	    if (el.name && (match=el.name.match(/^ytcpanel_(.*)$/))) {
	        var name = match[1];	        
	        var value = '';
	        if (el.tagName.toLowerCase() == 'input' && (el.type.toLowerCase()=='radio' || el.type.toLowerCase()=='checkbox')) {
	        	if (el.checked) value = el.value;
	        } else {
	        	value = el.value;
	        }
			if(value.trim()){
				if (usersetting[name]) {
					if (value) usersetting[name] = value + ',' + usersetting[name];
				} else {
					usersetting[name] = value;
				}
			}
	    }
	}
	
	for (var k in usersetting) {
		name = TMPL_NAME + '_' + k; //alert(name);
		value = usersetting[k];
		createCookie(name, value, 365);
	}
	
	window.location.reload(true);
}

	



jQuery(document).ready(function($){
	$(".cp_select").each(function(){
		$(this).wrap('<div class="selectbox"/>');
		$(this).after("<span class='selecttext'></span><span class='select-arrow'></span>");
		var val = $(this).children("option:selected").text();
		$(this).next(".selecttext").text(val);
		$(this).change(function(){
		var val = $(this).children("option:selected").text();
		$(this).next(".selecttext").text(val);
		});
	}); 
	
	// Select For Layout Style
	var $typeLayout = $('.typeLayout .cp_select'), $patten = $(".body-bg .pattern") ;
	
	if($patten.length > 0){
		$patten.each(function($i){
			$(this).click(function (e) {
				if( $typeLayout.val()=='wide' ) alert ('Select For Layout Style: Boxed ') ;
			});
		});
	}
	
	/* Begin: Show hide cpanel */  
	var ua = navigator.userAgent,
    event = (ua.match(/iPad/i)) ? "touchstart" : "click";
	
	$("#cpanel_btn").bind(event, function(event) {
		event.preventDefault();
		widthC = $('#cpanel_wrapper').width()+20;
		if ($(this).hasClass("isDown") ) {
			$("#cpanel_wrapper").animate({right:"0px"}, 400);			
			$(this).removeClass("isDown");
		} else {
			$("#cpanel_wrapper").animate({right:-widthC}, 400);	
			$(this).addClass("isDown");
		}
		return false;
	});
	/* End: Show hide cpanel */
	

	
	
});

