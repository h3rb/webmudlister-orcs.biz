<?php

echo '<html><head></head><body>';
echo '<pre>';

$host="nimud.divineright.org";
$port=5333;

//Function reading the flow
function grab($flux)
{
// waiting the first char
$incoming = false;//fgetc($flux);
while (!$incoming) $incoming = fgetc($flux);
//$Output = $incoming;

//Reading next chars
$Output = fread($flux, 8192);
fclose($Output);
//Replace the carriage return
$Output = str_replace("\n", " ", $Output);
return $Output;
}


$Socket = pfsockopen($host, $port);

if (! $Socket)
{
echo 'Connection refused : <br>';
echo posix_strerror($Socket) . '<br>';
}
else
{

echo grab($Socket);
echo grab($Socket);

//Writing the order
//fputs($Socket, #Command "\r");
//echo lisflux($Socket);//
}

echo '</pre>';
echo '</body>';

?>
