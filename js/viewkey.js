function valrbtn (iditem) {
	var fini = document.getElementById("fecini");
	var ffin = document.getElementById("fecfin");
	var idnro = document.getElementById("nro");
	if (iditem.value == "n") {
		fini.disabled = "disabled";
		ffin.disabled = "disabled";
		idnro.disabled = "";
	}else if(iditem.value == "f"){
		idnro.disabled = "disabled";
		fini.disabled = "";
		ffin.disabled = "";
	}
}