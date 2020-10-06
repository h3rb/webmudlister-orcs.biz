#!/usr/local/bin/php
<?php
 $result=file_get_contents("result.txt");
 $names=strip_tags($result);
 $names=explode("\n",$names);
 $isolated_names=array(); $i=0;
 foreach ( $names as $name ) {
  $isolated_names[$i]=explode("[",$name);
  $isolated_names[$i]=$isolated_names[$i][0];
  $i++;
 }
 $isolated_links=array(); $i=0;
 $links=explode("\n",$result);
 foreach( $links as $link ) {
  $isolated_links[$i]=explode("\"",$link);
  $isolated_links[$i]=str_replace("&amp;","&",$isolated_links[$i][3]);
  $i++;
 }
 $total=count($isolated_names); $files=array();
 $output="";
 for ( $i=0; $i<$total; $i++ ) {
  if ( strlen(trim($isolated_names[$i])) < 1 ) continue;
  $port=0;
  $site="";
  @exec( $e="wget -q \"http://www.mudconnect.com".$isolated_links[$i]."\" --output-document=pages/" . $files[$i]=str_replace(" ","_",$isolated_names[$i]) );
  echo $e;
  $copy=$page=@file_get_contents("pages/".$files[$i]);
  if ( strpos($page,"telnet://") ) {
   $site=explode("telnet://",$page);
   $site=explode("\"", $site[1]);
   $site=$site[0];
   $port=explode(":",$site); $port=str_replace("/","",$port[1]);
   $site=explode(":",$site); $site=$site[0];
  } else continue;
  $page=$copy;
  if ( strpos($page,"homepage:" ) ) {
   $A=strpos($page,"url=http://")+strlen("url=");
   $B=strpos($page,"\"",$A);
   $web=substr( $page, $A, ($B-$A) );
   echo "----\n";
   var_dump($web);
   echo "----\n";
  } else $web="";
  $output.=($a=trim($isolated_names[$i]) . '|'
        . $site . '|'. $port . '|'
        . (strlen($web)<70? $web :"") . "\n"); echo $a;
 }
 file_put_contents("mergable.txt",$output);
?>
