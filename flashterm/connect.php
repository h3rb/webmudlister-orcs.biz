<?php
 require '../config.php';
 require '../html.php';
 require 'terminal.php';
 $showing=intval($_GET['id']);
 $i=0;
 $mudlist=explode( "\n", file_get_contents( '../'.MUDLIST ));
 if (SORT_AZ && !isset($_GET['submitted']) ) sort($mudlist);
 foreach ( $mudlist as $mud ) if ( $i++ == $showing ) {
  $mud=explode("|",$mud);
  echo html( "../html/pagestart.html", array("###","<!--flashterm-->","list.php"), array("../css/mud.css", flashterm($mud[0], $mud[1], $mud[2]),"../list.php") );
  echo '<center>' . $mud[0] . '</center><br>';
  echo '<div id="flash"></div>';
  echo html( "../html/pageend.html", array( "list.php" ), array( "../list.php" ) );
  die();
 }
?>
