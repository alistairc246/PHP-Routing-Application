<?php 

    // Requests the inclusion of the functions.php file

    include('functions.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Community Centers' Registration</title>
        <!-- Meta Data -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Calls external stylesheets for css styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        
        <!-- Calls external javascript files to enable javascript methods -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/bootstrap.js"></script>
        
    </head>
    
<body>    
    <div class="container">
        <div class="wrapper">
            <form action="register.php" method="post" class="form-signin">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="form-signin-heading">Register Now!</h3>
                          <hr class="colorgraph"><br>
                        
                            <!-- Call error file to display errors -->
                            <?php include('errors.php'); ?>

                                    <label for="fname">Center Name:</label>
                                    <input type="text" class="form-control" id="username" placeholder="Enter Community Center (Required)" name="username" value="<?php echo $username; ?>"><br/>

                                    <label for="email">Email:</label>
                                    <input type="text" class="form-control" id="email" placeholder="example@gmail.com (Required)" name="email" value="<?php echo $email; ?>"><br/>

                                    <label for="telephone">Telephone No:</label>
                                    <input type="text" class="form-control" id="telephone" placeholder="000-000-0000 (Required)" name="telephone" value="<?php echo $telephone; ?>"><br/>

                                    <label for="address">Address:</label>
                                    <input type="text" class="form-control" id="address" placeholder="Enter Address (Required)" name="address" value="<?php echo $address; ?>"><br/>                      


                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter Your Password">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>Confirm password</label>
                                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
                                </div>
                            </div>


                            <button class="btn btn-primary btn-block"  name="register_btn" value="Login" type="Submit">REGISTER!</button><br/>  

                            <p style="text-align: center;">
                                Already registered? <a href="login.php">Log In</a><br/>
                                Register as a volunteer? <a href="volunteers_registration.php">Volunteer Registration</a>
                            </p>
                    </div>
                </div>
            </form>			
        </div>
    </div> 
  
</body>
</html>