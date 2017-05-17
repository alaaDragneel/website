<?php
	/*
	==========================================
	== Services page
	== you can EDIT | DELETE | ADD Service page
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
        $serSelect = $conn->prepare("SELECT 
                                        articles.*, 
                                        services.Name AS SERVICE_NAME,
                                        admins.Name   AS ADMIN_NAME 
                                     FROM articles
                                     INNER JOIN services ON services.ID = articles.Service_ID
                                     INNER JOIN admins   ON admins.ID   = articles.admin_ID
                                     ");
        //start excute the data
        $serSelect->execute();
        //count the row 
        $count = $serSelect->rowCount();
        //if the count > 0 start fetch
        if($count > 0){//start if
            $rows = $serSelect->fetchAll(); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Manage articals Page</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Manage articals Page You Can [ Edit | Delete | Update | Add ] Members
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Img</th>
                                        <th>Time</th>
                                        <th>Date</th>
                                        <th>Service</th>
                                        <th>Added By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php
                                      foreach($rows as $row){ //start loop

                                            echo '<tr class="odd gradeX">';
                                                echo "<td>". $row["ID"] ."</td>";
                                                echo "<td>". str_replace('-', ' ', $row["Title"]) ."</td>";
                                                echo "<td>". str_replace('-', ' ', $row["Content"]) ."</td>";
                                                echo "<td><img class='thumbnail' style='margin: 15px auto;' width='250' height='250' src='Layout/img/artical_img/". $row["Img"] ."'/> </td>";
                                                echo "<td>". $row["Time"] ."</td>";
                                                echo "<td>". $row["Date"] ."</td>";
                                                echo "<td>". $row["SERVICE_NAME"] ."</td>";
                                                echo "<td>". $row["ADMIN_NAME"] ."</td>";
                                                echo "<td>";
                                                    echo '<a class="btn btn-info btn-block" href="?do=Edit&ID='. $row["ID"] .'" >Edit</a>';
                                                    echo '<a class="btn btn-danger btn-block confirm" href="?do=Delete&ID='. $row["ID"] .'" >Delete</a>';
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
                    <a class="btn btn-primary" href="?do=Add" style="margin-bottom: 20px;">Add new artical</a>
                </div>
                <?php  }else{
                            echo "<div class='container'> ";
                                echo  "<div class='alert alert-warning text-center' style='margin-top: 20px;'> there are no data to show</div>";
                                echo '<a class="btn btn-primary " href="?do=Add" style="margin-left: 45%; margin-bottom: 4%;">Add new artical</a>';
                            echo "</div>";
                        } 
                ?>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    <?php
	}elseif ($do == 'Add') { // Add Page
	?>
    <div class="main-content">
        <!-- You only need this form and the form-basic.css -->
        <form class="form-basic" method="post" action="?do=Insert" enctype="multipart/form-data">
            <div class="form-title-row">
                <h1>Add Artical</h1>
            </div>
            <div class='alert alert-info text-center'>the Image extension Must Be [ png, gif, jpeg, jpg, pjpeg, x-png, png ]
            </div>
            <div class="form-row">
                <label>
                    <span>Title</span>
                    <input type="text" name="title">
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Content</span>
                    <textarea name="Scoap" style="resize:none" maxlength="150"></textarea>
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span class="col-md-2" >Image</span>
                    <input class="form-control col col-md-10" type="file" name="img" >
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Service</span>
                    <select name="service">
                        <option value="0">------------Select Service------------</option>
                        <?php
                            //start select the data 
                            $serSelect = $conn->prepare("SELECT * FROM services");
                            //start excute the data
                            $serSelect->execute();
                            //count the row 
                            $count = $serSelect->rowCount();
                            //if the count > 0 start fetch
                            if($count > 0){//start if
                                $servRows = $serSelect->fetchAll();
                                foreach($servRows as $row){
                                    echo '<option value="'. $row["ID"] .'">'. $row["Name"] .'</option>';
                                } 
                            }
                        ?>
                    </select>
                </label>
            </div>
            <div class="form-row">
                <input class="btn btn-primary" style="color:#fff;margin-left: 162px;" type="submit" name="submit" value="Add new artical" />
            </div>
        </form>
    </div>
    <?php
	}elseif ($do == 'Insert') { // Insert Page
         if($_SERVER["REQUEST_METHOD"] == 'POST'){
            // get the post values
            $title           = str_replace(' ', '-',trim(strip_tags($_POST["title"])));
            $Scoap           = str_replace(' ', '-',trim(strip_tags($_POST["Scoap"])));
            $service         = $_POST["service"];
            $dir_name        = dirname(__FILE__) . "/Layout/img/artical_img/";
            $path            = $_FILES['img']['tmp_name'];//temporary path
            $name            = $_FILES['img']['name'];
            $size            = $_FILES['img']['size'];
            $type            = $_FILES['img']['type']; //image type
            $error           = $_FILES['img']['error'];

            /*Start Check the Fileds */
            $formError = array();
            if(empty($title)){
                $formError[] = "title Filed Can't be Empty";
            }
            if(empty($Scoap)){
                $formError[] = "Scoap Filed Can't be Empty";
            }
            if(empty($service)){
                $formError[] = "you must choose service";
            }
            if(empty($name)){
                $formError[] = "You Must Select Image";
            }
            if(!empty($name) && $size > 300000) { //if the image filed not empty and size
                $formError[] = "the Image too Large";
            }
            if(!empty($name) && 
                in_array($type, array('image/png', 'image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png')) === FALSE) { //if the image filed not empty and image type 
                $formError[] = "the Image extension Must Be [ 'image/png', 'image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png' ]";
            }
            if(!empty($name) && !$error && in_array($type, array('image/png', 'image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png')) === TRUE) { //if the image filed not empty and ther is no errors 
                move_uploaded_file($path, $dir_name . $name); // move to the temp Folder
            }
            if(!empty($formError)){ // if not he array empty
                    echo "<div class='container'> ";
                foreach($formError as $err){
                        echo "<div class='alert alert-danger text-center' style='margin-top: 20px;'>". $err ."</div>";
                }
                    redirect(@$msg, "PrevPage", "Peview", 5); // redirect dynamic function
                    echo"</div>";

            }
            if(empty($formError)){ // if the array empty
                $countPro = checkItme("Title", "articles", $title);
                if($countPro > 0){
                    echo "<div class='container'> ";
                        $msg = "<div class='alert alert-danger text-center' style='margin-top: 20px;'>this Artical Title is already used Select Another One</div>";
                    echo"</div>";
                    redirect($msg, "PrevPage", "Peview");
                }else{
                    //start insert the data
                    $proInsert = $conn->prepare("INSERT INTO 
                                                            articles(Title, Content, Img, Time, Date, Service_ID, admin_ID) 
                                                        VALUES
                                                            (:tTitle, :tContent, :tImg, now(), now(), :tService, :tAdmin)");
                    //start execute the data
                    $proInsert->execute(array(

                                    'tTitle'        => $title,
                                    'tContent'      => $Scoap,
                                    'tImg'          => $name,
                                    'tService'      => $service,
                                    'tAdmin'        => $_SESSION['userId']

                                  ));
                    echo "<div class='container'> ";
                        $msg =  "<div class='alert alert-success text-center'>". $proInsert->rowCount() ." project Is Inserted</div>";
                        redirect($msg, "PrevPage", "Peview");
                    echo"</div>";

                }
            }

        }

	}elseif ($do == 'Edit') { // Edit Page
        //get the ID 
        $artId = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        // start prepare for the select
        $artEdit = $conn->prepare("SELECT * FROM articles WHERE ID = ?");
        //start execute the data
        $artEdit->execute(array($artId));
        //fetch the data
        $artRows = $artEdit->fetch();
        ?>
    <div class="main-content">
        <!-- You only need this form and the form-basic.css -->
        <form class="form-basic" method="post" action="?do=Update" enctype="multipart/form-data">
            <input type="hidden" name="artId" value='<?php echo $artRows["ID"] ?>' />
            <div class="form-title-row">
                <h1>Edit Artical</h1>
            </div>
            <div class='alert alert-info text-center'>the Image extension Must Be [ png, gif, jpeg, jpg, pjpeg, x-png, png ]
            </div>
            <div class="form-row">
                <label>
                    <span>Title</span>
                    <input type="text" name="title" value="<?php echo str_replace('-', ' ',$artRows["Content"])?>">
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Content</span>
                    <textarea name="Scoap" style="resize:none" maxlength="150"><?php echo str_replace('-', ' ',$artRows["Content"]) ?></textarea>
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span class="col-md-2" >Image</span>
                    <input class="form-control col col-md-10" type="file" name="img" >
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Service</span>
                    <select name="service">
                        <?php
                            //start select the data 
                            $serSelect = $conn->prepare("SELECT * FROM services");
                            //start excute the data
                            $serSelect->execute();
                            //count the row 
                            $count = $serSelect->rowCount();
                            //if the count > 0 start fetch
                            if($count > 0){//start if
                                $servRows = $serSelect->fetchAll();
                                foreach($servRows as $row){
                                    echo '<option value="'. $row["ID"] .'"';
                                            if($artRows["Service_ID"] == $row["ID"]){echo "selected";}echo '>'. $row["Name"] .'</option>';
                                } 
                            }
                        ?>
                    </select>
                </label>
            </div>
            <div class="form-row">
                <input class="btn btn-primary" style="color:#fff;margin-left: 162px;" type="submit" name="submit" value="Edit artical" />
            </div>
        </form>
    </div>
    <?php
	}elseif ($do == 'Update') { // Update Page
         if($_SERVER["REQUEST_METHOD"] == 'POST'){
            // get the post values
            $artId           = isset($_POST['artId']) && is_numeric($_POST['artId']) ? intval($_POST['artId']) : 0;
            $title           = str_replace(' ', '-',trim(strip_tags($_POST["title"])));
            $Scoap           = str_replace(' ', '-',trim(strip_tags($_POST["Scoap"])));
            $service         = $_POST["service"];
            $dir_name        = dirname(__FILE__) . "/Layout/img/artical_img/";
            $path            = $_FILES['img']['tmp_name'];//temporary path
            $name            = $_FILES['img']['name'];
            $size            = $_FILES['img']['size'];
            $type            = $_FILES['img']['type']; //image type
            $error           = $_FILES['img']['error'];

            /*Start Check the Fileds */
            $formError = array();
            if(empty($title)){
                $formError[] = "title Filed Can't be Empty";
            }
            if(empty($Scoap)){
                $formError[] = "Scoap Filed Can't be Empty";
            }
            if(empty($name)){
                $formError[] = "You Must Select Image";
            }
            if(!empty($name) && $size > 300000) { //if the image filed not empty and size
                $formError[] = "the Image too Large";
            }
            if(!empty($name) && 
                in_array($type, array('image/png', 'image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png')) === FALSE) { //if the image filed not empty and image type 
                $formError[] = "the Image extension Must Be [ 'image/png', 'image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png' ]";
            }
            if(!empty($name) && !$error && in_array($type, array('image/png', 'image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png')) === TRUE) { //if the image filed not empty and ther is no errors 
                move_uploaded_file($path, $dir_name . $name); // move to the temp Folder
            }
            if(!empty($formError)){ // if not he array empty
                    echo "<div class='container'> ";
                foreach($formError as $err){
                        echo "<div class='alert alert-danger text-center' style='margin-top: 20px;'>". $err ."</div>";
                }
                    redirect(@$msg, "PrevPage", "Peview", 5); // redirect dynamic function
                    echo"</div>";

            }
            if(empty($formError)){ // if the array empty
                 // start select the data  to check if the user name is exist from the other member and not check the current name 
                $vSelect = $conn->prepare("SELECT * FROM articles WHERE Title = ? && ID != ?");
                //start execute
                $vSelect->execute(array($title, $artId));
                // count the rows
                $count = $vSelect->rowCount();
                if($count == 1){ // start if condistion if the statment == 1
                    echo "<div class='container'> ";
                    $msg =  "<div class='alert alert-danger text-center'>this artical is exist</div>";
                    redirect($msg, "PrevPage", "Peview");
                     echo"</div>";
                }else{
                    //start insert the data
                    $artUpdate = $conn->prepare("UPDATE articles SET Title = ?, Content = ?, Img = ?, Service_ID = ?, admin_ID = ? WHERE ID = ?");
                    // excute the data
                    $artUpdate->execute(array($title, $Scoap, $name, $service, $_SESSION['userId'], $artId));
                    echo "<div class='container'> ";
                        $msg =  "<div class='alert alert-success text-center'>". $artUpdate->rowCount() ." artical Is updated</div>";
                        redirect($msg, "PrevPage", "Peview");
                    echo"</div>";

                }
            }

        }


	}elseif ($do == 'Delete') { // Delete Page
        //get the ID 
        $artId = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        //select all data depend on the id
        $check = checkItme( 'ID', 'articles', $artId);
        //if there is such id show form
        if ($check > 0) { 
            // start prepare for the delete
            $artDelete = $conn->prepare("DELETE FROM articles WHERE ID = :ID");
            //bindParam the data
            $artDelete->bindParam('ID', $artId);
            //start execute the data
            $artDelete->execute();
             echo "<div class='container'> ";
                $msg =  "<div class='alert alert-success text-center'>". $artDelete->rowCount() ." artical Is Deleted</div>";
                redirect($msg, "PrevPage", "Peview");
            echo"</div>";
        }else{
            echo "<div class='container'> ";
                $msg =  "<div class='alert alert-danger text-center'>ther is no such ID [ ". $artId ." ]</div>";
                redirect($msg, "PrevPage", "Peview");
            echo"</div>";
        }
	}
		
		
	include "Includes/templates/footer.php";
    }else{
        header('location: index.php');//redirect to the dashboard page
        exit();
    }
    ob_end_flush();
?>