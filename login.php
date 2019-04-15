<?php 

    // Requests the inclusion of the functions.php file

    include('functions.php'); 
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
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
            <form action="login.php" method="post" class="form-signin">       
                <h3 class="form-signin-heading">General Login</h3>
                  <hr class="colorgraph"><br>
                
                    <!-- Call error file to display errors -->
                    <?php include('errors.php'); ?>

                        <label>Username</label>
                         <input type="text" class="form-control" name="username" placeholder="Enter Username (Required)" value="<?php echo $username; ?>"><br/>

                        <label>Password</label>
                         <input type="password" class="form-control" name="password" placeholder="Enter Your Password (Required)"><br/>			  


                        <button class="btn btn-primary btn-block"  name="login_btn" type="Submit">LOGIN</button><br/>

                    <p style="text-align: center;">
                        Are you registered? <a href="register.php">Register Now!</a><br/>
                        Forgot Password? <a href="forgot_password.php">Change Password!</a>
                    </p>
            </form>			
        </div>
    </div>
    
</body>
</html>