$(document).ready(function() {
	$("#page-refresh").click(function(){
		$.ajaxSetup ({
			cache: false
		});
		var ajax_load = "<div class='spinner'></div>";
		var loadUrl = window.location.pathname;
		$("body").html(ajax_load).load(loadUrl);
		return false;
	});
});