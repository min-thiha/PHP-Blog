<?php
  session_start();
  require_once "../config/config.php";
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("location:login.php");
  }

  $statement = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
  $statement->bindParam(":id", $_GET['id']);
  if($statement->execute()) {
      $post = $statement->fetch(PDO::FETCH_OBJ);
  }

  // update
  if($_POST) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    if ($_FILES['image']['name'] != null) {
      $file = 'images/'.($_FILES['image']['name']);
      $imageType = pathinfo($file,PATHINFO_EXTENSION);
      if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg'){
        echo "<script>alert('Image must be png,jpg,jpeg')</script>";
      } else {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],$file);
        $statement = $pdo->prepare("UPDATE posts SET title='$title',content='$content',image='$image' WHERE id='$id'");
        $result = $statement->execute();
        if($result){
          echo "<script>alert('Successfully Updated');window.location.href='index.php';</script>";
        }
      }
    } else {
      $statement = $pdo->prepare("UPDATE posts SET title='$title',content='$content' WHERE id='$id'");
      $result = $statement->execute();
      if($result){
        echo "<script>alert('Successfully Updated');window.location.href='index.php';</script>";
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
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $post->id; ?>">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" value="<?php echo $post->title; ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Content</label>
                            <textarea name="content" class="form-control" id="" cols="30" rows="10"><?php echo $post->content; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Image</label> <br>
                            <img src="images/<?php echo $post->image ?>" alt="" width="250" height="250"> <br> <br>
                            <input type="file" name="image">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">Update</button>
                            <a href="index.php" class="btn btn-danger">Back</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

  <?php require_once "footer.php"; ?>
