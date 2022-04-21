<form action="" method="POST">
  <div class="form-group">
    <label for="cat_title">Edit Category</label>
    <?php
    if(isset($GET_["edit"])){
      $cat_id = $_GET["edit"];
      $query = "SELECT * FROM categories WHERE cat_id = $cat_id ";
      $select_categories_id = mysqli_query($connection, $query);
      while($row = mysqli_fetch_assoc($select_categories_id)){
        $cat_id = $row["cat_id"];
        $cat_title = $row["cat_title"];
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>"; ?>
        <input value="<?php if(isset($cat_title)){echo $cat_title;} ?>" class="form-control" type="text" name="cat_title">
      <?php }
    } ?>
    <?php // UPDATE SELECTED CATEGORY QUERY
    if(isset($_POST["update_category"])){
      $get_cat_title = $_POST["cat_title"];
      $query = "UPDATE categories SET cat_title = '{$get_cat_title}' WHERE cat_id = {$cat_id} ";
      $update_query = mysqli_query($connection, $query);
      confirm($update_query);
    }
    ?>
  </div>
  <div class="form-group">
    <input class="form-control" type="text" name="cat_title">
  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
  </div>
</form>