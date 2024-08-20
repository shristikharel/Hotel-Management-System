<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shristi -ABOUT</title>
    <?php require('inc/links.php') ?>
    <?php require('config.php') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <style>
        .box:hover{
            border-top-color: var(--teal) !important;
        }
    </style>
</head>
<body class="bg-light">
<!-- header -->
<?php require('inc/header.php') ?>
 <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">ABOUT US</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">
    Empowering seamless hospitality experiences,
     our hotel management system orchestrates efficient operations,
     elevating guest services and ensuring a memorable stay.
    </p>   
 </div>

 <div class="container">
    <div class="row justify-content-between align-items-center">
        <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
            <h3 class="mb-3">Hotel Managemet System (HMS)</h3>
            <p>
            Revolutionizing hospitality, our hotel management system seamlessly integrates operations, ensuring precision and guest satisfaction. From streamlined bookings to personalized recommendations, we elevate the guest experience, making every stay unforgettable. Trust us to redefine the art of hospitality management.
            </p>
        </div>
        <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
            <img src="images/rooms/1.jpg" class="w-100">
        </div>
    </div>
 </div>
    </div>
 </div>
 
 <div class="container mt-5">
    <div class="row">
      <?php
    // Count the number of rooms
            $roomCountQuery = "SELECT COUNT(*) as room_count FROM rooms";
            $roomCountResult = mysqli_query($con, $roomCountQuery);
            $roomCount = 0;

            if ($roomCountResult && mysqli_num_rows($roomCountResult) > 0) {
                $roomCountRow = mysqli_fetch_assoc($roomCountResult);
                $roomCount = $roomCountRow['room_count'];
            }
            ?>
        <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/hotel.svg" width="70px">
                <h4 class ="mt-3"><?php echo $roomCount; ?>+ ROOMS</h4>
            </div>
        </div>
        <!-- 1 -->
        <?php
        $customerCountQuery = "SELECT COUNT(*) as customer_count FROM user_table WHERE user_type = 'customer'";
        $customerCountResult = mysqli_query($con, $customerCountQuery);
        $customerCount = 0;
        
        if ($customerCountResult && mysqli_num_rows($customerCountResult) > 0) {
            $customerCountRow = mysqli_fetch_assoc($customerCountResult);
            $customerCount = $customerCountRow['customer_count'];
        }
        ?>
        <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/customers.svg" width="70px">
                <h4 class ="mt-3"><?php echo $customerCount; ?>+ CUSTOMERS</h4>
            </div>
        </div>
        <!-- 2 -->
        <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/rating.svg" width="70px">
                <h4 class ="mt-3">150+ REVIEWS</h4>
            </div>
        </div>
        <!-- 3 -->
        <?php
        $staffCountQuery = "SELECT COUNT(*) as staff_count FROM user_table WHERE user_type = 'staff'";
        $staffCountResult = mysqli_query($con, $staffCountQuery);
        $staffCount = 0;
        
        if ($staffCountResult && mysqli_num_rows($staffCountResult) > 0) {
            $staffCountRow = mysqli_fetch_assoc($staffCountResult);
            $staffCount = $staffCountRow['staff_count'];
        }
        ?>
        <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/staff.svg" width="70px">
                <h4 class ="mt-3"><?php echo $staffCount; ?>+ STAFFS</h4>
            </div>
        </div>
        <!-- 4 -->
    </div>
 </div>



<!-- footer -->
<?php require('inc/footer.php') ?>

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


</body>
</html>