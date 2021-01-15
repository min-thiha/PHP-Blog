<?php
  session_start();
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("location:login.php");
  }
  require_once "../config/config.php";

  if(!empty($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
  } else {
    $pageno = 1;
  }
  $numOfrecs = 1;
  $offset = ($pageno - 1) * $numOfrecs;
  if(empty($_POST['search'])) {
    $statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_OBJ);
    $total_pages = ceil(count($posts) / $numOfrecs);
    $statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs");
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_OBJ);
  } else {
    $search = $_POST['search'];
    $statement = $pdo->prepare("SELECT * FROM posts WHERE title='$search' ORDER BY id DESC");
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_OBJ);
    $total_pages = ceil(count($posts) / $numOfrecs);
    $statement = $pdo->prepare("SELECT * FROM posts WHERE title='$search' ORDER BY id DESC LIMIT $offset,$numOfrecs");
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_OBJ);
  }

?>

  <?php require_once "header.php"; ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Blog Listings</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="add.php" class="btn btn-primary mb-4">New Blog Post</a>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Content</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php if($results): ?>
                        <?php $i = 1; foreach($results as $result): ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $result->title; ?></td>
                            <td><?php echo substr($result->content,0 , 50); ?></td>
                            <td>
                              <div class="btn-group">
                                  <div class="container">
                                  <a href="edit.php?id=<?php echo $result->id; ?>" class="btn btn-outline-success">Edit</a>
                                  </div>
                                  <div class="container">
                                  <a href="delete.php?id=<?php echo $result->id; ?>" onclick="return confirm('Sure to delete ?');" class="btn btn-outline-danger">Delete</a>
                                  </div>
                              </div>
                            </td>
                          </tr>
                        <?php $i++; endforeach; ?>
                      <?php endif; ?>  

                  </tbody>
                </table> <br>
                <nav aria-label="Page navigation example" class="float-right">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <= 1) {echo "disabled";} ?>">
                      <a class="page-link" href="<?php if($pageno <= 1){echo '#';}else{echo "?pageno=".($pageno-1);} ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno >= $total_pages){echo '#';}else{echo "?pageno=".($pageno+1);} ?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages ?>">Last</a></li>
                  </ul>
                </nav>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

  <?php require_once "footer.php"; ?>
