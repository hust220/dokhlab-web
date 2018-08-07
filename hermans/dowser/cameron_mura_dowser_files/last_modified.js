// JavaScript for inserting last modified data of (html) files in locale timezone
// Cameron Mura (04/09/2003)
// 07/22/2004:	cleaned-up code and incorporated .toLocaleString() method on 
//		date object so as to avoid expressing as GMT times with offset
<!--
var lastmod = new Date(document.lastModified);
//var lastmod = document.lastModified   	// get string of last modified date
var lastModMillisec = Date.parse(lastmod)   	// convert modified string to date
if(lastModMillisec == 0){               // unknown date (or January 1, 1970 GMT)
	document.writeln("Last Modified: Unknown") } 
else {
//	alert(lastmod.toLocaleString())
	document.writeln("Page last touched <tt>" + lastmod.toLocaleString() + "</tt>")
}
// end of javascript -->
