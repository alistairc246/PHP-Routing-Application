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
        <title>Fema Item Collection</title>
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
            <form action="collect_items.php" method="post" class="form-signin">       
                <h3 class="form-signin-heading">Emergency Items Collection</h3>
                  <hr class="colorgraph"><br>
                
                    <!-- Call error file to display errors -->
                    <?php include('errors.php'); ?>

                      <div class="row">
                        <div class="col-md-12">
                            <div id="accordion" class="panel-group">
                                
                                <!-- Fetches community centers with their item amounts and street addresses -->
                                <?php 
                                
                                    // Query database: JOIN tables query
                                    $get_items = mysqli_query($conn, "SELECT c.cid, u.username, u.address, c.sup_amount , ns.item FROM center_supplies c INNER JOIN needed_supplies ns on c.sid = ns.sid INNER JOIN users u on c.center = u.id WHERE ns.item_amt = 0 ORDER BY ns.priority");

                                    if (mysqli_num_rows($get_items) != 0) {
                                        
                                            // Output table results within an accordion
                                            while ($row = $get_items->fetch_assoc()) {
                                                
                                                $address = str_replace("+", " ", $row['address']);

                                                echo "<div class='panel panel-default'>
                                                    <div class='panel-heading'>
                                                        <h4 class='panel-title'>
                                                            <a data-toggle='collapse' data-parent='#accordion' href='#".$row['cid']."'>".$row['username']."</a>
                                                            <input type='checkbox' class='item' name='item[]' value='".$row['cid']."' style='float:right;' >
                                                        </h4>
                                                    </div>
                                                    <div id='".$row['cid']."' class='panel-collapse collapse'>
                                                        <div class='panel-body'>Item: 
                                                            ".$row['item']."<br/>
                                                            Amount Needed: ".$row['sup_amount']."<br/>
                                                            Address: ".$address."
                                                        </div>
                                                    </div>
                                                </div>";

                                            }

                                        } else {

                                            array_push($errors, "There are currently no items to be collected!");
                                        }

                                  ?>                       

                            </div>   
                        </div>
                    </div>
                
                    <button id="collect" class="btn btn-primary btn-block" name="collect_items">COLLECT ITEMS</button>
                    <a href="transport.php" style="color: white; text-decoration: none;" class="btn btn-primary btn-block">BACK</a>
            </form>            

        </div>
    </div>
         
</body>
</html>