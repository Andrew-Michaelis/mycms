<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php 
            if(isset($_GET["p_id"])){
                $the_post_id = $_GET["p_id"];

                //increment page view count each time the page is acessed
                $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $the_post_id";
                $send_view_query = mysqli_query($connection, $view_query);

                //get every post from the database
                $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                $select_all_posts_query = mysqli_query($connection,$query);

                while($row = mysqli_fetch_assoc($select_all_posts_query)){
                    $post_id = $row["post_id"];
                    $post_title = $row["post_title"];
                    $post_author = $row["post_author"];
                    $post_date = $row["post_date"];
                    $post_image = $row["post_image"];
                    $post_content = $row["post_content"];
                ?>
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> 
                        Posted on <?php echo $post_date ?>
                    </p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                    <hr>
                    <p>
                        <?php echo $post_content ?>
                    </p>
                    <hr>
            <?php }
            }else{
                header("Location: ./index.php", true);
            } ?>
        </div>
        
        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>
    </div>
        
    <!-- Create Comments -->
    <?php
    if(isset($_POST["create_comment"])){
        $the_post_id = $_GET["p_id"];
        
        $comment_author = $_POST["comment_author"];
        $comment_email = $_POST["comment_email"];
        $comment_content = $_POST["comment_content"];
        if(!empty($comment_author)&&!empty($comment_email)&&!empty($comment_content)){

            $query ="INSERT INTO comments 
                        (comment_post_id,
                        comment_date,
                        comment_author,
                        comment_email,
                        comment_content,
                        comment_status)
                    VALUES 
                        ($the_post_id,
                            now(),
                        '{$comment_author}',
                        '{$comment_email}',
                        '{$comment_content}',
                        'Awaiting Judgement')";
            $create_comment_query = mysqli_query($connection, $query);

            if(!$create_comment_query){die("QUERY FAILED ".mysqli_error($connection));}
            $query = "UPDATE posts SET post_comment_count = post_comment_count+1 WHERE post_id = $the_post_id";
            
            $increment_comment_count_query = mysqli_query($connection, $query);
            if(!$increment_comment_count_query){die("QUERY FAILED ".mysqli_error($connection));}

            header("Location: post.php?p_id={$the_post_id}");
        }else{
            echo "<script>alert('Fields cannot be empty')</script>";
        }
    }
    ?>

    <!-- Comments Form -->
    <div class="well">
        <h4>Leave a Comment:</h4>
        <form action="" method="post" role="form">
            <div class="form-group">
                <label for="Author">Author</label>
                <input type="text" name="comment_author" class="form-control" name="comment_author">
            </div>
            <div class="form-group">
                <label for="Email">Email</label>
                <input type="email" name="comment_email" class="form-control" name="comment_email">
            </div>
            <div class="form-group">
                <label for="comment">Your Comment Here</label>
                <textarea name="comment_content" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <hr>
    <!-- Posted Comments -->

    <?php
    $query ="SELECT * FROM comments WHERE comment_post_id = {$the_post_id}
            AND comment_status = 'APPROVED' ORDER BY comment_id DESC ";
    $select_comment_query = mysqli_query($connection, $query);
    if(!$select_comment_query){die("QUERY FAILED ".mysqli_error($connection));}
    while($row = mysqli_fetch_array($select_comment_query)){
        $comment_date = $row["comment_date"];
        $comment_content = $row["comment_content"];
        $comment_author = $row["comment_author"];
        ?>
        <div class="media">
            <a class="pull-left" href="#">
                <img class="mr-3" src="/images/generic64x64.svg" alt="Generic Placeholder Image">
            </a>
            <div class="media-body">
                <h4 class="mt-0"><?php echo $comment_author; ?>
                <small><?php echo $comment_date; ?></small>
                </h4>
                <?php echo $comment_content; ?>
            </div>
        </div>
    <?php } ?>
</div>
<hr>

<?php include "includes/footer.php"; ?>