<?php

 if ( !function_exists(html) ) {
 function html( $file, $keys="", $message="" ) {
  $code=file_get_contents($file);
  if ( is_array( $keys ) ) {
   $i=0;
   $messages=array();
   foreach ( $message as $m ) $messages[$i++] = $m;
   $i=0;
   foreach ( $keys as $key ) $code=str_replace( $key, $messages[$i++], $code );
  } else str_replace( $keys, $message, $code );
  return '<!--'.$file.'-->
'.$code.'
<!--end of file-->';
 }
 }

?>
