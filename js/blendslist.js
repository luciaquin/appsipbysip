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
			$('#employeeList').append('<li><a href="#" id="'+newblends.id+'">' +
					'<img src="admin/' + newblends.ruta + '"/>' +
					'<h4>' + newblends.blend + '</h4></a></li>');
		});
		$('#employeeList').listview('refresh');
	});
}