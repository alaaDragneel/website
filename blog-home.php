<?php
	ob_start();
	include "init.php";

?>
<!-- Page Content -->
<div class="container">
    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Blog Home
                <small>Subheading</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <li class="active">Blog Home</li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
    <?php
        // start select the articals
        $artSelect = $conn->prepare("SELECT articles.*, admins.Name AS ADMIN_NAME 
                                    FROM articles 
                                    INNER JOIN admins ON admins.ID = articles.admin_ID
                                    ORDER BY ID DESC");
        $artSelect->execute();
        $countArt = $artSelect->rowCount();
        if($countArt > 0){
            $artRows = $artSelect->fetchAll();
             echo '<!-- Blog Entries Column -->';
            echo ' <div class="col-md-8"><!-- First Blog Post -->';
            foreach($artRows as $row){
                echo' <div class="blogs">';
                    echo '<h2>';
                       echo '<a href="blog-post.php?ID='. $row["ID"] .'">'. str_replace('-', ' ',$row["Title"]) .'</a>';
                    echo '</h2>';
                    echo '<p class="lead">';
                        echo 'by <span class="approved">'. $row["ADMIN_NAME"] .'</span>';
                    echo '</p>';
                    echo '<p><i class="fa fa-clock-o"></i> Posted on '. $row["Date"] .' at '. $row["Time"] .'</p>';
                    echo '<hr>';
                    echo '<a href="blog-post.php?ID='. $row["ID"] .'">';
                       echo '<img class="img-responsive img-hover" src="Admin/Layout/img/artical_img/'. $row["Img"] .'" alt="">';
                    echo '</a>';
                    echo '<hr>';
                    echo '<p>';
                        echo  str_replace('-', ' ', $row["Content"]);
                    echo '</p>';
                    echo '<a class="btn btn-primary" href="blog-post.php?ID='. $row["ID"] .'">Read More <i class="fa fa-angle-right"></i></a>';
                    echo '<hr>';
                echo '</div>';
            }
        echo '</div>';
        }
    ?>
     <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-4">



            <!-- Blog Search Well -->
            <div class="well">
                <h4>Blog Search</h4>
                <div class="input-group">
                    <input type="text" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                    </span>
                </div>
                <!-- /.input-group -->
            </div>



            <!-- Blog Categories Well -->
            <div class="well">
                <h4>Blog Categories</h4>
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-unstyled">
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.col-lg-6 -->
                </div>
                <!-- /.row -->
            </div>
        </div>
    </div>
    <!-- /.row -->



    <hr>
</div>
<!-- /.container -->
<?php
	include "includes/templates/footer.php";
	ob_end_flush();
?>