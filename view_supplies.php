
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
        <title>Fema View Items</title>
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
                <h3 class="form-signin-heading">View Emergency Items</h3>
                  <hr class="colorgraph"><br>            

                      <div class="row">
                        <div class="col-md-12">
                            <div id="accordion" class="panel-group">

                                <?php                        
                                    // Fetches needed supplies where amount are not empty
                                    // Sorts based on highest priority
                                    $get_items = mysqli_query($conn, "SELECT * FROM needed_supplies WHERE item_amt != 0 ORDER BY priority");

                                    // Display needed items in accordion layout
                                    while ($row = $get_items->fetch_assoc()) {

                                        echo "<div class='panel panel-default'>
                                            <div class='panel-heading'>
                                                <h4 class='panel-title'>
                                                    <a data-toggle='collapse' data-parent='#accordion' href='#".$row['sid']."'>".$row['item']."</a>                           
                                                </h4>
                                            </div>
                                            <div id='".$row['sid']."' class='panel-collapse collapse'>
                                                <div class='panel-body'>
                                                    Amount Needed: ".$row['item_amt']."                                           
                                                </div>
                                            </div>
                                        </div>";

                                    }

                                ?>                       

                            </div>   
                         </div>
                        </div>
                <a href="admin.php" style="color: white; text-decoration: none;" class="btn btn-primary btn-block">BACK</a>
            </form>         

        </div>
    </div>   
      
</body>
</html>