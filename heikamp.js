
onRowClick = function(ev) {
	console.log("click " + ev);
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
