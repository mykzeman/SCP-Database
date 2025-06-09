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
include "connection.php";
if(isset($_GET['recordnum'])) {
    $update=$_GET['recordnum'];

  if(isset($_POST['submit'])) {
   $item=$connection->prepare("update records set name=?,class=?,containment=?,description=?,image=? where recordnum=?");
   $item->bind_param("ssssss",$_POST['name'],$_POST['class'],$_POST['containment'],$_POST['description'],$_POST['image'],$update);
   if ($item->execute()){
       echo "<div class='alert alert-success' role='alert'>
  SCP updated successfully!
</div>
";
   }
   else{
       echo "<div class='alert alert-danger' role='alert'>
        Error: Failed to update SCP!
      </div>";

   }
  }
  
    $record = $connection->query("SELECT * FROM records WHERE recordnum='$update'");
    $array = $record->fetch_assoc();
  }
    else{     echo "<div class='alert alert-danger' role='alert'>
        Error: Failed to retrieve SCP to update!
        </div>";}
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
  <h2 class="mb-4">Update SCP Record</h2>
    <p class="text-danger"> All fields are required</p>
  <form action="update.php?recordnum=<?php echo $_GET['recordnum'];?>" method="post">
    <input type="hidden" id="recordnum" value=<?php echo $_GET['recordnum'];?>>

    <div class="mb-3">
      <label for="name" class="form-label">SCP Name</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Enter new SCP name here..." required value="<?php echo $array['name']; ?>">
    </div>

    <div class="mb-3">
      <label for="subject" class="form-label">Object Class</label>
      <input type="text" class="form-control" id="class" name="class" placeholder="Enter new SCP object class here..." required value="<?php echo $array['class']; ?>">
    </div>

    <div class="mb-3">
      <label for="containment" class="form-label">Containment Procedures</label>
      <textarea class="form-control" id="containment" name="containment" rows="4" placeholder="Enter the containment procedures of new SCP here..." required><?php echo $array['containment']; ?></textarea>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter the description of new SCP..." required><?php echo $array['description']; ?></textarea>
    </div>
        <div class="mb-3">
      <label for="image" class="form-label">Image</label>
      <input type="text" class="form-control" id="image" name="image" placeholder="Enter the url of the image here..." required value="<?php echo $array['image']; ?>">
        <p class="text-info small">You can type things like: images/unknown.png (for SCPs with an indescribable persona) or images/neu_scp.png (for SCPs that have been neutralised)</p>
    </div>

    <button type="submit" class="btn btn-primary" name="submit"> Update SCP to the database</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="scripts/process.js"></script>
</body>
</html>
