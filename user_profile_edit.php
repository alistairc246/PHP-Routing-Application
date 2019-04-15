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
        unset($_SESSION['user']['username']);
        header("location: login.php");
        
    }

    /*
        Fetches the needed supplies
        Stores them in variables to be used for editable purposes
    */

    $id = mysqli_real_escape_string($conn, $_POST["userid"]);

    $selection = mysqli_query($conn, "SELECT * FROM user WHERE id = '".$id."'");

    while ($rows = mysqli_fetch_array($selection)) {
        
        $id = $rows['id'];
        $username = $rows['username'];
        $email = $rows['email'];
        $telephone = $rows['telephone'];        
        $address = $rows['address'];        
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit User Profile</title>
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
            <form action="user_profile_edit.php" method="post" class="form-signin">       
                <h3 class="form-signin-heading">Edit User Profile</h3>
                  <hr class="colorgraph"><br>
                
                    <div style="display: none;">              
                      <input type="text" class="form-control" id="userid"  name="userid" value="<?php echo $id; ?>" style="visibility: hidden;">
                    </div>
                
                    <label for="fname">Center Name:</label>
                    <input type="text" class="form-control" id="username" name="edit_username" value="<?php echo $username; ?>"><br/>
                
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="edit_email" value="<?php echo $email; ?>"><br/>
                
                    <label for="telephone">Telephone No:</label>
                    <input type="text" class="form-control" id="telephone" name="edit_telephone" value="<?php echo $telephone; ?>"><br/>
                
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="edit_address" value="<?php echo $address; ?>"><br/>
                
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="address" name="edit_password"><br/>
                
                    <button type="submit" class="btn btn-primary btn-block" name="update_profile_btn">UPDATE PROFILE</button>

                    <button class="btn btn-primary btn-block"><a href="index.php" style="color: white; text-decoration: none;">BACK</a></button>  			
            </form>			
        </div>
    </div>    
   
</body>
</html>