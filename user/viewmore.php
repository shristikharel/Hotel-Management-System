<?php
include('../admin/config.php');
include('../functions/common_function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shristi - ROOMS</title>
    <?php require('../inc/links.php') ?>
</head>

<body class="bg-light">
    <!-- header -->
    <?php include(dirname(__DIR__).'/inc/links.php') ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><strong> WELCOME </strong><?php echo $_SESSION['cust_name'] ?></a>
    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active me-2" aria-current="page" href="userindex.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="rooms.php">Rooms</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="facilities.php">Facilities</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="book_details.php"><i class="bi bi-building-check"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="book.php">Booking History</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        
      </ul>
      <div class="d-flex">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2 custom-btn" data-bs-toggle="modal" data-bs-target="#loginModal" style="color: black; text-decoration: none;">
    <a href="../admin/logout.php" style="color: inherit; text-decoration: none;">Logout</a>
</button>


    </div>
    </div>
  </div>
</nav>
    <!-- end of header -->
   

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_GET['room_id'])) {
                    $room_id = $_GET['room_id'];
                function view_details()
                {
                    global $con;
                    if (isset($_GET['room_id'])) {
                        $room_id = $_GET['room_id'];
                        $select_query = "SELECT * FROM `rooms` WHERE room_id = $room_id";
                        $result_query = mysqli_query($con, $select_query);

                        while ($row = mysqli_fetch_assoc($result_query)) {
                            $user_id = get_user_id_fromsession();
                            $room_id = $row['room_id'];
                            $room_title = $row['Name'];
                            $room_description = $row['Description'];
                            $room_image1 = $row['Image'];
                            $room_image2 = $row['Image2'];
                            $room_image3 = $row['Image3'];
                            $room_image4 = $row['Image4'];
                            $room_price = $row['Price'];
                            $facility = $row['Facilities'];
                            $facilitiesArray = explode(",", $facility);

                            echo "<div class='row' style='height:60vh'>
                                    <div class='col-md-3'>
                                        <div class='card' style='width: 18rem; height:100%'>
                                            <div style='width:100%;'>
                                                <img src='../uploads/rooms/$room_image1' class='card-img-top' alt='$room_title'>
                                            </div>
                                            <div class='card-body'>
                                                <h5 class='card-title'>$room_title</h5>
                                                <p class='card-text'>$room_description</p>
                                                <h6 class='card-title text-danger fw-bold'>Price: Rs.$room_price Per Night/-</h6>
                                                <a href='rooms.php' class='btn btn-primary mt-3'>Go to Home</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-3'>
                                        <div class='card' style='width: 18rem; height:100%'>
                                            <div style='width:100%;'>
                                                <img src='../uploads/rooms/$room_image2' class='card-img-top' alt='$room_title'>
                                            </div>
                                            <div class='card-body'>
                                                <h5 class='card-title'>Facilities</h5>";

                            if (!empty($facilitiesArray)) {
                                echo "<ul class='list-unstyled'>";
                                foreach ($facilitiesArray as $facilityTitle) {
                                    echo "<li><i class='bi bi-house-lock-fill'></i> $facilityTitle</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "<p class='card-text'>No facilities available</p>";
                            }

                            echo "</div>
                                        </div>
                                    </div>

                                    <div class='col-md-3'>
                                        <div class='card' style='width: 18rem; height:100%'>
                                        <div style='width:100%;'>
                                                <img src='../uploads/rooms/$room_image4' class='card-img-top' alt='$room_title'>
                                            </div>
                                            <div class='card-body'>
                                                <marquee><h5 class='fw-bold fst-italic'>Book Now!</h5></marquee>
                                                <form method='POST' action='viewmore.php?room_id=$room_id'>
                                                    <div class= detailsform>
                                                        <label for='checkin' class='mt-2'>Check In Date:</label>
                                                        <input type='date' id='checkin' name='checkin' min=" .date('Y-m-d') ." class='form-control' required='required'>
                                                        <label for='checkout' class='mt-2'>Check Out Date:</label>
                                                        <input type='date' id='checkout'  name='checkout' min=" .date('Y-m-d') ." class='form-control' required='required'>
                                                    </div>
                                                    <input type='submit' class='btn btn-primary mt-3' name='submit' value='Book Now'>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-3'>
                                        <div class='card' style='width: 18rem; height:100%'>
                                            <div style='width:100%;'>
                                                <img src='../uploads/rooms/$room_image3' class='card-img-top' alt='$room_title'>
                                            </div>
                                            <div class='card-body'>
                                                <h5 class='card-title'>$room_title</h5><br>
                                                <h5 class='card-title text-success'><i class='fa-solid fa-square-phone'></i> For more information:</h5>
                                                <h6 class='card-title'><i class='fa-solid fa-location-dot'></i> Sifal, Kathmandu</h6>
                                                <h6 class='card-title'><i class='fa-solid fa-envelope'></i> shristikharel@deerwalk.edu.np</h6>
                                                <h6 class='card-title'><i class='fa-solid fa-phone'></i> 9869031332</h6>
                                                <a href='rooms.php' class='btn btn-primary mt-3'>Go to Home</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                        }
                    }
                }}

                if (isset($_POST['submit'])) {
                    $room_id = $_GET['room_id'];
                    $user_id = get_user_id_fromsession();
                    $email = user_email();
                    $checkin_date = $_POST['checkin'];
                    $checkout_date = $_POST['checkout'];

                    $query = "SELECT * FROM book_details WHERE room_id = '$room_id' AND ('$checkin_date' < checkoutdate AND '$checkout_date' > checkindate) ORDER BY checkoutdate DESC";
                    $result = mysqli_query($con, $query);
                    $no_of_rows = mysqli_num_rows($result);

                    if ($no_of_rows > 0) {
                        echo "<script>alert('Sorry, the room is already booked for the selected date. Please choose another room or date.')</script>";
                        echo "<script>window.open('rooms.php', '_self')</script>";
                    } else {
                        $insert_query = "INSERT INTO `book_details` (room_id, user_id, email, checkindate, checkoutdate, status) 
                                        VALUES ('$room_id', '$user_id', '$email', '$checkin_date', '$checkout_date', 'pending')";

                        if (mysqli_query($con, $insert_query)) {
                            echo "<script>alert('Booking Reservation made! Please wait for Approval')</script>";
                            echo "<script>window.open('book.php', '_self')</script>";
                            exit();
                        } else {
                            echo "Error: " . mysqli_error($con);
                        }
                    }
                }

                view_details();
                ?>
            </div>
        </div>
    </div>
    <!-- End of Main Content -->

    <!-- Recommendation Section -->
    <h2 class="fw-bold h-font text-center mt-5" style="margin-top: 20px;"> You May Like: </h2>

    <?php
    // Function to calculate cosine similarity
    function cosineSimilarity($vector1, $vector2)
    {
        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        foreach ($vector1 as $key => $value) {
            $dotProduct += $value * $vector2[$key];
            $magnitude1 += $value * $value;
            $magnitude2 += $vector2[$key] * $vector2[$key];
        }

        $magnitude = sqrt($magnitude1) * sqrt($magnitude2);

        if ($magnitude == 0) {
            return 0;
        } else {
            return $dotProduct / $magnitude;
        }
    }

    // Fetch details of the user's selected room
    $userSelectedRoomQuery = "SELECT room_id, Name, Price, rating, `noise_level(dB)`, `room_temp(C)`, `light_intensity(Lumens)`, `wifi_speed(Mbps)`, `room_size(sq_feet)` FROM rooms WHERE room_id = $room_id";
    $userSelectedRoomResult = mysqli_query($con, $userSelectedRoomQuery);

    if (!$userSelectedRoomResult) {
        // Handle the SQL error
        die('Error in SQL query: ' . mysqli_error($con));
    }

    $userSelectedRoom = mysqli_fetch_assoc($userSelectedRoomResult);

    // Features for the user's selected room
    $userSelectedRoomFeatures = [
        $userSelectedRoom['Price'],
        $userSelectedRoom['rating'],
        $userSelectedRoom['noise_level(dB)'],
        $userSelectedRoom['room_temp(C)'],
        $userSelectedRoom['light_intensity(Lumens)'],
        $userSelectedRoom['wifi_speed(Mbps)'],
        $userSelectedRoom['room_size(sq_feet)'],
    ];

    $recommendedRooms = [];

    // Fetch data from rooms table excluding the user's selected room
    $roomsQuery = "SELECT room_id, Name, Price, rating, `noise_level(dB)`, `room_temp(C)`, `light_intensity(Lumens)`, `wifi_speed(Mbps)`, `room_size(sq_feet)` FROM rooms WHERE room_id != $room_id";
    $roomsResult = mysqli_query($con, $roomsQuery);

    if (!$roomsResult) {
        // Handle the SQL error
        die('Error in SQL query: ' . mysqli_error($con));
    }

    // Iterate through room details
    while ($room = mysqli_fetch_assoc($roomsResult)) {
        $roomFeatures = [
            $room['Price'],
            $room['rating'],
            $room['noise_level(dB)'],
            $room['room_temp(C)'],
            $room['light_intensity(Lumens)'],
            $room['wifi_speed(Mbps)'],
            $room['room_size(sq_feet)'],
        ];

        // Calculate cosine similarity
        $similarity = cosineSimilarity($userSelectedRoomFeatures, $roomFeatures);

        // Add room to recommended list with similarity score
        $recommendedRooms[] = [
            'room_id' => $room['room_id'],
            'room_name' => $room['Name'],
            'similarity' => $similarity,
        ];
    }

    // Shuffle recommended rooms array to make it random
    shuffle($recommendedRooms);
    ?>
    <div class="container">
        <div class="row">
            <?php
            // Display top 3 recommended rooms
            $topRecommendedRooms = array_slice($recommendedRooms, 0, 3);

            // Iterate through top recommended rooms
            foreach ($topRecommendedRooms as $recommendedRoom) {
                // Retrieve room details
                $room_id = $recommendedRoom['room_id'];
                $room_name = $recommendedRoom['room_name'];

                // Query to get details of the recommended room
                $recommendedRoomQuery = "SELECT * FROM rooms WHERE room_id = $room_id";
                $recommendedRoomResult = mysqli_query($con, $recommendedRoomQuery);

                if ($recommendedRoomResult && mysqli_num_rows($recommendedRoomResult) > 0) {
                    $row = mysqli_fetch_assoc($recommendedRoomResult);

                    // Extract data for each recommended room
                    $price_per_night = $row['Price'];
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
                    echo '<img src="../uploads/rooms/' . $room_image . '" class="card-img-top" style="height: 150px; object-fit: cover;">';
                    echo '<div class="card-body d-flex flex-column">';
                    echo '<h5 class="card-title">' . $room_name . '</h5>';
                    echo '<h6 class="mb-4">रु ' . $price_per_night . ' per night</h6>';
                    
                    // Facilities
                    echo '<div class="facilities mb-4">';
                    echo '<h6 class="mb-1">Facilities</h6>';
                    foreach ($facilitiesArray as $facilityTitle) {
                        echo '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $facilityTitle . '</span>';
                    }
                    echo '</div>';
                    
                    // Features
                    echo '<div class="features mb-4">';
                    echo '<h6 class="mb-1">Features</h6>';
                    foreach ($featuresArray as $featureTitle) {
                        echo '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $featureTitle . '</span>';
                    }
                    echo '</div>';

                    // Guests
                    echo '<div class="guests mb-4">';
                    echo '<h6 class="mb-1">Guests</h6>';
                    echo '<span class="badge rounded-pill bg-light text-dark text-wrap mb-3">' . $adult . ' Adults</span>';
                    echo '<span class="badge rounded-pill bg-light text-dark text-wrap mb-3">' . $child . ' Children</span>';
                    
                    // ... display other room details here
                    echo '<div class="mt-auto">';
                    echo '<a href="viewmore.php?room_id=' . $row['room_id'] . '" class="btn btn-sm btn-outline-dark shadow-none">Book Now</a>';
                    echo '<span style="margin-right: 10px;"></span>';
                    echo '<a href="viewmore.php?room_id=' . $row['room_id'] . '" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>';
                    echo "<p class='card-text'>Similarity: {$recommendedRoom['similarity']}</p>";
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
    <!-- End of Recommendation Section -->

    <!-- Footer Section -->
    <?php include('../inc/footer.php'); ?>
    <!-- End of Footer Section -->

    
</body>

</html>
