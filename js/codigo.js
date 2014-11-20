$(document).ready(function(){



	var serviceURL = "http://localhost/appsipbysip/services/";

	/*var serviceURL = "http://sip-by-sip.info/services/";*/

	var blends;


	$('#employeeListPage').bind('pageinit', function(event) {
		showListadoBlends();
	});

	function showListadoBlends() {

		$.getJSON(serviceURL + 'getblends.php', function(data) {	
			$('#employeeList li').remove();
			blends = data.items;
			$.each(blends, function(index, newblends) {
				$('#employeeList').append('<li><a class="deonda" href="#" id="'+newblends.id+'">' +
						'<img src="admin/' + newblends.ruta + '"/>' +
						//'<img src="../admin/' + imagenes.ruta + '"/>' +
						'<h4>' + newblends.blend + '</h4>' +
						'<span class="ui-li-count">' + ">" + '</span></a></li>');
			});
			$('#employeeList').listview('refresh');
		});
	}

	$('ul').on('click', 'a.deonda', function(e){
		console.log("goya puto");
		blendId = this.id;
		console.log(blendId);
		$.getJSON(serviceURL + 'getBlend.php', {'idBlend': blendId}, showBlend)
		$.mobile.changePage("#detailsPage");
	});



	////////////////////blend detail

function showBlend(data){
	console.log("En funcion che: id " +data.blend.id);
	$('#imagen').attr('src', 'admin/' + data.blend.ruta);
	$('#nombre').text(data.blend.blend);
	$('#descripcion').text(data.blend.descripcion);
	$("#idBlendHidden").val(data.blend.id);
	$("#nombreBlendHidden").val(data.blend.blend);
}



$("#submit").click(function(){
	console.log("suuuuubmit");

	var elMail = $("#email").val();
	var idHidden = $("#idBlendHidden").val();
	var nombreHidden = $("#nombreBlendHidden").val();
	console.log("El mail ingresado es: " + elMail + " y el id del hidden blend: " + idHidden);

	var datos = 'idBlend='+idHidden+'&nombreBlend='+nombreHidden+'&mail='+elMail;

	$.ajax({
		type:'post',
		url:serviceURL+"blendMail.php",
		data:datos
	});

});



console.log("Ready");


});
