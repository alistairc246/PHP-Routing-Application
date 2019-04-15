<?php 

    // Requests the inclusion of the functions.php file

    include('functions.php');

    // Calls the isLoggedIn Function

    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You are required to login";
        
        header('location: login.php');
    }

    // Logs user out if logout button clicked
    if (isset($_GET['logout'])) {
        
        session_destroy();
        unset($_SESSION['user']);
        header("location: login.php");
        
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Community Centers</title>
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
    
    <div class = "container">
        <div class="wrapper">
            <form action="edit_user.php" method="post" class="form-signin">       
                <h3 class="form-signin-heading">Edit Community Centers</h3>
                  <hr class="colorgraph"><br>
                
                    <!-- Call error file to display errors -->
                     <?php include('errors.php'); ?>
                
                        <label for="username">Center Name:</label><br/>
                          <select class="form-control" id="username" name="id" onchange="this.form.submit()">
                            <option value="" selected>Choose...</option>
                              
                              <!-- Fetches centers stored in the database -->
                                <?php

                                  $get_centers = mysqli_query($conn, "SELECT * FROM users WHERE user_type = 'center'");

                                    while ($row = $get_centers->fetch_assoc()){

                                        echo "<option value='". $row['id'] ."'>" . $row['username'] . "</option>";
                                    }       

                                ?>  

                          </select><br/> 		  

                  <a href="admin.php" style="color: white; text-decoration: none;" class="btn btn-primary btn-block">BACK</a>		
            </form>			
        </div>
    </div>   
     
</body>
</html>