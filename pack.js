var timerlen = 5;

function animatedDiv(divID, animLen) {
	this.divID = divID;
	this.animLen = animLen;
	this.divObj = document.getElementById(divID);
	if(!this.divObj.style.overflow) this.divObj.style.overflow = "hidden";
}

animatedDiv.prototype.slideIt=function() {
	(this.divObj.style.display)?this.origDisp = this.divObj.style.display:this.origDisp = "none";
	if(this.origDisp == "none") {
		this.divObj.style.opacity = 0.01;
		this.divObj.style.filter = "alpha(opacity=1)";
		this.divObj.style.display = '';
	}
	this.divHeight = this.divObj.offsetHeight;
	this.divObj.style.height = this.divHeight;
	this.divObj.style.display = this.origDisp;
	this.divObj.style.filter = "alpha(opacity=100)";
	this.divObj.style.opacity = 1;
	if(this.origDisp == "none") {
		this.slideDown();
	} else {
		this.slideUp();
	}
}

animatedDiv.prototype.slideDown=function() {
	if(this.sliding) return; //do not start moving an already moving object
	if(this.origDisp!="none") return; //do not move a visible object - sanity check
	this.sliding = true;
	this.direction = "down";
	this.startSlide();
}

animatedDiv.prototype.slideUp=function() {
	if(this.sliding) return; //do not start moving an already moving object
	if(this.origDisp == "none") return; //do not move a hidden object - sanity check
	this.sliding = true;
	this.direction = "up";
	this.startSlide();
}

animatedDiv.prototype.startSlide=function() {
	var instance = this;
	this.startTime = (new Date()).getTime();
	if(this.direction == "down" ) {
		this.divObj.style.height = "1px";
	}
	this.divObj.style.display = "block";
	this.runTimer = setInterval(function() { instance.slideTick(); },timerlen);
}

animatedDiv.prototype.slideTick=function() {
	var elapsed = (new Date()).getTime()-this.startTime;
	if(elapsed > this.animLen) 
		this.endSlide();
	else {
		var dt = Math.round(elapsed / this.animLen * this.divHeight);
		if(this.direction == "up") dt = this.divHeight - dt;
		this.divObj.style.height = dt + "px";
	}
	return;
}

animatedDiv.prototype.endSlide=function() {
	clearInterval(this.runTimer);
	if(this.direction == "up") this.divObj.style.display = "none";
	this.divObj.style.height = this.divHeight + "px";
	this.sliding=false;
	this.direction='';
	this.startTime='';
	this.runTimer='';
	return;
}
