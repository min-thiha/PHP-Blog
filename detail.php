<?php
  session_start();
  require_once "config/config.php";
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("location:login.php");
  }
  $statement = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
  $statement->bindParam(":id", $_GET['id']);
  if($statement->execute()) {
      $post = $statement->fetch(PDO::FETCH_OBJ);
  }

  if($_POST) {
    if(empty($_POST['comment'])){
      if(empty($_POST['title'])) {
        $cmtError = 'Comment can not be null';
      }
    }else{
      $blogId = $_GET['id'];
      $comment = $_POST['comment'];
      $statement = $pdo->prepare("INSERT INTO comments(content,author_id,post_id) VALUES (:content,:author_id,:post_id)");
      $statement->bindParam(":content", $comment);
      $statement->bindParam(":author_id", $_SESSION['user_id']);
      $statement->bindParam(":post_id", $blogId);
      if($statement->execute()) {
        header("location:detail.php?id=".$blogId);
      }
    }

  }

  $blogId = $_GET['id'];
  $stmt = $pdo->prepare("SELECT * FROM comments WHERE post_id =  $blogId");
  $stmt->execute();
  $cmts = $stmt->fetchAll(PDO::FETCH_OBJ);


if($cmts){
  foreach($cmts as $cmt){
    $authorId = $cmt->author_id;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id =  $authorId");
    $stmt->execute();
    $authors = $stmt->fetchAll(PDO::FETCH_OBJ);
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blog | Detail </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <div class="content-wrapper ml-0">

    <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-md-12">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <div class="card-title float-none text-center">
                    <h4 class=""><?php echo $post->title; ?></h4>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <img class="img-fluid pad w-100" src="admin/images/<?php echo $post->image; ?>" alt="Photo">

                <p><?php echo $post->content; ?></p> <br>
                <a href="index.php" class="btn btn-outline-danger mb-3">Back To Blogs</a>
                <h3>Comments</h3> <hr>
                
              </div>
              <!-- /.card-body -->
              <div class="card-footer card-comments">
                <div class="card-comment">
                  <?php if($cmts):?>
                  <?php foreach($cmts as $cmt): ?>
                    <div class="comment-text ml-0">
                      <span class="username">
                        <?php foreach($authors as $author): ?>
                        <?php echo $author->name; ?>
                        <?php endforeach; ?>
                        <span class="text-muted float-right"><?php echo $cmt->created_at; ?></span>
                      </span><!-- /.username -->
                        <?php echo $cmt->content; ?>
                    </div>
                  <?php endforeach; ?>
                  <?php endif; ?>
                  <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->
              </div>
              <!-- /.card-footer -->
              <div class="card-footer">
                <form action="" method="post">
                  <div class="img-push">
                  <p class="text-danger"><?php echo empty($cmtError)? '' : '*'.$cmtError; ?></p>
                    <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer ml-0">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="logout.php" class="btn btn-info">Logout</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020-2021 <a href="">mthblogs</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
