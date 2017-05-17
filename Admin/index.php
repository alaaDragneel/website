<?php
    session_start();
    $noNavbar = ''; // Var to not include the navbar by dynamic way
    include "init.php"; //include the initialize file 
    // get the GET Value for the LOgIn Or LogOut
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    // start login Checks

    if($_SERVER["REQUEST_METHOD"] == 'POST' && $do == 'manage') {
        // Get Posts Values
        $email      = $_POST["email"];
        $password   = $_POST["password"]; 
        $hashedpass = sha1($password);
        //array error for the empty Fields
        $logError = array();
        if(empty($email)){
            $logError[] = "Email Field Can't be Empty";
        }
        if(empty($password)){
            $logError[] = "Password Field Can't be Empty";
        }
        if(!empty($logError)){//if the array not empty
            foreach($logError as $err){ //start loop
                echo "<div class='container'> ";
                    echo "<div class='alert alert-danger text-center' style='margin-top: 20px;'>". $err ."</div>";
                echo"</div>";    
            }//end loop
        }
        if(empty($logError)){//if the array empty
            // Using PDO STATMENT
            $logInAdmin = $conn->prepare("SELECT * FROM admins WHERE Email = ? && Password = ?");
            // start execute the statment
            $logInAdmin->execute(array($email, $hashedpass));
            //fetch the data to put in sessions if admin found
            $rows = $logInAdmin->fetch();
            // count the rows 
            $countRow = $logInAdmin->rowCount();

            if($countRow > 0) {
                $_SESSION["logged"];
                $_SESSION["userName"] = $rows["Name"]; //register session name
                $_SESSION["userId"] = $rows["ID"]; //register session ID
                header('location: dashboard.php');//redirect to the dashboard page
                exit();
            }
            // array errors for the matches rows
            $errorLog = array();
            // if the email doesn't matches
            if($rows["Email"] !== $email){
                $errorLog[] = "email You Enter Is Wrong";
            }
            // if the password doesn't matches
            if($rows["Password"] !== $hashedpass){
                $errorLog[] = "Password You Enter Is Wrong";
            }
            if(!empty($errorLog)){//if the array not empty
                foreach($errorLog as $err){ //start loop
                    echo "<div class='container'> ";
                        echo "<div class='alert alert-danger text-center' style='margin-top: 20px;'>". $err ."</div>";
                    echo"</div>";    
                }//end loop
            }
        }

    }

    if($do == 'logout'){
        session_unset();    //unset the data
        session_destroy();  // Destroy the session
        header('location: index.php');//redirect to the index page
        exit();
    }

?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="<?php echo $_SERVER["PHP_SELF"]?>">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" autocomplete="new-password">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="submit" class="btn btn-lg btn-success btn-block" value='Login' name='logIn' />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
	include "Includes/templates/footer.php";
?>