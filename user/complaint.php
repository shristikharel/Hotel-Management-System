<?php
include('../admin/config.php');
include('../functions/common_function.php');
include('../inc/links.php');

// Get user ID from session
$user_id = get_user_id_fromsession();

// Ensure that room_id is set and is a valid integer
if (isset($_GET['room_id']) && is_numeric($_GET['room_id'])) {
    $room_id = $_GET['room_id'];

    // Query to retrieve information about the specific room
    $query = "SELECT rooms.room_id, booking_id, Name, Image, checkindate, checkoutdate, price, status,
              DATEDIFF(checkoutdate, checkindate) * price * 0.0075 as room_price
              FROM `book_details`, `rooms` 
              WHERE book_details.room_id=rooms.room_id AND book_details.user_id=$user_id AND book_details.room_id=$room_id";

    $result = mysqli_query($con, $query);

    // Check if the query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $room_title = $row['Name'];
        $renting_price = $row['room_price'];
    } else {
        // Handle the case where the room with the specified room_id was not found
        echo "Room not found";
        exit(); // Stop execution if the room is not found
    }
} else {
    // Debugging: Output the value of $_GET['room_id'] for testing
    echo "Invalid room ID: " . $_GET['room_id'] . "<br>";

    // Handle the case where room_id is not set or is not a valid integer
    echo "Invalid room ID";
    exit(); // Stop execution if room_id is not valid
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Review</title>

    <style>
        .bttn {
            background-color: #3CB371;
            color: white;
            padding: 10px;
            border: none;
            outline: none;
            border-radius: 10px;
            margin-top: 10px;
        }

        .img {
            object-fit: contain;
            height: 500px;
            width: 500px;
        }

        .room-title {
            margin-top: -80px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        .custom-btn {
    color: black;
    text-decoration: none;
  }

  /* Styles for hover effect */
  .custom-btn:hover {
    background-color: black;
    color: white;
  }
    </style>
</head>

<body>

    <!-- Header Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><strong> WELCOME </strong><?php echo $_SESSION['cust_name'] ?></a>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active me-2" aria-current="page" href="index.php">Home</a>
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

    <!-- End of Navbar -->
    <div class="container mt-5">
        <h2 class="fw-bold h-font text-center">Submit a Complaint</h2>
        <p class="text-center text-muted">We apologize that our services did not meet your expectations. Please share your feedback below, and we'll work to improve.</p>

        <div class="row">
            <!-- Image and Room Title -->
            <div class="col-md-6">
                <div class="img-box">
                    <img src="../uploads/rooms/<?php echo $row['Image'] ?>" class="img">
                    <div class="room-title"><?php echo $row['Name']; ?></div>
                </div>
            </div>
            <?php
            if (isset($_POST['submit'])) {
                $room_id = $_POST['room_id'];
                $user_id = get_user_id_fromsession();
                $email = user_email();
                $complainant_name = mysqli_real_escape_string($con, $_POST['c_name']);
                $complaint_type = mysqli_real_escape_string($con, $_POST['c_type']);
                $complaint = mysqli_real_escape_string($con, $_POST['complaint']);
            
                // Insert data into the complaints table
                $insertQuery = "INSERT INTO `complaints` (`room_id`, `user_id`, `email`, `complainant_name`, `complaint_type`, `complaint`, `created_at`) 
                                VALUES ('$room_id', '$user_id', '$email', '$complainant_name', '$complaint_type', '$complaint', NOW())";
            
                $insertResult = mysqli_query($con, $insertQuery);
            
                if ($insertResult) {
                    echo "<script>alert('Complaint submitted successfully');</script>";

                } else {
                    echo "Error submitting complaint: " . mysqli_error($con);
                }
            }
            
                ?>
            <!-- Complaint Form -->
            <div class="col-md-6">
                <div class="review-box">
                    <form autocomplete="off" action="complaint.php?room_id=<?php echo $room_id; ?>" method="POST">
                        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
                        <div class="fw-bold mt-3 px-2">
                            <label class="form-label">Complainant Name *</label><br>
                            <input type="text" name="c_name" class="form-control" required="required" autocomplete="off">
                        </div>
                        
                        <div class="fw-bold mt-3 px-2">
                            <label class="form-label">Complaint Type *</label><br>
                            <input type="text" name="c_type" class="form-control" required="required" autocomplete="off">
                        </div>

                        
                        <div class="fw-bold mt-3 px-2">
                            <label for="rating" class="form-label">Complaint *</label>
                            <input type="text" name="complaint" class="form-control" required="required" autocomplete="off">
                        </div>

                        <input type="submit" value="Submit Complaint" name="submit" class="bttn" style="background-color: #FF0000;">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php require('../inc/footer.php') ?>
</body>

</html>
