<?php

require('../admin/config.php');
require('../inc/links.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shristi - FACILITIES</title>
    <style>
        .pop:hover {
            border-top-color: var(--teal) !important;
            transform: scale(1.03);
            transition: 0.3s;
        }

        /* Set a fixed height for the image container */
        .facility-image {
            height: 200px; /* Adjust as needed */
            overflow: hidden;
        }

        /* Ensure images fill the container while maintaining aspect ratio */
        .facility-image img {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
        .custom-btn {
    color: black;
    text-decoration: none;
  }

  /* Styles for hover effect */
  .custom-btn:hover {
    color: white !important;
  }
    </style>
</head>
<body class="bg-light">
    <!-- header -->
    <!-- header -->
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

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Our Facilities</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
        Empowering seamless hospitality experiences, our hotel management system orchestrates efficient operations, elevating guest services and ensuring a memorable stay.
        </p>   
    </div>

    <div class="container">
        <div class="row">
            <?php
            // Fetch facilities from the database
            $facilityQuery = "SELECT facility_title, about_facility, facility_image FROM facilities";
            $facilityResult = mysqli_query($con, $facilityQuery);

            // Check if there are facilities
            if ($facilityResult && mysqli_num_rows($facilityResult) > 0) {
                while ($facilityRow = mysqli_fetch_assoc($facilityResult)) {
                    $facilityTitle = $facilityRow['facility_title'];
                    $aboutFacility = $facilityRow['about_facility'];
                    $facilityImage = $facilityRow['facility_image']; // Adjust the path
                    ?>
                    <div class="col-lg-4 col-md-6 mb-5 px-4">
                        <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                        <div class="facility-image">
                                <img src="../uploads/facilities/<?php echo $facilityImage; ?>" class="img-fluid rounded" alt="<?php echo $facilityTitle; ?>">
                            </div>
                            <h5 class="text-center mb-3 mt-2"><?php echo $facilityTitle; ?></h5>               
                            <p><?php echo $aboutFacility; ?></p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // Handle the case when no facilities are found
                echo '<div class="col-12 text-center"><p>No facilities available at the moment.</p></div>';
            }

            // Close the database connection
            mysqli_close($con);
            ?>
        </div>
    </div>
<!-- footer -->
<?php require('../inc/footer.php') ?>
</body>
</html>
