<?php
  session_start();
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("location:login.php");
  }
  require_once "../config/config.php";
  $statement = $pdo->prepare("SELECT * FROM users WHERE id = :id");
  $statement->bindParam(":id", $_GET['id']);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_OBJ);

  if($_POST){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    if($role == 'admin') {
        $statement = $pdo->prepare("
            UPDATE users
            SET name=$name,email=$email,password=$password,role=1
            WHERE id = $id 
        ");
        if($statement->execute()){
            echo "<script>alert('successfully updated');window.location.href='userlist.php';</script>";
        }
    } else {
        $statement = $pdo->prepare("
        UPDATE users
        SET name=$name,email=$email,password=$password,role=0
        WHERE id = $id 
    ");
        if($statement->execute()){
            echo "<script>alert('successfully updated');window.location.href='userlist.php';</script>";
        }  
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
                <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email"  value="<?php echo $user->email; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password"  value="<?php echo $user->password; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="role">User Type</label>
                    <select name="role" class="form-control">
                        <option value="admin" <?php if($user->role=="admin"){echo "selected";} ?>>Admin</option>
                        <option value="normal" <?php if($user->role=="admin"){echo "selected";} ?>>Normal User</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-success">Update</button>
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
