<?php
 include_once 'config.php';
 include_once 'atomic.php';
 include_once 'banner.php';
 include_once 'html.php';
 $muds=explode("\n",file_get_contents( "lists/big.txt" ));
 $digest="";
 foreach ($muds as $m) {
  if ( trim(strlen($m)) < 1 ) continue;
  $m=explode("|",$m);
  if ( !file_exists( "cache/".$m[1].'.'.$m[2] ) ) file_put_contents( "cache/".$m[1].'.'.$m[2], mud_validate($m[1],$m[2]) );
  $s=@stat("cache/".$m[1].'.'.$m[2]);
  $d="\n <small>Added: " . date("r",$s[9]) . "</small> |" . (intval($m[4])==0 ? "<i>Verified last night</i>" : "Last connected: " . date("r",intval($m[4]))) . "<br>\n" ;
  $digest.="\n\n<hr size=1><h1>$m[0]</h1>\n"
         .$d
         ."<br><br><center>telnet://$m[1]:$m[2]\n$m[3]\n<br>\n" . ansiout($m) . '</center><br>' ;
 }
 echo html( "html/pagestart.html", array( "digest<", "###" ), array( "<", "css/mud.css" ) );
 echo $digest;
 echo html( "html/pageend.html" );
?>
