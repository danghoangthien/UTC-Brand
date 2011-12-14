/** @preserve jquery.jqDock.js v1.4 
 */
/*
 * jqDock jQuery plugin
 * Version : 1.4
 * Author : Roger Barrett
 * Date : April 2010
 *
 * Inspired by:
 *   iconDock jQuery plugin
 *   http://icon.cat/software/iconDock
 *   version: 0.8 beta
 *   date: 2/05/2007
 *   Copyright (c) 2007 Isaac Roca & icon.cat (iroca@icon.cat)
 *   Dual licensed under the MIT-LICENSE.txt and GPL-LICENSE.txt
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Dual licensed under the MIT-LICENSE.txt and GPL-LICENSE.txt
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Change Log :
 * v1.4
 *    - bugfix : in IE8, non-statically positioned child elements do not inherit opacity, so fadeIn did not work correctly
 *    - new option, fadeLayer (default ''), allows the fade-in to be switched from the original menu element down to either the
 *      div.jqDockWrap or div.jqDock layer
 * v1.3
 *    - new option, inactivity (default 0), allowing auto-collapse after a specified period (mouse on dock)
 *    - new option, fadeIn (default 0), allowing initialised menu to be faded in over a specified period (as opposed to an instant show)
 *    - new option, step (default 50), which is the interval between animation steps
 *    - default size increased to 48 (from 36)
 *    - default distance increased to 72 (from 54)
 *    - default duration reduced to 300 ms (from 500 ms)
 *    - better 'best guess' for maximum dimensions of Dock
 *    - handle integer options being passed in as strings (eg. size:'48' instead of size:48)
 *    - the wrapper div now has width, height, and a class
 *    - all menu items are double-wrapped now in 2 divs 
 *    - double-wrap resolves ie8 horizontal float problem
 *    - dimensioning switched from image to innermost of the item's double-wrap
 *    - labels now assigned per menu item instead of one for the entire dock
 *    - labels within anchors so clicking activates anchor
 *    - labels are always created, regardless of option setting
 *    - default label position changed from 'tc' to 'tl' for any alignment except 'top' (labels='br') and 'left' (labels='tr')
 *    - events switched from mouseover/out to mouseenter/leave
 * v1.2
 *    - Fixes for Opera v9.5 - many thanks to Rubel Mujica
 * v1.1
 *    - some speed optimisation within the functions called by the event handler
 *    - added positioning of labels (top/middle/bottom and left/center/right)
 *    - added click handler to label (triggers click event on related image)
 *    - added jqDockLabel(Link|Image) class to label, depending on type of current image
 *    - updated demo and documentation for label positioning and clicking on labels
 */
(function($, window){
if(!$.jqDock){ //can't see why it should be, but it doesn't hurt to check
	var TRBL = ['Top', 'Right', 'Bottom', 'Left']
		, PROPMAP = {src:'Source', altsrc:'AltSource'}
		, VANILLA = [
				'<div style="position:relative;padding:0;'
			, 'margin:0;border:0 none;background-color:transparent;'
			, '">'
			]
		, VERTHORZ = {
				v: { wh:'height', xy:1, tl:'top', lead:TRBL[0], trail:TRBL[2], act:'TransInv' } //Opts.align = left/center/right
			, h: { wh:'width', xy:0, tl:'left', lead:TRBL[3], trail:TRBL[1], act:'Trans' } //Opts.align = top/middle/bottom
			}
		, DOCKS = []
		, XY = [0, 0] //mouse position from left, mouse position from top
/** tests to see if an image has an alt attribute that looks like an image path, returning it if found, else false
 * @private
 * @param {element} el Image element
 * @return {string|boolean} Image path or false
 */
		, ALT_IMAGE = function(el){
				var alt = $(el).attr('alt');
				return (alt && alt.match(/\.(gif|jpg|jpeg|png)$/i)) ? alt : false;
			}
/** returns integer numeric of leading digits in string argument
 * @private
 * @param {string} x String representation of an integer
 * @return {integer} Number
 */
		, AS_INTEGER = function(x){
				var r = parseInt(x, 10);
				return isNaN(r) ? 0 : r;
			}
/** translates (without affecting) XY[0] or XY[1] into an offset within div.jqDock
 * note: doing it this way means that all attenuation is against the initial (shrunken) image positions,
 * but it saves having to find every image's offset() each time the cursor moves or an image changes size!
 * @private
 * @param {Dock} Dock Dock object
 * @return {integer} Translated mouse offset
 */
		, DELTA_XY = function(Dock){
				var opvh = Dock.Opts.vh //convenience
					, rtn = 0
					, el = Dock.Current !== false ? Dock.Elem[Dock.Current] : 0 
					, p;
				if(el){
					p = el.Pad[opvh.lead] + el.Pad[opvh.trail]; //element's user-specified padding
					//get the difference between the cursor position and the leading edge of the current element's outer wrapper,
					//multiply by the full/shrunken ratio, and add the element's pre-calculated offset within div.jqDock...
					rtn = Math.floor((XY[opvh.xy] - el.Wrap.parent().offset()[opvh.tl]) * (p + el.Initial) / (p + el.Trans)) + el.Offset;
				}
				return rtn;
			}
/** returns an object containing width and height, with the one NOT represented by 'dim'
 * being calculated proportionately
 * if horizontal menu then attenuation is along horizontal (x) axis, thereby setting the new
 * dimension for width, so the one to keep in proportion is height; and vice versa for
 * vertical menus, obviously!
 * @private
 * @param {element} el Element of elements array
 * @param {integer} dim Image dimension
 * @param {object} orient Dock orientation object (or part thereof), containing properties 'vh' and 'inv'
 * @return {object} The provided dimension and the proportioned dimension (width and height, but not necessarily respectively!)
 */
		, KEEP_PROPORTION = function(el, dim, orient){
				var r = {}
					, vhwh = VERTHORZ[orient.vh].wh //convenience
					, invwh = VERTHORZ[orient.inv].wh //convenience
					;
				r[vhwh] = dim;
				r[invwh] = Math.round(dim * el[invwh] / el[vhwh]);
				return r;
			}
/** re-positions a label, if needed
 * only labels with middle and/or center alignment need re-positioning because css handles the corners
 * @private
 * @param {object} Dock Dock object
 */
		, POSITION_LABEL = function(Dock){
				var labels = Dock.Opts.labels
					, opvh = Dock.Opts.vh
					, css = {}
					, el, label;
				if(labels && Dock.Current !== false && (/[mc]/).test(labels)){
					labels = labels.split('');
					el = Dock.Elem[Dock.Current];
					label = el.Label;
					//note: if vertically or horizontally centred then centre is based on the IMAGE only
					//(ie without including padding), otherwise, positioning includes any image padding
					if(labels[0] == 'm'){
						css.top = Math.floor((el[opvh.inv.act] - label.height - label.heightPad) / 2);
					}
					if(labels[1] == 'c'){
						css.left = Math.floor((el[opvh.act] - label.width - label.widthPad) / 2);
					}
					label.el.css(css);
				}
				labels = css = null;
			}
/** removes ALL text nodes from the menu, so that we don't get spacing issues between menu elements
 * @private
 * @param {element} el DOM Element
 * @recursive
 */
		, REMOVE_TEXT = function(el){
				var i = el.childNodes.length, j;
				while(i){
					j = el.childNodes[--i];
					if(j.childNodes && j.childNodes.length){
						REMOVE_TEXT(j);
					}else if(j.nodeType == 3){
						el.removeChild(j);
					}
				}
			}
/** sets up the labels, storing each label's dimensions (if necessary)
 * @private
 * @param {object} Dock Dock object
 * @param {integer} idx Menu item index
 */
		, SET_LABEL = function(Dock, Elem){
				var labels = Dock.Opts.labels
					, label = Elem.Label //convenience
					, pad, css, splt
					;
				if(label.txt){
					//give the label a click handler that triggers its related image's click handler...
					label.el.click(function(){ Elem.Img.trigger('click'); });
					//if labels are being aligned middle and/or centre then we need to find any user-styled padding and store width/height...
					if((/[mc]/).test(labels)){
						pad = {};
						$.each(TRBL, function(n, v){
								pad[v] = AS_INTEGER(label.el.css('padding'+v));
							});
						//store the label dimensions for this image...
						$.each(VERTHORZ, function(vh, o){
								label[o.wh] = label.el[o.wh]();
								label[o.wh+'Pad'] = pad[o.lead] + pad[o.trail]; //hold padding separately
							});
					}
					//position the label...
					splt = labels.split('');
					css = { top: 0, left: 0, bottom: 'auto', right: 'auto'};
					if(splt[0] == 'b'){
						css.top = 'auto';
						css.bottom = 0;
					}
					if(splt[1] == 'r'){
						css.left = 'auto';
						css.right = 0;
					}
					label.el.css(css);
					pad = css = splt = null;
				}
			}
/** calculates the image sizes according to the current (translated) position of the cursor within div.jqDock
 * result stored in Final for each menu element
 * @private
 * @param {integer} id Dock index
 * @param {integer} [mxy] Translated cursor offset in main axis
 */
		, SET_SIZES = function(id, mxy){
				var Dock = DOCKS[id] //convenience
					, op = Dock.Opts //convenience
					, i = Dock.Elem.length
					, el, ab;
				 //if not forced, use current translated cursor position (main axis)...
				mxy = mxy || DELTA_XY(Dock);
				while(i){
					el = Dock.Elem[--i];
					ab = Math.abs(mxy - el.Centre);
					//if we're smack on or beyond the attenuation distance then set to the min dim
					//ensure Final ends up as an integer to avoid 'flutter'
					el.Final = ab < op.distance 
						? el[op.vh.wh] - Math.floor((el[op.vh.wh] - el.Initial) * Math.pow(ab, op.coefficient) / op.attenuation) 
						: el.Initial;
				}
			}
/** shows/hides a label
 * @private
 * @param {object} Dock Dock object
 * @param {boolean} [show] Show label
 */
		, SHOW_LABEL = function(Dock, show){
				var label;
				if(Dock.Opts.labels && Dock.Current !== false){
					label = Dock.Elem[Dock.Current].Label;
					label.el[label.txt && show ? 'show' : 'hide']();
				}
			}
/** sets the css for an individual image wrapper to effect its change in size
 * 'dim' is the new value for the main axis dimension as specified in Opts.vh.wh, so
 * the margin needs to be applied to the inverse of Opts.vh.wh!
 * note: 'force' is only set when called from initDock() to do the initial shrink
 * @private
 * @param {integer} id Dock index
 * @param {integer} idx Image index
 * @param {integer} dim Main axis dimension of image
 * @param {boolean} force Force change even if no size difference
 */
		, CHANGE_SIZE = function(id, idx, dim, force){
				var Dock = DOCKS[id] //convenience
					, el = Dock.Elem[idx] //convenience
					, op = Dock.Opts //convenience
					, invers = op.vh.inv //convenience
					, margin = 'margin' //convenience
					, srcDiff = el.Source != el.AltSource
					, bdr, css, diff
					;
				if(force || el.Trans != dim){
					//horizontal menus in IE quirks mode require border widths (if any) of the Dock to be added to the Dock's main axis dimension...
					bdr = ($.boxModel || op.orient.vh == 'v') ? 0 : Dock.Borders[op.vh.lead] + Dock.Borders[op.vh.trail];
					//switch image source to large, if (a) it's different to small source, and (b) this is the first step of an expansion...
					if(srcDiff && !force && el.Trans == el.Initial){
						el.Img[0].src = el.AltSource;
					}
					Dock.Spread += dim - el.Trans; //adjust main axis dimension of dock
					css = KEEP_PROPORTION(el, dim, op.orient);
					diff = op.size - css[invers.wh];
					//add minor axis margins according to alignment...
					//note: where diff is an odd number of pixels, for 'middle' or 'center' alignment put the odd pixel in the 'lead' margin
					switch(op.align){
						case 'bottom': case 'right' : //set top/left margin
							css[margin + invers.lead] = diff;
							break;
						case 'middle': case 'center' : //set top/left and bottom/right margins
							css[margin + invers.lead] = (diff + (diff % 2)) / 2;
							css[margin + invers.trail] = (diff - (diff % 2)) / 2;
							break;
						default: // = case 'top': case 'left': //set bottom/right margin
							css[margin + invers.trail] = diff;
					}
					//set dock's main axis dimension (if it's changed, or if force and this is first menu item)...
					if (dim != el.Trans || (force && !idx)) {
						Dock.Yard[op.vh.wh](Dock.Spread + bdr);
					}
					//change image wrapper size and margins...
					el.Wrap.css(css);
					//set dock's main axis 'lead' offset (not negative!)...
					Dock.Yard.css(op.vh.tl, Math.floor(Math.max(0, (Dock[op.vh.wh] - Dock.Spread) / 2)));
					//reposition the label if need be...
					if(Dock.OnDock){
						POSITION_LABEL(Dock);
					}
					//store new dimensions...
					el.Trans = dim; //main axis
					el.TransInv = css[invers.wh]; //minor axis
					//switch image source to small, if (a) it's different to large source, and (b) this was the last step of a shrink...
					if(srcDiff && !force && el.Trans == el.Initial){
						el.Img[0].src = el.Source;
					}
					css = null;
				}
			}
/** modifies the target sizes in proportion to 'duration' if still within the 'duration' period following a mouseenter
 * calls CHANGE_SIZE() for each menu element (if more than Opts.step ms since mouseenter)
 * @private
 * @param {integer} id Dock index
 * @param {boolean} revers For shrinking (from OFF_DOCK())
 */
		, FACTOR_SIZES = function(id, revers){
				var Dock = DOCKS[id] //convenience
					, op = Dock.Opts //convenience
					, lapse = op.duration + op.step
					, i = 0 //must go through the elements in logical order
					, factor, el, sz;
				if(Dock.Timestamp){
					lapse = (new Date()).getTime() - Dock.Timestamp;
					//there's no point continually checking Date once op.duration has passed...
					if(lapse >= op.duration){
						Dock.Timestamp = 0;
					}
				}
				if(lapse > op.step){ //only if more than Opts.step ms have passed since last mouseenter/leave
					factor = lapse < op.duration ? lapse / op.duration : 0;
					while(i < Dock.Elem.length){
						el = Dock.Elem[i];
						if(revers){ //revers is for shrinking, where we're going from Final->Initial instead of Initial->Final
							sz = factor ? Math.floor(el.Final - ((el.Final - el.Initial) * factor)) : el.Initial;
						}else{
							sz = factor ? Math.floor(el.Initial + ((el.Final - el.Initial) * factor)) : el.Final;
						}
						CHANGE_SIZE(id, i++, sz);
					}
					//tweak 'best guess':
					//having changed all item sizes within the dock, if Spread is greater than main axis dimension, adjust wrap dimension...
					if(Dock.Spread > Dock[op.vh.wh]){
						Dock.Yard.parent()[op.vh.wh](Dock.Spread + Dock.Borders[op.vh.lead] + Dock.Borders[op.vh.trail]);
						Dock[op.vh.wh] = Dock.Spread;
					}
				}
			}
/** called when cursor goes outside menu, and checks for completed shrinking of all menu elements
 * calls FACTOR_SIZES() (with revers set) on any menu element that has not finished shrinking
 * calls itself on a timer to complete the shrinkage
 * @private
 * @param {integer} id Dock index
 */
		, OFF_DOCK = function(id){
				var Dock = DOCKS[id] //convenience
					, el = Dock.Elem
					, i = el.length;
				if(!Dock.OnDock){
					while((i--) && el[i].Trans <= el[i].Initial){}
					//this is here for no other reason than that early versions of Opera seem to leave 
					//a 'shadow' residue of the expanded image unless/until Delta is recalculated!...
					DELTA_XY(Dock);
					if(i < 0){ //complete
						//reset everything back to 'at rest' state...
						i = el.length;
						while(i--){
							el[i].Trans = el[i].Final = el[i].Initial;
						}
						Dock.Current = false;
					}else{
						FACTOR_SIZES(id, true); //set revers
						window.setTimeout(function(){ OFF_DOCK(id); }, Dock.Opts.step);
					}
				}
			}

/** checks for completed expansion (if OnDock)
 * if not completed, runs SET_SIZES(), FACTOR_SIZES(), and then itself on a timer
 * @private
 * @param {integer} id Dock index
 */
		, OVER_DOCK = function(id){
				var Dock = DOCKS[id] //convenience
					, el = Dock.Elem
					, i = el.length;
				if(Dock.OnDock){
					while((i--) && el[i].Trans >= el[i].Final){}
					if(i < 0){ //complete
						Dock.Expanded = true;
						SHOW_LABEL(Dock, true); //show
					}else{
						SET_SIZES(id);
						FACTOR_SIZES(id);
						window.setTimeout(function(){ OVER_DOCK(id); }, Dock.Opts.step);
					}
				}
			}
/** actions for any type of mouse event
 * @private
 * @param {string} etype Event type
 * @param {integer} id Dock id
 * @param {integer|boolean} idx Menu item id or false
 */
		, DO_MOUSE = function(etype, id, idx){
				var Dock = DOCKS[id] //convenience
					, el = Dock.Elem //convenience
					, i;
				switch(etype){
					case 'mousemove':
						if(idx !== Dock.Current){ //mousemove from one item onto another
							SHOW_LABEL(Dock); //hide
							Dock.Current = idx;
						}
						POSITION_LABEL(Dock);
						if(Dock.Expanded){
							SHOW_LABEL(Dock, true); //show
						}
						if(Dock.OnDock && Dock.Expanded){
							SET_SIZES(id);
							FACTOR_SIZES(id);
						}
						break;
					case 'mouseenter':
						Dock.OnDock = true;
						if(Dock.Current !== false && Dock.Current !== idx){
							SHOW_LABEL(Dock); //hide
						}
						Dock.Current = idx;
						POSITION_LABEL(Dock);
						if(Dock.Expanded){
							SHOW_LABEL(Dock, true); //show
						}
						Dock.Timestamp = (new Date()).getTime();
						SET_SIZES(id);
						OVER_DOCK(id); //sets Expanded when complete
						break;
					case 'mouseleave':
						if(Dock.Inactive){
							window.clearTimeout(Dock.Inactive);
							Dock.Inactive = null;
						}
						Dock.OnDock = Dock.Expanded = false;
						SHOW_LABEL(Dock); //hide
						Dock.Timestamp = (new Date()).getTime();
						i = el.length;
						while(i--){ //just in case...
							el[i].Final = el[i].Trans;
						}
						OFF_DOCK(id); //clears Current when complete
						break;
					default:
				}
			}
/** handler for all bound mouse events (move/enter/leave)
 * @private
 * @this {element}
 * @param {object} ev jQuery Event object
 * @return {boolean} false
 */
		, MOUSE_HANDLER = function(ev){
				var dockId = 1 * (this.id.match(/^jqDock(\d+)$/)||[0,-1])[1]
					, Dock = dockId >= 0 ? DOCKS[dockId] : 0
					, tgt = Dock ? ev.target.className.toString().match(/jqDockMouse(\d+)/) : 0
					, idx = tgt ? 1 * tgt[1] : false
					;
				if(Dock){
					XY = [ev.pageX, ev.pageY];
					if(ev.type == 'mouseleave'){
						if(Dock.OnDock){
							DO_MOUSE(ev.type, dockId, idx);
						}
					}else{ //mousemove or mouseenter...
						if(Dock.Opts.inactivity){
							if(Dock.Inactive){
								window.clearTimeout(Dock.Inactive);
								Dock.Inactive = null;
							}
							Dock.Inactive = window.setTimeout(function(){ DO_MOUSE('mouseleave', dockId, idx); }, Dock.Opts.inactivity);
						}
						if(ev.type == 'mousemove'){
							if(idx === false){
								if(Dock.OnDock && Dock.Current !== false){ //off of current
									DO_MOUSE('mouseleave', dockId, idx);
								}
							}else if(!Dock.OnDock || Dock.Current === false){ //instant re-entry or no current
								DO_MOUSE('mouseenter', dockId, idx);
							}else{ //change of current or moving within current
								DO_MOUSE(ev.type, dockId, idx);
							}
						}else if(idx !== false && !Dock.OnDock){ //mouseenter...
							DO_MOUSE(ev.type, dockId, idx);
						}
					}
				}
				return false;
			}
		;
/**
 * The main $.jqDock object
 * @private
 */
	$.jqDock = (function(){
		//return an object...
		return {
				version : 1.4
			, defaults : { //can be set at runtime, per menu
					size : 48 //[px] maximum minor axis dimension of image (width or height depending on 'align' : vertical menu = width, horizontal = height)
				, distance : 72 //[px] attenuation distance from cursor
				, coefficient : 1.5 //attenuation coefficient
				, duration : 300 //[ms] duration of initial expansion and off-menu shrinkage
				, align : 'bottom' //[top/middle/bottom or left/center/right] fixes horizontal/vertical expansion axis
				, labels : false //enable/disable display of a label on the current image
				, source : false //function: given context of relevant image element; passed index of image within menu; required to return image source path, or false to use original
				, loader : null //overrides useJqLoader if set to 'image' or 'jquery'
				, inactivity : 0 //[ms] duration of inactivity (no mouse movement) after which any expanded images will collapse; 0 (zero) disables the inactivity timeout
				, fadeIn : 0 //[ms] duration of the fade-in 'reveal' of the jqDocked menu; set to zero for instant 'show'
				, fadeLayer : '' //if fadeIn is set, this can change the element that it faded; the default is the entire original menu; alternatives are 'wrap' or 'dock'
				, step : 50 //[ms] the timer interval between each step of shrinkage/expansion
				}
			, useJqLoader : $.browser.opera || $.browser.safari //use jQuery method for loading images, rather than "new Image()" method

/**
 * initDock()
 * ==========
 * called by the image onload function, it stores and sets image height/width;
 * once all images have been loaded, it completes the setup of the dock menu
 * note: unless all images get loaded, the menu will stay hidden!
 * @this {$.jqDock}
 * @param {integer} id Dock index
 */
			, initDock : function(id){
			//========================================
					var Dock = DOCKS[id] //convenience
						, op = Dock.Opts //convenience
						, vertOrHorz = op.vh //convenience
						, orient = op.orient //convenience
						, borders = Dock.Borders //convenience
						, vanillaDiv = VANILLA.join('')
						, off = 0
						, i = 0
						, j, el, wh, acc, upad, wrap, callback
						;
					// things will screw up if we don't clear text nodes...
					REMOVE_TEXT(Dock.Menu);
					//double wrap, and set some basic styles on the dock elements, otherwise it won't work
					$(Dock.Menu).children()
						.each(function(i, kid){
								var wrap = Dock.Elem[i].Wrap = $(kid).wrap(vanillaDiv + vanillaDiv + '</div></div>').parent(); 
								if(orient.vh == 'h'){
									wrap.parent().css('float', 'left');
								}
							})
						.find('img').andSelf()
						.css({
								position: 'relative'
							, padding: 0
							, margin: 0
							, borderWidth: 0
							, borderStyle: 'none'
							, verticalAlign: 'top'
							, display: 'block'
							, width: '100%'
							, height: '100%'
							});
					//resize each image and store various settings wrt main axis...
					while(i < Dock.Elem.length){
						el = Dock.Elem[i++];
						//resize the image wrapper to make the minor axis dimension meet the specified 'Opts.size'...
						wh = KEEP_PROPORTION(el, op.size, {vh:orient.inv, inv:orient.vh}); //inverted!
						el.Trans = el.Final = el.Initial = wh[vertOrHorz.wh];
						el.Wrap.css(wh); //resize the image wrapper to its new shrunken setting
						//remove titles, alt text...
						el.Img.attr({alt:''}).parent('a').andSelf().removeAttr('title');
						//use inverts because we're after the minor axis dimension...
						Dock[vertOrHorz.inv.wh] = Math.max(Dock[vertOrHorz.inv.wh], op.size + el.Pad[vertOrHorz.inv.lead] + el.Pad[vertOrHorz.inv.trail]);

						el.Offset = off;
						el.Centre = off + el.Pad[vertOrHorz.lead] + (el.Initial / 2);
						off += el.Initial + el.Pad[vertOrHorz.lead] + el.Pad[vertOrHorz.trail];
					}

					//'best guess' at calculating max 'spread' (main axis dimension - horizontal or vertical) of menu:
					//for each img element of the menu, call SET_SIZES() with a forced cursor position of the centre of the image;
					//SET_SIZES() will set each element's Final value, so tally them all, including user-applied padding, to give
					//an overall width/height for this cursor position; set dock width/height to be the largest width/height found
					i = 0;
					while(i < Dock.Elem.length){
						el = Dock.Elem[i++];
						j = Dock.Elem.length;
						upad = el.Pad[vertOrHorz.lead] + el.Pad[vertOrHorz.trail]; //user padding in main axis
						//tally the minimum widths...
						Dock.Spread += el.Initial + upad;

						//set sizes with an overridden cursor position...
						SET_SIZES(id, el.Centre);
						//tally image widths/heights (plus padding)...
						acc = 0; //accumulator for main axis image dimensions
						while(j){
							//note that Final is an image dimension (in main axis) and does not include any user padding...
							acc += Dock.Elem[--j].Final + upad;
						}
						//keep largest main axis dock dimension...
						if(acc > Dock[vertOrHorz.wh]){ Dock[vertOrHorz.wh] = acc; }

						//re-set sizes with an overridden cursor position, using Offset this time...
						SET_SIZES(id, el.Offset);
						//tally image widths/heights (plus padding)...
						acc = 0; //reset accumulator for main axis image dimensions
						while(j < Dock.Elem.length){
							//note that Final is an image dimension (in main axis) and does not include any user padding...
							acc += Dock.Elem[j++].Final + upad;
						}
						//keep largest main axis dock dimension...
						if(acc > Dock[vertOrHorz.wh]){ Dock[vertOrHorz.wh] = acc; }
					}
					//reset Final for each image...
					while(i){
						el = Dock.Elem[--i];
						el.Final = el.Initial;
					}
					wrap = [
							VANILLA[0], VANILLA[2] //this will be div.jqDockWrap, but I don't want margin, border or background
						, '<div id="jqDock', id, '" class="jqDock" style="position:absolute;top:0;left:0;padding:0;margin:0;overflow:visible;'
						, 'height:', Dock.height, 'px;width:', Dock.width, 'px;"></div></div>'
						].join('');
					Dock.Yard = $(Dock.Menu).wrapInner(wrap).find('div.jqDock');
					//let's see if the user has applied any css border styling to div.jqDock...
					$.each(TRBL, function(n, v){
							borders[v] = AS_INTEGER(Dock.Yard.css('border'+v+'Width'));
						});
					Dock.Yard.parent().addClass('jqDockWrap')
						.width(Dock.width + borders.Left + borders.Right)
						.height(Dock.height + borders.Top + borders.Bottom);
					//shrink all images down to 'at rest' size, and add appropriate identifying class...
					while(i < Dock.Elem.length){
						el = Dock.Elem[i];
						//apply the image's user-applied padding to the outer element wrapper...
						upad = el.Wrap.parent();
						for(j in el.Pad){
							if(el.Pad[j]){
								upad.css('padding'+j, el.Pad[j]);
							}
						}
						CHANGE_SIZE(id, i, el.Final, true); //force
						//give a mouse class to both the image and the outer element wrapper (to handle any user padding)...
						upad.add(el.Img).addClass('jqDockMouse'+i);
						//create and append the label
						el.Label.el = $('<div class="jqDockLabel jqDockMouse'+i+' jqDockLabel'+(el.Linked?'Link':'Image')+'" style="position:absolute;margin:0px;">'+el.Label.txt+'</div>')
							.hide().appendTo(el.Img.parent()); //append to either anchor or item wrapper
						i += 1;
					}
					//show the menu now...
					callback = function(){
							//set up labels if appropriate...
							if(op.labels){
								$.each(Dock.Elem, function(){
										SET_LABEL(Dock, this);
									});
							}
							//bind a mousehandler to the menu...
							Dock.Yard.bind('mouseenter mouseleave mousemove', MOUSE_HANDLER);
						};
					if(op.fadeIn){
//v1.4 : bugfix : in IE8, non-statically positioned child elements do not inherit opacity, so set filter:inherit on child elements
//       added fadeLayer option handling
//						$(Dock.Menu).fadeIn(op.fadeIn, callback);
						el = {dock:'.jqDock',wrap:'.jqDockWrap'}[op.fadeLayer.toString()] || '';
						if(el){
							el = $(el, Dock.Menu).hide();
							$(Dock.Menu).show();
						}else{
							el = $(Dock.Menu);
						}
						el.find(':not(.jqDockLabel)').css({filter:'inherit'}).end().fadeIn(op.fadeIn, callback);
					}else{
						$(Dock.Menu).show();
						callback();
					}
				} //end function initDock()

			}; //end of return object
		})(); //run the function to set up $.jqDock

	/***************************************************************************************************
	*  jQuery.fn.jqDock()
	*  ==================
	* STANDARD
	* usage:      $(selector).jqDock(options);
	* options:    see $.jqDock.defaults (top of script)
  *
  * ALTERNATE   ...provides a means for modifying image paths post-initialisation
  * usage:      $(image-selector).jqDock(options);
	* options:    src {string|function} Path to 'at rest' image, or function returning a path
	*             altsrc: {string|function} Path to expanded image, or function returning a path
  * Note : image-selector *must* result in solely IMG element(s)
	*
	* note: the aim is to do as little processing as possible after setup, because everything is
	* driven from the mousemove/enter/leave events and I don't want to kill the browser if I can help it!
	* hence the code below, and in $.jqDock.initDock(), sets up and stores everything it possibly can
	* which will reduce processing at runtime, and hopefully give as smooth animation as possible.
	***************************************************************************************************/
	$.fn.jqDock = function(opts){
		if(this.length && !this.not('img').length){ //alternate usage...
			/***************************************************************************************************
			* If a function is provided, it will be called with scope of the image DOM element, and 2 parameters:
			* - current setting
			* - settingType, eg. 'src' or 'altsrc'
			*
			* Example (with strings):
			*   $('#menu img').eq(0).jqDock({src:'newpath.jpg', altsrc:'newexpanderpath.jpg'});
			* Example (with functions):
			*   fnChangePath = function(current, type){
			*       //always change altsrc, but only change src if image has a class of 'changeExpanded'...
			*       return type == 'altsrc' || $(this).hasClass('changeExpanded')
			*         ? current.replace(/old\.png$/, 'new.png')
			*         : current;
			*     };
			*   $('#menu img').jqDock({src:fnChangePath, altsrc:fnChangePath});
			***************************************************************************************************/
			this.each(function(n, el){
					var idx = el.className.toString().match(/jqDockMouse(\d+)/)
						, id = idx ? ($(el).parents('div.jqDock').attr('id')||'').match(/^jqDock(\d+)$/) : 0
						, src = 0
						, item, atRest
						;
					opts = opts || {};
					if(id){
						id = 1 * id[1];
						idx = 1 * idx[1];
						item = DOCKS[id].Elem[idx];
						atRest = item.Trans == item.Initial;
						$.each(PROPMAP, function(k, v){
								var str;
								if(opts[k]){
									str = ($.isFunction(opts[k]) ? opts[k].call(el, item[v], k) : opts[k]).toString();
									if(item[v] !== str){
										item[v] = str;
										src = (k == 'src' ? atRest : !atRest) ? v : src;
									}
								}
							});
						if(src){
							$(el).attr('src', item[src]);
						}
					}
				});
		}else{ //standard usage...
			this.not('.jqDocked').filter(function(){
					//check that no parents are already docked, and that all children are either images, or anchors containing only an image...
					return !$(this).parents('.jqDocked').length && !$(this).children().not('img').filter(function(){
							return $(this).filter('a').children('img').parent().children().length !== 1;
						}).length;
				}).hide().addClass('jqDocked') //hide it/them
				.each(function(){
					var id = DOCKS.length
						, imgOnload = function(ev){
								//store 'large' width and height...
								var dock = DOCKS[ev.data.id]
									, el = dock.Elem[ev.data.idx];
								el.height = this.height;
								el.width = this.width;
								if(++dock.Loaded >= dock.Elem.length){ //check to see if all images are loaded...
									window.setTimeout(function(){ $.jqDock.initDock(ev.data.id); }, 0);
								}
							}
						, Dock, op, jqld, i;
					//add an object to the docks array for this new dock...
					DOCKS[id] = { 
							Elem : [] // an object per img menu option
						, Menu : this //original containing element
						, OnDock : false //indicates cursor over menu and initial sizes set
						, Expanded : false //indicates completion of initial menu element expansions
						, Timestamp : 0 //set on mouseenter/leave and used (within opts.duration) to proportion the menu element sizes
						, width : 0 //width of div.jqDock container
						, height : 0 //height of div.jqDock container
						, Spread : 0 //main axis dimension (horizontal = width, vertical = height)
						, Borders : {} //border widths (main axis) on div.jqDock
						, Yard : false //jQuery of div.jqDock
						, Opts : $.extend({}, $.jqDock.defaults, opts||{}, $.metadata ? $(this).metadata() : {}) //options; support metadata plugin
						, Current : false //current image index
						, Loaded : 0 //count of images loaded
						, Inactive : null //inactivity timer
						};
					Dock = DOCKS[id]; //convenience
					op = Dock.Opts; //convenience
					jqld = (!op.loader && $.jqDock.useJqLoader) || op.loader === 'jquery';
					$.each(['size','distance','duration','inactivity','fadeIn','step'], function(k,v){ op[v] = AS_INTEGER(op[v]); });
					i = op.coefficient * 1;
					op.coefficient = isNaN(i) ? 1.5 : i;
					//set up some extra Opts now, just to save some computing power later...
					op.attenuation = Math.pow(op.distance, op.coefficient); //straightforward, static calculation
					op.orient = ({left:1, center:1, right:1}[op.align]) ? {vh:'v', inv:'h'} : {vh:'h', inv:'v'}; //orientation based on 'align' option
					op.vh = $.extend({}, VERTHORZ[op.orient.vh], {inv:VERTHORZ[op.orient.inv]}); //main and minor axis internals
					op.labels = op.labels === true ? {top:'br',left:'tr'}[op.align] || 'tl' : ((/^[tmb][lcr]$/).test(op.labels.toString()) ? op.labels : false);

					$('img', this).each(function(n, el){
							//add an object to the dock's elements array for each image...
							var jself = $(el)
								, src = jself.attr('src') //'small' image source
								, linkParent = jself.parent('a')
								;
							Dock.Elem[n] = { 
									Img : jself //jQuery of img element
								, Source : src  //image path, small
								, AltSource: (op.source ? op.source.call(el, n) : '') || ALT_IMAGE(el) || src //image path, large
								, Label : {  //label text, dimensions, user-applied padding, jQuery of label container 
										txt: jself.attr('title') || linkParent.attr('title') || '' //label text?
									, width: 0
									, height: 0
									, widthPad: 0
									, heightPad: 0
									, el: 0
									}
								, Initial : 0 //width/height when fully shrunk; it's important to note that this is not necessarily the same as Opts.size!
								, Trans : 0 //transitory width/height (main axis)
								, TransInv : 0 //transitory width/height (minor axis)
								, Final : 0 //target width/height
								, Offset : 0 //offset of 'lead' edge of the image within div.jqDock (including user-padding)
								, Centre : 0 //'Offset' + 'lead' user-padding + half 'Initial' dimension
								, Pad : {} //user-applied padding, set up below
								, Linked : !!linkParent.length //image-within-link or not
								, width : 0 //original width of img element (the one that expands)
								, height : 0 //original height of img element (the one that expands)
								};
							$.each(TRBL, function(i, v){
									Dock.Elem[n].Pad[v] = AS_INTEGER(jself.css('padding'+v));
								});
						});
					//we have to run a 'loader' function for the images because the expanding image
					//may not be part of the current DOM. what this means though, is that if you
					//have a missing image in your dock, the entire dock will not be displayed!
					//however I've had a few problems with certain browsers: for instance, IE does
					//not like the jQuery method; and Opera was causing me problems with the native
					//method when reloading the page; I've also heard rumours that Safari 2 might cope better with
					//the jQuery method, but I cannot confirm since I no longer have Safari 2.
					//
					//anyway, I'm providing both methods. if anyone finds it doesn't work, try
					//overriding with option.loader, and/or changing $.jqDock.useJqLoader for the 
					//browser in question and let me know if that solves it.
					$.each(Dock.Elem, function(i, v){
							var pre, altsrc = v.AltSource;
							if(jqld){ //jQuery method...
								$('<img />').bind('load', {id:id, idx:i}, imgOnload).attr({src:altsrc});
							}else{ //native 'new Image()' method...
								pre = new Image();
								pre.onload = function(){
										imgOnload.call(this, {data:{id:id, idx:i}});
										pre.onload = ''; //wipe out this onload function
										pre = null;
									};
								pre.src = altsrc;
							}
						});
				});
		}
		return this;
	}; //end jQuery.fn.jqDock()
} //end of if()
})(jQuery, window);
