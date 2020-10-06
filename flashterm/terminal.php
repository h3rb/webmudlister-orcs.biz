<?php
require_once('../config.php');
require_once('../atomic.php');
function flashterm( $name, $host, $port, $font="Topaz" ) {
 $xml="<connection 
	name=\"$name\" 
	address=\"$host\" 
	port=\"$port\" 
	socket_server_port=\"".FLASH_PORT."\"  
	info_graphic=\"\"
	default_font=\"$font\"
	columns=\"80\"
	lines=\"50\"/>
<!--
Optional attributes:
info_graphic - URL of JPG, PNG, or GIF (eg. images/info.png)
default_font - 80x25, 80x50, Pot Noodle, or Topaz
-->";
 file_put_contents_atomic( "settings.xml", $xml );
 return '<script type="text/javascript" src="swfobject.js"></script>
<script type="text/javascript"> var flashvars = {}; var params = {}; var attributes = {};
params.menu = "false"; params.bgcolor = "000000";
swfobject.embedSWF("flashterm.swf", "flash", "650", "440", "9.0.115", "expressInstall.swf", flashvars, params, attributes);
function setFocusOnFlash() { var fl = document.getElementById("flash"); fl.focus(); }
swfobject.addLoadEvent(setFocusOnFlash);</script>';
}
?>
