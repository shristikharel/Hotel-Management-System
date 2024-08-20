<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS</title>
    <?php require('inc/links.php') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <style>
    .availability-form{
margin-top: -50px;
z-index: 2;
position: relative;
}
 /* Default styles */
 .custom-btn {
    color: black;
    text-decoration: none;
  }

  /* Styles for hover effect */
  .custom-btn:hover {
    background-color: black;
    color: white;
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

<?php require('inc/header.php') ?>

<!-- Carousel -->
<div class="container-fluid px-lg-4 mt-4">
<div class="swiper swiper-container">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <img src="images/carousel/1.png" class="w-100 d-block">
      </div>
      <div class="swiper-slide">
        <img src="images/carousel/2.png" class="w-100 d-block">
      </div>
      <div class="swiper-slide">
        <img src="images/carousel/3.png" class="w-100 d-block">
      </div>
      <div class="swiper-slide">
        <img src="images/carousel/4.png" class="w-100 d-block">
      </div>
      <div class="swiper-slide">
        <img src="images/carousel/5.png" class="w-100 d-block">
      </div>
      <div class="swiper-slide">
        <img src="images/carousel/6.png" class="w-100 d-block">
      </div>  
    </div>
  </div>
</div>
<!-- Check Booking Availability -->
<div class="container availability-form">
    <div class="row bg-white shadow p-2 rounded mx-auto d-flex align-items-center text-center">
        <marquee><h3 class="h-font">Hotel Management System!</h3></marquee>
    </div>
</div>

<!-- Rooms -->
<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR ROOMS</h2>
<div class="container">
    <div class="row">
        <?php
        // Include your database configuration file and common functions
        include('config.php');

        // Select data from the 'rooms' table
        $select_query = "SELECT * FROM `rooms` LIMIT 3";
        $result_select = mysqli_query($con, $select_query);

        if ($result_select) {
            while ($row = mysqli_fetch_assoc($result_select)) {
                // Extract data for each room
                $room_name = $row['Name'];
                $price_per_night = $row['Price'];
                $room_image = $row['Image'];
                $adult = $row['Adults'];
                $child = $row['Children'];
                $facility = $row['Facilities'];
                $feature = $row['Features'];
                // ... extract other room details as needed

                // Explode facility and feature strings into arrays
                $facilitiesArray = explode(",", $facility);
                $featuresArray = explode(",", $feature);

                // HTML for each room card
                echo '<div class="col-lg-4 col-md-6 my-3">';
                echo '<div class="card h-100 border-0 shadow" style="max-width: 350px; margin: auto;">';
                echo '<img src="uploads/rooms/' . $room_image . '" class="card-img-top" style="height: 150px; object-fit: cover;">';
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
                // Retrieve room_id from the current row
                $room_id = $row['room_id'];
                // <!-- Rating Section -->
                echo'<div class="rating mb-4">';
                echo'<h6 class="mb-1">Rating</h6>';
  
    // Query to retrieve ratings for the current room
    $rating_query = "SELECT AVG(starrating) AS average_rating FROM rating WHERE room_id = $room_id";
    $rating_result = mysqli_query($con, $rating_query);

    if ($rating_result && mysqli_num_rows($rating_result) > 0) {
        $row = mysqli_fetch_assoc($rating_result);
        $average_rating = $row['average_rating'];

        // Display star icons based on the average rating
        $full_stars = floor($average_rating);
        $half_star = ceil($average_rating - $full_stars);
        
        // Display full stars
        for ($i = 0; $i < $full_stars; $i++) {
            echo '<i class="bi bi-star-fill text-warning mb-2"></i>';
        }
        
        // Display half star if needed
        if ($half_star > 0) {
            echo '<i class="bi bi-star-half text-warning mb-2"></i>';
        }
    } else {
        // Display a message when no ratings are available
        echo 'No ratings yet';
    }
                // ... display other room details here
                echo '<div class="mt-auto">';
                echo '<a href="viewmore.php" class="btn btn-sm text-white custom-bg shadow-none">Book Now</a>';
                echo '<span style="margin-right: 10px;"></span>';
                echo '<a href="viewmore.php" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            // Handle the case when there is an error fetching data
            echo '<div class="col-12 text-center"><p>No rooms available at the moment.</p></div>';
        }

        // Close the database connection
        mysqli_close($con);
        ?>
        <div class="col-lg-12 text-center mt-5">
      <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms >>> </a>
    </div>
    </div>
</div>


<!-- Facilities -->
<h3 class="my-5 fw-bold h-font text-center">Facilities</h3>
<div class="container px-4">
    <style>
        /* Custom styles for management team cards */
        .swiper-slide {
            height: 400px; /* Set a fixed height for the card */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center; /* Center-align the text */
        }

        .swiper-slide img {
            max-height: 80%; /* Adjusted the height of the image to leave space for the text */
            max-width: 100%; /* Make the image fill the card horizontally */
            object-fit: cover; /* Maintain aspect ratio while covering the card */
            margin-bottom: 15px; /* Add some space between the image and the text */
        }
    </style>

    <div class="swiper mySwiper">
        <div class="swiper-wrapper mb-4">
            <?php
            // Include your database configuration file
            include('config.php');

            // Fetch facilities from the user_table
            $facQuery = "SELECT facility_title, facility_image FROM facilities";
            $facResult = mysqli_query($con, $facQuery);

            // Check if there are facilities
            if ($facResult && mysqli_num_rows($facResult) > 0) {
                while ($row = mysqli_fetch_assoc($facResult)) {
                    $name = $row['facility_title'];
                    $image = $row['facility_image']; // Adjust the path
                    ?>
                    <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                    <img src="uploads/facilities/<?php echo $image; ?>" class="w-100" alt="<?php echo $name; ?>">                        <h5 class="mt-2"><?php echo $name; ?></h5>
                    </div>
                    <?php
                }
            } else {
                // Handle the case when no facilities are found
                echo '<div class="swiper-slide bg-white text-center overflow-hidden rounded">No facilities available.</div>';
            }

            // Close the database connection
            mysqli_close($con);
            ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="col-lg-12 text-center mt-5">
      <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Facilities >>> </a>
    </div>
    </div>
</div>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 4,
    spaceBetween: 40,
    pagination: {
      el: ".swiper-pagination",
    },
    breakpoints: {
        320: {
          slidesPerView: 1, 
        },
        640: {
          slidesPerView: 1, 
        },
        768: {
          slidesPerView: 3, 
        },
        1024: {
          slidesPerView: 3, 
        },
      }
  });
</script>


<!-- Reach Us -->
<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">REACH US</h2>
<div class="container">
  <div class="row">
    <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
    <iframe class="w-100 rounded" height="320px"  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.0010898905243!2d85.32137247524038!3d27.71725262505495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19377c2c6743%3A0x971897caf9b0bb96!2sSifal!5e0!3m2!1sen!2snp!4v1695431095158!5m2!1sen!2snp" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="bg-white p-4 rounded mb-4">
          <h5>Call Us</h5>
          <a href="tel: +9779869031332" class="d-inline-block mb-2 text-decoration-none text-dark">
          <i class="bi bi-telephone-fill"></i> +9779869031332</a>
          <br>
          <a href="tel: +9779869031332" class="d-inline-block text-decoration-none text-dark">
          <i class="bi bi-telephone-fill"></i> +9779869031332</a>
        </div>

<!-- next -->
<div class="bg-white p-4 rounded mb-4">
          <h5>Follow Us</h5>
          <a href="#" class="d-inline-block mb-3">
          <span class="badge bg-light text-dark fs-6 p-2">
          <i class="bi bi-twitter-x me-1"></i> Twitter
          </span>
          </a>
          <br>
          <a href="#" class="d-inline-block mb-3">
          <span class="badge bg-light text-dark fs-6 p-2">
          <i class="bi bi-meta"></i> Facebook
          </span>
          </a>
          <br>
          <a href="https://www.instagram.com/instagram/" class="d-inline-block">
          <span class="badge bg-light text-dark fs-6 p-2">
          <i class="bi bi-instagram"></i> Instagram
          </span>
          </a>
        </div>


<!-- next -->

    </div>
  </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
 <!-- Initialize Swiper -->
 <script>
    var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      loop: true,
      autoplay: {
        delay:3500,
        disableOnInteraction:false,
      }
    });

    var swiper = new Swiper(".swiper-testimonials", {
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: "auto",
      slidesPerView:"3",
      loop: true,
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: false,
      },
      pagination: {
        el: ".swiper-pagination",
      },
      breakpoints: {
        320: {
          slidesPerView: 1, 
        },
        640: {
          slidesPerView: 1, 
        },
        768: {
          slidesPerView: 2, 
        },
        1024: {
          slidesPerView: 3, 
        },
      }
    });

  </script>
</body>
<!-- footer -->
<?php require('inc/footer.php') ?>
</html>