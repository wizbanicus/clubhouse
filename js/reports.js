$(function() {
  $('input[name="daterange"]').daterangepicker({
      "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "Su",
            "Mo",
            "Tu",
            "We",
            "Th",
            "Fr",
            "Sa"
        ],
        "monthNames": [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        "firstDay": 1
    },
  });
  $('.popup').popover();
});

$(function() {
      $('input[name="as_of_date"]').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "Su",
            "Mo",
            "Tu",
            "We",
            "Th",
            "Fr",
            "Sa"
        ],
        "monthNames": [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        "firstDay": 1
    },
  });
  $('.popup').popover();
});

$(function (){
	$(".ch-rt-ga").hide();
	$(".ch-rt-mi").hide();
});

function updateInputs() {
	var reportType = document.getElementById("reportType").value;
	if (reportType == "general-attendance"){;
		$(".ch-rt-mi").hide();
		$(".ch-rt-ga").show();
	}
	if (reportType == "member-info"){
		$(".ch-rt-ga").hide();
		$(".ch-rt-mi").show();
	}
}

    
    
    
