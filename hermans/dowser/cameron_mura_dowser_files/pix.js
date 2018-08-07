<!-- hide from non-JS capable browsers
//
// Cameron Mura, 09/13/2004
//
// NOTES:
//	* 09/29/2004:	Note that images must be in same dir as this pix.js, index.html, etc.
//			So if want to keep imgs in separate dirs, just symlink them to $cwd
//			(making sure that .htaccess properly set-up to follow symlinks).
// 	* 09/13/2004:   Adapted from the JavaScript I wrote for McCammon Gallery of BS 
//			(/net/home/www/htdocs/gallery/gallery.js). Primary changes were 
//			to:
//			    1)  delete the "RESTART" functionality -- unnecessary for the 
//				stills displayed on this page!
//			    2)  change background color for spawned windows to white
//
/*************** this is the JavaScript for opening example images in new windows ************************************************/ 

var browser_info = navigator.appName+" "+navigator.appVersion+" "+navigator.appCodeName+" "+navigator.platform+" "+navigator.userAgent;
var window_features = "";
var loaded_movie = new Array();
var movie_windows = new Array();


if (browser_info.search(/mozilla/i) > 0 && browser_info.search(/linux/i) > 0 ) 	// if client is a mozilla browser on linux platform then 
										// set these chingis...
        {
         var width_padding = 40;
         var height_padding = 85;
         var script_verdict = '\t<script type="text/javascript" src="pix.js"><\/script>\n';
        }
else
        {
         var width_padding = 40;
         var height_padding = 100;
         var script_verdict = '\t\n';
        }


function preloadMovie(animation_file)
{	
	var basename = getBasename(animation_file);	
        loaded_movie[basename] = new Image();
        loaded_movie[basename].src = animation_file;
        return false;
}


function getBasename(filename)
{
        var split_filename = filename.split(".");
        if (split_filename[0] != '') { var basename = split_filename[0]; } else { var basename = filename;}
        return basename;
}


function openMovie(animation_file)
{
	var basename = getBasename(animation_file);
	var width = loaded_movie[basename].width+width_padding; 
	var height = loaded_movie[basename].height+height_padding;
	var window_features = "resizable,scrollbars,width="+width+",height="+height;
	movie_windows[basename] = window.open(loaded_movie[basename].src,basename,window_features);
	movie_windows[basename].document.open();
	movie_windows[basename].document.write("<html>\n\n<head>\n\t<title>"+animation_file+"</title>\n");
	movie_windows[basename].document.write("\t<link rel='stylesheet' type='text/css' media='screen' href='cmura.css' />\n");
	movie_windows[basename].document.write(script_verdict);
	movie_windows[basename].document.write("</head>\n\n");
	movie_windows[basename].document.write("<body style=\"background-color: white\">\n\n\t<center>\n");
	movie_windows[basename].document.write("\t<img src='"+loaded_movie[basename].src+"' style='vertical-align: middle;' />\n\t<br />\n\t<br />\n");
	movie_windows[basename].document.write("\t<form>\n");
	movie_windows[basename].document.write("\t\t<input type='button' value='CLOSE window' onclick='self.close();'>&nbsp\n");
//	alert(	"browser_info.search(/mozilla/i) = " + browser_info.search(/mozilla/i) + "\n" +
//		"browser_info.search(/linux/i) = " +   browser_info.search(/linux/i) + "\n" + 
//		"browser_info.search(/rv:1.4/i) = " +  browser_info.search(/rv:1.4/i));	
	movie_windows[basename].document.write("\t</form>\n");
	movie_windows[basename].document.write("\t</center>\n\n</body>\n\n</html>");
	movie_windows[basename].document.close();
	movie_windows[basename].focus();
	return false;
}


// end hide -->
