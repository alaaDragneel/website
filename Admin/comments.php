<?php
	/*
	==========================================
	== comment page
	== you can EDIT | DELETE | Approve [pagename] page
	==========================================
	*/
    ob_start();
	session_start();
    include "init.php";
    if(isset($_SESSION["userName"])) {

	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // Check if the $do is Exixets

	//start [pagename] page

	if ($do == 'Manage') {// if the do is equal manage
        //start select the data 
        $commSelect = $conn->prepare("SELECT comments.*, articles.Title AS TITLE FROM comments
                                      INNER JOIN articles ON articles.ID = comments.article_id");
        //start excute the data
        $commSelect->execute();
        //count the row 
        $count = $commSelect->rowCount();
        //if the count > 0 start fetch
        if($count > 0){//start if
            $rows = $commSelect->fetchAll(); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Manage comment page</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Manage comment page You Can [ Edit | Delete | Update | Approve] comment
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Email</th>
                                        <th>Comment</th>
                                        <th>Status</th>
                                        <th>Time</th>
                                        <th>Date</th>
                                        <th>artical</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($rows as $row){ //start loop

                                            echo '<tr class="odd gradeX">';
                                                echo "<td>". $row["ID"] ."</td>";
                                                echo "<td>". $row["comment"] ."</td>";
                                                echo "<td>". $row["email"] ."</td>";
                                                echo "<td>";
                                                    if($row["status"] == 0){echo "<span class='desabled'>NotApproved</span>";}
                                                    if($row["status"] == 1){echo "<span class='approved'>Approved</span>";}
                                                echo"</td>";
                                                echo "<td>". $row["comment_time"] ."</td>";
                                                echo "<td>". $row["comment_date"] ."</td>";
                                                echo "<td>". str_replace('-', ' ',$row["TITLE"]) ."</td>";
                                                echo "<td>";
                                                    echo '<a class="btn btn-info btn-block" href="?do=Edit&ID='. $row["ID"] .'" >Edit</a>';
                                                    echo '<a class="btn btn-danger btn-block confirm" href="?do=Delete&ID='. $row["ID"] .'" >Delete</a>';
                                                    if($row["status"] == 0){
                                                         echo '<a class="btn btn-success btn-block confirm" href="?do=approve&ID='. $row["ID"] .'" >Approve</a>'; 
                                                    }
                                                echo"</td>";
                                            echo "</tr>";
                                        } //end loop
                                    ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <?php  }else{
                            echo "<div class='container'> ";
                                echo  "<div class='alert alert-warning text-center' style='margin-top: 20px;'> there are no data to show</div>";
                            echo "</div>";
                        } 
                ?>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    <?php
      
	}elseif ($do == 'Edit') { // Edit Page
        //get the ID 
        $commId = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        // start prepare for the select
        $commEdit = $conn->prepare("SELECT * FROM comments WHERE ID = ?");
        //start execute the data
        $commEdit->execute(array($commId));
        //fetch the data
        $commRows = $commEdit->fetch();
    ?>
        <div class="main-content">
        <!-- You only need this form and the form-basic.css -->
        <form class="form-basic" method="post" action="?do=Update">
        <input type="hidden" name="commId" value="<?php echo $commId?>" />
            <div class="form-title-row">
                <h1>Edit comment</h1>
            </div>
            <div class="form-row">
                <label>
                    <span>email</span>
                    <input type="email" name="email" value="<?php echo $commRows["email"] ?>" />
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>comment</span>
                     <textarea style="resize:none" maxlength="150" name="comment"><?php echo $commRows["comment"] ?></textarea>
                </label>
            </div>
            <input class="btn btn-primary" style="color:#fff;margin-left: 80px;" type="submit" name="submit" value="Edit comment" />
        </form>
     <?php   
	}elseif ($do == 'Update') { // Update Page
        $commId        = isset($_POST['commId']) && is_numeric($_POST['commId']) ? intval($_POST['commId']) : 0;
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
            echo "<div class='container'> ";
                foreach($formError as $err){
                        echo "<div class='alert alert-danger text-center' style='margin-top: 20px;'>". $err ."</div>";
                }
                redirect(@$msg, "PrevPage", "Peview", 5); // redirect dynamic function
            echo "</div>";    
        }
        if(empty($formError)){
            //start insert the comment
            $commUpdate = $conn->prepare("UPDATE comments SET email = ?, comment = ? WHERE ID = ?");
            $commUpdate->execute(array( $email, $comment, $commId));
            echo "<div class='container'> ";
                $msg = "<div class='alert alert-success text-center'>".$commUpdate->rowCount()." Comment updated</div>";
                redirect($msg, "PrevPage", "Peview"); // redirect dynamic function
            echo "</div>"; 
        }
       
	}elseif ($do == 'Delete') { // Delete Page
        //get the ID 
        $commId = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        //select all data depend on the id
        $check = checkItme( 'ID', 'comments', $commId);
        //if there is such id show form
        if ($check > 0) { 
            // start prepare for the delete
            $commDelete = $conn->prepare("DELETE FROM comments WHERE ID = :ID");
            //bind Param the data
            $commDelete->bindParam('ID', $commId);
            //start execute the data
            $commDelete->execute();
             echo "<div class='container'> ";
                $msg =  "<div class='alert alert-success text-center'>". $commDelete->rowCount() ." comment Is Deleted</div>";
                redirect($msg, "PrevPage", "Peview");
            echo"</div>";
        }else{
            echo "<div class='container'> ";
                $msg =  "<div class='alert alert-danger text-center'>ther is no such ID [ ". $commId ." ]</div>";
                redirect($msg, "PrevPage", "Peview");
            echo"</div>";
        }

	}elseif ($do == 'approve') { // Approve Page
        // get the Id
        $commId = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;

        $commApprove = $conn->prepare("UPDATE comments SET status = ? WHERE ID = ?");
        //excute the Approve statemnt
        $commApprove->execute(array( 1, $commId));
        echo "<div class='container'> ";
            $msg =  "<div class='alert alert-success text-center'>". $commApprove->rowCount() ." comment Is Approved</div>";
            redirect($msg, "PrevPage", "Peview");
        echo"</div>";
    }
		
		
	include "Includes/templates/footer.php";
    }else{
        header('location: index.php');//redirect to the dashboard page
        exit();
    }
    ob_end_flush();
?>