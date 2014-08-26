

function match_file(fname) {
	farr = fname.toLowerCase().split(".");
	if (farr.length != 0) {
		len = farr.length
		if (farr[len - 1] == "gz" || farr[len - 1] == "bz2" || farr[len -1] == "zip") len--;
		switch (farr[len - 1]) {
		case "sql" :document.getElementById("radio_plugin_sql").checked = true;init_options();break;

		}
	}
}  


onInit = function(ev) {

}

onReady = function(ev) {
	var rows = document.getElementsByClassName('objrow');
	for (var i=0; i<rows.length; i++) {
//		rows[i].onclick = onRowClick;
	}
}

document.onreadystatechange = function() {
	var state = document.readyState;
	if (state == 'interactive') {
		onInit();
	} else if (state == 'complete') {
		onReady();
	}
};
