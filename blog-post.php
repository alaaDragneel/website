<?php
	ob_start();
	include "init.php";
    //get Artical ID
     $artId = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
    // start select the articals
        $artSelect = $conn->prepare("SELECT articles.*, admins.Name AS ADMIN_NAME 
                                    FROM articles 
                                    INNER JOIN admins ON admins.ID = articles.admin_ID
                                    && articles.ID = ?");
        $artSelect->execute(array($artId));
        $artRows = $artSelect->fetch();
?>
<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Blog Post
                <small>by <span class="approved"><?php echo $artRows["ADMIN_NAME"] ?></span>
                </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <li class="active">Blog Post</li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

    <!-- Content Row -->
    <div class="row">
        <!-- Blog Post Content Column -->
        <div class="col-lg-8">
            <!-- Blog Post -->
            <hr>
            <!-- Date/Time -->
            <p><i class="fa fa-clock-o"></i> Posted on <?php echo $artRows["Date"] ?> at <?php echo $artRows["Time"] ?></p>
            <hr>
            <!-- Preview Image -->
            <img class="img-responsive" src="Admin/Layout/img/artical_img/<?php echo $artRows["Img"] ?>" alt="">
            <hr>
            <!-- Post Content -->
            <p class="lead"><?php echo str_replace('-', ' ',$artRows["Title"]) ?></p>
            <p><?php echo str_replace('-', ' ',$artRows["Content"] )?></p>
            <hr>

            <!-- Blog Comments -->
            <!-- Comments Form -->
            <div class="well">
            <?php
                if(isset($_POST["addComment"])){
                    $email        = trim(strip_tags($_POST["email"]));
                    $comment      = trim(strip_tags($_POST["comment"]));
                    $formError = array();
                    if(empty($email)){
                        $formError[] = "email Filed Can't be Empty";
                    }
                    if(empty($comment)){
                        $formError[] = "comment Title Filed Can't be Empty";
                    }
                    if(!empty($formError)){ // if not he array empty
                            foreach($formError as $err){
                                    echo "<div class='alert alert-danger text-center' style='margin-top: 20px;'>". $err ."</div>";
                            }
                    }
                    if(empty($formError)){
                        //start insert the comment
                        $commInsert = $conn->prepare("INSERT INTO comments(email, comment, comment_time,comment_date, article_id)
                                                                  VALUES(:commEmail, :commComment, now(),now(), :commArt)");
                        $commInsert->execute(array(
                                'commEmail'      => $email,
                                'commComment'    => $comment,
                                'commArt'        => $artId
                            ));
                            echo "<div class='alert alert-info text-center'>your comment is now uploaded to the admin and please wait until the admin approve your comment</div>";
                        
                    }

                }
            ?>
                <h4>Leave a Comment:</h4>
                <form role="form" method="post">
                    <div class="form-group">
                        <input type="email" class="form-control" rows="3" placeholder="email Here Plaease" name="email" />
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="3" placeholder="comment Here Plaease" name="comment"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="addComment">Submit</button>
                </form>
            </div>


            <!-- Posted Comments -->
            <?php
                //start select the data 
                $commSelect = $conn->prepare("SELECT * FROM comments WHERE status = 1 && article_id = ? ORDER BY ID DESC");
                //start excute the data
                $commSelect->execute(array($artId));
                //count the row 
                $count = $commSelect->rowCount();
                //if the count > 0 start fetch
                if($count > 0){//start if
                    $rows = $commSelect->fetchAll(); 
                    foreach($rows as $comm){
                        echo '<hr>';
                        echo '<!-- START Comment -->';
                        echo '<div class="media">';
                            echo '<a class="pull-left" href="#">';
                                echo '<img class="media-object" src="Admin/Layout/img/avatar.jpg" alt="avatar" 
                                        style="width: 64px; height: 64px;border-radius: 50%;">';
                            echo '</a>';
                            echo '<div class="media-body">';
                                echo '<h4 class="media-heading">'.$comm["email"] . '<br/>';
                                    echo '<small>'.$comm["comment_date"].'at '.$comm["comment_time"].'</small>';
                                echo '</h4>';
                                echo '<p>'. $comm["comment"].'</p>';
                            echo '</div>';
                        echo '</div>';

                        echo '<!-- END Comment -->';
                        
                    }

                }
            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-4">
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