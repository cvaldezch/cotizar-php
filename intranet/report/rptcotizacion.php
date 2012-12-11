<?php 
session_start();

include("../../datos/postgresHelper.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Reporte Cotización</title>
	<link rel="shortcut icon" href="../../ico/icrperu.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="../../css/styleint.css">
	<link rel="stylesheet" type="text/css" href="../../css/styleint2.css">
	<script type="text/javascript" src="../../js/viewkey.js"></script>
</head>
<body>
<header>
	<hgroup>
		<img src="../../source/icrlogo.png">
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
	<?include("../includes/menu.inc");?>
	<fieldset id="dgen">
		<legend>Datos Generales</legend>
		<span id="radios">
		<input type="Radio" name="rbtnb" value="n" onchange="valrbtn(this);"><label>Nro Cotizacion</label>
		<input type="Radio" name="rbtnb" value="f" onchange="valrbtn(this);"><label>Entre Fechas</label>
		</span>
		<hr />
		<form name="form1" method="POST" action="">
		<span class="nrocot">
			<label>Nro Cotizacion:</label>
			<input type="text" id="nro" name="nro" maxlength="10" style="width:110px;" title="Ingrese el Nro de Cotizacion para Buscar" placeholder="Nro Cotizacion" REQUIRED DISABLED/>
		</span>
		<span class="fec2">
			<label>Fecha Inicio:</label>
			<input type="date" id="fecini" maxlength="8" style="width:90px;" name="fecini" REQUIRED DISABLED/>
			<label> &nbsp;&nbsp; </label>
			<label>Fecha Fin: </label>
			<input type="date" id="fecfin" maxlength="8" style="width:90px;" name="fecfin" REQUIRED DISABLED/>
		</span>
		<br>
		<button type="Submit">Buscar</button>
		</form>
	</fieldset>
	<div>
		<? 
		$nro = $_POST['nro'];
		$fini = $_POST['fecini'];
		$ffin = $_POST['fecfin'];
		if (isset($nro) || isset($fini) && isset($ffin)){
		?>
		<fieldset id="cont">
			<legend> Lista de Keys Auto-Generados</legend>
			<?
			$cn = new PostgreSQL();
			if(isset($nro)){
				$cad = "SELECT DISTINCT a.nrocotizacion,a.rucproveedor,p.razonsocial,a.keygen,c.fecha::date FROM logistica.autogenerado a INNER JOIN logistica.cotizacion c 
							ON a.nrocotizacion = c.nrocotizacion INNER JOIN admin.proveedor p ON a.rucproveedor = p.rucproveedor
							WHERE a.nrocotizacion LIKE '$nro'
							ORDER BY a.nrocotizacion ASC";
			}else{
				$cad = "SELECT DISTINCT a.nrocotizacion,a.rucproveedor,p.razonsocial,a.keygen,c.fecha::date FROM logistica.autogenerado a INNER JOIN logistica.cotizacion c 
							ON a.nrocotizacion = c.nrocotizacion INNER JOIN admin.proveedor p ON a.rucproveedor = p.rucproveedor
							WHERE c.fecha BETWEEN to_date('$fini','yyyy-MM-dd') AND to_date('$ffin','yyyy-MM-dd')
							ORDER BY a.nrocotizacion ASC";
			}
			$query = $cn->consulta($cad);
			if ($cn->num_rows($query)>0) {
				echo "<table>";
				echo "<thead>";
				echo "<tr>";
				echo "<th>Nro Cotizacion</th>";
				echo "<th>R U C</th>";
				echo "<th>Razon Social</th>";
				echo "<th>Fecha</th>";
				echo "<th>Auto-Generados</th>";
				echo "<th>Ver</th>";
				echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
				while ($result = $cn->ExecuteNomQuery($query)) {
					echo "<tr>";
					echo "<td style='text-align:center'>".$result['nrocotizacion']." </td>";
					echo "<td>".$result['rucproveedor']." </td>";
					echo "<td>".$result['razonsocial']."</td>";
					echo "<td>".$result['fecha']."</td>";
					echo "<td style='text-align:center'>".$result['keygen']."</td>";
					echo "<td style='text-align:center'><a href='../../reports/pdfs/system/intsolcotpdf.php?ruc=".$result['rucproveedor']."&nro=".$result['nrocotizacion']."' target='_blank'><img src='../../source/solti48.png' height='24' width='24' ></a></td>";
					echo "</tr>";
				}
				echo "</tbody>";
				echo "</table>";
			}
			?>
		</fieldset>
		<?}?>
	</div>
</section>
	<?php }?>
<footer>
</footer>
</body>
</html>
