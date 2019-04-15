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

    /*
        Fetches the user's information
        Stores them in variables to be used for editable purposes
    */

    $id = mysqli_real_escape_string($conn, $_POST["id"]);

    $selection = "SELECT id, username, email, address, telephone FROM users WHERE id = '".$id."'";

    $result = mysqli_query($conn, $selection);

    while ($rows = mysqli_fetch_array($result)) {
        
        $userid = $rows['id'];
        $username = $rows['username'];
        $email = $rows['email'];
        $telephone = $rows['telephone'];
        $address = $rows['address'];
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
            <script src="js/bootstrap.js"></script>
    </head>
    
<body>
    
    <div class="container">
        <div class="wrapper">
            <form action="edit_user.php" method="post" class="form-signin">       
                <h3 class="form-signin-heading">Edit Community Centers</h3>
                  <hr class="colorgraph"><br>
                
                    <div style="display: none;">              
                      <input type="text" class="form-control" id="userid"  name="userid" value="<?php echo $userid; ?>" style="visibility: hidden;">
                    </div>
                
                    <label for="fname">Center Name:</label>
                    <input type="text" class="form-control" id="username" placeholder="Enter Community Center (Required)" name="edit_username" value="<?php echo $username; ?>"><br/>
                
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" placeholder="example@gmail.com (Required)" name="edit_email" value="<?php echo $email; ?>"><br/>
                
                    <label for="telephone">Telephone No:</label>
                     <input type="text" class="form-control" id="telephone" placeholder="000-000-0000 (Required)" name="edit_telephone" value="<?php echo $telephone; ?>"><br/>
                
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" placeholder="Enter Address (Required)" name="edit_address" value="<?php echo $address; ?>"><br/>
                
                    <button type="submit" class="btn btn-primary btn-block" name="update_btn">UPDATE CENTER</button>

                    <a href="admin_user_edit.php" style="color: white; text-decoration: none;" class="btn btn-primary btn-block">BACK</a> 			
            </form>			
        </div>
    </div>    
   
</body>
</html>