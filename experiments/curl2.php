<?php 

function domain_check($domain,$port) { 

$data = "http://$domain:$port"; 

// Create a curl handle to a non-existing location 
$ch = curl_init($data); 

// Execute 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_exec($ch); 

// Check if any error occured 
if(curl_errno($ch)) 
{ 
    return '<span style="color:#22c922">The domain is active!</span>'; 
} else { 
    return '<span style="color:#c92222">The domain is not active</span>'; 
} 

// Close handle 
curl_close($ch); 
} 

echo domain_check("nimud.divineright.org",5333);
?> 

