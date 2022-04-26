<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Username</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Make Admin</th>
      <th>Make Sub</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $query = "SELECT * FROM users";
    $select_users = mysqli_query($connection, $query);
    confirm($select_users);

    while($row = mysqli_fetch_assoc($select_users)){
      $user_id = $row["user_id"];
      $username = $row["username"];
      $user_firstname = $row["user_firstname"];
      $user_lastname = $row["user_lastname"];
      $user_email = $row["user_email"];
      $user_role = $row["user_role"];

      // insert data into row and display
      echo "<tr>";
      echo "<td>{$user_id}</td>";
      echo "<td>{$username}</td>";
      echo "<td>{$user_firstname}</td>";
      echo "<td>{$user_lastname}</td>";
      echo "<td>{$user_email}</td>";
      echo "<td>{$user_role}</td>";
      echo "<td><a href='users.php?upgrade={$user_id}'>Admin</a></td>";
      echo "<td><a href='users.php?downgrade={$user_id}'>Subscriber</a></td>";
      echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
      echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
      echo "</tr>";
    }
    ?>
  </tbody>
</table>
<?php
if(isset($_GET["upgrade"])){
  $user_id = $_GET["upgrade"];
  $query = "UPDATE users SET user_role = 'Admin' WHERE user_id = {$user_id}";
  $up_query = mysqli_query($connection, $query);
  confirm($up_query);
  header("Location: users.php", true);
}
if(isset($_GET["downgrade"])){
  $user_id = $_GET["downgrade"];
  $query = "UPDATE users SET user_role = 'Subscriber' WHERE user_id = {$user_id}";
  $down_query = mysqli_query($connection, $query);
  confirm($down_query);
  header("Location: users.php", true);
}
if(isset($_GET["delete"])){
  $user_id = $_GET["delete"];
  $query = "DELETE FROM users WHERE user_id = {$user_id}";
  $delete_query = mysqli_query($connection, $query);
  confirm($delete_query);
  header("Location: users.php", true);
}
?>