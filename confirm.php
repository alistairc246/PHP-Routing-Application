<?php 

    // Requests the inclusion of the functions.php file
    // Connecting to database, saving to the database

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
            <script src="js/bootstrap.js"></script>
    </head>
<body>
    
    <div class = "container">
        <div class="wrapper">
            <form action="confirm.php" method="post" class="form-signin">       
                <h3 class="form-signin-heading">Confirm Registration</h3>
                  <hr class="colorgraph"><br>
                    
                    <!-- Call error file to display errors -->
                    <?php include('errors.php'); ?>
                
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" placeholder="example@gmail.com (Required)" name="email" value="<?php echo $email; ?>"><br/>

                        <label for="telephone">Telephone No:</label>
                        <input type="text" class="form-control" id="telephone" placeholder="000-000-0000 (Required)" name="telephone" value="<?php echo $telephone;?>"><br/>

                    <button type="submit" class="btn btn-primary btn-block" name="confirm">CONFIRM</button>               			
            </form>			
        </div>
    </div>

</body>
</html>