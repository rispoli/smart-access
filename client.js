function addressBook(textarea) {
	var addressBook = new Array();
	if(textarea != "") {
		var ls = textarea.split('\n');
		for(var l in ls) {
			var a = ls[l].split(',');
			addressBook[a[0]] = a[1];
		}
	}
	return addressBook;
}

function handleRequest(form, addressBook) {
	var formData = new FormData(form)
	var rv = false;
	var credentials = "(" + form.credentials.value + ")";

	var xhr = new XMLHttpRequest();
	xhr.open('POST', form.action, false);
	xhr.onload = function(e) {
		if(this.status == 200) {
			var response = JSON.parse(this.responseText);
			if(response == "granted") {
				document.getElementById('output').innerHTML += form.action + " says: '" + form.request.value + "' granted.<br />";
				rv = true;
			} else {
				var success_d = false;
				for(var d in response) {
					document.getElementById('output').innerHTML += form.action + " says: additional credentials '" + response[d] + "'." + "<br />";
					var success_c = 0;
					for(var c in response[d])
						if(response[d][c] == form.request.value)
							break;
						else {
							var action_a = addressBook[response[d][c].split(' says ')[0]];
							var form_a = form.cloneNode(true);
							form_a.credentials.value = form.principal.value + ' says ' + response[d][c];
							form_a.request.value = response[d][c];
							form_a.action = action_a;
							var s = handleRequest(form_a, addressBook);
							if(s) { success_c++; credentials += " and (" + response[d][c] + ")"; }
						}
					if(success_c == response[d].length) { success_d = true; break; }
				}
				if(success_d) {
					var form_c = form.cloneNode(true);
					form_c.credentials.value = credentials;
					rv = handleRequest(form_c, addressBook);
				} else
					document.getElementById('output').innerHTML += form.action + " says: '" + form.request.value + "' cannot be granted.<br />";
			}
		}
	};

	xhr.send(formData);
	return rv;
}
