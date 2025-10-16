<?php
require_once __DIR__ . '/../db.php';
// Handle POST -> insert task then redirect (PRG)
$successMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
  $task = trim($_POST['task']);
  if ($task !== '') {
    $stmt = $conn->prepare("INSERT INTO tasks (description) VALUES (?)");
    $stmt->bind_param('s', $task);
    if ($stmt->execute()) {
      // use session to show success after redirect
      session_start();
      $_SESSION['success'] = 'Task added.';
      $stmt->close();
      $conn->close();
      header('Location: index.php');
      exit;
    } else {
      $successMsg = 'Error: ' . $stmt->error;
      $stmt->close();
    }
  } else {
    $successMsg = 'Task cannot be empty.';
  }
}
// Show success message if redirected
session_start();
if (isset($_SESSION['success'])) {
    $successMsg = $_SESSION['success'];
    unset($_SESSION['success']);
}
// Read all tasks
$result = $conn->query('SELECT id, description FROM tasks ORDER BY id DESC');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>To-Do App (Task 2)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header class="bg-primary text-white text-center py-3 mb-4">
    <h1>To-Do List</h1>
  </header>
  <main class="container">
    <?php if ($successMsg): ?>
      <div class="alert alert-info"><?php echo htmlspecialchars($successMsg); ?></div>
    <?php endif; ?>

    <div class="row">
      <div class="col-md-6">
        <form id="taskForm" method="post" action="" class="card p-3 mb-4">
          <div class="mb-3">
            <label for="task" class="form-label">New Task</label>
            <input type="text" id="task" name="task" class="form-control">
          </div>
          <button type="submit" class="btn btn-primary">Add Task</button>
        </form>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <h2>Tasks</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo htmlspecialchars($row['description']); ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="3">No tasks yet.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
  <footer class="text-center py-3 mt-4">&copy; 2025 To-Do App</footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="app.js"></script>
</body>
</html>
<?php $conn->close(); ?>
