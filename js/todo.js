'use strict';

document.getElementById('form_add_edit_todo').addEventListener('submit', function (event) {
	event.preventDefault();

	let todoId = document.getElementById('todoid').value;
	let method, action, actionError;
	if (todoId) {
		method      = 'PUT';
		action      = 'updated';
		actionError = 'updating';
	} else {
		method      = 'POST';
		action      = 'inserted';
		actionError = 'inserting';
	}

	let options = {
		method: method,
		body  : JSON.stringify({
			todoId     : todoId,
			title      : document.getElementById('title').value,
			description: document.getElementById('description').value
		})
	}

	fetch(`./api/addEditTodo.php`, options).then(function (response) {
		if (!response.ok) {
			alert('Error retrieving data from the server');
			return false;
		}
		response.json().then(function (retorno) {
			if (retorno) {
				if (retorno.query) {
					alert(`Todo successfully ${action}`);
					if (method === 'POST') {
						document.getElementById('form_add_edit_todo').reset();
					}
				} else {
					alert(`Error ${actionError} the todo`);
				}
			} else {
				alert('Error retrieving data from the query');
			}
		});
	});
});