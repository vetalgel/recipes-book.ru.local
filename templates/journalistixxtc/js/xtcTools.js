/*
 * xtcTools - Auto Heights - xtcAH
 * 
 */
var xtcAH = new Class({
	/* Params (default) */
	options: {
		container: document
	},
	initialize: function(options){
		this.setOptions(options);
		/* Vars */
		this.tallest = 0;
	},
	autoHeightsByClass: function( o ){
		o.targets.setStyle('height', this.calculateTallest( o.targets ) );
	},	
	autoHeightsById: function( ids ){
		ids.targets.setStyle('height', this.calculateTallest( ids.targets ) ); 
	},	
	calculateTallest: function( cols ){
		this.tallest = 0;
		cols.each(function(c,i){
			this.tallest = ( c.getSize().size.y > this.tallest ) ? c.getSize().size.y : this.tallest ;
		}, this);
		return this.tallest;
	}
});
xtcAH.implement(new Options);


/* XTC Tools Class */
var xtcTools = new Class({
	options: {
		version: '1.0'
	},
	
	initialize: function(options){
		this.setOptions(options);
	},
});
xtcTools.implement(new Options);
xtcTools.implement(new xtcAH);