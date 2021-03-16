/*
 * Mootools Scripts
 * Background Fade for Top Level Menu Items
 */

window.addEvent('domready', function(){

	if(!window.ie7){
		var menu = $('menu');
		var menuUL = menu.getElement('ul.menu');
		var menuLIS = menuUL.getChildren('li');
		
		menuLIS.each(function(l,i){
			/* Create and Style the background */
			var libg = new Element('span').addClass('libg');
			libg.setStyles({
				'display':'block',
				'position':'absolute',
				'top':'0px',
				'left':'0px',
				'width':l.getSize().x + 'px',
				'height':l.getSize().y + 'px',
				'z-index':-1,
				'opacity':0
			});
			/* Get the Link and add the background */
			var link = l.getElement('a');
			var plul = link.getParent().getElement('ul');
			link.adopt(libg);
			
			/* Create the fx var */
			var fx = new Fx.Morph(libg, {
				duration: 600,
				link: 'cancel',
				transition: Fx.Transitions.Sine.easeOut
			});
	
			/* Finding current & active */
	
				if( !l.hasClass('active')){
					/* Hover the Top Elments */
					l.addEvent('mouseenter', function(){
						fx.start({
							'opacity':1
						});
					});
					
					/* Hover Out the Top Elments */
					l.addEvent('mouseleave', function(){
						fx.start({
							'opacity':0
						});
					});
				} 
			
		});
	}
	
});

