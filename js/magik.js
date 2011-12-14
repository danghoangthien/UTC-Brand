// JavaScript Document
  /////////////////////////////////////////////////////////////////////////////
 /////////////////////////   Magic Animation 1.0   ///////////////////////////
/////////////////////////////////////////////////////////////////////////////

// Animation styles used in Magic /////////////////////////////////////////////

function styleLinear(x) { return x; }
function styleSin(x) { return Math.sin(x*Math.PI/2); }
function stylePulse(x) { return (Math.sin(x*2*Math.PI) + 1) / 2; }
function styleBounce(x) { return (x == 0) ? 0 : (((-Math.sin(x*25)/(x*25))+1)*(1-x))+x; }
function styleBounceLess(x) { return (x == 0) ? 0 : (((-Math.sin(x*15)/(x*15))+1)*(1-x))+x; }
function styleBounceMore(x) { return (x == 0) ? 0 : (((-Math.sin(x*35)/(x*35))+1)*(1-x))+x; }

// Magic Animation Core ///////////////////////////////////////////////////////

magic = new function ()
{
	this.effects = [];
	this.interval;
	this.frequency = 30;
	
	this.remove = function(effect)
	{
		var i = 0;
		while (i < this.effects.length) 
			if (this.effects[i] == effect) 
				this.effects.splice(i, 1);
			else i++;
				
		if (this.effects.length == 0) 
			window.clearInterval(this.interval);
	}
	
	this.tick = function()
	{
		for (var i=0; i<this.effects.length; i++)			
			this.effects[i].tick();
	}

	this.add = function(effect)
	{
		this.effects.push(effect);
		if (this.effects.length == 1)
			this.interval = window.setInterval(function() {magic.tick();}, this.frequency);	
	}
}


function effectObject(elementId, ticksToStart, speed, action, style, loop, coAction, endAction) 
{		
	this.elementId = elementId;
	this.ticksToStart = (ticksToStart == undefined) ? 0 : ticksToStart;
	this.speed = speed;
	this.now = 0;
	this.action = action;
	this.coAction = coAction;
	this.endAction = endAction;
	this.loop = (loop == undefined) ? false : loop;
	this.style = (style == undefined) ? styleSin : style;
	this.tick = function()
	{
		if (this.ticksToStart > 0)
		{
			this.ticksToStart--;
			return;
		}
		
		if (this.now > 100)
		{
			if (this.loop)
				this.now = 0;
			else
			{
				magic.remove(this);				
				if (this.endAction != undefined) 
					this.endAction();
			}
		}
		else
		{
			if (typeof elementId == 'string' && document.getElementById(elementId) == null)
			{
				magic.remove(this);
				return;
			}			
			this.action();
			
			if (this.coAction != undefined)
				this.coAction();
			
			this.now += this.speed;
			if (this.now > 100) this.now = 101;			
		}
	}
	
	magic.add(this);
}

// Magic Effects //////////////////////////////////////////////////////////////


function changeNumber(element, what, suffix, value1, value2, speed, ticksToStart, style, loop, coAction, endAction)
{
	action = function()
	{
		this.element.style[this.what] = Math.round(this.value1 + this.style(this.now/100)*(value2-value1)) + suffix;
	}
	effect = new effectObject(element, ticksToStart, speed, action, style, loop, coAction, endAction);
	effect.element = (typeof element == 'string') ? document.getElementById(element) : element;
	effect.what = what;
	effect.value1 = value1;
	effect.value2 = value2;
}

function fade(element, opacity1, opacity2, speed, ticksToStart, style, loop, coAction, endAction)
{
	action = function()
	{		
		this.element.style.opacity = this.opacity1 + this.style(this.now/100) * (this.opacity2-this.opacity1);
		this.element.style.filter = "alpha(opacity=" + this.element.style.opacity*100 + ")";
	}
	effect = new effectObject(element, ticksToStart, speed, action, style, loop, coAction, endAction);
	effect.element = (typeof element == 'string') ? document.getElementById(element) : element;
	effect.opacity1 = opacity1;
	effect.opacity2 = opacity2;
}

function move(element, top1, left1, top2, left2, speed, ticksToStart, style, loop, coAction, endAction)
{	
	changeNumber(element, "top", "px", top1, top2, speed, ticksToStart, style, loop, coAction, endAction);
	changeNumber(element, "left", "px", left1, left2, speed, ticksToStart, style, loop);
}

function scale(element, width1, height1, width2, height2, speed, ticksToStart, style, loop, coAction, endAction)
{
	changeNumber(element, "width", "px", width1, width2, speed, ticksToStart, style, loop, coAction, endAction);
	changeNumber(element, "height", "px", height1, height2, speed, ticksToStart, style, loop);
}

function morph(element1, element2, width1, height1, width2, height2, speed, ticksToStart, style, loop, coAction, endAction)
{
	scale(element1, width1, height1, width2, height2, speed, ticksToStart, style, loop, coAction, endAction);
	scale(element2, width1, height1, width2, height2, speed, ticksToStart, style, loop);
	fade(element1, 1, 0, speed, ticksToStart, style, loop);
	fade(element2, 0, 1, speed, ticksToStart, style, loop);
}

 /////////////////////////  (c) Miso Antonic 2007  ///////////////////////////