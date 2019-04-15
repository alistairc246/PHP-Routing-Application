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
    <title>Fema: Map Route</title>
        <!-- Meta Data -->
        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        
        <!-- Calls external stylesheets for css styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/maps.css">
    
  </head>
    
<body>
    <div id="map"></div>
        <div id="right-panel">
            
            <div>
                <b>Starting Point:</b>
                    <select class="form-control" id="start">
                        <option value="" selected>Choose...</option>
                            <?php
                                // Fetches locations of type driver
                                $get_location = mysqli_query($conn, "SELECT * FROM locations WHERE type = 'driver'");
                                
                                    // Display locations in drop-down select box
                                    while ($row = $get_location->fetch_assoc()){

                                        $address = str_replace("+", " ", $row['address']);

                                        echo "<option value='". $address ."'>" . $address . "</option>";
                                    }       

                            ?>  

                    </select><br/>

                <b>Collection Centers:</b> <br>
                    <i>(Ctrl+Click or Cmd+Click for multiple selection)</i> <br>
                    <select class="form-control"  multiple id="waypoints">
                        <option value="" selected>Choose...</option>
                            <?php
                                // Fetches location address of community centers whose orders have been fulled
                                $get_location = mysqli_query($conn, "SELECT c.cid, u.username, u.address, c.sup_amount , ns.item FROM center_supplies c INNER JOIN needed_supplies ns on c.sid = ns.sid INNER JOIN users u on c.center = u.id WHERE ns.item_amt = 0 ORDER BY ns.priority");
                                    
                                    // Display community centers in multiple select box
                                    while ($row = $get_location->fetch_assoc()){

                                        $address = str_replace("+", " ", $row['address']);

                                        echo "<option value='". $address ."'>" . $row['username'] . "</option>";
                                    }       

                            ?>  

                    </select><br/>

                <b>Destination:</b>
                    <select class="form-control" id="end">
                        <option value="" selected>Choose...</option>
                            <?php
                                // Fetches locations of type center
                                $get_location = mysqli_query($conn, "SELECT * FROM locations WHERE type = 'center'");

                                    // Display locations in drop-down select box
                                    while ($row = $get_location->fetch_assoc()){

                                        $address = str_replace("+", " ", $row['address']);

                                        echo "<option value='". $address ."'>" . $address . "</option>";
                                    }       

                            ?>  

                    </select><br/>

                  <input type="submit" id="submit" class="btn btn-primary btn-block">
            </div>
            
        <div id="directions-panel"></div><br/>
            <a href="transport.php" style="color: white; text-decoration: none;" class="btn btn-primary btn-block">BACK</a>
        </div>   
      
    <!-- Special Javascript: Google Maps API Javascript -->  
    <script>
    
    // Function initMap: creates a standard Google Map
    // Initical Zoom - 6 pixels
    // Google Directions Service enabled
    // Initical map center: set to latitude 41.85, longitude -87.65
    // Display map within div container map
        
      function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 6,
          center: {lat: 41.85, lng: -87.65}
        });
        directionsDisplay.setMap(map);

        document.getElementById('submit').addEventListener('click', function() {
          calculateAndDisplayRoute(directionsService, directionsDisplay);
        });
      }
        
    // Function calculateandDisplayRoute: creates road map directions
    // Directions are generated based on Google's DRIVING map travel mode
    // Starts and ends road mapping based on select tag ids
    // Calculates and Displays directions withing the directions-panel div 

      function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        var waypts = [];
        var checkboxArray = document.getElementById('waypoints');
        for (var i = 0; i < checkboxArray.length; i++) {
          if (checkboxArray.options[i].selected) {
            waypts.push({
              location: checkboxArray[i].value, // specifies the location of the waypoint, as a Lat & Lng
              stopover: true                    // indicates that the waypoint is a stop on the route
            });
          }
        }

        directionsService.route({
          origin: document.getElementById('start').value,
          destination: document.getElementById('end').value,
          waypoints: waypts,
          optimizeWaypoints: true,
          provideRouteAlternatives: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
            var summaryPanel = document.getElementById('directions-panel');
            summaryPanel.innerHTML = '';
            // For each route, display summary information.
            for (var i = 0; i < route.legs.length; i++) {
              var routeSegment = i + 1;
              summaryPanel.innerHTML += '<b>Route Path: ' + routeSegment +
                  '</b><br>';
              summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
              summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
              summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
            }
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
    </script>
    
    <!-- Syncs Map to Google Map API system using user defined API key -->
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtfr13rawb9m16mvWcjMr8v9sVYBKfkjE&callback=initMap">
    </script>
    
  </body>
</html>
