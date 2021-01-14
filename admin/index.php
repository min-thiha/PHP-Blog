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
                      <?php if($posts): ?>
                        <?php $i = 1; foreach($posts as $post): ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $post->title; ?></td>
                            <td><?php echo substr($post->content,0 , 50); ?></td>
                            <td>
                              <div class="btn-group">
                                  <div class="container">
                                  <a href="edit.php?id=<?php echo $post->id; ?>" class="btn btn-outline-success">Edit</a>
                                  </div>
                                  <div class="container">
                                  <a href="delete.php?id=<?php echo $post->id; ?>" class="btn btn-outline-danger">Delete</a>
                                  </div>
                              </div>
                            </td>
                          </tr>
                        <?php $i++; endforeach; ?>
                      <?php endif; ?>  

                  </tbody>
                </table>
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
