<?php
	/*
	==========================================
	== Portofolio Page
	== you can EDIT | DELETE | ADD [pagename] page
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
        $proSelect = $conn->prepare("SELECT * FROM portofolio");
        //start excute the data
        $proSelect->execute();
        //count the row 
        $count = $proSelect->rowCount();
        //if the count > 0 start fetch
        if($count > 0){//start if
            $rows = $proSelect->fetchAll(); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Manage portofolio</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Manage portofolio You Can [ Edit | Delete | Update | Add ] projects
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>sub Name</th>
                                        <th>Scoap</th>
                                        <th>Img</th>
                                        <th>Details</th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                      foreach($rows as $row){ //start loop

                                            echo '<tr class="odd gradeX">';
                                                echo "<td>". $row["ID"] ."</td>";
                                                echo "<td>". str_replace('-', ' ',$row["Name"])."</td>";
                                                echo "<td>". str_replace('-', ' ',$row["subName"]) ."</td>";
                                                echo "<td>". str_replace('-', ' ',$row["Description"]) ."</td>";
                                                echo "<td><img class='thumbnail' width='200' height='200' src='Layout/img/projects_img/". $row["Img"] ."'/> </td>";
                                                echo "<td>".str_replace('-', ' ',$row["Details"]) ."</td>";
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
                    <a class="btn btn-primary" href="?do=Add" style="margin-bottom: 20px;">Add project</a>
                </div>
                <?php  }else{
                            echo "<div class='container'> ";
                                echo  "<div class='alert alert-warning text-center' style='margin-top: 20px;'> there are no data to show</div>";
                                echo '<a class="btn btn-primary " href="?do=Add" style="margin-left: 45%; margin-bottom: 4%;">Add New Member</a>';
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
                <h1>Add project</h1>
            </div>
            <div class='alert alert-info text-center'>the Image extension Must Be [ png, gif, jpeg, jpg, pjpeg, x-png, png ]
            </div>
            <div class="form-row">
                <label>
                    <span>Name</span>
                    <input type="text" name="name">
                </label>
            </div>
			<div class="form-row">
                <label>
                    <span>sub name</span>
                    <input type="text" name="subName">
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
                    <span>Scoap</span>
                    <textarea name="Scoap" style="resize:none" maxlength="150"></textarea>
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Details</span>
                    <textarea name="details" style="resize:none" maxlength="150"></textarea>
                </label>
            </div>
            <div class="form-row">
                <input class="btn btn-primary" style="color:#fff;margin-left: 162px;" type="submit" name="submit" value="Add project" />
            </div>
        </form>
    </div>
	<?php
	}elseif ($do == 'Insert') { // Insert Page
         if($_SERVER["REQUEST_METHOD"] == 'POST'){
            // get the post values
            $proName         = str_replace(' ', '-',trim(strip_tags($_POST["name"])));
            $subName         = str_replace(' ', '-',trim(strip_tags($_POST["subName"])));
            $Scoap           = str_replace(' ', '-',trim(strip_tags($_POST["Scoap"])));
            $details         = str_replace(' ', '-',trim(strip_tags($_POST["details"])));
            $dir_name        = dirname(__FILE__) . "/Layout/img/projects_img/";
            $path            = $_FILES['img']['tmp_name'];//temporary path
            $name            = $_FILES['img']['name'];
            $size            = $_FILES['img']['size'];
            $type            = $_FILES['img']['type']; //image type
            $error           = $_FILES['img']['error'];

            /*Start Check the Fileds */
            $formError = array();
            if(empty($proName)){
                $formError[] = "Name Filed Can't be Empty";
            }
            if(empty($subName)){
                $formError[] = "sub Name Filed Can't be Empty";
            }
            if(empty($Scoap)){
                $formError[] = "Scoap Filed Can't be Empty";
            }
            if(empty($details)){
                $formError[] = "details Filed Can't be Empty";
            }
            if(empty($name)){
                $formError[] = "You Must Select Image";
            }
            if(!empty($name) && $size > 300000) { //if the image filed not empty and size
                $formError[] = "the Image to Large";
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
                $countPro = checkItme("Name", "portofolio", $proName);
                if($countPro > 0){
                    echo "<div class='container'> ";
                        $msg = "<div class='alert alert-danger text-center' style='margin-top: 20px;'>this Project Name is already used Select Another One</div>";
                    echo"</div>";
                    redirect($msg, "PrevPage", "Peview");
                }else{
                    //start insert the data
                    $proInsert = $conn->prepare("INSERT INTO portofolio(Name, subName, Description, Img, details) 
                                                                VALUES(:tName, :tsub, :tScoap, :tImg, :tDetails)");
                    //start execute the data
                    $proInsert->execute(array(

                                    'tName'     => $proName,
                                    'tsub'      => $subName,
                                    'tScoap'    => $Scoap,
                                    'tImg'      => $name,
                                    'tDetails'  => $details

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
        $proId = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        // start prepare for the select
        $proEdit = $conn->prepare("SELECT * FROM portofolio WHERE ID = ?");
        //start execute the data
        $proEdit->execute(array($proId));
        //fetch the data
        $proRows = $proEdit->fetch();
    ?>
        <div class="main-content">
        <!-- You only need this form and the form-basic.css -->
        <form class="form-basic" method="post" action="?do=Update" enctype="multipart/form-data">
            <input type="hidden" name="proId" value="<?php echo $proRows["ID"]?>">
            <div class="form-title-row">
                <h1>Edit project</h1>
            </div>
            <div class='alert alert-info text-center'>the Image extension Must Be [ png, gif, jpeg, jpg, pjpeg, x-png, png ]
            </div>
            <div class="form-row">
                <label>
                    <span>Name</span>
                    <input type="text" name="name" value="<?php echo str_replace('-', ' ',$proRows["Name"]);?>">
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>sub name</span>
                    <input type="text" name="subName" value="<?php echo str_replace('-', ' ',$proRows["subName"])?>">
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span class="col-md-2" >Image</span>
                    <input class="form-control col col-md-10" type="file" name="img" multiple>
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Scoap</span>
                    <textarea name="Scoap" style="resize:none" maxlength="150"><?php echo str_replace('-', ' ',$proRows["Description"])?></textarea>
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Details</span>
                    <textarea name="details" style="resize:none" maxlength="150"><?php echo str_replace('-', ' ',$proRows["Details"])?></textarea>
                </label>
            </div>
            <div class="form-row">
                <input class="btn btn-primary" style="color:#fff;margin-left: 184px;" type="submit" name="submit" value="Edit Project" />
            </div>
        </form>
    </div>
    <?php   
	}elseif ($do == 'Update') { // Update Page
        if($_SERVER["REQUEST_METHOD"] == 'POST'){
            // get the post values
            $proId           = isset($_POST['proId']) && is_numeric($_POST['proId']) ? intval($_POST['proId']) : 0;
            $proName         = str_replace(' ', '-',trim(strip_tags($_POST["name"])));
            $subName         = str_replace(' ', '-',trim(strip_tags($_POST["subName"])));
            $Scoap           = str_replace(' ', '-',trim(strip_tags($_POST["Scoap"])));
            $details         = str_replace(' ', '-',trim(strip_tags($_POST["details"])));
            $dir_name        = dirname(__FILE__) . "/Layout/img/projects_img/";
            $path            = $_FILES['img']['tmp_name'];//temporary path
            $name            = $_FILES['img']['name'];
            $size            = $_FILES['img']['size'];
            $type            = $_FILES['img']['type']; //image type
            $error           = $_FILES['img']['error'];

            /*Start Check the Fileds */
            $formError = array();
            if(empty($proName)){
                $formError[] = "Name Filed Can't be Empty";
            }
            if(empty($subName)){
                $formError[] = "sub Name Filed Can't be Empty";
            }
            if(empty($Scoap)){
                $formError[] = "Scoap Filed Can't be Empty";
            }
            if(empty($details)){
                $formError[] = "details Filed Can't be Empty";
            }
            if(empty($name)){
                $formError[] = "You Must Select Image";
            }
            if(!empty($name) && $size > 300000) { //if the image filed not empty and size
                $formError[] = "the Image to Large";
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
                $vSelect = $conn->prepare("SELECT * FROM portofolio WHERE Name = ? && ID != ?");
                //start execute
                $vSelect->execute(array($proName, $proId));
                // count the rows
                $count = $vSelect->rowCount();
                if($count == 1){ // start if condistion if the statment == 1
                    echo "<div class='container'> ";
                    $msg =  "<div class='alert alert-danger text-center'>this Project is exist</div>";
                    redirect($msg, "PrevPage", "Peview");
                     echo"</div>";
                }else{
                    //start insert the data
                    $proUpdate = $conn->prepare("UPDATE portofolio SET Name = ?, subName = ?, Description = ?, Img = ?, Details = ? WHERE ID = ?");
                    //start execute the data
                    $proUpdate->execute(array( $proName, $subName, $Scoap, $name, $details, $proId));
                    echo "<div class='container'> ";
                        $msg =  "<div class='alert alert-success text-center'>". $proUpdate->rowCount() ." project Is updated</div>";
                        redirect($msg, "PrevPage", "Peview");
                    echo"</div>";

                }
            }

        }


	}elseif ($do == 'Delete') { // Delete Page
        //get the ID 
        $proId = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        //select all data depend on the id
        $check = checkItme( 'ID', 'portofolio', $proId);
        //if there is such id show form
        if ($check > 0) { 
            // start prepare for the delete
            $proDelete = $conn->prepare("DELETE FROM portofolio WHERE ID = :ID");
            //bind Param the data
            $proDelete->bindParam('ID', $proId);
            //start execute the data
            $proDelete->execute();
             echo "<div class='container'> ";
                $msg =  "<div class='alert alert-success text-center'>". $proDelete->rowCount() ." project Is Deleted</div>";
                redirect($msg, "PrevPage", "Peview");
            echo"</div>";
        }else{
            echo "<div class='container'> ";
                $msg =  "<div class='alert alert-danger text-center'>ther is no such ID [ ". $proId ." ]</div>";
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