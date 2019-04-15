<?php 
    // Requests the inclusion of the functions.php file

    include('functions.php');    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Volunteer Registration</title>
            <!-- Meta Data -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
        
            <!-- Calls external stylesheets for css styles -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <link rel="stylesheet" href="css/bootstrap.css">
        
            <!-- Calls external javascript files to enable javascript methods -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
            <script type="text/javascript" src="js/bootstrap.js"></script>    
    </head>
    
<body>    
    <div class="container">
        <div class="wrapper">
            <form action="volunteers_registration.php" method="post" class="form-signin">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="form-signin-heading">Volunteer Registration</h3>
                          <hr class="colorgraph"><br>
                        
                            <!-- Call error file to display errors -->
                            <?php include('errors.php'); ?>
                        
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="fname">First Name:</label>
                                    <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname" value="<?php echo $fname; ?>">
                                </div>
                                
                                <div class="col-sm-6 form-group">
                                    <label for="lname">Last Name:</label>
                                    <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname" value="<?php echo $lname; ?>">
                                </div>
                            </div>
                        
                            <label for="email">Email:</label>
                            <input type="text" class="form-control" id="email" placeholder="example@gmail.com (Required)" name="email" value="<?php echo $email; ?>"><br/>
                        
                            <label for="telephone">Telephone No:</label>
                            <input type="text" class="form-control" id="telephone" placeholder="000-000-0000 (Required)" name="telephone" value="<?php echo $telephone; ?>"><br/>
                        
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" id="address" placeholder="Enter Address (Required)" name="address" value="<?php echo $address; ?>"><br/>
                        
                            <label class="occupation" for="occupation">Occupation:</label>
                              <select class="form-control" id="occupation" name="occupation">
                                <option value="" selected>Choose...</option>
                                <?php
                                  // Fetches all occupations stored in the database
                                  $get_occupations = mysqli_query($conn, "SELECT * FROM occupations");

                                    while ($row = $get_occupations->fetch_assoc()){

                                        echo "<option value='". $row['oid'] ."'>" . $row['name'] . "</option>";
                                    }       

                                ?>  

                              </select><br/>                        		  

                          <button class="btn btn-primary btn-block"  name="vol_register" type="Submit">REGISTER</button><br/>
                        
                          <p style="text-align: center;">
                            Already registered? <a href="login.php">Log In</a><br/>
                          </p>
                    </div>
                </div>
            </form>			
        </div>
    </div>   
	
</body>
</html>