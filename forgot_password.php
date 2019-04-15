<?php

    // Requests the inclusion of the functions.php file

    include('functions.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Registration Success</title>
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
            <form action="forgot_password.php" method="post" class="form-signin">       
                <h3 class="form-signin-heading">Change Password</h3>
                  <hr class="colorgraph"><br>
                
                    <!-- Call error file to display errors -->
                    <?php include('errors.php'); ?>
                
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" placeholder="Enter username (Required)" name="usrname" value="<?php echo $username; ?>"><br/>
                
                    <label for="password">New Password:</label>
                    <input type="password" class="form-control" id="password" placeholder="Password (Required)" name="password"><br/>
                
                    <label for="c_password">Confirm Password:</label>
                    <input type="password" class="form-control" id="c_password" placeholder="Confirm Password (Required)" name="c_password"><br/>

                    <button type="submit" class="btn btn-primary btn-block" name="change_password">CHANGE PASSWORD</button>               			
            </form>			
        </div>
    </div>
    
</body>
</html>