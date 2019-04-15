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
    
    <div class = "container">
        <div class="wrapper">
            <form action="admin_register.php" method="post" class="form-signin">       
                <h3 class="form-signin-heading">Add Users</h3>
                  <hr class="colorgraph"><br>
                
                    <!-- Call error file to display errors -->
                    <?php include('errors.php'); ?>
                
                        <label for="fname">Name:</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter Name (Required)" name="username" value="<?php echo $username; ?>"><br/>

                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" placeholder="example@gmail.com (Required)" name="email" value="<?php echo $email; ?>"><br/>

                        <label for="telephone">Telephone No:</label>
                        <input type="text" class="form-control" id="telephone" placeholder="000-000-0000 (Required)" name="telephone" value="<?php echo $telephone; ?>"><br/>

                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="address" placeholder="Enter Address (Required)" name="address" value="<?php echo $address; ?>"><br/>                

                        <label for="password">Default Password:</label>
                        <input type="password" class="form-control" name="password" placeholder="Default Password"/><br/> 

                        <label class="users" for="users">User Type:</label>
                          <select class="form-control" id="users" name="user_type">
                            <option value="" selected>Choose...</option>
                            <option value="admin">Administrator</option>
                            <option value="center">Community Center</option>
                          </select><br/>

                        <button type="submit" class="btn btn-primary btn-block" name="c_register_btn">ADD CENTER</button>                    		  

                  <button class="btn btn-primary btn-block"><a href="admin.php" style="color: white; text-decoration: none;">BACK</a></button>  			
            </form>			
        </div>
    </div>    
   
</body>
</html>