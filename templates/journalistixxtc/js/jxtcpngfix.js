
window.addEvent('domready',function(){

	$extend(window, {
		imgfixPNG: function(img) {
			if (window.ie){
				var w = img.width;
				var h = img.width;
				var imgURL = img.src;
		    var imgID = (img.id) ? "id='" + img.id + "' " : ""
		    var imgClass = (img.className) ? "class='" + img.className + "' " : ""
			  var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
			  var imgStyle = "display:inline-block;" + img.style.cssText 
			  if (img.align == "left") imgStyle = "float:left;" + imgStyle
			  if (img.align == "right") imgStyle = "float:right;" + imgStyle
			  if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
			  var strNewHTML = "<span " + imgID + imgClass + imgTitle
			    + " style=\"" + "width:" + w + "px; height:" + h + "px;" + imgStyle + ";"
			    + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
			    + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>" 
			  img.outerHTML = strNewHTML;
			}
		}
	});	

});