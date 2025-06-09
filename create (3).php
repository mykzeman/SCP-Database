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
  if(isset($_POST['submit'])) {
   $item=$connection->prepare("insert into records(name,class,containment,description,image) values(?,?,?,?,?)");
   $item->bind_param("sssss",$_POST['name'],$_POST['class'],$_POST['containment'],$_POST['description'],$_POST['image']);
   if ($item->execute()){
       echo "<div class='alert alert-success' role='alert'>
  SCP added successfully!
</div>
";
   }
   else{
       echo "<div class='alert alert-danger' role='alert'>
        Error: Failed to add SCP!
      </div>";

   }
   
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
  <h2 class="mb-4">Add SCP Record</h2>
    <p class="text-danger"> All fields are required</p>
  <form action="create.php" method="post" onsubmit="location.reload();">
    <div class="mb-3">
      <label for="name" class="form-label">SCP Name</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Enter your SCP name here..." required>
    </div>

    <div class="mb-3">
      <label for="subject" class="form-label">Object Class</label>
      <input type="text" class="form-control" id="class" name="class" placeholder="Enter your SCP object class here..." required>
    </div>

    <div class="mb-3">
      <label for="containment" class="form-label">Containment Procedures</label>
      <textarea class="form-control" id="containment" name="containment" rows="4" placeholder="Enter the containment procedures of your SCP here..." required></textarea>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter the description of your SCP..." required></textarea>
    </div>
        <div class="mb-3">
      <label for="image" class="form-label">Image</label>
      <input type="text" class="form-control" id="image" name="image" placeholder="Enter the url of the image here..." required>
         <div class="mb-3">
       <p class="text-secondary mt-3 small">You can type things like: images/unknown.png (for SCPs with an indescribable persona) or images/neu_scp.png (for SCPs that have been neutralised)</p>
    </div>
    </div>

    <button type="submit" class="btn btn-primary" name="submit">Add your SCP to the database</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="scripts/process.js"></script>
</body>
</html>
