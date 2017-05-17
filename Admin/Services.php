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
        $serSelect = $conn->prepare("SELECT services.*, admins.Name AS USER_NAME FROM services 
                                    INNER JOIN admins ON admins.ID = services.admin_ID ");
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
                    <h1 class="page-header">Manage Services page</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Manage Services page You Can [ Edit | Delete | Update | Add ] services
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Img</th>
                                        <th>Scoap</th>
                                        <th>Added By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php
                                        foreach($rows as $row){ //start loop

                                            echo '<tr class="odd gradeX">';
                                                echo "<td>". $row["ID"] ."</td>";
                                                echo "<td>". $row["Name"] ."</td>";
                                                echo "<td><img class='thumbnail' style='margin: 15px auto;' width='250' height='250' src='Layout/img/service_img/". $row["Img"] ."'/> </td>";
                                                echo "<td>". $row["Describtion"] ."</td>";
                                                 echo "<td>". $row["USER_NAME"] ."</td>";
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
                    <a class="btn btn-primary" href="?do=Add" style="margin-bottom: 20px;">Add new service</a>
                </div>
                <?php  }else{
                            echo "<div class='container'> ";
                                echo  "<div class='alert alert-warning text-center' style='margin-top: 20px;'> there are no data to show</div>";
                                echo '<a class="btn btn-primary " href="?do=Add" style="margin-left: 45%; margin-bottom: 4%;">Add new service</a>';
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
        <!-- Start Form -->
        <form class="form-basic" method="post" action="?do=Insert" enctype="multipart/form-data">
            <div class="form-title-row">
                <h1>Add Services</h1>
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
                    <span class="col-md-2" >Image</span>
                    <input class="form-control col col-md-10" type="file" name="img">
                </label>
            </div>
            <div class="form-row">
                <label>
                    <span>Describtion</span>
                    <textarea name="Desc" style="resize:none" maxlength="150" placeholder="Describtion of the service"></textarea>
                </label>
            </div>
            <div class="form-row">
                <input class="btn btn-primary" style="color:#fff;margin-left: 162px;" type="submit" name="submit" value="Add Service" />
            </div>
        </form>
    </div>
	<?php
	}elseif ($do == 'Insert') { // Insert Page
        if($_SERVER["REQUEST_METHOD"] == 'POST'){
            // get the post values
            $artName         = trim(strip_tags($_POST["name"]));
            $Describtion     = trim(strip_tags($_POST["Desc"]));
            $dir_name        = dirname(__FILE__) . "/Layout/img/service_img/";
            $path            = $_FILES['img']['tmp_name'];//temporary path
            $name            = $_FILES['img']['name'];
            $size            = $_FILES['img']['size'];
            $type            = $_FILES['img']['type']; //image type
            $error           = $_FILES['img']['error'];

            /*Start Check the Fileds */
            $formError = array();
            if(empty($artName)){
                $formError[] = "service Title Filed Can't be Empty";
            }
            if(empty($Describtion)){
                $formError[] = "Describtion Filed Can't be Empty";
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
                $countArt = checkItme("Name", "services", $artName);
                if($countArt > 0){
                    echo "<div class='container'> ";
                        $msg = "<div class='alert alert-danger text-center' style='margin-top: 20px;'>this service Title is already used Select Another One</div>";
                    echo"</div>";
                    redirect($msg, "PrevPage", "Peview");
                }else{
                    //start insert the data
                    $serInsert = $conn->prepare("INSERT INTO services(Name, Img, Describtion, Date, admin_ID) 
                                                                VALUES(:tName, :tImg, :tDesc, now(), :admin)");
                    //start execute the data
                    $serInsert->execute(array(

                                    'tName'     => $artName,
                                    'tImg'      => $name,
                                    'tDesc'     => $Describtion,
                                    'admin'     => $_SESSION["userId"]

                                  ));
                    echo "<div class='container'> ";
                        $msg =  "<div class='alert alert-success text-center'>". $serInsert->rowCount() ." service Is Inserted</div>";
                        redirect($msg, "PrevPage", "Peview");
                    echo"</div>";

                }
            }

        }


	}elseif ($do == 'Edit') { // Edit Page
        //get the ID 
        $serId = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        // start prepare for the select
        $serEdit = $conn->prepare("SELECT * FROM services WHERE ID = ?");
        //start execute the data
        $serEdit->execute(array($serId));
        //fetch the data
        $serRows = $serEdit->fetch();
	?>
	<div class="main-content">
        <!-- You only need this form and the form-basic.css -->
        <form class="form-basic" method="post" action="?do=Update" enctype="multipart/form-data">
         <input type="hidden" name="serId" value="<?php echo $serId; // the service Id?>" />
            <div class="form-title-row">
                <h1>Edit Services</h1>
            </div>
             <div class='alert alert-info text-center'>the Image extension Must Be [ png, gif, jpeg, jpg, pjpeg, x-png, png ]
            </div>
            <div class="form-row">
                <label>
                    <span>Name</span>
                    <input type="text" name="name" value="<?php echo $serRows["Name"]?>">
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
                    <span>Describtion</span>
                    <textarea name="Desc" style="resize:none" maxlength="150" placeholder="Describtion of the service" ><?php echo $serRows["Describtion"]?></textarea>
                </label>
            </div>
            <input class="btn btn-primary" style="color:#fff;margin-left: 80px;" type="submit" name="submit" value="Edit Service" />
        </form>
    </div>
<?php
	}elseif ($do == 'Update') { // Update Page
        if($_SERVER["REQUEST_METHOD"] == 'POST'){
            // get the post values
            $serId          = isset($_POST['serId']) && is_numeric($_POST['serId']) ? intval($_POST['serId']) : 0;
            $artName         = trim(strip_tags($_POST["name"]));
            $Describtion     = trim(strip_tags($_POST["Desc"]));
            $dir_name        = dirname(__FILE__) . "/Layout/img/service_img/";
            $path            = $_FILES['img']['tmp_name'];//temporary path
            $name            = $_FILES['img']['name'];
            $size            = $_FILES['img']['size'];
            $type            = $_FILES['img']['type']; //image type
            $error           = $_FILES['img']['error'];

            /*Start Check the Fileds */
            $formError = array();
            if(empty($artName)){
                $formError[] = "Artical Title Filed Can't be Empty";
            }
            if(empty($Describtion)){
                $formError[] = "Describtion Filed Can't be Empty";
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
               //start select to check if the name exist with out check on the currnt service name
                $cSelect = $conn->prepare("SELECT Name FROM services WHERE Name = ? && ID != ?");
                //start execute
                $cSelect->execute(array($artName, $serId));
                // start count the rows
                $countName = $cSelect->rowCount();
                if($countName == 1){
                    echo "<div class='container'> ";
                        $msg = "<div class='alert alert-danger text-center' style='margin-top: 20px;'>this service Title is already used Select Another One</div>";
                    echo"</div>";
                    redirect($msg, "PrevPage", "Peview");
                }else{
                    //start insert the data
                    $serUpdate = $conn->prepare("UPDATE services SET Name = ?, Img = ?, Describtion = ?, admin_ID = ? WHERE ID = ?");
                    //start execute the data
                    $serUpdate->execute(array( $artName, $name, $Describtion, $_SESSION["userId"], $serId));
                    echo "<div class='container'> ";
                        $msg =  "<div class='alert alert-success text-center'>". $serUpdate->rowCount() ." service Is updated</div>";
                        redirect($msg, "PrevPage", "Peview");
                    echo"</div>";

                }
            }

        }


	}elseif ($do == 'Delete') { // Delete Page
         //get the ID 
        $serId = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        //select all data depend on the id
        $check = checkItme( 'ID', 'services', $serId);
        //if there is such id show form
        if ($check > 0) { 
            // start prepare for the delete
            $serDelete = $conn->prepare("DELETE FROM services WHERE ID = :ID");
            //bindParam the data
            $serDelete->bindParam('ID', $serId);
            //start execute the data
            $serDelete->execute();
             echo "<div class='container'> ";
                $msg =  "<div class='alert alert-success text-center'>". $serDelete->rowCount() ." Service Is Deleted</div>";
                redirect($msg, "PrevPage", "Peview");
            echo"</div>";
        }else{
            echo "<div class='container'> ";
                $msg =  "<div class='alert alert-danger text-center'>ther is no such ID [ ". $serId ." ]</div>";
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