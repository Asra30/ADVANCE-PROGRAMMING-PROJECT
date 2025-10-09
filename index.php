
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_app";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$successMsg = "";
$successMsg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = htmlspecialchars($_POST["name"]);
	$email = htmlspecialchars($_POST["email"]);
	$phone = htmlspecialchars($_POST["phone"]);
	$sql = "INSERT INTO students (name, email, phone) VALUES (?, ?, ?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("sss", $name, $email, $phone);
	if ($stmt->execute()) {
		// Set a session variable for success message
		session_start();
		$_SESSION['successMsg'] = "Registration successful!";
		$stmt->close();
		$conn->close();
		header("Location: index.php");
		exit();
	} else {
		$successMsg = "Error: " . $stmt->error;
		$stmt->close();
	}
}
// Show success message if redirected
session_start();
if (isset($_SESSION['successMsg'])) {
	$successMsg = $_SESSION['successMsg'];
	unset($_SESSION['successMsg']);
}
$sql = "SELECT id, name, email, phone FROM students";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registration Form & Student Details</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<header class="bg-primary text-white text-center py-4 mb-4">
		<h1>Register</h1>
	</header>
	<main>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6">
					<?php if ($successMsg): ?>
						<div class="alert alert-info text-center"> <?php echo $successMsg; ?> </div>
					<?php endif; ?>
					<form class="card p-4 shadow" method="post" action="" id="registrationForm">
						<div class="mb-3">
							<label for="name" class="form-label">Name</label>
							<input type="text" class="form-control" id="name" name="name" required>
						</div>
						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input type="email" class="form-control" id="email" name="email" required>
						</div>
						<div class="mb-3">
							<label for="phone" class="form-label">Phone</label>
							<input type="tel" class="form-control" id="phone" name="phone" required>
						</div>
						<button type="submit" class="btn btn-primary w-100">Register</button>
					</form>
				</div>
			</div>
			<div class="row justify-content-center mt-5">
				<div class="col-md-10">
					<h2 class="mb-4 text-center">Student Details</h2>
					<table class="table table-bordered table-striped">
						<thead class="table-dark">
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
							</tr>
						</thead>
						<tbody>
						<?php if ($result && $result->num_rows > 0): ?>
							<?php while($row = $result->fetch_assoc()): ?>
								<tr>
									<td><?php echo $row['id']; ?></td>
									<td><?php echo htmlspecialchars($row['name']); ?></td>
									<td><?php echo htmlspecialchars($row['email']); ?></td>
									<td><?php echo htmlspecialchars($row['phone']); ?></td>
								</tr>
							<?php endwhile; ?>
						<?php else: ?>
							<tr><td colspan="4" class="text-center">No students found.</td></tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</main>
	<footer class="bg-light text-center py-3 mt-4">
		<small>&copy; 2025 Registration Page</small>
	</footer>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="form-validation.js"></script>
</body>
</html>
<?php $conn->close(); ?>
