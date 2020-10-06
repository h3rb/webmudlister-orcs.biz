<?php

 require('config.php');
 require('html.php');

 echo html( "html/pagestart.html" );
 if ( $_GET['graveyard'] == 'yes' ) $list=explode("\n",file_get_contents( GRAVEYARD ));
 else $list=explode("\n",file_get_contents( MUDLIST ) );
 $total=count($list)-1;
 echo html( "html/listheader.html", array("###","#total#"), array( $_GET['graveyard'] == 'yes' ? GRAVEYARD_TITLE : MUDLIST_TITLE , $total ) );

 if ( $_GET['graveyard'] == 'yes' ) {
//  if (SORT_AZ) sort($list);
  echo '<table>';
  $id=0;
  foreach ( $list as $item ) if (strlen($item) >= 1) {
   $item=explode("|",$item);
   echo '<tr><td><b><a href="grave.php?id=' . $id . '">' . $item[0] . '</a> (R.I.P.)</b></td><td>' . $item[1] . ' ' . $item[2]  . '<td>Died: ' . date("r",intval($item[4])) . '</td></tr>';
   $id++;
  }
  echo '</table>';
 }
 else {
  if (SORT_AZ) sort($list);
  echo '<table>';
  $id=0;
  foreach ( $list as $item ) {
   $item=explode("|",$item);
   echo '<tr><td><a href="mud.php?id=' . $id . '">' . $item[0] . '</a></td><td>' . $item[1] . ' ' . $item[2] . '</td><td><a target="_blank" href="' . $item[3] . '">' . $item[3] . '</a></td></tr>';
   $id++;
  }
  echo '</table>';
 }

 echo '<hr size=1>';
 if ( !file_exists( "cache/lock.file" ) ) echo html( "html/form.html" );
 else echo '<br>Service is undergoing maintenance.  If you want to add one, check back in an hour. ';
 echo html( "html/pageend.html" );

?>
