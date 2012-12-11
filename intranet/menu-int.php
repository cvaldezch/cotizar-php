<?php 
session_start();
?>
<!DOCTYPE html>
<html lang='es'>
<head>
	<meta charset='utf-8' />
	<title>Bienvenido a la Intranet ICR PERU</title>
	<link rel="shortcut icon" href="../ico/icrperu.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="../css/styleint.css">
	<link rel="stylesheet" type="text/css" href="../css/styleint-menu.css">
	<link href="http://fonts.googleapis.com/css?family=Finger+Paint" type="text/css" rel="stylesheet" />
	<link href="http://fonts.googleapis.com/css?family=Redressed" type="text/css" rel="stylesheet" />
</head>
<body>
	<div id="cu">
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
<header>
<h1>ICR PERÚ S.A.</h1>
</header>
<?php if ($_SESSION['accessi']==true) {?>
<section>
		<nav>
			<li class="lihome"><a href="menu-int.php"><img src="../source/inicio48.png"><span class="home">Inicio</span></a></li>
			<li class="parent"><a href=""><img src="../source/cotiza48.png"><span class="coti">Cotizacion</span></a>
				<ul>
					<li><a href="cotizacion.php"><img src="../source/cot48.png"><span>Cotizacion</span></a></li>
					<li><a href="cotcalc.php"><img src="../source/excel32.png"><span>Cotizacion con Excel</span></a></li>
					<li><a href="viewkey.php"><img src="../source/llave32.png"><span>Ver Keygens</span></a></li>
					<li><a href="compararcot.php"><img src="../source/solti48.png"><span>Comparar Cotizacion</span></a></li>
				</ul>
			</li>
			<li class="limant"><a href=""><img src="../source/mant48.png"><span class="mant">Mantenimiento</span></a>
				<ul>
					<li><a href=""><img src="../source/png"><span>Proyectos</span></a></li>
					<li><a href="estados.php"><img src="../source/mago48.png"><span>Estados</span></a></li>
				</ul>
			</li>
			<li class="lireport"><a href=""><img src="../source/doc32.png"><span class="report">Reporte</span></a>
				<ul>
					<li><a href=""><img src="../source/png"><span>Cotización</span></a></li>
					<li><a href=""><img src="../source/png"><span>Orden de Compra</span></a></li>
				</ul>
			</li>
			<li class="liabout"><a href=""><img src="../source/about48.png"><span class="about">About</span></a></li>
		</nav>
</section>
<?}?>
</div>
<footer></footer>
</body>
</html>