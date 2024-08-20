<?php
include_once('../admin/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS</title>
    <?php require('../inc/links.php') ?>
    <?php require('../functions/common_function.php') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <style>
    .availability-form{
margin-top: -50px;
z-index: 2;
position: relative;
}

  /* Add custom styles to make the text white */
  .custom-btn {
    color: black !important;
  }
  /* Add styles to make the text white when hovering */
  .custom-btn:hover {
    color: white !important;
  }

@media screen and (max-width: 575px) {
.availability-form{
margin-top: 25px;
padding: 0 35px;
}
}
</style>


</head>
<body class="bg-light">

<style>
 
</style>


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
<div class="container">
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Search Results</h2>
    <div class="row">
        <?php
        if (!isset($_GET["search_data"])) {
            $select_query = "SELECT * FROM `rooms`";
            $result_query = mysqli_query($con, $select_query);

            while ($row = mysqli_fetch_assoc($result_query)) {
                $room_name = $row['Name'];
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

                echo '<div class="mt-auto">';
                echo '<a href="viewmore.php?room_id=' . $room_id . '" class="btn btn-sm btn-outline-dark shadow-none">View More</a>';
                echo '<span style="margin-right: 10px;"></span>';
                echo '<a href="viewmore.php?room_id=' . $room_id . '" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            search_room($con);
        }
        ?>
    </div>
</div>
