<html>
<head>
    <title></title>
</head>
<body>
<?php
//	Guardar Tipo de Cambio
function Obtener_contenidos($url,$inicio,$final){
$source = @file_get_contents($url)or die('se ha producido un error');
$posicion_inicio = strpos($source, $inicio) + strlen($inicio);
$posicion_final = strpos($source, $final) - $posicion_inicio;
$found_text = substr($source, $posicion_inicio, $posicion_final);
return $inicio . $found_text .$final;
}
$url = 'http://www.sbs.gob.pe/0/home.aspx'; /// pagina web del contenido
//echo Obtener_contenidos($url,'<p class="WEB_compra">','<div class="WEB_CONTE_cabeceraInferior">');
// Obtener_contenidos(url,ancla inicio,ancla final);
echo date("d-m-Y H:m:s");
?>
<script type="text/javascript">
	var obj = document.getElementsByTagName("span");
	for (var i = 0; i < obj.length; i++) {
		alert(obj[i].innerHTML);
	};
</script>

</form>
</body>
</html>