<?php
 $file=file_get_contents( "big.txt" );
 $list=explode("\n",$file);
 $converted=array();
 $i=0; foreach ( $list as $l ) { $converted[$i]=explode("|",$l); $converted[$i][4]=0; $converted[$i]=implode("|",$converted[$i]); $i++; }
 file_put_contents( "big.txt", implode("\n",$converted) );
?>
