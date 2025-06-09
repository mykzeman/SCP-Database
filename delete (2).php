<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SCP Update Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
include 'connection.php';

if (isset($_GET['recordnum'])) {
    $id = $_GET['recordnum'];

    // Fetch the SCP record
    $record = $connection->query("SELECT name FROM records WHERE recordnum = $id");
    $array = $record->fetch_assoc();

    // Handle deletion
    if (isset($_POST['submit'])) {
        $delete = $connection->prepare("DELETE FROM records WHERE recordnum = ?");
        $delete->bind_param("i", $id);
        if ($delete->execute()) {
            echo '<div class="alert alert-success" role="alert">SCP "' . $array['name'] . '" deleted successfully!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error: Failed to delete SCP!</div>';
        }
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Error: No SCP selected to delete!</div>';
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">SCP DATA</a>
    <div class="navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Index</a></li>
        <?php foreach($result as $scp): ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php?scp=<?php echo urlencode($scp['name']); ?>">
              <?php echo htmlspecialchars($scp['name']); ?>
            </a>
          </li>
        <?php endforeach; ?>
        <li class="nav-item"><a class="nav-link" href="create.php">Add Record</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-5">
 <h2 class="mb-4">Delete SCP Record</h2>

<form action="delete.php?recordnum=<?php echo $id; ?>" method="post" onsubmit="return scpWarning();">
  <div class="mb-3">
    <p class="mb-3 text-danger">Are you sure you want to delete "<?php echo $array['name']; ?>"?</p>
    
    <button type="submit" class="btn btn-danger" name="submit">
      DELETE SCP!!! ⚠️⚠️⚠️
    </button>
  </div>
</form>

<script>
  function scpWarning() {
    return confirm("Are you absolutely sure you want to delete this SCP?");
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
