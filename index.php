<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SCP Data Index Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php 
include "connection.php";
// Get list of scps
$result = $connection->query("SELECT name FROM records");
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">SCP DATA</a>
    <div class="navbar-collapse">
      <ul class="navbar-nav me-auto">
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

<div class="container mt-4">
  <?php
  if(isset($_GET['scp'])) {
    $name =$_GET['scp'];
    $record = $connection->query("SELECT * FROM records WHERE name='$name'");

    if($record && $array = $record->fetch_assoc()) {
    echo "
    <div class='card mb-4'>
      <div class='card-header'>
        <h2>" . htmlspecialchars($array['name']) . "</h2>
        <h5>Class: " . htmlspecialchars($array['class']) . "</h5>
      </div>
      <div class='card-body'>
        <img src='" . htmlspecialchars($array['image']) . "' alt='" . htmlspecialchars($array['name']) . "' class='img-fluid mb-3'>
        <h4>Containment Procedures</h4>
        <p>" . nl2br(htmlspecialchars($array['containment'])) . "</p>
        <h4>Description</h4>
        <p>" . nl2br(htmlspecialchars($array['description'])) . "</p>
<div class='card shadow border-0 mx-auto mt-4'  style='width: 10rem;'>
  <img 
    src='images/speak.png' 
    class='card-img-top' 
    alt='Say {$array['name']}' 
    style='cursor: pointer;' 
    onclick='speechToText(\"Hello, My name is {$array['name']}\")'>
</div>

    </div>
          <div class='card-footer'>
          
              <a href='update.php?recordnum=" . urlencode($array['recordnum']) . "' class='btn btn-warning mt-3'>Updade ". htmlspecialchars($array['name'])."</a>
    <a href='delete.php?recordnum=" . urlencode($array['recordnum']) . "' class='btn btn-danger mt-3'>Delete ". htmlspecialchars($array['name'])."</a>

          </div>
        </div>";
    } else {
      echo '<div class="alert alert-warning">Record not found or failed to load.</div>';
    }
  } else {
    echo '<p class="text-muted">Select an SCP from the navbar above.</p>';
  }
  ?>
  
</div>
<script>
    
    function speechToText(text) {
    const speech=new SpeechSynthesisUtterance(text);
    speech.lang="en-US";
    speech.voice=window.speechSynthesis.getVoices()[0];
    speechSynthesis.speak(speech);
    
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
