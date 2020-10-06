<?php
 include '../config.php';
 include '../banner.php';
 include '../atomic.php';
 echo 'Begin . . . ';
 function mud_in_list( $name, $host, $resolved, $port, $site, $item ) {
  $ip1=$resolved;;
  $ip2=$item['host'];
//  if ( strlen($name) < 1 || strlen($item[0]) < 1 ) return true;
//  if ( !strcmp($name,$item[0]) ) return true;
  if ( (($ip1==$ip2)||strtolower(trim($host))==strtolower(trim($item[1]))) && intval($port) == intval($item[2]) ) return true;
  return false;
 }
 echo "Loading file import.txt\n";
 $importing=file_get_contents( "import.txt" );
 $importing=explode("\n",$importing);
 $in=array(); $i=0;
 echo 'Exploding from file...';
 foreach ( $importing as $import ) {
  $in[$i]=array();
  $in[$i]=explode("|",$import);
  $in[$i]['host']=gethostbyname($in[1]);
  $i++;
 }
 echo 'Importing from big.txt...';
 $validated=file_get_contents( "../lists/big.txt" );
 $validated=explode("\n",$validated);
 $valid=array();
 echo 'Exploding and gathering hosts for validated list...';
 $duplicates=0;
 $i=0; foreach ( $validated as $v ) { $valid[$i]=explode("|",$v); $valid[$i]['host']=gethostbyname($valid[$i][1]); $i++; }
 $failures=$imported=""; 
 echo "Importing:\n";
 foreach ( $in as $m ) {
  $found=false;
  echo 'Searching...';
  foreach( $valid as $item ) {
   if ( mud_in_list( $m[0], $m[1], $m['host'], $m[2], "", $item ) ) { $res="ALREADY"; echo 'Duplicate; '; $found=true; $duplicates++; break; }
  }
  if ( $found ) continue;
  echo "Unique! Validating: ";
  echo ($res=mud_validate( $m[1], $m[2], true ));
  if ( !($res === true)  && ( $res == "NONE" || $res=="ALREADY" || $res=="NOLIST" || $res=="BADHOST" || $res=="NONE" )  )
  { $failures.=$m[1].' '.$m[2].' '.$m[3].' '.$res."\n"; file_put_contents("fails.txt",$failures); echo "Failed to find host\n"; } else {
   $imported.=($a=$m[0].'|'.$m[1].'|'.$m[2]."||0\n"); echo $a; echo "  Imported.\n";
   file_put_contents_atomic( "cache/" . $m[1] .'.'. $m[2], $res );
  }
 }

 echo "\n";
 echo $duplicates . ' ignored';
 echo 'Writing merged.txt list...'."\n";
 file_put_contents_atomic( "merged.txt", implode("\n",$validated) . $imported );
?>
