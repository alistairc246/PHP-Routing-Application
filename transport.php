<?php 

    // Requests the inclusion of the functions.php file

	include('functions.php');

    // Calls the isLoggedIn function

    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You are required to login";
        
        header('location: login.php');
    }

    // Logs user out if logout button clicked

    if (isset($_GET['logout'])) {
        
        session_destroy();
        unset($_SESSION['user']['username']);
        header("location: login.php");
        
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>FEMA Transportation</title>
            <!-- Meta Data -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
        
            <!-- Calls external stylesheets for css styles -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <link rel="stylesheet" href="css/bootstrap.css">
        
            <!-- Calls external javascript files to enable javascript methods -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>
    
<body>
    <div class="container">
        <div class="wrapper">        
            <form action="" method="post" name="Login_Form" class="form-signin">       
                <h3 class="form-signin-heading">FEMA Transportation</h3>
                  <hr class="colorgraph">

                    <!-- notification message -->
                    <?php if (isset($_SESSION['success'])) : ?>
                        <div class="alert alert-success">
                            <h3 style="text-align: center; font-size: 16px !important;">
                                <?php 
                                    echo $_SESSION['success']; 
                                    unset($_SESSION['success']);
                                ?>
                            </h3>
                        </div>
                    <?php endif ?>

                    <!-- logged in user information -->

                    <?php  if (isset($_SESSION['user'])) : ?>

                        <p style="text-align: center; font-size: 16px;">Welcome <strong><?php echo $_SESSION['user']['username']; ?></strong></p>

                          <a href="collect_items.php" style="color: white; text-decoration: none;" class="btn btn-primary btn-block">COLLECT EMERGANCY ITEMS</a> 

                          <a href="map_route.php" style="color: white; text-decoration: none;" class="btn btn-primary btn-block">MAP ROUTE</a>

                          <a href="index.php?logout='1'" style="color: white; text-decoration: none;" class="btn btn-primary btn-block">LOGOUT</a> 

                     <?php endif ?>
            </form>			
        </div>
    </div>
	
</body>
</html>