<?php

$app = require "./core/app.php";
function validateUserData($data)
{
	$errors = [];

	if (empty($data['name'])) {
		$errors[] = 'Name is required.';
	}

	if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
		$errors[] = 'Valid email is required.';
	}

	if (empty($data['city'])) {
		$errors[] = 'City is required.';
	}

	if (empty($data['phone']) || !preg_match('/^[0-9]{10}$/', $data['phone'])) {
		$errors[] = 'Valid 10-digit phone number is required.';
	}

	return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		// Validate input
		$errors = validateUserData($_POST);
		if (!empty($errors)) {
			echo json_encode(['status' => 'error', 'errors' => $errors]);
			exit;
		}

		// Create new instance of user
		$user = new User($app->db);
		// Insert it to database with POST data
		$user->insert(
			array(
				'name' => $_POST['name'],
				'email' => $_POST['email'],
				'city' => $_POST['city'],
				'phone' => $_POST['phone']
			)
		);

		// Fetch the last inserted user
		$lastUser = User::findFirst($app->db, '*', array(), array('id' => 'DESC'));

		if (!$lastUser) {
			throw new Exception('Failed to retrieve the last inserted user.');
		}

		// Return the new user row HTML
		$row = "
		<tr class='highlight'>
			<td>" . htmlspecialchars($lastUser->getName()) . "</td>
			<td>" . htmlspecialchars($lastUser->getEmail()) . "</td>
			<td>" . htmlspecialchars($lastUser->getCity()) . "</td>
			<td>" . htmlspecialchars($lastUser->getPhone()) . "</td>
		</tr>";

		echo json_encode(['status' => 'success', 'row' => $row]);
	} catch (Exception $e) {
		// Return JSON error response
		echo json_encode(['status' => 'error', 'errors' => [$e->getMessage()]]);
	}
} else {
	// Redirect back to index
	header('Location: index.php');
}