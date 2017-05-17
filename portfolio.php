<?php
	ob_start();
	include "init.php";
    // start prepare for the select
    $proSelect = $conn->prepare("SELECT * FROM portofolio");
    //start execute the data
    $proSelect->execute();
    //fetch the data
    $proRow = $proSelect->fetchAll();?>

?>
<!-- Page Content -->
<div class="container">
    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Our Portfolio
                <small>ODT</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <li class="active">Our Portfolio</li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <!-- Projects -->
    <?php 
        foreach($proRow as $pro){?>
    <div class="row" style="margin-top: 2%;">
        <div class="col-md-7">
            <a href="portfolio-item.php?do=manage&ID=<?php echo $pro["ID"]?>">
                <img class="img-responsive img-hover" src="Admin/Layout/img/projects_img/<?php echo $pro["Img"]?>" alt="">
            </a>
        </div>
        <div class="col-md-5">
            <h3><?php echo str_replace('-', ' ',$pro["Name"]);?></h3>
            <h4><?php echo str_replace('-', ' ',$pro["subName"]);?></h4>
            <p><?php echo str_replace('-', ' ',$pro["Description"]);?></p>
            <a class="btn btn-primary" href="portfolio-item.php?do=manage&ID=<?php echo $pro["ID"]?>">View Project</i></a>
        </div>
    </div>
    <?php }?>
    <!-- /.row -->
    <hr> <!-- Dont Forget To loop the hr With the protofoluios -->
</div><!-- /.container -->
<?php
	include "includes/templates/footer.php";
	ob_end_flush();
?>