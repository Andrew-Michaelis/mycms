<?php include "includes/admin_header.php";
if(isset($_SESSION["username"])){
  $username = $_SESSION["username"];
  $query = "SELECT * FROM users WHERE username = '{$username}'";
  $select_user_query = mysqli_query($connection, $query);
  confirm($select_user_query);
  while($row = mysqli_fetch_array($select_user_query)){
    $user_id = $row["user_id"];
    $username = $row["username"];
    $user_password = $row["user_password"];
    $user_firstname = $row["user_firstname"];
    $user_lastname = $row["user_lastname"];
    $user_email = $row["user_email"];
    $user_image = $row["user_image"];
    $user_role = $row["user_role"];
  }
}
if(isset($_POST["update_profile"])){
  $user_firstname = $_POST["user_firstname"];
  $user_lastname = $_POST["user_lastname"];
  $user_role = $_POST["user_role"];
  $username = $_POST["username"];
  $user_password = $_POST["user_password"];
  $user_email = $_POST["user_email"];

  $query = "UPDATE users SET 
              user_firstname = '${user_firstname}', 
              user_lastname = '${user_lastname}', 
              user_role = '${user_role}', 
              username = '${username}', 
              user_password = '${user_password}', 
              user_email = '${user_email}'
            WHERE username = '{$username}'";
  $update_user_query = mysqli_query($connection, $query);
  confirm($update_user_query);
}
?>
  <div id="wrapper">
    
    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">
      <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
          <div class="col-lg-12">
            <h1 class="page-header">
              Your Profile
              <small><?php echo $_SESSION["username"]; ?></small>
            </h1>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="user_firstname">First Name</label>
                <input type="text" value="<?php echo $user_firstname ?>" class="form-control" name="user_firstname">
              </div>
              <div class="form-group">
                <label for="user_lastname">Last Name</label>
                <input type="text" value="<?php echo $user_lastname ?>" class="form-control" name="user_lastname">
              </div>
              <div class="form-group">
                <label for="user_role">User Permissions</label><br>
                <select name="user_role" is="">
                  <option value="<?php echo $user_role ?>"><?php echo $user_role ?></option>
                  <?php 
                  if($user_role == "Admin"){
                    echo "<option value='Subscriber'>Subscriber</option>";
                  }else{
                    echo "<option value='Admin'>Admin</option>";
                  }
                  ?>
                </select>
              </div>
              <!-- <div class="form-group">
                <label for="user_image">Profile Picture</label>
                <input type="file" class="form-control" name="user_image">
              </div> -->
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" value="<?php echo $username ?>" class="form-control" name="username">
              </div>
              <div class="form-group">
                <label for="user_password">Password</label>
                <input type="password" value="<?php echo $user_password ?>" class="form-control" name="user_password">
              </div>
              <div class="form-group">
                <label for="user_email">Email Address</label>
                <input type="email" value="<?php echo $user_email ?>" class="form-control" name="user_email">
              </div>
              <div class="form-group">
                <input class="btn btn-primary" type="submit" name="update_profile" value="Update">
              </div>
            </form>
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
  </div>
  <!-- /#wrapper -->

<?php include "includes/admin_footer.php" ?>