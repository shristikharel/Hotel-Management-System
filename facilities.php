<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shristi - FACILITIES</title>
    <?php require('inc/links.php') ?>
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
    </style>
</head>
<body class="bg-light">
    <!-- header -->
    <?php require('inc/header.php') ?>

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
            // Include your database configuration file
            include('config.php');

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
                                <img src="uploads/facilities/<?php echo $facilityImage; ?>" class="img-fluid rounded" alt="<?php echo $facilityTitle; ?>">
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
<?php require('inc/footer.php') ?>
</body>
</html>
