function MM_swapImgRestore() {
	var i,x,a=document.MM_sr; 
	for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() {
	var d=document; if(d.images) { 
		if(!d.MM_p) d.MM_p=new Array();
		var i,j=d.MM_p.length,a=MM_preloadImages.arguments; 
		for(i=0; i<a.length; i++) {
			if (a[i].indexOf("#")!=0) 
			{ 
				d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];
			}
		}
	}
}

function MM_findObj(n, d) {
	var p,i,x;  
	if(!d) d=document; 
	if((p=n.indexOf("?"))>0&&parent.frames.length) {
		d=parent.frames[n.substring(p+1)].document; 
		n=n.substring(0,p);
	}
	if(!(x=d[n])&&d.all) x=d.all[n]; 
	for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
	if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_swapImage() {
	var i,j=0,x,a=MM_swapImage.arguments; 
	document.MM_sr=new Array; 
	for(i=0;i<(a.length-2);i+=3) {
		if ((x=MM_findObj(a[i]))!=null) {
			document.MM_sr[j++]=x; 
			if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];
		}
	}
}

var uniquepageid=window.location.href.replace("http://"+window.location.hostname, "").replace(/^\//, "") //get current page path and name, used to uniquely identify this page for persistence feature

function animatedcollapse(divId, animatetime, persistexpand, initstate) {
	this.divId=divId
	this.divObj=document.getElementById(divId)
	this.divObj.style.overflow="hidden"
	this.timelength=animatetime
	this.initstate=(typeof initstate!="undefined" && initstate=="block")? "block" : "contract"
	this.isExpanded=animatedcollapse.getCookie(uniquepageid+"-"+divId) //"yes" or "no", based on cookie value
	this.contentheight=parseInt(this.divObj.style.height)
	var thisobj=this
	if (isNaN(this.contentheight))	{ //if no CSS "height" attribute explicitly defined, get DIV's height on window.load
		animatedcollapse.dotask(window, function(){thisobj._getheight(persistexpand)}, "load")
		if (!persistexpand && this.initstate=="contract" || persistexpand && this.isExpanded!="yes" && this.isExpanded!="") //Hide DIV (unless div should be expanded by default, OR persistence is enabled and this DIV should be expanded)
		this.divObj.style.visibility="hidden" //hide content (versus collapse) until we can get its height
	}
	else if (!persistexpand && this.initstate=="contract" || persistexpand && this.isExpanded!="yes" && this.isExpanded!="") //Hide DIV (unless div should be expanded by default, OR persistence is enabled and this DIV should be expanded)
		this.divObj.style.height=0 //just collapse content if CSS "height" attribute available
	if (persistexpand)
		animatedcollapse.dotask(window, function(){animatedcollapse.setCookie(uniquepageid+"-"+thisobj.divId, thisobj.isExpanded)}, "unload")
}

animatedcollapse.prototype._getheight=function(persistexpand){
	this.contentheight=this.divObj.offsetHeight
	if (!persistexpand && this.initstate=="contract" || persistexpand && this.isExpanded!="yes"){ //Hide DIV (unless div should be expanded by default, OR persistence is enabled and this DIV should be expanded)
		this.divObj.style.height=0 //collapse content
		this.divObj.style.visibility="visible"
	}
	else //else if persistence is enabled AND this content should be expanded, define its CSS height value so slideup() has something to work with
	this.divObj.style.height=this.contentheight+"px"
}

animatedcollapse.prototype._slideengine=function(direction){
	var elapsed=new Date().getTime()-this.startTime //get time animation has run
	var thisobj=this
	if (elapsed<this.timelength){ //if time run is less than specified length
		var distancepercent=(direction=="down")? animatedcollapse.curveincrement(elapsed/this.timelength) : 1-animatedcollapse.curveincrement(elapsed/this.timelength)
		this.divObj.style.height=distancepercent * this.contentheight +"px"
		this.runtimer=setTimeout(function(){thisobj._slideengine(direction)}, 10)
	}
	else{ //if animation finished
		this.divObj.style.height=(direction=="down")? this.contentheight+"px" : 0
		this.isExpanded=(direction=="down")? "yes" : "no" //remember whether content is expanded or not
		this.runtimer=null
	}
}

animatedcollapse.prototype.slidedown=function(){
	if (typeof this.runtimer=="undefined" || this.runtimer==null){ //if animation isn't already running or has stopped running
		if (isNaN(this.contentheight)) //if content height not available yet (until window.onload) 
			alert("Please wait until document has fully loaded then click again")
		else if (parseInt(this.divObj.style.height)==0){ //if content is collapsed
			this.startTime=new Date().getTime() //Set animation start time
			this._slideengine("down")
		}
	}
}

animatedcollapse.prototype.slideup=function(){
	if (typeof this.runtimer=="undefined" || this.runtimer==null){ //if animation isn't already running or has stopped running
		if (isNaN(this.contentheight)) //if content height not available yet (until window.onload)
			alert("Please wait until document has fully loaded then click again")
		else if (parseInt(this.divObj.style.height)==this.contentheight){ //if content is expanded
			this.startTime=new Date().getTime()
			this._slideengine("up")
		}
	}
}

animatedcollapse.prototype.slideit=function(){
	if (isNaN(this.contentheight)) //if content height not available yet (until window.onload)
		alert("Please wait until document has fully loaded then click again")
	else if (parseInt(this.divObj.style.height)==0)
		this.slidedown()
	else if (parseInt(this.divObj.style.height)==this.contentheight){
		this.slideup()
	}
}

// -------------------------------------------------------------------
//
//// A few utility functions below:
//
//// -------------------------------------------------------------------
//
//
animatedcollapse.curveincrement=function(percent){
	return (1-Math.cos(percent*Math.PI)) / 2 //return cos curve based value from a percentage input
}

animatedcollapse.dotask=function(target, functionref, tasktype) { //assign a function to execute to an event handler (ie: onunload)
	var tasktype=(window.addEventListener)? tasktype : "on"+tasktype
	if (target.addEventListener)
		target.addEventListener(tasktype, functionref, false)
	else if (target.attachEvent)
		target.attachEvent(tasktype, functionref)
}

animatedcollapse.getCookie=function(Name) { 
	var re=new RegExp(Name+"=[^;]+", "i"); //construct RE to search for target name/value pair
	if (document.cookie.match(re)) //if cookie found
	return document.cookie.match(re)[0].split("=")[1] //return its value
	return ""
}

animatedcollapse.setCookie=function(name, value){
	document.cookie = name+"="+value
}

function changeArrows(imgId) {
	this.imgId=imgId
	this.imgSrc=imgId.getElementById(imgId).src
	if ( this.imgSrc.indexOf("right_arrow") > 0 ) {
		this.imgSrc="images/up_arrow.png"
	}
	else {
		this.imgSrc="images/right_arrow.png"
	}
}

function addFilter(filDiv) {
	document.getElementById(filDiv).style.display="block";
}

function removeFilter(filDiv) {
	document.getElementById(filDiv).style.display="none";
}

function toggleDisplay() {
	for(i=0;i<arguments.length;i++) {
		if ( document.getElementById(arguments[i]).style.display=="none" ) {
			document.getElementById(arguments[i]).style.display="block";
		} else {
			document.getElementById(arguments[i]).style.display="none";
		}
	}
}

function getFilters(fil_list,frmName) {
	var filterList=fil_list.split(",");
	var selFilters="";
	for(i=0;i<filterList.length;i++) {
		if ( document.getElementById(filterList[i]).style.display=="block" ) {
			selFilters = selFilters + filterList[i] + ",";
		}
	}
	document.forms[frmName].innerHTML = document.forms[frmName].innerHTML + "<input type=hidden name=filters value='" + selFilters +"'>";
	document.forms[frmName].innerHTML = document.forms[frmName].innerHTML + "<input type=hidden name=duplss value='" + document.getElementById("keyword").value +"'>";
	document.forms[frmName].innerHTML = document.forms[frmName].innerHTML + "<input type=hidden name=duplsc value='" + document.getElementById("category").value +"'>";
	document.forms[frmName].submit();
}

function restoreSearch(search_string, search_category) {
	document.getElementById("keyword").value=search_string;
	for (i=0;i<document.getElementById("category").options.length;i++) {
		if(document.getElementById("category").options[i].value==search_category) {
			document.getElementById("category").selectedIndex=i;
			break;
			}
		}
}

function restoreFilters(filters) {
	var filterids=filters.split(",");
	for(i=0;i<filterids.length;i++) {
		if ( document.getElementById(filterids[i]).style.display=="none") {
			document.getElementById(filterids[i]).style.display="block";
		}
	}
}

function toggleTabClass(btn,frm) {
	for(i=0;i<frm.elements.length;i++) {
		if(frm.elements[i].name==btn.name) {
			frm.elements[i].className="tabActive";
		} else {
			frm.elements[i].className="tab";
		}
	}
}

function setState(btn,frm) {
	for(i=0;i<document.forms[frm].elements.length;i++) {
		if(document.forms[frm].elements[i].name==btn) {
			document.forms[frm].elements[i].className="tabActive";
		} else {
			document.forms[frm].elements[i].className="tab";
		}
	}
}

function submitForm(btn,frm) {
	frm.innerHTML = frm.innerHTML + "<input type=hidden name="+btn+" value='1'>";
	frm.submit();
}

function adminForm(btn,frm) {
	frm.innerHTML = frm.innerHTML + "<input type=hidden name='page' value="+btn+">";
	frm.submit();
}

function trim(toTrim) {
	return toTrim.replace(/^\s+|\s+$/g,"");
}

function validateForm(frm) {
	if(frm.name=="login") {
		if(trim(frm.uname.value)!="" && trim(frm.pword.value)!="") {
			return true;
		} else {
			if(trim(frm.uname.value)=="") {
				alert("Username cannot be empty");
				return false;
			} 
			if(trim(frm.pword.value)=="") {
				alert("Password cannot be empty");
				return false;
			}
		}
	}
	if(frm.name=="adduser") {
		if(trim(frm.add_seluser.value)!="dummy" && trim(frm.add_uname.value)!="" && trim(frm.add_pword.value)!="") {
			return true;
		} else {
			if(trim(frm.add_seluser.value)=="dummy") {
				alert("Please pick a user");
				return false;
			}
			if(trim(frm.add_uname.value)=="") {
				alert("Username cannot be empty");
				return false;
			}
			if(trim(frm.add_pword.value)=="") {
				alert("Password cannot be empty");
				return false;
			}
		}
	}
	if(frm.name=="edituser") {
		if(trim(frm.edit_seluser.value)!="dummy") {
			return true;
		} else {
			if(trim(frm.edit_seluser.value)=="dummy") {
				alert("Please pick a user");
				return false;
			}
		}
	}
	if(frm.name=="addmember") {
		if(trim(frm.firstname.value)=="") {
			alert("Firstname cannot be empty");
			return false;
		}
		if(trim(frm.lastname.value)=="") {
			alert("Lastname cannot be empty");
			return false;
		}
		myCurr = -1;
		for (i=frm.curr.length-1; i > -1; i--) {
			if (frm.curr[i].checked) {
				myCurr = i; i = -1;
			}
		}
		if (myCurr == -1) {
			alert("Please check either yes or no for 'Current'");
			return false;
		}
		myPubl = -1;
		for (i=frm.haspubl.length-1; i > -1; i--) {
			if (frm.haspubl[i].checked) {
				myPubl = i; i = -1;
			}
		}
		if (myPubl == -1) {
			alert("Please check either yes or no for 'Current'");
			return false;
		}
		if(trim(frm.designation.value)=="dummy") {
			alert("Please pick a designation");
			return false;
		}
		return true;
	}
	if(frm.name=="search") {
		if(trim(frm.keyword.value)!="") {
			return true;
		} else {
			alert("Please enter keyword(s) to initiate search");
			return false;
		}
	}
}

function loginError(uname,yrn) {
	document.forms['login'].elements['uname'].value = uname;
	if(yrn == "y") {
		document.getElementById("uimg").src = "images/cross.png";
	} else {
		document.getElementById("uimg").src = "images/tick.png";
		document.getElementById("pimg").src = "images/cross.png";
		document.getElementById("verpass").style.display = "block";
	}
	document.getElementById("veruser").style.display = "block";
}

function showUserbar(uname,divId) {
	document.getElementById(divId).style.display='block';
	var utext = document.getElementById('cuser');
	utext.innerHTML = "Current User : <strong>" + uname + "</strong>";
}

function confirmRemove() {
	var answer = confirm('Is it ok to remove this member?');
	if(answer) return true;
	return false;
}

function showMember(catID, divID, frmName) {
	document.forms[frmName].innerHTML = document.forms[frmName].innerHTML + "<input type=hidden name=memid value=" + catID + ">";
	document.forms[frmName].innerHTML = document.forms[frmName].innerHTML + "<input type=hidden name=divid value=" + divID + ">";
	document.forms[frmName].submit();
}

/*function addAuthor(divID,aNo) {
	var dID = document.getElementById(divID);
	var authNo = parseInt(aNo) + 1;
	dID.innerHTML += "<br><select name=selauth"+authNo+" class=dropdown><option value=dummy />Chosen One...</select> / ";
	dID.innerHTML += "<input type=text class=keyword name=auth"+authNo+" value=\"\">";
	dID.innerHTML += "<input type=button class=button name=addauth"+authNo+" value=\"Add Another\" onclick=\"addAuthor('authors',"+authNo+")\">";
	document.getElementById('addauth'+parseInt(aNo)).style.display="none";
}*/

function pickdate(month, day, year, tdiv) {
	if (tdiv == "es") {
		document.forms['subnewevent'].esdate.value = month+'-'+day+'-'+year;
		document.getElementById('sdate').style.display = "none";
	} else {
		if(document.forms['subnewevent'].esdate.value != "") {
			var sdate = document.forms['subnewevent'].esdate.value;
			var sdatearr = sdate.split("-");
			if(parseInt(month)<parseInt(sdatearr[0]) || parseInt(day)<parseInt(sdatearr[1]) || parseInt(year)<parseInt(sdatearr[2])) {
				alert(month+'-'+day+'-'+year+' : Event cannot end before starting');
				return false;
			} else {
				document.forms['subnewevent'].eedate.value = month+'-'+day+'-'+year;
				document.getElementById('edate').style.display = "none";
			}
		} else {
			alert('Please set start date first');
			document.forms['subnewevent'].eedate.value = "";
			document.getElementById('edate').style.display = "none";
			return false;
		}
	}
}

function repeatEvent(divID, freq) {
	var divElem = document.getElementById(divID);
	if(freq == "once" && divElem.style.display == "inline") {
		divElem.style.display = "none";
	} else if(freq == "repeat" && divElem.style.display == "none") {
		divElem.style.display = "inline";
	}
}

function visInfo(divID, vtype) {
	var divElem = document.getElementById(divID);
	if(vtype == "public" && divElem.style.display == "inline") {
		divElem.style.display = "none";
	} else if(vtype == "private" && divElem.style.display == "none") {
		divElem.style.display = "inline";
	}
}
