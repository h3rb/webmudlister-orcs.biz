<?php  
  
  $address="nimud.divineright.org";
  $port=5333;

  if (isset($port) and
      ($socket=socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) and
      (socket_connect($socket, $address, $port)))
    {
      $text="Connection successful on IP $address, port $port";
      socket_close($socket);
    }
  else
    $text="Unable to connect<pre>".socket_strerror(socket_last_error())."</pre>";
    
  echo "<html><head></head><body>".
       $text.
       "</body></html>";
?>
