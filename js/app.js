'use strict';

function getTodos(todoId = null) {
	let options = {
		method: 'GET'
	}

	const params = new URLSearchParams({
		todoId: todoId
	});

	fetch(`./api/getTodos.php?${params.toString()}`, options).then(function (response) {
		if (!response.ok) {
			return false;
		}
		response.json().then(function (retorno) {
			document.getElementById('div_todos').innerHTML = '';
			if (retorno) {
				if (retorno.length > 0) {
					let html = '';
					for (const item of retorno) {
						html += `
							<div class="col-3 my-2">
								<div class="card">
									<div class="card-header">
										${item.title}
									</div>
									<div class="card-body">
										${item.description}
									</div>
								</div>
								<span class="remove_todo" onclick="removeTodo(${item.id})">Remove todo</span>
							</div>
						`;
					}
					document.getElementById('div_todos').innerHTML = html;
				} else {
					document.getElementById('div_todos').innerHTML = `
						<div class="col-12 text-center"><h5>No todo found</h5></div>
					`;
				}
			} else {
				alert('No todos found.');
			}
		});
	});
}

getTodos();

function removeTodo(id) {
	let options = {
		method: 'DELETE',
		body  : JSON.stringify({
			id: id
		})
	}

	fetch(`./api/removeTodo.php`, options).then(function (response) {
		if (!response.ok) {
			alert('Error retrieving data from the server');
			return false;
		}
		response.json().then(function (retorno) {
			if (retorno) {
				if (retorno.query) {
					getTodos();
				} else {
					alert('Error removing the todo');
				}
			} else {
				alert('Error retrieving data from the query');
			}
		});
	});
}
