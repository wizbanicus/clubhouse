$(function() {
		var startAge = $("#startAge").val();
		
		var endAge = $("#endAge").val();
		var asOfDate = $("#asOfDate").val();
		var orgID = $("#orgID").val();
    console.log( "ready!" );
		var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				  		var memberInfos = JSON.parse(xmlhttp.responseText, function(k,v){return v;});
					  		$.each(memberInfos, function(index,value){

					  		});			  	
				  }
			};
			xmlhttp.open("POST", "reports/member-info_as_json.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			
			var sendRequest = "startAge" + startAge + "&endAge=" + endAge + "&asOfDate=" + asOfDate + "&orgID=" + orgID;
			xmlhttp.send(sendRequest);
	});
