<?php
session_start();
include("../datos/postgresHelper.php");?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset='utf-8' />
	<title>Cotizador con Excel</title>
	<link rel="stylesheet" href="../css/styleint.css">
	<script type="text/javascript" src="../js/cotcalc.js"></script>
	<script type="text/javascript" src="../ajax/ajxupcalc.js"></script>
	<style type="text/css">
	section
	{
  	background: #fefcea; /* Old browsers */
  	background: -moz-linear-gradient(top,  #fefcea 0%, #f1da36 100%); /* FF3.6+ */
  	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fefcea), color-stop(100%,#f1da36)); /* Chrome,Safari4+ */
  	background: -webkit-linear-gradient(top,  #fefcea 0%,#f1da36 100%); /* Chrome10+,Safari5.1+ */
  	background: -o-linear-gradient(top,  #fefcea 0%,#f1da36 100%); /* Opera 11.10+ */
  	background: -ms-linear-gradient(top,  #fefcea 0%,#f1da36 100%); /* IE10+ */
 	background: linear-gradient(to bottom,  #fefcea 0%,#f1da36 100%); /* W3C */
  	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fefcea', endColorstr='#f1da36',GradientType=0 ); /* IE6-9 */
  	height: 100%;
  	margin: 0 auto;
  	position: fixed;
 	 width: 100%;
	}
	</style>
</head>
<body>
	<header>
		<hgroup>
			<img src="../source/icrlogo.png">
			<div id="cab">
				<h1>Especialistas en Sistemas Contra Incendios</h1>
			</div>
		</hgroup>
	</header>
	<div id="sess">
<?if ($_SESSION['accessi']==true) {
$nom = $_SESSION['nom'];
$car = $_SESSION['cargo'];
?>
<label for="user" style="font-weight: bold;">Cargo:</label>
<label for="usuario"><?echo $car;?></label>
<label for="nom" style="font-weight: bold;">Nombre: </label>
<label for="nombre"><?echo $nom;?></label>
<br />
<label style="font-weight: bold;">Dni:</label>
<label><?echo $_SESSION['dni']?></label>
<label style="font-weight: bold;">User:</label>
<label><?echo $_SESSION['usere'];?></label>
<button id="btnclose" onclick="javascript:document.location.href = '../includes/destroy.php?int=t';">Cerrar Session</button>
<?}else{?>
<form name="frm" method="POST" action="index.php">
<label for="user">Usuario:</label>
<input type="text" id="txtuser" name="txtuser" title="Usuario" placeholder="Username" REQUIRED />
<label for="passwd">Password: </label>
<input type="Password" id="txtpwd" name="txtpwd" title="Password" placeholder="Password" REQUIRED />
<button id="btnin" type="Submit">Iniciar</button>
</form>
<a href="">Olvidaste tu Contrase?</a>
<?}?>
</div>
<?php if ($_SESSION['accessi']==true) {?>
	<section>
		<?include("includes/menu.inc");?>
		<aside>
			<select id="cbotpro" multiple>
				<?
				$cn = new PostgreSQL();
				$query = $cn->consulta("SELECT proyectoid,nompro FROM logistica.proyectos ORDER BY nompro ASC");
				if ($cn->num_rows($query)>0) {
					while ($result = $cn->ExecuteNomQuery($query)) {
						echo "<option value=".$result['proyectoid'].">".$result['nompro']."</option>";
					}
				$cn->close($query);
				}
				?>
			</select>
			<button id="btnadd" onclick="addproyecto();"> > </button>
			<button id="btndel" onclick="rmproyecto();"> < </button>
			<select id="cboprosel" multiple >
			</select>
			<button id="btnok" onclick="calc();">OK</button>
		</aside>
	<article>
		<div id="upcalc">
		</div>
		<?
function array_recibe($url_array) { 
     $tmp = stripslashes($url_array); 
     $tmp = urldecode($tmp); 
     $tmp = unserialize($tmp); 

    return $tmp; 
} 


$array=$_REQUEST['array']; 
  // el método de envio usado. (en el ejemplo un link genera un GET. En el formulario se usa POST podria ser GET tambien ...) 

$archivo = $_FILES["calc"]['name'];
if(isset($archivo)){
    //$prefijo = substr(md5(uniqid(rand())),0,6);
$ruta_destino = $_SERVER['DOCUMENT_ROOT']."/web-cotiza/tmp/";
$tot = count($_FILES["calc"]["name"]);
if ($archivo != "") {
	$count = 0;
    foreach ($_FILES["calc"]["error"] as $key => $error) { 
        if ($error == UPLOAD_ERR_OK) { //se ha subido bien 
        //Cojemos los nombres del fichero 
        $nombre_fichero=$_FILES["calc"]["name"][$key]; 
        $nombre_temporal_que_le_ha_dado_php=$_FILES["calc"]["tmp_name"][$key]; 
        //lo movemos donde queramos 
        move_uploaded_file($nombre_temporal_que_le_ha_dado_php,$ruta_destino.$nombre_fichero); 
        //es aconsejable ponerle permisos 
        chmod($ruta_destino.$nombre_fichero,0777); 
        $status = "Se subio los archivos Correctamente";
        $count++;
        }//fin del if 
        else{ 
            $status = $_FILES["imagen"]["name"][$key]." se subió mal"; 
        } 
    }

} else {
    $status = "Error al subir archivo Primero";
}

error_reporting(E_ALL ^ E_NOTICE);
require_once '../modules/excel_reader2.php';

$array=array_recibe($array); 

foreach ($array as $indice => $valor){ 
echo $indice." = ".$valor."<br>";
$data = new Spreadsheet_Excel_Reader();
$data->read($_SERVER['DOCUMENT_ROOT']."/web-cotiza/tmp/".$_FILES['calc']['name'][$indice]);

for ($fila=1; $fila <= $data->rowcount(); $fila++) {
	$cn = new PostgreSQL();
	$query = $cn->consulta("SELECT * FROM logistica.spgrabartmpcant('".$valor."','".$data->sheets[0]['cells'][$fila][1]."',".$data->sheets[0]['cells'][$fila][2].")");
	$cn->affected_rows($query);
	$cn->close($query);
}

}

}

echo "<div>";
echo "<center>";
if ($count > 0) {
$array = serialize($array);
$array = urlencode($array);
echo "<META HTTP-EQUIV='REFRESH' CONTENT=2;URL='saldomat.php?array=$array'>";
}
echo $status;
echo "</center>";
echo "</div>";
?> 
	</article>
<?}?>
</section>
	<footer>
	</footer>
</body>
</html>