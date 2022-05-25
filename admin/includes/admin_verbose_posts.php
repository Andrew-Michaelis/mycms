<?php
if(isset($_POST["checkBoxArray"])){
  foreach($_POST["checkBoxArray"] as $postValueId){
    $bulk_options = $_POST["bulk_options"];
    switch($bulk_options){
    case "PUBLISHED":
      $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
      $update_to_published = mysqli_query($connection, $query);
      confirm($update_to_published);
      break;
    case "Draft":
      $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
      $update_to_draft = mysqli_query($connection, $query);
      confirm($update_to_draft);
      break;
    case "delete":
      $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
      $delete_selected = mysqli_query($connection, $query);
      confirm($delete_selected);
      break;
    case "clone":
      $query = "SELECT * FROM posts WHERE post_id = {$postValueId}";
      $select_post_query = mysqli_query($connection, $query);
      confirm($select_post_query);
      while($row = mysqli_fetch_array($select_post_query)){
        $post_title = $row["post_title"];
        $post_category_id = $row["post_category_id"];
        $post_date = $row["post_date"];
        $post_author = $row["post_author"];
        $post_status = $row["post_status"];
        $post_image = $row["post_image"];
        $post_tags = $row["post_tags"];
        $post_content = $row["post_content"];
      }
      $query = "INSERT INTO posts(post_category_id, 
                            post_title,
                            post_author,
                            post_date,
                            post_image,
                            post_content,
                            post_tags,
                            post_status) 
                      VALUES({$post_category_id},
                      '{$post_title}',
                      '{$post_author}',
                      now(),
                      '{$post_image}',
                      '{$post_content}',
                      '{$post_tags}',
                      '{$post_status}') ";
      $copy_query = mysqli_query($connection, $query);
      confirm($copy_query);
      break;
    }
  }
}
?>

<form action="" method="post">
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <div id="bulkOptionsContainer" class="col-xs-4" style="padding-left: 0px;">
        <select class="form-control" name="bulk_options" id="">
          <option value="">Select Options</option>
          <option value="PUBLISHED">Publish</option>
          <option value="Draft">Draft</option>
          <option value="delete">Delete</option>
          <option value="clone">Clone</option>
        </select>
      </div>
      <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
      </div>
      <thead>
        <tr>
          <th><input id="selectAllBoxes" type="checkbox"></th>
          <th>Id</th>
          <th>Title</th>
          <th>Author</th>
          <th>Category</th>
          <th>Status</th>
          <th>Image</th>
          <th>Tags</th>
          <th>Comments / Views</th>
          <th>Date</th>
          <th>View Post</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $query = "SELECT * FROM posts ORDER BY post_id DESC";
          $select_posts = mysqli_query($connection, $query);

          while($row = mysqli_fetch_assoc($select_posts)){
            $post_id = $row["post_id"];
            $post_author = $row["post_author"];
            $post_title = $row["post_title"];
            $post_category = $row["post_category_id"];
            $post_status = $row["post_status"];
            $post_image = $row["post_image"];
            $post_tags = $row["post_tags"];
            $post_comments = $row["post_comment_count"];
            $post_views = $row["post_views_count"];
            $post_date = $row["post_date"];

            // insert data into row and display
            echo "<tr>"; 
            ?>
            <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id ?>'></td>
            <?php
            echo "<td>{$post_id}</td>";
            echo "<td>{$post_title}</td>";
            echo "<td>{$post_author}</td>";
    // ---------------------------------------------------------------------------------
              $query = "SELECT * FROM categories WHERE cat_id = {$post_category} ";
              $select_categories_id = mysqli_query($connection, $query);
              confirm($select_categories_id);
              while($row = mysqli_fetch_assoc($select_categories_id)){
                $cat_id = $row["cat_id"];
                $cat_title = $row["cat_title"];
              }
    // ---------------------------------------------------------------------------------
            echo "<td>{$cat_title}</td>";
            echo "<td>{$post_status}</td>";
            echo "<td><img width='100' src='../images/$post_image' alt='image'></td>";
            echo "<td>{$post_tags}</td>";
            echo "<td>{$post_comments} / <a href='posts.php?reset={$post_id}'>{$post_views}</a></td>";
            echo "<td>{$post_date}</td>";
            echo "<td><a href='../post.php?p_id={$post_id}'>View</a></td>";
            echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
            echo "<td><a onClick=\"javascript: return confirm('Are you sure?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
            echo "</tr>";
          }
        ?>
      </tbody>
    </table>
  </div>
</form>
<?php
if(isset($_GET["delete"])){
  $post_id = mysqli_real_escape_string($connection, $_GET['delete']);
  $query = "DELETE FROM posts WHERE post_id = $post_id" ;
  $delete_query = mysqli_query($connection, $query);
  confirm($delete_query);
  header("Location: posts.php", true);
}
if(isset($_GET["reset"])){
  $post_id = mysqli_real_escape_string($connection, $_GET['reset']);
  echo $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = $post_id";
  $zero_query = mysqli_query($connection, $query);
  confirm($zero_query);
  header("Location: posts.php", true);
}
?>