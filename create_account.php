<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Admin | Employee's Payroll Management System | Create Account</title>
  <?php include('./header.php'); ?>
  <?php include('./db_connect.php'); ?>
  <?php
  session_start();


  if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $empno = $_POST["employeeno"];
    $loc = $_POST["branch"];
    $password = $_POST['password'];
    // Add any other user details you want to store in the database

    // Perform some validation checks if necessary
    // For example, check if the username is unique, password complexity, etc.

    // Assuming you have a 'users' table in your database, you can insert the new user record

    $sql = "INSERT INTO  users(username,employnumber,location,password) VALUES(:username,:empno,:loc,:password)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':empno', $empno, PDO::PARAM_STR);
    $query->bindParam(':loc', $loc, PDO::PARAM_STR);

    $query->bindParam(':password', $password, PDO::PARAM_STR);
    // $query->bindParam(':vimage', $vimage, PDO::PARAM_STR);



    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {

      echo "<script>alert('Registration successfull. Now you can login');</script>";
      header('Location: index.php');
    } else {
      echo "<script>alert('Something went wrong. Please try again');</script>";
    }
  }

  ?>
</head>

<body style="align-items: center;">
  <center>
    <main id="main" style="align-items: center;">
      <div id="login-left">
        <!-- Your logo or any other content for the left section -->
      </div>

      <div id="login-right">
        <div class="card col-md-8">
          <div class="card-body">
            <div class="logo">
              <!-- Reference to the logo -->
              <img src="assets/img/payroll1.png" alt="Jkuat Logo" width="150" height="150">
            </div>
            <h3>Welcome</h3>
            <p>To create an account, please enter your details below:</p>
            <form id="create-account-form" method="post">
              <div class="form-group">
                <label for="username" class="control-label">Full Name</label>
                <input type="text" id="username" name="username" class="form-control">
              </div>
              <div class="form-group">
                <label for="username" class="control-label">Employee Number</label>
                <input type="text" id="username" name="employeeno" class="form-control">
              </div>

              <div class="form-group">
                <label for="username" class="control-label">Select Campus Branch</label>
                <select class="form-select" aria-label="Default select example" id="dep" name="branch">
                  <?php $ret = "select * from department";
                  $query = $dbh->prepare($ret);
                  //$query->bindParam(':id',$id, PDO::PARAM_STR);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                  ?>
                      <option><?php echo htmlentities($result->name); ?></option>
                  <?php }
                  } ?>

                </select>
              </div>
              <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" id="password" name="password" class="form-control">
              </div>
              <!-- Add any other fields you want the user to provide for creating an account -->

              <center><button type="submit" name="submit" class="btn-sm btn-block btn-wave col-md-4 btn-primary">Create Account</button></center>
            </form>
            <div class="mt-3 text-center">
              <a href="index.php">Back to Login</a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </center>
</body>

</html>