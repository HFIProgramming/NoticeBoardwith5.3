var domainroot = "hfi.me/post";

function Bingsitesearch(curobj) {
	curobj.q.value = "site:" + domainroot + " " + curobj.keyword.value;
}

function do_search() {
	var search_form = document.getElementById("search-form");
	search_form.q.value = "site:" + domainroot + " " + search_form.keyword.value;
	search_form.submit();
}