/* js_e4e20338d47310236e5bbd3912dd463d.core.js */
function switchFontSize(ckname,val){var bd=document.getElementsByTagName('body');if(!bd||!bd.length)return;bd=bd[0];switch(val){case'inc':if(CurrentFontSize+1<7){CurrentFontSize++;}
break;case'dec':if(CurrentFontSize-1>0){CurrentFontSize--;}
break;case'reset':default:CurrentFontSize=DefaultFontSize;}
var newclass='fs'+CurrentFontSize;bd.className=bd.className.replace(new RegExp('fs.?','g'),'');bd.className=trim(bd.className);bd.className+=(bd.className?' ':'')+newclass;createCookie(ckname,CurrentFontSize,365);}
function switchTool(ckname,val){createCookie(ckname,val,365);window.location.reload();}
function cpanel_reset(){var matches=document.cookie.match(new RegExp('(?:^|;)\\s*'+tmpl_name.escapeRegExp()+'_([^=]*)=([^;]*)','g'));if(!matches)return;for(var i=0;i<matches.length;i++){var ck=matches[i].match(new RegExp('(?:^|;)\\s*'+tmpl_name.escapeRegExp()+'_([^=]*)=([^;]*)'));if(ck){createCookie(tmpl_name+'_'+ck[1],'',-1);}}
if(window.location.href.indexOf('?')>-1){window.location.href=window.location.href.substr(0,window.location.href.indexOf('?'));}else{window.location.reload(true);}}
function cpanel_apply(){var elems=document.getElementById('ja-cpanel-main').getElementsByTagName('*');var usersetting={};for(var i=0;i<elems.length;i++){var el=elems[i];if(el.name&&(match=el.name.match(/^user_(.*)$/))){var name=match[1];var value='';if(el.tagName.toLowerCase()=='input'&&(el.type.toLowerCase()=='radio'||el.type.toLowerCase()=='checkbox')){if(el.checked)value=el.value;}else{value=el.value;}
if(usersetting[name]){if(value)usersetting[name]=value+','+usersetting[name];}else{usersetting[name]=value;}}}
for(var k in usersetting){name=tmpl_name+'_'+k;value=usersetting[k].trim();if(value.length>0){createCookie(name,value,365);}}
if(window.location.href.indexOf('?')>-1){window.location.href=window.location.href.substr(0,window.location.href.indexOf('?'));}else{window.location.reload(true);}}
function createCookie(name,value,days){if(days){var date=new Date();date.setTime(date.getTime()+(days*24*60*60*1000));var expires="; expires="+date.toGMTString();}else{expires="";}
document.cookie=name+"="+value+expires+"; path=/";}
function trim(str,chars){return ltrim(rtrim(str,chars),chars);}
function ltrim(str,chars){chars=chars||"\\s";return str.replace(new RegExp("^["+chars+"]+","g"),"");}
function rtrim(str,chars){chars=chars||"\\s";return str.replace(new RegExp("["+chars+"]+$","g"),"");}
function getScreenWidth(){var x=0;if(self.innerHeight){x=self.innerWidth;}else if(document.documentElement&&document.documentElement.clientHeight){x=document.documentElement.clientWidth;}else if(document.body){x=document.body.clientWidth;}
return x;}
function equalHeight(els){els=$$_(els);if(!els||els.length<2)return;var maxh=0;var els_=[];els.each(function(el,i){if(!el)return;els_[i]=el;var ch=els_[i].getCoordinates().height;maxh=(maxh<ch)?ch:maxh;},this);els_.each(function(el,i){if(!el)return;if(el.getStyle('padding-top')!=null&&el.getStyle('padding-bottom')!=null){if(maxh-el.getStyle('padding-top').toInt()-el.getStyle('padding-bottom').toInt()>0){el.setStyle('min-height',maxh-el.getStyle('padding-top').toInt()-el.getStyle('padding-bottom').toInt());}}else{if(maxh>0)el.setStyle('min-height',maxh);}},this);}
function getDeepestWrapper(el){while(el.getChildren().length==1){el=el.getChildren()[0];}
return el;}
function fixHeight(els,group1,group2){els=$$_(els);group1=$$_(group1);group2=$$_(group2);if(!els||!group1)return;var height=0;group1.each(function(el){if(!el)return;height+=el.getCoordinates().height;});if(group2){group2.each(function(el){if(!el)return;height-=el.getCoordinates().height;});}
els.each(function(el,i){if(!el)return;if(el.getStyle('padding-top')!=null&&el.getStyle('padding-bottom')!=null){if(height-el.getStyle('padding-top').toInt()-el.getStyle('padding-bottom').toInt()>0){el.setStyle('min-height',height-el.getStyle('padding-top').toInt()-el.getStyle('padding-bottom').toInt());}}else{if(height>0){el.setStyle('min-height',height);}}});}
function addFirstLastItem(el){el=$(el);if(!el||!el.getChildren()||!el.getChildren().length)return;el.getChildren()[0].addClass('first-item');el.getChildren()[el.getChildren().length-1].addClass('last-item');}
function $$_(els){if(typeOf(els)=='string')return $$(els);var els_=[];els.each(function(el){el=$(el);if(el)els_.push(el);});return els_;}
$(document).addEvent('domready',function(){$$('[data-dismiss="alert"]').each(function(el){el.addEvent('click',function(){el.getParent().destroy();if($('system-message').getChildren().length==0){Joomla.removeMessages();}});});});;;

/* js_c39b94bf649df7c1b90baac8a95dd3de.iphone.js */
var JAIToolbox=new Class({initialize:function(options){this.options=(window.$extend||Object.append)({animOn:false,axis:'x',slideInterval:0,slideSpeed:20},options||{});window.addEvent('domready',this.start.bind(this));},start:function(){this._backs=[];this._currenttoggle=null;this._last=null;this._links=$$('a');this._back=$('toolbar-back');this._close=$('toolbar-close');this._title=$('toolbar-title');this._boxes=$$('.toolbox');this._boxes2=$$('.toolbox');if(!this._boxes||!this._boxes.length)return;this._overlay=$('ja-overlay');this._mainbox=$('ja-toolbar-main');if(this.options.animOn){this._boxes.setStyle('opacity',0);this._overlay.setStyle('opacity',0);this._boxes.push($('ja-toolbar-main'));this._boxes.push(this._overlay);this._fx=new Fx.Elements(this._boxes,{'onComplete':this.slidedone.bind(this)});}
var top=(this._boxes&&this._boxes.length)?this._boxes[0].getCoordinates().top:0;this._links.each(function(link){if(link.href&&link.hash&&link.hash!="#"){link._box=$(link.hash.substr(1));if(!link._box||!link._box.hasClass('toolbox'))return;link._box._link=link;link._h=top+link._box.getCoordinates().height;if(link.hasClass('ip-button')){link.addEvent('click',function(e){if(e){e.stop();}
this.togglebox(link);return false;}.bind(this));}else{link.addEvent('click',function(e){if(e){e.stop();}
this.showbox(link,true);return false;}.bind(this));}}},this);if(this._back){this._back.addEvent('click',function(e){if(e){e.stop();}
this.back();return false;}.bind(this));}
if(this._close){this._close.addEvent('click',function(e){if(e){e.stop();}
this.close();return false;}.bind(this));}
this._overlay.addEvent('click',function(e){this.close();return false;}.bind(this));},slidedone:function(){if(this._currenttoggle==null){this._overlay.setStyle('display','none');}},togglebox:function(link){if(this._currenttoggle==link){this.close();}
if(this._currenttoggle==null){this._overlay.setStyles({'display':'block','height':$('ja-wrapper').offsetHeight});}
this.showbox(link,true);this._currenttoggle=link;},showbox:function(link,addback){if(this.options.animOn)this.showbox2(link,addback);else this.showbox1(link,addback);},close:function(){if(this.options.animOn)this.close2();else this.close1();},showbox1:function(link,addback){this._boxes2.setStyle('display','none');link._box.setStyle('display','block');this._mainbox.setStyle('height',link._h);if(addback&&this._last){this._backs.push(this._last);}
this._last=link;this.updatestatus(link);},close1:function(){this._boxes2.setStyle('display','none');this._mainbox.setStyle('height',0);this._overlay.setStyle('display','none');this._backs=[];this._currenttoggle=null;this._last=null;},showbox2:function(link,addback){this._fx.stop();objs={};for(i=0;i<this._boxes.length-2;i++){if(this._boxes[i]!=link._box){objs[i]={'opacity':0};}else{objs[i]={'opacity':1};}}
objs[this._boxes.length-2]={'height':link._h};if(this._currenttoggle==null){objs[this._boxes.length-1]={'opacity':0.7};}
this._fx.start(objs);if(addback&&this._last){this._backs.push(this._last);}
this._last=link;this.updatestatus(link);},close2:function(){this._fx.stop();objs={};for(i=0;i<this._boxes.length-2;i++){objs[i]={'opacity':0};}
objs[this._boxes.length-2]={'height':0};objs[this._boxes.length-1]={'opacity':0};this._fx.start(objs);this._backs=[];this._currenttoggle=null;this._last=null;},updatestatus:function(link){this._title.innerHTML=link.title;if((lastlink=this._backs.getLast())){this._back.innerHTML=lastlink.title;this._back.setStyle('display','block');}else{this._back.innerHTML='';this._back.setStyle('display','none');}},back:function(){if((link=this._backs.pop())){this.showbox(link);}}})
new JAIToolbox();;;

