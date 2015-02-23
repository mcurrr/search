$(function() {
	$input = $("input[name='search']");
	$userName = $("#nik");
	$label = $('#nikName');

	$input.on('focus', function() {
		$("#output").html('');
	});
	
	$input.on('keyup', function() {
		var searchTxt = $input.val();
		$.post("instantSearch.php", {searchVal: searchTxt}, function(data){
			$("#output").html(data);
			console.log(data);
			}); 
	});

	$userName.on('keyup', function() {
		var searchName = $userName.val();
		$.post("userNameRegCheck.php", {searchVal: searchName}, function(data){
			if (data != 0) {
				$label.html("Nik is taken!").css({"color": "black"});
			}
			else {
				$label.html("Nik: ").css({"color": "inherit"});
			}
			console.log(data);
		}); 
	});
});