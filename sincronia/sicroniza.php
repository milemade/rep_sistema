<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Documento sin t&iacute;tulo</title>
</head>

<?
incremento_contador();

function incremento_contador()
{
// $archivo contiene el numero que actualizamos
$contador = 0;

$archivo_leer="http://globater.com/sistema/sincronia/leer.txt"; // url de la pagina que queremos obtener   para leer
$archivo_borrar="ftp://glob1843:Manager1@ftp.globater.com/sistema/sincronia/leer.txt"; // url de la pagina que queremos obtener  
$fp = fopen($archivo,"r"); 


$file = @fopen($archivo_leer, 'r');  
if($file){  
  while(!feof($file)) {  
    $url_content .= @fgets($file, 4096);  
  }  
  fclose ($file);  
}  

echo $url_content;





//fpassthru($fp);
//echo unlink($archivo); // borro el archivo
exit;
//Abrimos el archivo y leemos su contenido
//$fp = fopen($archivo,"a+"); 
//$contador = fgets($fp, 26); 
//fclose($fp);

//Incrementamos el contador
$contador++;

//Actualizamos el archivo con el nuevo valor
echo $fp = fopen($archivo,"w"); 
fwrite($fp, "leo"); 
fclose($fp); 

//echo "Este script ha sido ejecutado $contador veces"; 
}

exit;



//$url="http://globater.com/sistema/sincronia/leer.txt"; // url de la pagina que queremos obtener   para leer
$url="ftp://glob1843:Manager1@ftp.globater.com/sistema/sincronia/leer.txt"; // url de la pagina que queremos obtener  
$url_content = '';  
echo $file = @fopen($url, 'r');  
if($file){  
  while(!feof($file)) {  
    $url_content .= @fgets($file, 4096);  
  }  
  fclose ($file);  
}  

echo $url_content;

//listar_directorios_ruta("");

function listar_directorios_ruta($ruta){ 
   // abrir un directorio y listarlo recursivo 
   if (is_dir($ruta)) { 
      if ($dh = opendir($ruta)) { 
         while (($file = readdir($dh)) !== false) { 
            //esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio 
            //mostraría tanto archivos como directorios 
            //echo "<br>Nombre de archivo: $file : Es un: " . filetype($ruta . $file); 
            if (is_dir($ruta . $file) && $file!="." && $file!=".."){ 
               //solo si el archivo es un directorio, distinto que "." y ".." 
               echo "<br>Directorio: $ruta$file"; 
               listar_directorios_ruta($ruta . $file . "/"); 
            } 
         } 
      closedir($dh); 
      } 
   }else 
      echo "<br>No es ruta valida"; 
} 
?>
<body>
</body>
</html>
<?
/*file_exists ('archivo.xxx');
fopen ('archivo.xxx','r'); 

if (file_exists("mifichero.txt")){ 
   echo "El fichero existe. Lo abro"; 
   $reffichero = fopen("mifichero.txt", "a"); 
}else{ 
   echo "El fichero no existe. Lo creo y abro."; 
   $reffichero = fopen("mifichero.txt", "w+"); 
} 
*/?>