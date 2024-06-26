<div class="container">
	<h1>PHP Test Application</h1>
	<div class="form-group">
		<input type="text" id="search-city" class="form-control" placeholder="Filter by city">
	</div>
	<table class="table table-striped table-bordered">
		<thead class="thead-dark">
			<tr>
				<th>Name</th>
				<th>E-mail</th>
				<th>City</th>
				<th>Phone</th>
			</tr>
		</thead>
		<tbody id="user-table">
			<?php foreach ($users as $user): ?>
				<tr class="highlight">
					<td><?= htmlspecialchars($user->getName()) ?></td>
					<td><?= htmlspecialchars($user->getEmail()) ?></td>
					<td><?= htmlspecialchars($user->getCity()) ?></td>
					<td><?= htmlspecialchars($user->getPhone()) ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<form id="user-form" class="form-horizontal mt-4" method="post" action="create.php">
		<div class="form-group">
			<label for="name" class="control-label">Name:</label>
			<input name="name" input="text" id="name" class="form-control" required />
		</div>

		<div class="form-group">
			<label for="email" class="control-label">E-mail:</label>
			<input name="email" input="text" id="email" class="form-control" required />
		</div>

		<div class="form-group">
			<label for="city" class="control-label">City:</label>
			<input name="city" input="text" id="city" class="form-control" required />
		</div>

		<div class="form-group">
			<label for="phone" class="control-label">Phone:</label>
			<input name="phone" type="text" id="phone" class="form-control" required />
		</div>

		<button type="submit" class="btn btn-fancy">Create new row</button>
		<div id="formErrors" class="error"></div>
	</form>
</div>
<script>
	$(document).ready(function () {
		// Filter rows by city
		$('#search-city').on('keyup', function () {
			var value = $(this).val().toLowerCase();
			$('#user-table tr').filter(function () {
				var city = $(this).find('td').eq(2).text().toLowerCase(); // Get city text
				$(this).toggle(city.indexOf(value) > -1);
			});
		});

		// AJAX form submission
		$('#user-form').on('submit', function (e) {
			e.preventDefault();

			// Clear previous errors
			$('#formErrors').html('');

			// Validate form
			var errors = [];
			var name = $('#name').val();
			var email = $('#email').val();
			var city = $('#city').val();
			var phone = $('#phone').val();

			if (!name) {
				errors.push('Name is required.');
			}
			if (!email || !validateEmail(email)) {
				errors.push('Valid email is required.');
			}
			if (!city) {
				errors.push('City is required.');
			}
			if (!phone || !/^[0-9]{10}$/.test(phone)) {
				errors.push('Valid 10-digit phone number is required.');
			}

			if (errors.length > 0) {
				$('#formErrors').html(errors.join('<br>'));
				return;
			}

			$.ajax({
				url: 'create.php',
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'json',
				success: function (response) {
					if (response.status === 'success') {
						$('#user-table').append(response.row);
						$('#user-form')[0].reset();
					} else {
						$('#formErrors').html(response.errors.join('<br>'));
					}
				}
			});
		});
	});

	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\.,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,})$/i;
		return re.test(String(email).toLowerCase());
	}
</script>