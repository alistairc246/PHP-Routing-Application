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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Select Items</title>
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
            <form action="supply_items.php" method="post" class="form-signin">       
                <h3 class="form-signin-heading">Select Items</h3>
                  <hr class="colorgraph"><br>
                
                    <label for="username">Items Needed:</label>
                        <select class="form-control" id="supplies" name="id" onchange="this.form.submit()">
                            <option value="" selected>Choose Item...</option>
                                <?php

                                    // Fetches needed supplies from the database: displays them in dropdown menu

                                    $get_items = mysqli_query($conn, "SELECT * FROM needed_supplies WHERE item_amt != 0 ORDER BY priority");

                                    while ($row = $get_items->fetch_assoc()){

                                         echo "<option value='". $row['sid'] ."'>" . $row['item'] . " (". $row['item_amt'] .") </option>";
                                    }       

                                ?>  

                        </select><br/>             
       
                  <a href="index.php" style="color: white; text-decoration: none;" class="btn btn-primary btn-block">BACK</a>	
            </form>			
        </div>
    </div> 
    
</body>
</html>