#!/usr/local/bin/php
<?php
 $dupes=file_get_contents("merged.txt");
 $dupes=explode("\n",$dupes);
 $output=""; $i=0; $unique=array(); $in=array();
 foreach( $dupes as $de ) { $in[$i++]=explode("|",$de); }
 $i=$j=0; $t=count($dupes);
 $d=$in;
 for( ; $j<$t; $j++ ) {
  if ( count($unique) > 0 ) {
   $found=false;
   foreach ( $unique as $u )
    if ( stristr($d[$j][0],$u[0])
      && stristr($d[$j][2],$u[2]) ) $found=true;
   if ( $found===true ) { echo "Duplicate:\n"; var_dump($d[$j]); echo "\n"; }
   else  $unique[$i++]=$d[$j]; echo 'Adding: ' . $d[$j][0] . "\n"; 
  } else $unique[$i++]=$d[$j];
 }
 foreach ( $unique as $b ) {
  $output.=implode("|",$b)."\n";
 }
 echo $i . ' unique';
 file_put_contents("unique.txt",$output);
?>
