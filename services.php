<?php
	ob_start();
	include "init.php";

?>
<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Services
                <small>Subheading</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a>
                </li>
                <li class="active">Services</li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

    <!-- Image Header -->
    <div class="row">
        <div class="col-lg-12">
            <img class="img-responsive" style="width: 1200px;height: 400px;" src="layout/img/slide-3.jpg" alt="">
        </div>
    </div>
    <!-- /.row -->
    <!-- Service Tabs -->
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Service Tabs</h2>
        </div>
        <div class="col-lg-12">

            <ul id="myTab" class="nav nav-tabs nav-justified">
                
                <?php
                    // start prepare for the select
                    $proSelect = $conn->prepare("SELECT * FROM Services ORDER BY ID DESC LIMIT 4");
                    //start execute the data
                    $proSelect->execute();
                    //fetch the data
                    $serRows = $proSelect->fetchAll();
                    $ser = 2;
                    $servCont = 2;
                    //start loop
                        echo '<li class="active"><a href="#service-1" data-toggle="tab">
                                <i class="fa fa-tree"></i> see our serveces here</a>
                              </li>';
                    foreach($serRows as $row){ //fetch the Name of the services
                        echo "<li>";
                            echo '<a href="#service-'.$ser++.'" data-toggle="tab"><i class="fa fa-tree"></i> '. $row["Name"] .'</a>';
                        echo "</li>";
                    }?>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="service-1">
                    <h4>Services</h4>
                    <p>We Hope You Like this Serveices ansd Hope to enjoy in Our site</p>
                </div>
                <?php
                    foreach($serRows as $row){// loop the content and name of the services
                        echo'<div class="tab-pane fade" id="service-'.$servCont++.'">';
                            echo '<h4>'.$row["Name"].'</h4>';
                            echo '<p>'.$row["Describtion"].'</p>';
                        echo'</div>';
                    }
                ?>
                <!-- Services Limit In this Div Is 5 -->
            </div>

        </div>
    </div>

    <!-- Service List -->
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Service List</h2>
        </div>
        <?php
            foreach($serRows as $service){ //start loop for the last service Part ?>
                <div class="col-sm-12 col-md-6 col-lg-3" style="margin-bottom: 1%;">
                    <div class="media">
                        <div class="pull-left">
                            <img style="border-radius: 50%;width: 55px;height: 55px;" src='Admin/Layout/img/service_img/<?php echo $service["Img"]; //loop for the image of the services?>'/> 
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $service["Name"] //loop for the name of the services?></h4>
                            <p><?php echo $service["Describtion"] //loop for the description of the services?></p>
                        </div>
                    </div>
                </div> 
        <?php }?>   
    </div>
    <!-- /.row -->
    <hr>
</div><!-- /.container -->
<?php
	include "includes/templates/footer.php";
	ob_end_flush();
?>