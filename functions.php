<?php 

    /*
        Start Session
        Session: enables different users to log in and out of profiles.
    */

    session_start();

    /* 
        Get database connection
        This connection enables the program to store data into the database.    
    */

    include ('connection.php');

    // Variables Declaration
    // These variables: use to store POST data

    $username = "";
    $email = "";
    $telephone = "";
    $address = "";
    $fname = "";
    $lname = "";    
    $occupation = "";
    $location = "";
    $sid = "";
    $item = "";
    $amount = "";
    $priority = "";
    $errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    
    /**************************************************************************************
    
        Volunteer Registration: Enables multiple users to sign-up, to offer their services
        Saves volunteers into database
    
    ***************************************************************************************/
    
    
    if (isset($_POST['vol_register'])) {
        
        // Formats variables to prevent exceptions: using mysqli_real_escape_string
        // Stores data via POST method 
        
        $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
        $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);                
        $telephone = mysqli_real_escape_string($conn, $_POST["telephone"]);
        $address = mysqli_real_escape_string($conn, $_POST["address"]);
        $occupation = mysqli_real_escape_string($conn, $_POST["occupation"]);

        // Form validation: ensures that the form is correctly filled
        // Ensures that textbox fields aren't empty
        
        if (empty($fname)) { array_push($errors, "First name is required"); }
        if (empty($lname)) { array_push($errors, "Last name is required"); }
        if (empty($email)) { array_push($errors, "An email is required"); }
        if (empty($telephone)) { array_push($errors, "A telephone number is required"); }
        if (empty($address)) { array_push($errors, "A street address is required"); }
        if (empty($occupation)) { array_push($errors, "An occupation is required"); }
        
        // Checks to ensure that email address entered is formatted to the correct format
        // If not, outputs error message

        if(!empty($email)) {
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                array_push($errors, "Invalid Email Format!");
            }
        }
        
        // Checks to ensure that the telephone number is formatted to the correct format
        // If not, outputs error message
        
        if(!empty($telephone)) {
            
            if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $telephone)) {

                array_push($errors, "Invalid Telephone Format!");
            } 
        }
        
        // If no errors were encountered...
        
        if (count($errors) == 0) {  
            
            // Calculate Map Coordinates from address
        
            $address = str_replace(" ", "+", $address);

            $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
            $json = json_decode($json);

            $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
            $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
            
            // Check if volunteer was already registered
            // If so, display error message
            // Else, add new volunteer into the program
            
            $chk_volunteer = "SELECT * FROM volunteers WHERE telephone = '".$telephone."' && email = '".$email."'";
                    
            $result = mysqli_query($conn, $chk_volunteer);
                    
                if (mysqli_num_rows($result)> 0) {
                        
                   array_push($errors, "That volunteer has register already!");                  
                    
                } else {
                    
                    $insert = "INSERT INTO volunteers (fname, lname, email, telephone, address, latitude, longitude, occupation, confirmation) VALUES ('$fname', '$lname', '$email', '$telephone', '$address', '$lat', '$long', '$occupation', 'no')";

                      if (mysqli_query($conn, $insert)) {

                         header('location: confirm.php');                         

                      } else {

                          echo "Error: " . $insert . "<br>" . mysqli_error($conn);
                      }
                } 
        }
    } 

    /****************************************************************************
    
        Confirm Volunteer registration
        Enables volunteers to confirm their registration
        N.B - allow confirmed volunteers will be contacted
        
    *****************************************************************************/

    if (isset($_POST['confirm'])) {
        
        // Formats variables to prevent exceptions: using mysqli_real_escape_string
        // Stores data via POST method 
        
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
        
        // Form validation: ensures that the form is correctly filled
        // Ensures that textbox fields aren't empty

        if (empty($email)) { array_push($errors, "An email is required"); }        
        if (empty($telephone)) { array_push($errors, "A telephone number is required"); }
        
        // Checks to ensure that email address entered is formatted to the correct format
        // If not, outputs error message
        
        if(!empty($email)) {
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                array_push($errors, "Invalid Email Format!");
            }
        }
        
        // Checks to ensure that the telephone number is formatted to the correct format
        // If not, outputs error message
        
        if(!empty($telephone)) {
            
            if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $telephone)) {

                array_push($errors, "Invalid Telephone Format!");
            } 
        }
        
        // If no errors were encountered....
        // Confirm volunteer's registration: via matched credentials

        if (count($errors) == 0) {            
            
            $confirm = "SELECT fname, lname FROM volunteers WHERE email = '".$email."' && telephone = '".$telephone."'"; 
            
            $result = mysqli_query($conn, $confirm);
            
            if(mysqli_num_rows($result) == 1) {                        
                
                $update = "UPDATE volunteers SET confirmation = 'yes' WHERE email = '$email' AND telephone = '$telephone'";

                    if (mysqli_query($conn, $update)) {

                         header('location: volunteers_registration.php');                          

                      } else {

                          echo "Error: " . $insert . "<br>" . mysqli_error($conn);
                      }                
                
                    
            } else {
                
                // Display errot if credentials don't match
                
                array_push($errors, "Email & Telephone Number Don't Match!");
            }           
            
        }
    }

    /**********************************************************************************
    
        General Registration: All users sign-in
        Saves registered user into database: via POST variable values
        
    ***********************************************************************************/

    if(isset($_POST['register_btn'])) {
        
        // Formats variables to prevent exceptions: using mysqli_real_escape_string
        // Stores data via POST method 
        
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);                
        $telephone = mysqli_real_escape_string($conn, $_POST["telephone"]);
        $address = mysqli_real_escape_string($conn, $_POST["address"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $confirm_password = mysqli_real_escape_string($conn, $_POST["confirm_password"]);

        // Form validation: ensures that the form is correctly filled
        // Ensures that textbox fields aren't empty
        
        if (empty($username)) { array_push($errors, "A username is required"); }   
        if (empty($email)) { array_push($errors, "An email is required"); }
        if (empty($telephone)) { array_push($errors, "A telephone number is required"); }
        if (empty($address)) { array_push($errors, "A street address is required"); }
        if (empty($password)) { array_push($errors, "A password if required"); }
        
        // Checks to ensure that the two entered password match!
        // If not, outputs error message

        if ($password != $confirm_password) { array_push($errors, "Passwords didn't match!"); }
        
        // Checks to ensure that email address entered is formatted to the correct format
        // If not, outputs error message

        if(!empty($email)) {

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                array_push($errors, "Invalid Email Format!");
            }
        }
        
        // Checks to ensure that the telephone number is formatted to the correct format
        // If not, outputs error message

        if(!empty($telephone)) {

            if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $telephone)) {

                array_push($errors, "Invalid Telephone Format!");
            } 
        }
        
        // Calculate Map Coordinates from address
        
        $address = str_replace(" ", "+", $address);

        $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
        $json = json_decode($json);

        $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
        $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

        // If no errors are encountered.....
        
            if (count($errors) == 0) {

                // Runs sql query to search to see if user already exists
                
                $chk_user = "SELECT * FROM users WHERE username = '".$username."' && email = '".$email."'";

                $result = mysqli_query($conn, $chk_user);
                
                // Checks no.of rows returned by sql query
                // If no.of rows is greater than 0, outputs error message: user has been registered already!

                if (mysqli_num_rows($result)> 0) {

                    array_push($errors, "That user has already been registered!");

                } else {

                    // Encrypts password: to prevent persons from viewing it in the database
                    // For security and data integrity purposes
                    
                    $crypt_password = md5($password);
                    
                    /* 
                       Gets user type: using the POST method
                       Adds user information into the database, if they are admin
                       Else adds user information into database as a community center
                       Redirects user to the correct section
                    */

                    if (isset($_POST['user_type'])) {

                        $user_type = mysqli_real_escape_string($db_conn, $_POST['user_type']);

                        $query = "INSERT INTO users (username, email, telephone, address, latitude, longitude, password, user_type) 
                                  VALUES('$username', '$email', '$telephone', '$address', '$lat', '$long', '$crypt_password' ,'$user_type')";

                        mysqli_query($conn, $query);

                        $_SESSION['success']  = "New user successfully created!!";
                        
                        header('location: admin.php');

                    } else {

                        $query = "INSERT INTO users (username, email, telephone, address, latitude, longitude, password, user_type) 
                                  VALUES('$username', '$email', '$telephone', '$address', '$lat', '$long', '$crypt_password' ,'center')";

                        mysqli_query($conn, $query);

                        // get id of the created user
                        $logged_in_user_id = mysqli_insert_id($conn);

                        $_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
                        $_SESSION['success']  = "Congrats! You are currently logged in";

                        header('location: index.php');	
                    }

                }           


            }
            
    }
    
    /****************************************************************************************************
    
        Login: Checks to ensure credentials match
        Once matched, sign in respective user to the correct section (admin or community center section)
        
    *****************************************************************************************************/
    
    if (isset($_POST['login_btn'])) {
        
        // Formats variables to prevent exceptions: using mysqli_real_escape_string
        // Stores data via POST method
        
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Form validation: ensures that the form is correctly filled
        // Ensures that textbox fields aren't empty
        
        if (empty($username)) { array_push($errors, "Username is required"); }
        
        if (empty($password)) { array_push($errors, "Password is required"); }
        
        // If no errors are encountered.....
        
        if (count($errors) == 0) {
            
            // Encrypts password: to prevent persons from viewing it in the database
            // For security and data integrity purposes
            
            $format_password = md5($password); 
            
            // Runs sql query to search to see if user already exists
            
            $query = "SELECT * FROM users WHERE username='$username' AND password='$format_password' LIMIT 1";
            
		    $results = mysqli_query($conn, $query);
            
            // Checks no.of rows returned by sql query
            
            if (mysqli_num_rows($results) == 1) {
                
                $logged_in_user = mysqli_fetch_assoc($results);
                
                // Checks if user type returned is of type admin
                // If so, logs in user into the admin section of the program
                // Else, logs in user into the community centers section of the program
                
                if ($logged_in_user['user_type'] == 'admin') {

                    $_SESSION['user'] = $logged_in_user;
                    $_SESSION['success']  = "You are now logged in";
                    
                    // Redirects to admin home page
                    
                    header('location: admin.php');		  
                    
                } else if ($logged_in_user['user_type'] == 'driver') {
                    
                    $_SESSION['user'] = $logged_in_user;
                    $_SESSION['success']  = "You are now logged in";
                    
                    // Redirects to centers home page

                    header('location: transport.php');
                
                } else {
                    
                    $_SESSION['user'] = $logged_in_user;
                    $_SESSION['success']  = "You are now logged in";
                    
                    // Redirects to centers home page

                    header('location: index.php');
                }
                
            } else {
                
                // Outputs error message if the passwords don't match!
                
                array_push($errors, "Username & Password Don't Match!");
            }
        }
    }
    
    /******************************************************************************
    
        Registration from Admin section: 
        Saves registered user into database: via POST variable values
        
    *******************************************************************************/
    
    if (isset($_POST['c_register_btn'])) {
        
        // Formats variables to prevent exceptions: using mysqli_real_escape_string
        // Stores data via POST method
        
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);                
        $telephone = mysqli_real_escape_string($conn, $_POST["telephone"]);
        $address = mysqli_real_escape_string($conn, $_POST["address"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $user_type = mysqli_real_escape_string($conn, $_POST["user_type"]);
        
        // Form validation: ensures that the form is correctly filled
        // Ensures that textbox fields aren't empty
        
        if (empty($username)) { array_push($errors, "A username is required"); }   
        if (empty($email)) { array_push($errors, "An email is required"); }
        if (empty($telephone)) { array_push($errors, "A telephone number is required"); }
        if (empty($address)) { array_push($errors, "A street address is required"); }
        if (empty($user_type)) { array_push($errors, "A user type is required"); }
        
        // Checks to ensure that email address entered is formatted to the correct format
        // If not, outputs error message
        
        if(!empty($email)) {

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                array_push($errors, "Invalid Email Format!");
            }
        }
        
        // Checks to ensure that the telephone number is formatted to the correct format
        // If not, outputs error message

        if(!empty($telephone)) {

            if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $telephone)) {

                array_push($errors, "Invalid Telephone Format!");
            } 
        }
        
        // If no errors are encountered.....
        
        if (count($errors) == 0) {
            
            // Calculate Map Coordinates from address
        
            $address = str_replace(" ", "+", $address);

            $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
            $json = json_decode($json);

            $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
            $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
            
            // Runs sql query to search to see if user already exists
            // If so, displays error message
            // Else, inserts new user into the database
            
            $chk_center = "SELECT * FROM users WHERE username = '".$username."' && email = '".$email."'";
                    
            $result = mysqli_query($conn, $chk_center);
                    
                if (mysqli_num_rows($result) > 0) {
                        
                   array_push($errors, "That center has been register already!");                   
                    
                } else {           
                    
                    
                    // Encrypt password: for security and data integrity purposes
                    
                    $format_password = md5($password);
                    
                    /*
                       Execute sql query insertion statement
                       If successful, redirects user to admin home page
                       Else, outputs sql error message
                    */

                    $insert = "INSERT INTO users (username, email, telephone, address, latitude, longitude, password, user_type) 
                            VALUES('$username', '$email', '$telephone', '$address', '$lat', '$long', '$format_password' ,'$user_type')";                    
                    
                    if (mysqli_query($conn, $insert)) {

                         header('location: admin.php');

                    } else {

                          echo "Error: " . $insert . "<br>" . mysqli_error($conn);
                    }          
                }        
        
            }   
        }
    
        /******************************************************************************
            
            Enables FEMA to update community centers user profile for security purposes
            Update user profiles (admin side)
            Allows admin to edit user profile if necessary     
            
        *******************************************************************************/
    
        if (isset($_POST['update_btn'])) {
            
            // Formats variables to prevent exceptions: using mysqli_real_escape_string
            // Stores data via POST method
            
            $userid = mysqli_real_escape_string($conn, $_POST['userid']);
            $username = mysqli_real_escape_string($conn, $_POST['edit_username']);
            $email = mysqli_real_escape_string($conn, $_POST['edit_email']);
            $telephone = mysqli_real_escape_string($conn, $_POST['edit_telephone']);
            $address = mysqli_real_escape_string($conn, $_POST['edit_address']);
            
            // Checks to ensure that email address entered is formatted to the correct format
            // If not, outputs error message
            
            if(!empty($email)) {

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    array_push($errors, "Invalid Email Format!");
                }
            }
            
            // Checks to ensure that the telephone number is formatted to the correct format
            // If not, outputs error message

            if(!empty($telephone)) {

                if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $telephone)) {

                    array_push($errors, "Invalid Telephone Format!");
                } 
            }
            
            // If no errors are encountered.....
            // Updates respective database table records accordingly
            
            if (count($errors) == 0) {
                
                $update_user = "UPDATE users SET username = '$username', email = '$email', telephone = '$telephone', address ='$address' WHERE id = '".$userid."'";

                if (mysqli_query($conn, $update_user)) {

                    header('location: admin.php');                          

                } else {

                    echo "Error: " . $update_user . "<br>" . mysqli_error($conn);
                }    
            }

        }
    
        /*************************************************************************************************
        
            Enables admin user to add needed emergence supplies
            Needed supplies are posted, so that community center once logged in can fulfill the request
            Supplies are ordered based on priority
            
        **************************************************************************************************/
    
        if (isset($_POST['add_items'])) {
            
            // Formats variables to prevent exceptions: using mysqli_real_escape_string
            // Stores data via POST method
            
            $item = mysqli_real_escape_string($conn, $_POST['supplies']);
            $amount = mysqli_real_escape_string($conn, $_POST['amount']);
            $priority = mysqli_real_escape_string($conn, $_POST['priority']);
            
            // Form validation: ensures that the form is correctly filled
            // Ensures that textbox fields aren't empty
            
            if (empty($item)) { array_push ($errors, "No item was entered!"); }
            if (empty($amount)) { array_push ($errors, "No amount was entered!"); }
            if (empty($priority)) { array_push ($errors, "No priority was entered!"); }
            
            // If no errors are encountered.....
            
            if (count($errors) == 0) {
                
                // Runs sql query to search to see if item already exists
                // If so, displays error message
                // Else, inserts new item into the database
                
                $chk_items = "SELECT * FROM needed_supplies WHERE item = '".$item."'";

                $result = mysqli_query($conn, $chk_items);

                if (mysqli_num_rows($result) > 0) {

                   $update_item = "UPDATE needed_supplies SET item_amt ='$amount', priority = '$priority' WHERE item = '".$item."'";
                    
                   if (mysqli_query($conn, $update_item)) {

                        header('location: add_supplies.php');                          

                    } else {

                        echo "Error: " . $update_item . "<br>" . mysqli_error($conn);
                    }    

                } else {
                    
                    $insert_items = "INSERT INTO needed_supplies (item, item_amt, priority) VALUES ('$item','$amount','$priority')";
                        
                    if (mysqli_query($conn, $insert_items)) {

                        // Redirect to add more supplies 
                        
                        header('location: add_supplies.php');
                          
                    } else {
                        
                        // Output error if insert query fails
                        
                        echo "Error: " . $insert_items . "<br>" . mysqli_error($conn);
                    }       
                    
                }
            
            }
        }
    
        /*************************************************************************************************
        
            Enables community centers to fulfill supply requests
            Saves community centers and their supply amounts into a separate table for collection purposes
            
        **************************************************************************************************/
    
        if (isset($_POST['add_items_btn'])) {
            
            // Formats variables to prevent exceptions: using mysqli_real_escape_string
            // Stores data via POST method
            
            $sid = mysqli_real_escape_string($conn, $_POST['sid']);
            $current_amt = mysqli_real_escape_string($conn, $_POST['amt']);
            $c_amt = mysqli_real_escape_string($conn, $_POST['center_amt']);
            $center = mysqli_real_escape_string($conn, $_POST['center']);
            
            // Form validation: ensures that the form is correctly filled
            // Ensures that textbox fields aren't empty
            
            if (empty($c_amt)) { array_push ($errors, "No amount was entered!"); }
            
            // If no errors were encountered, proceed to add center supply amounts to the database
            
            if (count($errors) == 0) {
                
                // Checks if record already exists 
                // If so, displays error message
                // Else, calculates current needed amount and inserts supplies into the database
                
                $chk_centers = "SELECT * FROM center_supplies WHERE sid = '".$sid."' AND center = '".$center."'";

                $result = mysqli_query($conn, $chk_centers);                
                
                if (mysqli_num_rows($result) > 0) {

                   array_push($errors, "Item has already been entered!");                       

                } else {
                    
                    // Calculate new amount of items needed     
                    
                    $new_total_needed = $current_amt - $c_amt;
                    
                    // Define insert query: inserts supplies into the database  
                    
                    $items = "INSERT INTO center_supplies (sid, sup_amount, center) VALUES ('$sid','$c_amt','$center')";                    
                        
                    if (mysqli_query($conn, $items)) {
                        
                        $update = "UPDATE needed_supplies SET item_amt = '$new_total_needed' WHERE sid = '".$sid."'";
                        
                        if (mysqli_query($conn, $update)) {
                            
                             // Redirect to add more supplies 
                            
                            header('location: user_supply_items.php');
                        }                       
                          
                    } else {
                        
                        // Output error if insert query fails
                        
                        echo "Error: " . $items . "<br>" . mysqli_error($conn);
                    }    
                
                }
                
            }
                
            
        }
    
        /****************************************************************
        
            Delete collected emergency items
            When checkbox is checked and submit button is clicked  
            
        *****************************************************************/
    
    
        if (isset($_POST['collect_items'])) {
            
            $array = array();
            
            $array = $_POST['item'];            
            
            $delete = 'DELETE FROM center_supplies WHERE `cid` IN (' . implode(",", $array) . ')';
            
            if (mysqli_query($conn, $delete)) {             
                            
                header('location: collect_items.php');
                
            } else {
                        
                // Output error if insert query fails
                        
                echo "Error: " . $delete . "<br>" . mysqli_error($conn);
            }  
            
        }
    
        /************************************************************
        
            Change Password
            Enables users to change their password, if forgotten 
            
        *************************************************************/
        
        if (isset($_POST['change_password'])) {
            
            // Formats variables to prevent exceptions: using mysqli_real_escape_string
            // Stores data via POST method
            
            $username = mysqli_real_escape_string($conn, $_POST['usrname']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $c_password = mysqli_real_escape_string($conn, $_POST['c_password']);
            
            // Form validation: ensures that the form is correctly filled
            // Ensures that textbox fields aren't empty
            
            if (empty($username)) { array_push ($errors, "No username was entered!"); }
            
            // Checks to ensure that the two entered password match!
            // If not, outputs error message

            if ($password != $c_password) { array_push($errors, "Passwords didn't match!"); }
            
            // If no errors were encountered, proceed to add center supply amounts to the database
            
            if (count($errors) == 0) {
                
                $chk_user = "SELECT * FROM users WHERE username = '".$username."'";

                $result = mysqli_query($conn, $chk_user);                
                
                if (mysqli_num_rows($result) > 0) {
                    
                    // Encrypt password: for security and data integrity purposes
                    
                    $format_password = md5($password);

                    $change = "UPDATE users SET password = '$format_password' WHERE username = '".$username."'";

                    if (mysqli_query($conn, $change)) {             

                        header('location: login.php');

                    } else {

                        // Output error if insert query fails

                        echo "Error: " . $change . "<br>" . mysqli_error($conn);
                    }                                          

                } else {
                
                    array_push($errors, "User does not exists!");
                }                
                
            }
            
        }
    
    
        /*********************************************************************************************************
        
            Add Occupations for Volunteers
            Enables Fema to add needed occupations such masons, carpenters, joiners, engineers etc.
            The occpuations are save in the database: so volunteers when registering can select a particular one
            
        **********************************************************************************************************/
    
        if (isset($_POST['add_occupation'])) {
            
            // Formats variables to prevent exceptions: using mysqli_real_escape_string
            // Stores data via POST method
            
            $occupation = mysqli_real_escape_string($conn, $_POST['job_title']);
            
            // Form validation: ensures that the form is correctly filled
            // Ensures that textbox fields aren't empty
            
            if (empty($occupation)) { array_push ($errors, "No occupation was entered!"); }
            
            // If no errors were encountered, proceed to add occupations into the database
            
            if (count($errors) == 0) {
                
                $chk_occupation = "SELECT * FROM occupations WHERE name = '".$occupation."'";

                $result = mysqli_query($conn, $chk_occupation);                
                
                if (mysqli_num_rows($result) > 0) {
                    
                    // Checks if occupation is already in the database
                    
                    array_push($errors, "Occupation already exists!");
                      
                } else {
                    
                    // Insert new occupation
                    
                    $insertion = "INSERT INTO occupations (name) VALUES ('$occupation')";

                    if (mysqli_query($conn, $insertion)) {             

                        header('location: add_occupations.php');

                    } else {

                        // Output error if insert query fails

                        echo "Error: " . $insertion . "<br>" . mysqli_error($conn);
                    }    
                }
            }
            
        }
    
        /***********************************************************************************
        
            Emergency Response Locations: FEMA
            Enables FEMA to add various Response Locations: which the truck will route to.
            Locations are stored in the database for fast retrieval purposes
            
        ************************************************************************************/
    
        if (isset($_POST['add_location'])) {
            
            // Formats variables to prevent exceptions: using mysqli_real_escape_string
            // Stores data via POST method
            
            $location = mysqli_real_escape_string($conn, $_POST['location']);
            $location_type = mysqli_real_escape_string($conn, $_POST['type']);
            
            // Form validation: ensures that the form is correctly filled
            // Ensures that textbox fields aren't empty
            
            if (empty($location)) { array_push ($errors, "No location was entered!"); }
            if (empty($location_type)) { array_push ($errors, "No location type was entered!"); }
            
            // If no errors were encountered, proceed to add locations into the database
            
            if (count($errors) == 0) {
                
                // Calculate Map Coordinates from address
        
                $address = str_replace(" ", "+", $location);

                $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
                $json = json_decode($json);

                $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
            
                
                $chk_location = "SELECT * FROM locations WHERE address = '".$location."'";

                $result = mysqli_query($conn, $chk_location);                
                
                if (mysqli_num_rows($result) > 0) {
                    
                    // Checks if occupation is already in the database
                    
                    array_push($errors, "Location has already been added!");
                      
                } else {
                    
                    // Insert new occupation
                    
                    $insertion = "INSERT INTO locations (address, latitude, longitude, type) VALUES ('$address', '$lat', '$long', '$location_type')";

                    if (mysqli_query($conn, $insertion)) {             

                        header('location: add_locations.php');

                    } else {

                        // Output error if insert query fails

                        echo "Error: " . $insertion . "<br>" . mysqli_error($conn);
                    }    
                }
            }
            
        }   
        
        
}

    /**************************************************************
    
        PHP Functions
        Get user ids: determine if user was successfully logged in
        Uses PHP SESSION methods
        
    ***************************************************************/

    // Function: getUserById - returns user via their id

    function getUserById($id) {            

       $query = "SELECT * FROM users WHERE id=" . $id;
       $result = mysqli_query($conn, $query);

       $user = mysqli_fetch_assoc($result);
       return $user;
    }

    // Function: isLoggedIn - prevents users from entering url path to pages within system without being logged in

    function isLoggedIn() {

        if (isset($_SESSION['user']['username'])) {

            return true;

        } else {

            return false;
        }
    }
   
?>