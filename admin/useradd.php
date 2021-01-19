<?php
  session_start();
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("location:login.php");
  }
  require_once "../config/config.php";

  if($_POST) {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $role = $_POST['role'];

      $statement = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
      $statement->bindParam(":name", $name);
      $statement->bindParam(":email", $email);
      $statement->bindParam(":password", $password); 
      $statement->bindParam(":role", 1);
      if($statement->execute()) {
          echo "<script>alert('user added');window.location.href='userlist.php'</script>";
      }
  }


?>

  <?php require_once "header.php"; ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <form action="">
                <h2>Create User</h2>
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="role">User Type</label>
                    <select name="role" class="form-control">
                        <option value="" disabled selected>Choose Type</option>
                        <option value="admin">Admin</option>
                        <option value="normal">Normal User</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-success">Submit</button>
                    <a href="userlist.php" class="btn btn-danger">Back</a>
                </div>
            </form>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

  <?php require_once "footer.php"; ?>
