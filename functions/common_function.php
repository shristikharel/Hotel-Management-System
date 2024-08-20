<?php
include(dirname(__DIR__, 1).'/admin/config.php');
// Get User ID Function for CUSTOMER
function get_user_id_fromsession()
{
    global $con;
    $select_query = "Select * from `user_table` where  username = '{$_SESSION['cust_name']}'";
    $result_query = mysqli_query($con, $select_query);
    if (mysqli_num_rows($result_query) > 0) {
        while ($row = mysqli_fetch_assoc($result_query)) {
            // to output MySQL data in HTML table format
            $user_id = $row['id'];
        }
    }
    return $user_id;
}
// Get User ID Function for ADMIN
function get_user_id_admin()
{
    global $con;
    // Check if 'admin_name' is set in the session
    if (isset($_SESSION['admin_name'])) {
        $admin_name = mysqli_real_escape_string($con, $_SESSION['admin_name']);
        $select_query = "SELECT * FROM `user_table` WHERE username = '$admin_name'";
        $result_query = mysqli_query($con, $select_query);
        if (mysqli_num_rows($result_query) > 0) {
            while ($row = mysqli_fetch_assoc($result_query)) {
                // to output mysql data in HTML table format
                $user_id = $row['id'];
            }
        }
        return $user_id;
    } else {
        // Handle the case when 'admin_name' is not set
        return null;
    }
}

// Get User ID Function for STAFF
function get_user_id_staff()
{
    global $con;
    
    // Check if 'staff_name' is set in the session
    if (isset($_SESSION['staff_name'])) {
        $staff_name = mysqli_real_escape_string($con, $_SESSION['staff_name']);
        $select_query = "SELECT * FROM `user_table` WHERE username = '$staff_name'";
        $result_query = mysqli_query($con, $select_query);
        if (mysqli_num_rows($result_query) > 0) {
            while ($row = mysqli_fetch_assoc($result_query)) {
                // to output mysql data in HTML table format
                $user_id = $row['id'];
            }
        }
        return $user_id;
    } else {
        // Handle the case when 'staff_name' is not set
        return null;
    }
}




function user_email()
{
    global $con;
    $select_query = "Select * from `user_table` where  username = '{$_SESSION['cust_name']}'";
    $result_query = mysqli_query($con, $select_query);
    if (mysqli_num_rows($result_query) > 0) {
        while ($row = mysqli_fetch_assoc($result_query)) {
            // to output mysql data in HTML table format
            $user_id = $row['email'];
        }
    }
    return $user_id;
}

function getrooms(){
  if(!isset($_GET['category'])){
    global $con;
    $select_query = "SELECT * FROM `rooms`";
                $result_select = mysqli_query($con, $select_query);

                if ($result_select) {
                    while ($row = mysqli_fetch_assoc($result_select)) {
                        $room_name = $row['Name'];
                        $price_per_night = $row['Price'];
                        $room_image = $row['Image'];
                        $adult = $row['Adults'];
                        $child = $row['Children'];
                        $facility = $row['Facilities'];
                        $feature = $row['Features'];

                        $facilitiesArray = explode(",", $facility);
                        $featuresArray = explode(",", $feature);
                        ?>
                        <div class="card mb-4 border-0 shadow">
                            <div class="row g-0">
                                <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                    <img src="uploads/rooms/<?php echo $room_image; ?>" class="img-fluid rounded"
                                        style="height: 100%;">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h5 class="mb-3"><?php echo $room_name; ?></h5>
                                        <div class="features mb-3">
                                            <h6 class="mb-1">Features</h6>
                                            <?php
                                            foreach ($featuresArray as $featureTitle) {
                                                echo '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $featureTitle . '</span>';
                                            }
                                            ?>
                                        </div>
                                        <div class="facilities mb-3">
                                            <h6 class="mb-1">Facilities</h6>
                                            <?php
                                            foreach ($facilitiesArray as $facilityTitle) {
                                                echo '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $facilityTitle . '</span>';
                                            }
                                            ?>
                                        </div>
                                        <div class="guests">
                                            <h6 class="mb-1">Guests</h6>
                                            <span
                                                class="badge rounded-pill bg-light text-dark text-wrap"><?php echo $adult; ?>
                                                Adults</span>
                                            <span
                                                class="badge rounded-pill bg-light text-dark text-wrap"><?php echo $child; ?>
                                                Children</span>
                                        </div>
                                        <h6 class="mb-4">रु <?php echo $price_per_night; ?> per night</h6>
                                        <a href="book.php?room_id=<?php echo $row['room_id']; ?>"
                                            class="btn btn-sm btn-outline-dark shadow-none">Book Now</a>
                                        <span style="margin-bottom: 10px;"></span>
                                        <a href="viewmore.php?room_id=<?php echo $row['room_id']; ?>"
                                            class="btn btn-sm btn-outline-dark shadow-none">View More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div class="col-12 text-center"><p>No rooms available at the moment.</p></div>';
                }
  }
}


//getting unique categories
function get_unique_categories() {
  global $con;

  // Check if 'category' parameter exists in the URL
  if (isset($_GET['category'])) {
      $category_id = $_GET['category'];

      // Use prepared statement to prevent SQL injection
      $select_query = "SELECT * FROM `rooms` WHERE id = ?";
      $statement = mysqli_prepare($con, $select_query);

      if ($statement) {
          // Bind the parameter and execute the statement
          mysqli_stmt_bind_param($statement, "i", $category_id);
          mysqli_stmt_execute($statement);

          // Get the result
          $result_select = mysqli_stmt_get_result($statement);

          if ($result_select) {
              while ($row = mysqli_fetch_assoc($result_select)) {
                  // Your existing code to display room details
                  $room_name = $row['Name'];
                  $price_per_night = $row['Price'];
                  $room_image = $row['Image'];
                  $adult = $row['Adults'];
                  $child = $row['Children'];
                  $facility = $row['Facilities'];
                  $feature = $row['Features'];

                  $facilitiesArray = explode(",", $facility);
                  $featuresArray = explode(",", $feature);

                  echo '<div class="card mb-4 border-0 shadow">
                      <div class="row g-0">
                          <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                              <img src="uploads/rooms/' . $room_image . '" class="img-fluid rounded" style="height: 100%;">
                          </div>
                          <div class="col-md-7">
                              <div class="card-body">
                                  <h5 class="mb-3">' . $room_name . '</h5>
                                  <div class="features mb-3">
                                      <h6 class="mb-1">Features</h6>';
                  foreach ($featuresArray as $featureTitle) {
                      echo '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $featureTitle . '</span>';
                  }
                  echo '</div>
                                  <div class="facilities mb-3">
                                      <h6 class="mb-1">Facilities</h6>';
                  foreach ($facilitiesArray as $facilityTitle) {
                      echo '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $facilityTitle . '</span>';
                  }
                  echo '</div>
                                  <div class="guests">
                                      <h6 class="mb-1">Guests</h6>
                                      <span class="badge rounded-pill bg-light text-dark text-wrap">' . $adult . ' Adults</span>
                                      <span class="badge rounded-pill bg-light text-dark text-wrap">' . $child . ' Children</span>
                                  </div>
                                  <h6 class="mb-4">रु ' . $price_per_night . ' per night</h6>
                                  <a href="book.php?room_id=' . $row['room_id'] . '" class="btn btn-sm btn-outline-dark shadow-none">Book Now</a>
                                  <span style="margin-bottom: 10px;"></span>
                                  <a href="viewmore.php?room_id=' . $row['room_id'] . '" class="btn btn-sm btn-outline-dark shadow-none">View More</a>
                              </div>
                          </div>
                      </div>
                  </div>';
              }
          } else {
              echo '<div class="col-12 text-center"><p>No rooms available at the moment.</p></div>';
          }

          // Close the statement
          mysqli_stmt_close($statement);
      } else {
          echo '<div class="col-12 text-center"><p>Failed to prepare the statement.</p></div>';
      }
  }
}



// function to get room number
function cart_item()
{
  if (isset($_GET['add_to_cart'])) {
    global $con;
    $select_query = "Select COUNT(room_id)  from `book_details` GROUP BY room_id";
    $result_query = mysqli_query($con, $select_query);
    $count_cart_items  = mysqli_num_rows($result_query);
  } else {
    global $con;
    $select_query = "Select COUNT(room_id)  from `book_details` GROUP BY room_id";
    $result_query = mysqli_query($con, $select_query);

    $count_cart_items  = mysqli_num_rows($result_query);
  }
  echo $count_cart_items;
}



// VIEW MORE


// SEARCH VEHICLES
function search_room($con)
{
    if (isset($_GET['search_data'])) {
        $search_data_value = $_GET['search_data'];
        $search_query = "SELECT * FROM `rooms` WHERE keywords LIKE '%" . $search_data_value . "%'";
        $result_query = mysqli_query($con, $search_query);

        while ($row = mysqli_fetch_assoc($result_query)) {
            $room_id = $row['room_id'];
            $room_name = $row['Name'];
            $room_description = $row['Description'];
            $room_price = $row['Price'];
            $room_image = $row['Image'];
            $adult = $row['Adults'];
            $child = $row['Children'];
            $facility = $row['Facilities'];
            $feature = $row['Features'];

            // Explode facility and feature strings into arrays
            $facilitiesArray = explode(",", $facility);
            $featuresArray = explode(",", $feature);

            // HTML for each room card
            echo '<div class="col-lg-4 col-md-6 my-3">';
            echo '<div class="card h-100 border-0 shadow" style="max-width: 350px; margin: auto;">';
            echo '<div style="width: 100%; height: 10rem;">';
            echo '<img src="../uploads/rooms/' . $room_image . '" class="card-img-top" style="height: 100%; object-fit: cover;">';
            echo '</div>';
            echo '<div class="card-body mt-3">';
            echo '<h5 class="card-title">' . $room_name . '</h5>';
            echo '<h6 class="mb-4">रु ' . $room_price . ' per night</h6>';
            

            // Facilities
            echo '<div class="facilities mb-2">';
            echo '<h6 class="mb-1">Facilities</h6>';
            foreach ($facilitiesArray as $facilityTitle) {
                echo '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $facilityTitle . '</span>';
            }
            echo '</div>';

            // Features
            echo '<div class="features mb-2">';
            echo '<h6 class="mb-1">Features</h6>';
            foreach ($featuresArray as $featureTitle) {
                echo '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $featureTitle . '</span>';
            }
            echo '</div>';

            echo '<div class="guests mb-2">';
            echo '<h6 class="mb-1">Guests</h6>';
            echo '<span class="badge rounded-pill bg-light text-dark text-wrap mb-1">' . $adult . ' Adults</span>';
            echo '<span class="badge rounded-pill bg-light text-dark text-wrap mb-1">' . $child . ' Children</span>';
            echo '</div>';

            // Add more details or customize as needed

            echo '<div class="mt-auto">';
            echo '<a href="viewmore.php?room_id=' . $room_id . '" class="btn btn-sm btn-outline-dark shadow-none">View More</a>';
            echo '<span style="margin-right: 10px;"></span>';
            echo '<a href="viewmore.php?room_id=' . $room_id . '" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
}


//GET Price
// function get_price()
// {
//   global $con;
//   $select_query = "Select * from `vehicles` where  username = '{$_SESSION['rentee_name']}'";
//   $result_query = mysqli_query($con, $select_query);
//   if (mysqli_num_rows($result_query) > 0) {
//     while ($row = mysqli_fetch_assoc($result_query)) {
//       $price = $row['Price'];
//     }
//   }else{
//     echo "Error!";
//   }
//   return $price;
// }

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendConfirmationEmail($booking_id)
{
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    $mail = new PHPMailer(true);
    global $con;

    // Retrieve user information including email address
    $user_info_query = "SELECT booking_id, book_details.user_id, email, checkindate, checkoutdate, 
        DATEDIFF(checkoutdate, checkindate) * price as room_price, book_details.status
        FROM `book_details`, `rooms` 
        WHERE book_details.room_id=rooms.room_id AND booking_id = '$booking_id'";
    $user_info_result = mysqli_query($con, $user_info_query);

    if ($user_info_result) {
        $user_info = mysqli_fetch_array($user_info_result);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'shristikharel321@gmail.com';
            $mail->Password   = 'mqyn hlal kpkb znko';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            //Recipients
            $mail->setFrom('shristikharel321@gmail.com', 'HMS System');
            $mail->addAddress($user_info['email'], 'Hotel Booking Website');

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Booking Confirmed';
            $mail->Body    = 'Dear  <strong>' . $user_info['email'] .' </strong>, <br>  Thank you for choosing HMS for your stay. 
                We are pleased to confirm your reservation for the following details: <br> 
                <strong> Check-in Date: </strong> ' . $user_info['checkindate'] .' <br>
                <strong> Check-out Date: </strong> ' . $user_info['checkoutdate'] .' <br>
                <strong> Total Cost: </strong> रु. ' . $user_info['room_price'] . ' <br>
                <strong> Contact Information: </strong> <br>
                <strong> Phone Number: </strong> 9869031332 <br>
                <strong> Email Address: </strong> shristi.kharel@deerwalk.edu.np <br>
                Please review the information above to ensure accuracy. 
                If you have any questions or need further assistance, feel free to contact us at <strong>9869031332</strong> . <br>
                We look forward to welcoming you to HMS Safe travels! <br>
                Best regards, <br>
                HMS Team <br>';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}



function sendCancellationEmail($booking_id)
{
//Load Composer's autoloader
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
global $con; // Make sure $con is accessible within the function

    // Retrieve user information including email address
    $user_info_query = "SELECT booking_id, email, checkindate, checkoutdate FROM `book_details` WHERE booking_id = '$booking_id'";
    $user_info_result = mysqli_query($con, $user_info_query);
    if ($user_info_result) {
        $user_info = mysqli_fetch_array($user_info_result);

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'shristikharel321@gmail.com';                     //SMTP username
    $mail->Password   = 'mqyn hlal kpkb znko';                  //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('shristikharel321@gmail.com', 'HMS System');
    $mail->addAddress($user_info['email'], 'Hotel Booking Website');   //Add a recipient
    

    
    // Content
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Booking Cancellation';
$mail->Body    = 'Dear <strong>' . $user_info['email'] . '</strong>, <br> We regret to inform you that your reservation with HMS has been cancelled. <br>
                  If you have any further questions or require assistance, please do not hesitate to contact us at <strong> 9869031332 </strong>. <br>
                  We appreciate your understanding. <br>
                  Best regards, <br>
                  HMS Team <br>';

    

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
    }
}



?>
