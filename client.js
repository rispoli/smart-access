/*

   Copyright 2012 Daniele Rispoli, Valerio Genovese, Deepak Garg

   This file is part of smart-rsync.

   smart-rsync is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as
   published by the Free Software Foundation, either version 3 of the
   License, or (at your option) any later version.

   smart-rsync is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public
   License along with smart-rsync.  If not, see <http://www.gnu.org/licenses/>.

*/

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
