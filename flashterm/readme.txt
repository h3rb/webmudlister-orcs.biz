===================================================================================
Flashterm version 0.7.1 beta (10/23/09)
===================================================================================

	Flashterm is an ANSI capable telnet terminal for the web written for the Adobe 
	Flash Player plugin developed by Peter Nitsch. The client is based off the 
	AS3ANSI open source library, and is free for download/use.
	
	Reference:
	Flashterm http://www.flashterm.com 
	Peter Nitsch http://www.peternitsch.net
	AS3ANSI http://code.google.com/p/as3ansi/
	Newsletter http://lists.enthralbbs.com/listinfo/flashterm
	
	
	File contents:
	1. Installation
	2. Change Log


===================================================================================
1. INSTALLATION
===================================================================================

IMPORTANT: As of version 0.4, the width and height of Flashterm have changed. If 
you're upgrading, change the width to 650 and height to 440 in your HTML. If you're 
unsure, reference index.html in the full release.

STEP 1: Run a socket policy file server.
-----------------------------------------------------------------------------------

	Flash Player requires a policy file be served for any socket communication 
	(reference). Maxim Sprey's PHP socket server (flashsocket.php) has been 
	included in the full download as a sample server, however there are a variety 
	solutions online for other scripting languages (reference).

	Special Note: Steve Winn has developed a great Win32 policy server specific 
	for Flashterm. This is highly recommended for Windows users. Link: 
	http://www.vadvbbs.com/products/utilities/downloads/index.php#flashpolicyserver

	a. 	Ensure your version of PHP is 4 or above.

	b. 	Check that php.ini has the line extension=php_sockets.dll uncommented.

	c. 	Change the $host attribute in flashsocket.php to reflect your telnet server 
		IP (eg. $host = "192.168.1.100";)

	d. 	Open a port on your router/firewall for the socket policy server. Flash 
		Player defaults to port 843, but that can be changed by modifying the port 
		settings in flashsocket.php and settings.xml.

	e. 	Run the process (eg. php -f flashsocket.php).

	If you'd like to learn more about policy files, the following links are a good 
	place to start:
	http://moock.org/asdg/technotes/crossDomainPolicyFiles/
	http://www.adobe.com/devnet/flashplayer/articles/fplayer9_security.html

STEP 2: Configure the client.
-----------------------------------------------------------------------------------

	Edit settings.xml and change the name, address, and port attributes to the 
	appropriate values for your telnet server.

	Optional: If you'd like to change the location of your settings xml, simply add
	the following parameter to the flashvars object in your HTML:
		flashvars.settings = "mypath/mysettings.xml";

	Optional: You can add an info graphic that is displayed before the user connects
	by changing the info_graphic attribute to the appropriate JPG, GIF, or PNG 
	location. If the attribute is left blank, nothing will display.

	Optional: You can change the default font by changing the default_font attribute 
	to any of the following: 80x25, 80x50, Pot Noodle, Topaz. If the attribute is 
	left blank, 80x25 will display.

STEP 3: Deploy.
-----------------------------------------------------------------------------------

	Copy the files to your web server.


===================================================================================
2. CHANGE LOG
===================================================================================

0.7.1b
	- 	fixed linux compatibility.

0.7b
	- 	rewrote scroll drawing mechanics to closer simulate terminal emulation.
	-	implemented vt100 screen scroll escape sequence: <ESC>[{start};{end}r
	-	externalized columns and lines for better customization (defaults to 80x25
		if no entries are provided).
	- 	enabled URL downloads with new custom escape sequences engine (more
		information online).
	
0.6b
	- 	fixed Device Report escape sequences resolving the ANSI detection problem
		with Enthral BBS and other systems looking for cursor positions.
	- 	fixed several cursor repositioning bugs that involved saving and restoring
		cursor positions.
	- 	changed download speeds to 300, 2400, 14.4k, and 56k (default)

