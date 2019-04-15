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

    $sid = mysqli_real_escape_string($conn, $_POST["id"]);

    $selection = "SELECT * FROM needed_supplies WHERE sid = '".$sid."'";

    $result = mysqli_query($conn, $selection);

    while ($rows = mysqli_fetch_array($result)) {
        
        $sid = $rows['sid'];
        $item = $rows['item'];
        $amount = $rows['item_amt'];
        $priority = $rows['priority'];        
    }

    // Get Current Login User: through the SESSION method

    if (isset($_SESSION['user'])) :

        $community_center = $_SESSION['user']['id'];

    endif
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add Items</title>
        
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
        
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <link rel="stylesheet" href="css/bootstrap.css">
        
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
<body>
    
    <div class="container">
        <div class="wrapper">
            <form action="" method="post" class="form-signin">       
                <h3 class="form-signin-heading">Add Emergence Items</h3>
                  <hr class="colorgraph"><br>
                
                    <div style="display: none;">
                        <input type="text" class="form-control" id="sid"  name="sid" value="<?php echo $sid; ?>" style="visibility: hidden;"><br/>
                    </div>
                
                    <label for="item">Item:</label>
                    <input type="text" class="form-control" id="item" name="item" value="<?php echo $item; ?>" readonly><br/>
                
                    <label for="amt">Amount:</label>
                    <input type="text" class="form-control" id="amt" name="amt" value="<?php echo $amount; ?>" readonly><br/>
                
                    <label for="priority">Priority:</label>
                    <input type="text" class="form-control" id="priority" name="priority" value="<?php echo $priority; ?>" readonly><br/>
                
                    <label for="amtonhand">Add Amount On-Hand:</label>
                    <input type="number" class="form-control" id="center_amount" placeholder="Enter Amount (Required)" name="center_amt"><br/>
                    
                    <div style="display: none;">
                        <input type="text" class="form-control" id="center" name="center" value="<?php echo $community_center; ?>" style="visibility: hidden;">
                    </div>
                
                    <button type="submit" class="btn btn-primary btn-block" name="add_items_btn">ADD SUPPLIES</button><br/>                    		  

                  <a href="user_supply_items.php" style="color: white; text-decoration: none;" class="btn btn-primary btn-block">BACK</a>		
            </form>			
        </div>
    </div>   
    
</body>
</html>

