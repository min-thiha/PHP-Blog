<?php
  session_start();
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("location:login.php");
  }
  require_once "../config/config.php";
  $statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
  if($statement->execute()){
    $posts = $statement->fetchAll(PDO::FETCH_OBJ);
  }

  if($_POST) {
    if(empty($_POST['title']) || empty($_POST['content']) || empty($_FILES['image'])) {
      if(empty($_POST['titile'])) {
        $titleError = 'Title can not be null';
      }
      if(empty($_POST['content'])) {
        $contentError = 'Content can not be null';
      }
      if(empty($_FILES['image'])) {
        $imageError = 'Image can not be null';
      }
    } else {
      $file = 'images/'.($_FILES['image']['name']);
      $imageType = pathinfo($file,PATHINFO_EXTENSION);
  
      if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg'){
          echo "<script>alert('Image must be png,jpg,jpeg')</script>";
      } else {
          $title = $_POST['title'];
          $content = $_POST['content'];
          $image = $_FILES['image']['name'];
          $author_id = $_SESSION['user_id'];
          move_uploaded_file($_FILES['image']['tmp_name'],$file);
          $statement = $pdo->prepare("
              INSERT INTO posts (title, content, image, author_id) VALUES
              (:title, :content, :image, :author_id)
          ");
          $statement->bindParam(":title", $title);
          $statement->bindParam(":content", $content);
          $statement->bindParam(":image", $image);
          $statement->bindParam(":author_id", $author_id);
         if( $statement->execute()){
             echo "<script>alert('successfully added')</script>";
             header("location:index.php");
         }
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
                    <form action="add.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="">Title</label>
                            <p class="text-danger"><?php echo empty($titleError)? '' : '*'.$titleError; ?></p>
                            <input type="text" name="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Content</label>
                            <p class="text-danger"><?php echo empty($contentError)? '' : '*'.$contentError; ?></p>
                            <textarea name="content" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Image</label> <br>
                            <p class="text-danger"><?php echo empty($imageError)? '' : '*'.$imageError; ?></p>
                            <input type="file" name="image">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">Submit</button>
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
