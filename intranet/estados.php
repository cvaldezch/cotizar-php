<?php 
session_start();
include ("../datos/postgresHelper.php");?>
<?php
$txt = $_POST['txtgen'];
if (isset($txt)) {
	$cn = new PostgreSQL();
	$query = $cn->consulta("SELECT to_char(((MAX(estid)::INTEGER)+1),'00') as cod FROM admin.estado");
	if ($cn->num_rows($query)>0) {
		$result = $cn->ExecuteNomQuery($query);
		$cn->close($query);
		$cn = new PostgreSQL();
		$query = $cn->consulta("INSERT INTO admin.estado VALUES(TRIM('".$result['cod']."'),'$txt')");
		$cn->affected_rows($query);
		$cn->close($query);
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8' />
	<title>Estados</title>
	<link rel="shortcut icon" href="../ico/icrperu.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="../css/styleint.css">
	<link rel="stylesheet" type="text/css" href="../css/styleint-estado.css">
	<script type="text/javascript" src="../ajax/ajxcboestado.js"></script>
	<script type="text/javascript" src="../js/estados.js"></script>
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
		<hgroup>
			<h3>Mantenimientos Estados</h3>
		</group>
		<div id="cuer">
			<fieldset>
				<legend>Datos Generales</legend>
			<label>Estado de :</label>
			<?php
			$cn = new PostgreSQL();
			$query = $cn->consulta("SELECT DISTINCT estid,estnom FROM admin.estado ORDER BY estnom ASC");
			?>
			
			<select id="cbogen">
				<option>--seleccione--</option>
				<?
				if ($cn->num_rows($query)>0) {
					while ($result = $cn->ExecuteNomQuery($query)) {
						echo "<option value=".$result['estid'].">".$result['estnom']."</option>";
					}
				}
				$cn->close($query);
				?>
			</select>
			<button title="Agregar Nuevo Estado" onClick="showadd();"><img src="../source/plus16.png"></button>
			<div id="estgen">
				<button title="Cerrar Nuevo Estado" onClick="hiddenadd();"><img src="../source/cerrar16.png"></button>
				<form name="frm" method="POST" action="">
				<label>Ingrese Estado General:</label><br>
				<input type="text" id="txtgen" name="txtgen" title-"Estado General" placeholder="Estado" REQUIRED />
				<button title="Guardar Estado" type="Submit"><img src="../source/floppy16.png"></button>
			</form>
			</div>
			<br>
			<label>Estado: </label>
			<input type="text" id="txtesp" name="txtesp" title="Ingrese el Nuevo estado" placeholder="Ingrese Descripcion" DISABLED REQUIRED />
			<br />
			<button title="Nuevo Estado Especifico" onClick="enaesp();"><img src="../source/plus16.png"></button>
			<button title="Cancelar" onClick="disesp();"><img src="../source/cancelar216.png"></button>
			<button id="btne" title="Guardar Estado" onClick="insest();" DISABLED ><img src="../source/floppy16.png"></button>
			</fieldset>
			<hr />
			<select id="cbogen2" onChange="estados();">
				<option>-- Seleccionar --</option>
				<?
					$cn = new PostgreSQL();
					$query = $cn->consulta("SELECT DISTINCT estid,estnom FROM admin.estado ORDER BY estnom ASC");
					if ($cn->num_rows($query)>0) {
						while ($result = $cn->ExecuteNomQuery($query)) {
							echo "<option value=".$result['estid'].">".$result['estnom']."</option>";
						}
					}
				$cn->close($query);
				?>
			</select>
			<br />
			<div id="tbl"></div>
		</div>
	</section>
	<?}?>
	<footer>
	</footer>
</body>
</html>