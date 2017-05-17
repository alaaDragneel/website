<?php
	/*
	==========================================
	== Team Members Page 
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
        $teamSelect = $conn->prepare("SELECT * FROM our_team");
        //start excute the data
        $teamSelect->execute();
        //count the row 
        $count = $teamSelect->rowCount();
        //if the count > 0 start fetch
        if($count > 0){//start if
            $rows = $teamSelect->fetchAll(); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Manage Team Members</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Manage Team Members You Can [ Edit | Delete | Update | Add ] Members
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Jop Title</th>
                                        <th>Scoap</th>
                                        <th>Img</th>
                                        <th>Facebook</th>
                                        <th>Gender</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($rows as $row){ //start loop

                                            echo '<tr class="odd gradeX">';
                                                echo "<td>". $row["ID"] ."</td>";
                                                echo "<td>". $row["Name"] ."</td>";
                                                echo "<td>". $row["Jop_Title"] ."</td>";
                                                echo "<td>". $row["Scoap"] ."</td>";
                                                echo "<td><img class='thumbnail' width='200' height='200' src='Layout/img/team_img/". $row["Img"] ."'/> </td>";
                                                echo "<td>". $row["Facebook"] ."</td>";
                                                echo "<td>"; 
                                                    if($row["gender"] == 1){ //show the gender 
                                                        echo "male";
                                                    }elseif ($row["gender"] == 2) {//show the gender
                                                        echo "female";
                                                    } 
                                                echo "</td>";
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
                    <a class="btn btn-primary" href="?do=Add" style="margin-bottom: 20px;">Add New Member</a>
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
                <h1>Add New Team Member</h1>
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
                    <span>Jop Title</span>
                    <input type="text" name="jop_title">
                </label>
            </div>
			<div class="form-row">
                <label>
                    <span class="col-md-2" >Image</span>
                    <input class="form-control col col-md-10" type="file" name="img">
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
                    <span>Facebook URL</span>
                    <input type="url" name="facebook">
                </label>
            </div>
			<div class="form-row">
                <label>
                    <span>Gender</span>
                    <select name="gender">
                    	<option value="0">------------Select Gender------------</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>
                </label>
            </div>
            <div class="form-row">
                <input class="btn btn-primary" style="color:#fff;margin-left: 162px;" type="submit" name="submit" value="Add Member" />
            </div>
        </form>
    </div>
	<?php
	}elseif ($do == 'Insert') { // Insert Page
        if($_SERVER["REQUEST_METHOD"] == 'POST'){
            // get the post values
            $userName        = trim(strip_tags($_POST["name"]));
            $jobTitle        = trim(strip_tags($_POST["jop_title"]));
            $Scoap           = trim(strip_tags($_POST["Scoap"]));
            $face            = trim(strip_tags($_POST["facebook"]));
            $gender          = trim(strip_tags($_POST["gender"]));
            $dir_name        = dirname(__FILE__) . "/Layout/img/team_img/";
            $path            = $_FILES['img']['tmp_name'];//temporary path
            $name            = $_FILES['img']['name'];
            $size            = $_FILES['img']['size'];
            $type            = $_FILES['img']['type']; //image type
            $error           = $_FILES['img']['error'];

            /*Start Check the Fileds */
            $formError = array();
            if(empty($userName)){
                $formError[] = "Name Filed Can't be Empty";
            }
            if(empty($jobTitle)){
                $formError[] = "Jop Title Filed Can't be Empty";
            }
            if(empty($Scoap)){
                $formError[] = "Scoap Filed Can't be Empty";
            }
            if(empty($face)){
                $formError[] = "faceBook URL Filed Can't be Empty";
            }
            if(empty($gender)){
                $formError[] = "gender Must Selected";
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
                $countMember = checkItme("Name", "our_team", $userName);
                if($countMember > 0){
                    echo "<div class='container'> ";
                        $msg = "<div class='alert alert-danger text-center' style='margin-top: 20px;'>this user Name is already used Select Another One</div>";
                    echo"</div>";
                    redirect($msg, "PrevPage", "Peview");
                }else{
                    //start insert the data
                    $teamInsert = $conn->prepare("INSERT INTO our_team(Name, Jop_Title, Scoap, Img, Facebook, gender) 
                                                                VALUES(:tName, :tJop, :tScoap, :tImg, :tUrl, :tgender)");
                    //start execute the data
                    $teamInsert->execute(array(

                                    'tName'     => $userName,
                                    'tJop'      => $jobTitle,
                                    'tScoap'    => $Scoap,
                                    'tImg'      => $name,
                                    'tUrl'      => $face,
                                    'tgender'   => $gender

                                  ));
                    echo "<div class='container'> ";
                        $msg =  "<div class='alert alert-success text-center'>". $teamInsert->rowCount() ." Member Is Inserted</div>";
                        redirect($msg, "PrevPage", "Peview");
                    echo"</div>";

                }
            }

        }
	}elseif ($do == 'Edit') { // Edit Page
        //get the ID 
        $userId = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        // start prepare for the select
        $teamEdit = $conn->prepare("SELECT * FROM our_team WHERE ID = ?");
        //start execute the data
        $teamEdit->execute(array($userId));
        //fetch the data
        $teamRows = $teamEdit->fetch();
	?>
	<div class="main-content">
        <!-- You only need this form and the form-basic.css -->
        <form class="form-basic" method="post" action="?do=Update" enctype="multipart/form-data">
            <input type="hidden" name="userId" value="<?php echo $userId; // the user Id?>" />
            <div class="form-title-row">
                <h1>Edit Team Member</h1>
            </div>
            <div class='alert alert-info text-center'>the Image extension Must Be [ png, gif, jpeg, jpg, pjpeg, x-png, png ]
            </div>
            <div class="form-row">
                <label>
                    <span>Name</span>
                    <input type="text" name="name" value="<?php echo $teamRows["Name"]?>">
                </label>
            </div>
			<div class="form-row">
                <label>
                    <span>Jop Title</span>
                    <input type="text" name="jop_title" value="<?php echo $teamRows["Jop_Title"]?>">
                </label>
            </div>
			<div class="form-row">
                <label>
                    <span class="col-md-2" >Image</span>
                    <input class="form-control col col-md-10" type="file" name="img" value="<?php echo $teamRows["Img"]?>">
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Scoap</span>
                    <textarea name="scoap" style="resize:none" maxlength="150"><?php echo $teamRows["Scoap"]?></textarea>
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Facebook URL</span>
                    <input type="url" name="facebook" value="<?php echo $teamRows["Facebook"]?>">
                </label>
            </div>
			<div class="form-row">
                <label>
                    <span>Gender</span>
                    <select name="gender">
                        <option value="1" <?php if($teamRows["gender"] == 1){echo "selected";}?> >Male</option>
                        <option value="2" <?php if($teamRows["gender"] == 2){echo "selected";}?> >Female</option>
                    </select>
                </label>
            </div>
            <div class="form-row">
                <input class="btn btn-primary" style="color:#fff;margin-left: 162px;" type="submit" name="submit" value="Edit Member" />
            </div>
        </form>
    </div>
	<?php
	}elseif ($do == 'Update') { // Update Page
        if($_SERVER["REQUEST_METHOD"] == 'POST'){
            // get the post values
            $userId          = isset($_POST['userId']) && is_numeric($_POST['userId']) ? intval($_POST['userId']) : 0;
            $userName        = trim(strip_tags($_POST["name"]));
            $jobTitle        = trim(strip_tags($_POST["jop_title"]));
            $Scoap           = trim(strip_tags($_POST["scoap"]));
            $face            = trim(strip_tags($_POST["facebook"]));
            $gender          = trim(strip_tags($_POST["gender"]));
            $dir_name        = dirname(__FILE__) . "/Layout/img/team_img/";
            $path            = $_FILES['img']['tmp_name'];//temporary path
            // check if the image field empty
            $name            = $_FILES['img']['name']; //image name
            $size            = $_FILES['img']['size']; // image size
            $type            = $_FILES['img']['type']; // image type
            $error           = $_FILES['img']['error']; //image error

            /*Start Check the Fileds */
            $formError = array();
            if(empty($userName)){
                $formError[] = "Name Filed Can't be Empty";
            }
            if(empty($jobTitle)){
                $formError[] = "Jop Title Filed Can't be Empty";
            }
            if(empty($Scoap)){
                $formError[] = "Scoap Filed Can't be Empty";
            }
            if(empty($face)){
                $formError[] = "faceBook URL Filed Can't be Empty";
            }
            if(empty($gender)){
                $formError[] = "gender Must Selected";
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
                $vSelect = $conn->prepare("SELECT * FROM our_team WHERE Name = ? && ID != ?");
                //start execute
                $vSelect->execute(array($userName, $userId));
                // count the rows
                $count = $vSelect->rowCount();
                if($count == 1){ // start if condistion if the statment == 1
                    echo "<div class='container'> ";
                    $msg =  "<div class='alert alert-danger text-center'>this user is exist</div>";
                    redirect($msg, "PrevPage", "Peview");
                     echo"</div>";
                }else{
                    //start prepare to update the data
                    $teamInsert = $conn->prepare("UPDATE our_team SET Name = ?, Jop_Title = ?, Scoap = ?, Img= ?, Facebook= ?, gender= ? WHERE ID = ?");
                    //start execute the data
                    $teamInsert->execute(array( $userName, $jobTitle, $Scoap, $name, $face, $gender, $userId));
                    echo "<div class='container'> ";
                        $msg =  "<div class='alert alert-success text-center'>". $teamInsert->rowCount() ." Member Is updated</div>";
                        redirect($msg, "PrevPage", "Peview");
                    echo"</div>";

                }
            }

        }



	}elseif ($do == 'Delete') { // Delete Page
        //get the ID 
        $userId = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        //select all data depend on the id
        $check = checkItme( 'ID', 'our_team', $userId);
        //if there is such id show form
        if ($check > 0) { 
            // start prepare for the delete
            $teamDelete = $conn->prepare("DELETE FROM our_team WHERE ID = :ID");
            //bind Param the data
            $teamDelete->bindParam('ID', $userId);
            //start execute the data
            $teamDelete->execute();
             echo "<div class='container'> ";
                $msg =  "<div class='alert alert-success text-center'>". $teamDelete->rowCount() ." Member Is Deleted</div>";
                redirect($msg, "PrevPage", "Peview");
            echo"</div>";
        }else{
            echo "<div class='container'> ";
                $msg =  "<div class='alert alert-danger text-center'>ther is no such ID [ ". $userId ." ]</div>";
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