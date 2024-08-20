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

    <div class="container"> 
        <div class="row">
            <!-- Image and Room Title -->
            <div class="col-md-6">
                <div class="img-box">
                    <img src="../uploads/rooms/<?php echo $row['Image'] ?>" class="img">
                    <div class="room-title"><?php echo $row['Name']; ?></div>
                </div>
            </div>
            <!-- Review Form -->
            <!-- Review and Rating Entry -->
            <?php
            if (isset($_POST['submit'])) {
    
                $room_id = $_POST['room_id'];
                $user_id = get_user_id_fromsession();
                $email = user_email();
                $review_title = $_POST['r_name'];
                $star_rating = $_POST['rating'];
                // Map string ratings to corresponding integer values
$rating_map = [
    'one' => 1,
    'two' => 2,
    'three' => 3,
    'four' => 4,
    'five' => 5,
];

// Check if the submitted rating exists in the mapping
if (isset($rating_map[$star_rating])) {
    $star_rating = $rating_map[$star_rating];
} else {
    // Default to a specific value or handle the case as appropriate
    $star_rating = 1;
}

                $insert_query = "INSERT INTO rating (room_id, user_id, email, review_title, starrating) 
                                 VALUES ('$room_id', '$user_id', '$email', '$review_title', '$star_rating')";
                $insert_result = mysqli_query($con, $insert_query);
                
                if ($insert_result) {
                    // Submission successful
                    echo "<script>alert('Submission successful!'); window.location.href = 'rooms.php';</script>";
                    exit;
                } else {
                    // Submission failed
                    echo "<script>alert('Submission failed: " . mysqli_error($con) . "');</script>";
                }
            }
            ?>
            <div class="col-md-6">
                <div class="review-box">
                    <form autocomplete="off" action="review.php?room_id=<?php echo $room_id; ?>" method="POST">
                        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
                        <div class="fw-bold mt-3 px-2">
                            <label class="form-label">Review Title *</label><br>
                            <input type="text" name="r_name" class="form-control" required="required" autocomplete="off">
                        </div>

                        <!-- Star Rating -->
                        <div class="fw-bold mt-3 px-2">
                            <label for="rating" class="form-label">Review Rating *</label>
                            <select name="rating" id="rating" class="form-select">
                                <option value="one">One</option>
                                <option value="two">Two</option>
                                <option value="three">Three</option>
                                <option value="four">Four</option>
                                <option value="five">Five</option>
                            </select>
                        </div>

                        <input type="submit" value="Submit Review" name="submit" class="bttn">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require('../inc/footer.php') ?>

    <!-- Add your script tags or other scripts here -->
</body>

</html>
