<?php
	ob_start();
	include "init.php";

    //strat select the data to the slider
    $slidSelect = $conn->prepare("SELECT * FROM services ORDER BY ID DESC LIMIT 3");
    // start execute the data
    $slidSelect->execute();
    // strat count the rows 
    $count = $slidSelect->rowCount();
    //check if there are data
    if($count > 0){
        //strat fetch the data
        $rows = $slidSelect->fetchAll();
    }?>
<!-- Header Carousel -->
<header id="myCarousel" class="carousel slide">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active">
            <div class="fill" style="background-image:url('Layout/img/slide-2.jpg');"></div>
            <div class="carousel-caption">
                <h2>Welcome to Our WebSite</h2>
            </div>
        </div>
    <?php 
        foreach($rows as $row){ //start loop?>  
        <div class="item">
            <div class="fill" style="background-image:url('Admin/Layout/img/service_img/<?php echo $row["Img"];?>');"></div>
            <div class="carousel-caption">
                <h2><?php echo $row["Name"]?></h2>
            </div>
        </div>
        <?php }//end loop?>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="icon-prev"></span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="icon-next"></span>
    </a>
</header>

<!-- Page Content -->
<div class="container">
<?php
    //strat select the data to the slider
    $whatSelect = $conn->prepare("SELECT * FROM whatwedo");
    // start execute the data
    $whatSelect->execute();
    // strat count the rows 
    $count = $whatSelect->rowCount();
    //check if there are data
    if($count > 0){
        //strat fetch the data
        $row = $whatSelect->fetchAll();
    }?>
?>

    <!-- Marketing Icons Section -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Welcome To Dezique
            </h1>
        </div>
        <?php 
            foreach($row as $weCan){?>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>
                        <?php echo $weCan["Icon"] . ' '; 
                              echo $weCan["Name"];
                        ?>      
                    </h4>
                </div>
                <div class="panel-body">
                    <p>
                        <?php echo $weCan["Description"]; ?> 
                    </p>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
    <!-- /.row -->

    <!-- Portfolio Section -->
    <?php //start select the data 
        $proSelect = $conn->prepare("SELECT * FROM portofolio");
        //start excute the data
        $proSelect->execute();
        //count the row 
        $count = $proSelect->rowCount();
        //if the count > 0 start fetch
        if($count > 0){//start if
            $proRrows = $proSelect->fetchAll(); ?>
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Portfolio Heading</h2>
        </div>
        <?php 
            foreach($proRrows as $row){?>
                <div class="col-md-4 col-sm-6"> 
                    <a href="portfolio-item.php?do=view&ID=<?php echo $row["ID"]?>">
                        <img class="img-responsive img-portfolio img-hover"  src="Admin/Layout/img/projects_img/<?php echo $row["Img"]?>" alt="">
                    </a>
                </div>
        <?php       
              }// end loop
            }
        ?>
    </div>
    <!-- /.row -->

    <hr>

</div><!-- /.container -->
<?php
	include "includes/templates/footer.php";
	ob_end_flush();
?>