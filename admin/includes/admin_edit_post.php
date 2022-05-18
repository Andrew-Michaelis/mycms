<?php
if(isset($_GET["p_id"])){
  $the_post_id = $_GET["p_id"];
}
$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
$select_post_by_id = mysqli_query($connection, $query);
confirm($select_post_by_id);

while($row = mysqli_fetch_assoc($select_post_by_id)){
  $post_author = $row["post_author"];
  $post_title = $row["post_title"];
  $post_category_id = $row["post_category_id"];
  $post_status = $row["post_status"];
  $post_image = $row["post_image"];
  $post_tags = $row["post_tags"];
  $post_content = $row["post_content"];
}
if(isset($_POST["update_post"])){
  $post_author = $_POST["post_author"];
  $post_title = mysqli_real_escape_string($connection, $_POST["post_title"]);
  $post_category_id = $_POST["post_category"];
  $post_status = $_POST["post_status"];
  $post_image = $_FILES["post_image"]["name"];
  $post_image_temp = $_FILES["post_image"]["tmp_name"];
  $post_tags = mysqli_real_escape_string($connection, $_POST["post_tags"]);
  $post_content = mysqli_real_escape_string($connection, $_POST["post_content"]);

  move_uploaded_file($post_image_temp, "../images/$post_image");
  if(empty($post_image)){
    $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
    $select_image = mysqli_query($connection,$query);
    confirm($select_image);
    while($row = mysqli_fetch_array($select_image)){
      $post_image = $row["post_image"];
    }
  }
  $query = "UPDATE posts SET 
              post_title = '${post_title}', 
              post_category_id = '${post_category_id}', 
              post_date = now(), 
              post_author = '${post_author}', 
              post_status = '${post_status}', 
              post_tags = '${post_tags}', 
              post_content = '${post_content}', 
              post_image = '${post_image}' 
            WHERE post_id = '{$the_post_id}'";
  $update_post = mysqli_query($connection, $query);
  confirm($update_post);
  echo "<p class='bg-success'>Post Updated. 
  <a href='../post.php?p_id={$the_post_id}'>View Post</a> or 
  <a href='posts.php'>Edit More Posts</a></p>";
}
?>

<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="post_title">Post Title</label>
    <input type="text" class="form-control" name="post_title" value="<?php echo $post_title ?>">
  </div>
  <div class="form-group">
    <label for="post_category">Category</label><br>
    <select name="post_category" id="">
      <?php
      $query = "SELECT * FROM categories";
      $select_categories = mysqli_query($connection, $query);
      confirm($select_categories);
      while($row = mysqli_fetch_assoc($select_categories)){
        $cat_id = $row["cat_id"];
        $cat_title = $row["cat_title"];
        echo "<option value='{$cat_id}'>{$cat_title}</option>";
      }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="post_author">Post Author</label>
    <input type="text" class="form-control" name="post_author" value="<?php echo $post_author ?>">
  </div>
  <div class="form-group">
    <label for="post_status">Post Status</label><br>
    <select name="post_status" id="">
      <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
      <?php if($post_status == "PUBLISHED"){
        echo "<option value='Draft'>Draft</option>";
      }else{
        echo "<option value='PUBLISHED'>PUBLISHED</option>";
      } ?>
    </select>
  </div>
  <div class="form-group">
    <label for="post_image">Post Image</label><br>
    <img width="100" src="../images/<?php echo $post_image; ?>" alt="image">
    <input type="file" class="" name="post_image" value="<?php echo $post_image;?>">
  </div>
  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags ?>">
  </div>
  <div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"><?php echo $post_content ?></textarea>
  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
  </div>
</form>