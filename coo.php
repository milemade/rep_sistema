<?php
$visitas = $visitas + 1;
setcookie("visitas",$visitas,time() +3600*24*365);
?>

<html>
<body>
<?php
if ($visitas > 1 )
{
echo ("Esta es tu visita número $visitas.");
} else {
echo ("Bienvenido, esta es la primera vez que visitas esta pagina");
}
?>

</body>
</html>