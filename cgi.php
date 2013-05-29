<?php 
$tipo_sapi = php_sapi_name(); 
if (substr($tipo_sapi, 0, 3) == 'cgi') { 
    echo "Est&aacute; usando PHP CGI\n"; 
} else { 
    echo "No est&aacute; usando PHP CGI\n"; 
} 
?>