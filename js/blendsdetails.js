$('#detailsPage').live('pageshow', function(event) {
	var id = getUrlVars()["id"];
	$.getJSON(serviceURL + 'getblend.php?id='+id, detalleBlend);
});

function detalleBlend(data) {
	var blend = data.item;
	console.log(blend);
	$('#imagen').attr('src', 'admin/' + blend.ruta);
	$('#nombre').text(blend.blend);
	$('#descripcion').text(blend.descripcion);
	
	//$('#actionList').listview('refresh');
	
}

function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
