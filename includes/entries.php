<?php include "db.php"; ?>
<div class="col-md-8">
  <?php 
  $per_page = 8;
  if(isset($_GET["page"])){
    $page = $_GET["page"];
  }else{
    $page = "";
  }
  if($page == "" || $page == 1){
    $page_floor = 0;
  }else{
    $page_floor = ($page * $per_page) - $per_page;
  }
  $query = "SELECT * FROM posts";
  $post_count_query = mysqli_query($connection, $query);
  $count = ceil(mysqli_num_rows($post_count_query)/8);

  $empty = true;
  $query = "SELECT * FROM posts WHERE post_status = 'PUBLISHED' LIMIT $page_floor, $per_page";
  $select_all_posts_query = mysqli_query($connection,$query);

  while($row = mysqli_fetch_assoc($select_all_posts_query)){
    $post_id = $row["post_id"];
    $post_title = $row["post_title"];
    $post_author = $row["post_author"];
    $post_date = $row["post_date"];
    $post_image = $row["post_image"];
    $post_content = substr($row["post_content"],0,100);
    $post_status = $row["post_status"];

    if($post_status == "PUBLISHED"){
    ?>
    <!-- Blog Post -->
    <h2>
      <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
    </h2>
    <p class="lead">
      by <a href="author_post.php?p_id=<?php echo $post_id; ?>&author=<?php echo $post_author ?>">
      <?php echo $post_author ?></a>
    </p>
    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
    <hr>
    <a href="post.php?p_id=<?php echo $post_id; ?>">
      <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
    </a>
    <hr>
    <p><?php echo $post_content ?></p>
    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
    <hr>
    <?php }} ?>
</div>