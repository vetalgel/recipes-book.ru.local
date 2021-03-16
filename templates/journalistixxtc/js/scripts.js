/* Mootools Domready Events */
window.addEvent('domready', function(){
	/* Line Module Titles */
	$$('.border-split').each(function(h,i){
		var lineleft = h.getElement('.title-line-left');
		var lineright = h.getElement('.title-line-right');
		var text = h.getElement('.title-text');
		if( $defined(text) ) {
			if ( $defined(lineleft) && $defined(lineright) ) {
				 lineleft.setStyle('width', (h.getSize().size.x - h.getStyle('padding-left').toInt() - h.getStyle('padding-right').toInt() - text.getSize().size.x)/2 - 0 );
				 lineright.setStyle('width', (h.getSize().size.x - h.getStyle('padding-left').toInt() - h.getStyle('padding-right').toInt() - text.getSize().size.x)/2 - 0 );
			}
		}
		
	});
	
});
