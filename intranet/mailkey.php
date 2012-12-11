<?php 
session_start();

include("../datos/postgresHelper.php");
//require("../modules/phpmailer/class.phpmailer.php");
//require("../modules/phpmailer/class.smtp.php");

?>
<!DOCTYPE html>
<html lang='es'>
<head>
	<meta charset="utf-8" />
	<title>Mail a Proveedor</title>
	<link rel="shortcut icon" href="../ico/icrperu.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="../css/styleint.css">
	<link rel="stylesheet" type="text/css" href="../css/styleint-mail.css">
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
<?php 
$ruc = $_GET['ruc'];
$nro = $_GET['nro'];
$rz = $_GET['rz'];
$key = $_GET['key'];


$s = $_POST['save'];

if (isset($s)) {
	$asu = $_POST['txtasunto'];
	$men = $_POST['txtmen'];
	$des = $_POST['txtmail'];

 	$codigohtml = $men;
	$email = $des;
	$asunto = $asu;
	$cabeceras = 'From: logistica@icrperusa.com' . "\r\n" .
            'Reply-To: logistica@icrperusa.com' . "\r\n" .
            "Content-type: text/html\r\n".
            'X-Mailer: PHP/' . phpversion();

    ini_set ("SMTP", "smtp.gmail.com"); 
    ini_set("sendmail_from","logistica@icrperusa.com");
	date_default_timezone_set('America/Lima');

	if(mail($email,$asunto,$codigohtml,$cabeceras)){
		echo "<br /><br />";
    	echo "<label class='msg'>Enviado Correctamente!!</label>";
	}else{
		echo "<br /><br />";
    	echo "<label class='msg'>No se ha podido enviar su Correo.</label>";
	}

}else{

$msg = "Saludos Sr(s). <b>$rz</b>, hacemos llegar nuestra <b>Solicitud de Cotización</b>, el número de cotización y el key ".
		"para el ingreso a nuestra Web Site para relaizar lo solicitado.<br><br>".
		"Nro de Cotizacion: <b>".$nro."</b><br />".
		"Key Auto Generado: <b>".$key."<b><br><br>".
		"Ir a nuestra Web Site: <a href='http://190.41.246.91/web-cotiza/'>IR a PAGINA</a>".
		"<br /><br /><br />".
		"--<br />".
		"Dpto. de Logistica<br />".
		"<b>ICR PERU S.A.</b><br />".
		"Central: 51 1 371-0443<br />".
		"logistica@icrperusa.com<br />".
		"www.icrperusa.com";
?>
<form name="frm" method="POST" action="">
	<table>
		<thead>
			<tr>
			<th><button type="Submit" id="save" name="save">Enviar</button></th>
			<th>Enviar Mail a <?echo $rz;?></th>
			</tr>
		</thead>
		<tr>
			<td>From:</td>
			<td>logitica@icrperusa.com</td>
		</tr>
		<tr>
			<td>From Name:</td>
			<td>Dpto. Logistica</td>
		</tr>
		<tr>
			<td>Destinatario:</td>
			<td><input type="email" id="txtmail" name="txtmail" title="Ingrese Email del destinatario" placeholder="ejemplo@dominio.com" REQUIRED /></td>
		</tr>
		<tr>
			<td>Asunto:</td>
			<td><input type="text" id="txtasunto" name="txtasunto" title="Ingrese el Asunto a Tratar" placeholder="Asunto" REQUIRED /></td>
		</tr>
		<tr>
			<td>Menssage:</td>
			<td rowspan='2'><textarea id="txtmen" name="txtmen" REQUIRED><?echo $msg;?></textarea></td>

		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>

		<tbody>
		</tbody>
	</table>
</form>
</section>
<?php 
}
}?>
<footer>
</footer>
</body>
</html>