<?php include "includes/admin_header.php" ?>

<div id="wrapper">

<?php
$session = session_id();
$time = time();
$timeout_in_seconds = 30;
$timeout = $time - $timeout_in_seconds;
$query = "SELECT * FROM users_online";
$send_query = mysqli_query($connection, $query);
$count = mysqli_num_rows($send_query);

if($count == NULL){
    mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
}else{
    mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
}
$users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$timeout'");
$count_user = mysqli_num_rows($users_online_query);
?>

<!-- Navigation! -->
    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small><?php echo $_SESSION["username"]." ".$count; ?></small>
                    </h1>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                    $query = "SELECT * FROM posts";
                                    $select_all_post = mysqli_query($connection, $query);
                                    confirm($select_all_post);
                                    $post_counts = mysqli_num_rows($select_all_post);
                                    echo "<div class='huge'>{$post_counts}</div>"
                                    ?>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                    $query = "SELECT * FROM comments";
                                    $select_all_comments = mysqli_query($connection, $query);
                                    confirm($select_all_comments);
                                    $comment_counts = mysqli_num_rows($select_all_comments);
                                    echo "<div class='huge'>{$comment_counts}</div>"
                                    ?>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                    $query = "SELECT * FROM users";
                                    $select_all_users = mysqli_query($connection, $query);
                                    confirm($select_all_users);
                                    $user_counts = mysqli_num_rows($select_all_users);
                                    echo "<div class='huge'>{$user_counts}</div>"
                                    ?>
                                    <div> Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                    $query = "SELECT * FROM categories";
                                    $select_all_categories = mysqli_query($connection, $query);
                                    confirm($select_all_categories);
                                    $category_counts = mysqli_num_rows($select_all_categories);
                                    echo "<div class='huge'>{$category_counts}</div>"
                                    ?>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <?php
                $query = "SELECT * FROM posts WHERE post_status != 'PUBLISHED'";
                $select_post_drafts = mysqli_query($connection, $query);
                $post_draft_count = mysqli_num_rows($select_post_drafts);

                $query = "SELECT * FROM comments WHERE comment_status = 'UNAPPROVED'";
                $select_unapproved_comments = mysqli_query($connection, $query);
                $un_comment_count = mysqli_num_rows($select_unapproved_comments);

                $query = "SELECT * FROM users WHERE user_role = 'Subscriber'";
                $select_all_subs = mysqli_query($connection, $query);
                $subscriber_count = mysqli_num_rows($select_all_subs);
            ?>
            <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['', 'Total', {role:'style'}],
                        <?php
                        $element_text = ['Posts', 'Draft Posts', 
                                            'Comments', 'Unapproved Comments', 
                                            'Users', 'Subscribers', 
                                            'Categories'];
                        $element_count = [$post_counts, $post_draft_count, 
                                            $comment_counts, $un_comment_count, 
                                            $user_counts, $subscriber_count,
                                            $category_counts];
                        $element_color = ['#337ab7','#337ab7',
                                            '#5cb85c','#5cb85c',
                                            '#efad4e','#efad4e',
                                            '#d9534f'];
                        for($i = 0;$i < 7;$i++){
                            echo "['{$element_text[$i]}', $element_count[$i], '$element_color[$i]'],";
                        }
                        ?>
                        ]);

                        var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1, { calc: "stringify",
                                                sourceColumn: 1,
                                                type: "string",
                                                role: "annotation" }, 2]);
                        var options = {
                            chart: {title: 'General Overview'},
                            chartArea: {width:'95%',
                                        height: '98%'},
                            hAxis: {textPosition: 'in',},
                            bar: {groupWidth: "92%"},
                            legend: {position: "none"},
                        };

                        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_material'));
                        chart.draw(view, options);
                    }
                </script>
                <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<?php include "includes/admin_footer.php" ?>