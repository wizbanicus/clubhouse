$(function() {
var DATE_FORMAT = document.getElementById("JS_DATE_FMT").value;
  $('input[name="birthdate"]').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      "locale": {
        "format": DATE_FORMAT,
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

function button_cancel(){
    document.getElementById('done').innerHTML = "cancel";
    document.getElementById('done').type="reset";
}

function button_done(){
    document.getElementById('done').innerHTML = "done";
    setTimeout(function(){document.getElementById('done').type="submit";}, 30);
}

function name_out(nm="unknown") {
  document.getElementById('inout').value = nm;
}
function button_submit(){
    document.getElementById('button').type = "submit";
}
function button_button(){
    document.getElementById('button').type = "button";
}
function set_timezone(){
   venue_no = js_venues.indexOf(document.getElementById('venue').value);
	document.getElementById('timezone').value = js_timezones[venue_no];
}

var comboplete = new Awesomplete(Awesomplete.$('input.dropdown-input'), {
	minChars: 0,
});
Awesomplete.$('.dropdown-btn').addEventListener("click", function() {
	if (comboplete.ul.childNodes.length === 0) {
		comboplete.minChars = 0;
		comboplete.evaluate();
	}
	else if (comboplete.ul.hasAttribute('hidden')) {
		comboplete.open();
	}
	else {
		comboplete.close();
	}
});
