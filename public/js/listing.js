$('#search').autocomplete({
    serviceUrl: window.baseurl + '/list/autocomplete',
    minChars: 2,
    deferRequestBy: 250,
    onSelect: function (suggestion) {
        window.location = window.baseurl + '/host/' + suggestion.data;
    }
});
$('#order').change(function(){
	loc = window.location.href;
	if (loc.indexOf("?") !== -1) {
		loc += '&order=' + $(this).val();
	} else {
		loc += '?order=' + $(this).val();
	}
	window.location = loc;
});