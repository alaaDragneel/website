<?php
	ob_start();
	include "init.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // Check if the $do is Exixets 
    if($do == 'view'){
        //get the ID 
        $proId = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        // start prepare for the select
        $proSelect = $conn->prepare("SELECT * FROM portofolio WHERE ID = ?");
        //start execute the data
        $proSelect->execute(array($proId));
        //fetch the data
        $pro = $proSelect->fetch();?>
            <!-- Page Content -->
            <div class="container">
                <!-- Page Heading/Breadcrumbs -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo str_replace('-', ' ',$pro["Name"]);?>
                            <small><?php echo str_replace('-', ' ',$pro["subName"]);?></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li><a href="index.php">Home</a>
                            </li>
                            <li class="active">Portfolio Item</li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <!-- Portfolio Item Row -->
                <div class="row">

                    <div class="col-md-8">
                         <img class="img-responsive"
                              src="Admin/Layout/img/projects_img/<?php echo $pro["Img"];?>" alt="projects image">
                    </div>

                    <div class="col-md-4">
                        <h3>Project Description</h3>
                        <p><?php echo str_replace('-', ' ',$pro["Description"]);?></p>
                        <h3>Project Details</h3>
                        <p><?php echo str_replace('-', ' ',$pro["Details"]);?></p>
                    </div>

                </div>
                <!-- /.row -->
                <hr>
            </div><!-- /.container -->
<?php }?>
    
        
<?php 
    if($do == 'manage'){
        //get the ID 
        $proId = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        // start prepare for the select
        $proSelect = $conn->prepare("SELECT * FROM portofolio WHERE ID = ?");
        //start execute the data
        $proSelect->execute(array($proId));
        //fetch the data
        $pro = $proSelect->fetch();?>

        <!-- Page Content -->
            <div class="container">
                <!-- Page Heading/Breadcrumbs -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo str_replace('-', ' ',$pro["Name"]);?>
                            <small><?php echo str_replace('-', ' ',$pro["subName"]);?></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li><a href="index.php">Home</a>
                            </li>
                            <li class="active">Portfolio Item</li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <!-- Portfolio Item Row -->
                <div class="row">

                    <div class="col-md-8">
                         <img class="img-responsive"
                              src="Admin/Layout/img/projects_img/<?php echo $pro["Img"];?>" alt="projects image">
                    </div>

                    <div class="col-md-4">
                        <h3>Project Description</h3>
                        <p><?php echo str_replace('-', ' ',$pro["Description"]);?></p>
                        <h3>Project Details</h3>
                        <p><?php echo str_replace('-', ' ',$pro["Details"]);?></p>
                    </div>

                </div>
                <!-- /.row -->
                <hr>
            </div><!-- /.container -->
<?php
}
	include "includes/templates/footer.php";
	ob_end_flush();
?>