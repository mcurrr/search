$(function() {
	$input = $("input[name='search']");
	$userName = $("#nik");

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
				$userName.next().html("Taken").css({"color": "red"});
			}
			else {
				$userName.next().html("");
			}
			console.log(data);
		}); 
	});
});