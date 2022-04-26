<?php include "includes/admin_header.php" ?>

  <div id="wrapper">
    
    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">
      <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
          <div class="col-lg-12">
            <h1 class="page-header">
              Welcome to Admin
              <small>John Doe</small>
            </h1>
            <?php
              if(isset($_GET["source"])){
                $source = $_GET["source"];
              } else {
                $source = "";
              }
              switch($source){
                case 'add_user';
                  include "includes/admin_add_user.php";
                  break;
                case 'edit_user';
                  include "includes/admin_edit_user.php";
                  break;
                default;
                  include "includes/admin_verbose_users.php";
                  break;
              }
            ?>
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