<?php
include_once('../functions/common_function.php');
include('../admin/config.php');
if (isset($_POST['upload'])) {
    $user_id =  get_user_id_admin();
    $category = $_POST['category'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $keywords = $_POST['keywords'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $price = $_POST['price'];
    $rate = $_POST['rating'];
    $noise = $_POST['noise'];
    $temp = $_POST['temp'];
    $intensity = $_POST['intensity'];
    $wifi = $_POST['wifi'];
    $size = $_POST['size'];

    // Fetch the category name based on the selected category_id
$categoryQuery = "SELECT name FROM categories WHERE id = '$category'";
$categoryResult = mysqli_query($con, $categoryQuery);

if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
    $categoryRow = mysqli_fetch_assoc($categoryResult);
    $categoryName = $categoryRow['name'];

    // Process Facilities and Features
    $facilities = isset($_POST['facilities']) ? $_POST['facilities'] : array();
    $features = isset($_POST['features']) ? $_POST['features'] : array();

    // Convert array to comma-separated string
    $facilitiesStr = implode(",", $facilities);
    $featuresStr = implode(",", $features);

    // File Upload
    $image = $_FILES['image']['name'];
    $image2 = $_FILES['picture']['name'];
    $image3 = $_FILES['photo']['name'];
    $image4 = $_FILES['pic']['name'];

    // Move uploaded files to a specific directory
    $target_dir = "../uploads/rooms/";

    move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);
    move_uploaded_file($_FILES['picture']['tmp_name'], $target_dir . $image2);
    move_uploaded_file($_FILES['photo']['tmp_name'], $target_dir . $image3);
    move_uploaded_file($_FILES['pic']['tmp_name'], $target_dir . $image4);

    // Fetch facility and feature titles
    $facilitiesTitles = array();
    $featuresTitles = array();

    foreach ($facilities as $facilityId) {
        $selectFacility = "SELECT `facility_title` FROM `facilities` WHERE `facility_id` = $facilityId";
        $resultFacility = mysqli_query($con, $selectFacility);
        $rowFacility = mysqli_fetch_assoc($resultFacility);
        $facilitiesTitles[] = $rowFacility['facility_title'];
    }

    foreach ($features as $featureId) {
        $selectFeature = "SELECT `feature_title` FROM `features` WHERE `feature_id` = $featureId";
        $resultFeature = mysqli_query($con, $selectFeature);
        $rowFeature = mysqli_fetch_assoc($resultFeature);
        $featuresTitles[] = $rowFeature['feature_title'];
    }

    // Convert array to comma-separated string
    $facilitiesTitlesStr = implode(",", $facilitiesTitles);
    $featuresTitlesStr = implode(",", $featuresTitles);

    // SQL Insert Query
    $insert_query = "INSERT INTO `rooms` 
    (`user_id`, `Category`, `Name`, `Description`, `Keywords`, `Facilities`, `Features`, `Adults`, `Children`, `Image`, `Image2`, `Image3`, `Image4`, `Price`, `rating`, `noise_level(dB)`, `room_temp(C)`, `light_intensity(Lumens)`, `wifi_speed(Mbps)`, `room_size(sq_feet)`) 
    VALUES 
    ('$user_id', '$categoryName', '$name', '$description', '$keywords', '$facilitiesTitlesStr', '$featuresTitlesStr', '$adults', '$children', '$image', '$image2', '$image3', '$image4', '$price', '$rate', '$noise', '$temp', '$intensity', '$wifi', '$size')";

    $result = mysqli_query($con, $insert_query);

    if ($result) {
        echo "<script>alert('Room has been inserted successfully')</script>";
    } else {
        echo "Error: " . mysqli_error($con); // Print the MySQL error
    }
}
}
?>


<h2 class="text-center py-4  text-dark fs-4 fw-bold text-uppercase border-bottom"><i class="fas fa-user fa-2x"></i> Hello <?php echo $_SESSION['admin_name'] ?>!</h2>    

<h1 class="text-center py-4 text-dark fs-4 fw-bold text-uppercase border-bottom"><i class="bi bi-house-add-fill fa-2x"></i>  Add a Room! </h1>

<form action="" method="POST" enctype="multipart/form-data">
            <!-- Room Category -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="category" class="form-label fw-bold">Room Category</label>
                <select name="category" class="form-select" required="required">
                    <option value="">Select a Category</option> 
                    <?php
                                $select_query="Select * from `categories`";
                                $result_select=mysqli_query($con,$select_query);   
                              if(mysqli_num_rows($result_select) > 0)
                              {
                                 while($row = mysqli_fetch_assoc($result_select)){
                                    echo "<option value='".$row['id']."'>".$row['name']."</option>";
                              }
                            }                           
                    ?>
                </select>           
            </div>
            <!-- Room Name -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="name" class="form-label fw-bold">Room Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Room Name" autocomplete="off" required="required">
            </div>
            <!-- Description -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="description" class="form-label fw-bold">Room Description</label>
                <input type="text" name="description" class="form-control" placeholder="Enter Room Description" autocomplete="off" required="required">
            </div>
            <!-- Keyword -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="keywords" class="form-label fw-bold">Room Keywords</label>
                <input type="text" name="keywords" class="form-control" placeholder="Enter Room Keywords" autocomplete="off" required="required">
            </div>
<!-- Facilities -->
<div class="form-outline mb-4 w-50 m-auto">
    <label for="facility" class="form-label fw-bold">Room Facilities</label>
    <?php
        $select_query = "SELECT * FROM `facilities`";
        $result_select = mysqli_query($con, $select_query);
        if (mysqli_num_rows($result_select) > 0) {
            while ($row = mysqli_fetch_assoc($result_select)) {
                echo "<div class='form-check'>";
                echo "<input class='form-check-input' type='checkbox' name='facilities[]' value='".$row['facility_id']."'>";
                echo "<label class='form-check-label'>".$row['facility_title']."</label>";
                echo "</div>";
            }
        }
    ?>
</div>

<!-- Features -->
<div class="form-outline mb-4 w-50 m-auto">
    <label for="feature" class="form-label fw-bold">Room Features</label>
    <?php
        $select_query = "SELECT * FROM `features`";
        $result_select = mysqli_query($con, $select_query);
        if (mysqli_num_rows($result_select) > 0) {
            while ($row = mysqli_fetch_assoc($result_select)) {
                echo "<div class='form-check'>";
                echo "<input class='form-check-input' type='checkbox' name='features[]' value='".$row['feature_id']."'>";
                echo "<label class='form-check-label'>".$row['feature_title']."</label>";
                echo "</div>";
            }
        }
    ?>
</div>


            <!-- Guests -->

            <!-- Adults -->
    <div class="form-outline mb-4 w-50 m-auto">
        <label for="adults" class="form-label fw-bold">Adults</label>
        <select name="adults" class="form-select" required="required">
            <option value="">Select Number of Adults</option>
            <?php
            // Loop to generate options for adults
            for ($i = 1; $i <= 10; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
        </select>
    </div>

    <!-- Children -->
    <div class="form-outline mb-4 w-50 m-auto">
        <label for="children" class="form-label fw-bold">Children</label>
        <select name="children" class="form-select" required="required">
            <option value="">Select Number of Children</option>
            <?php
            // Loop to generate options for children
            for ($i = 0; $i <= 10; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
        </select>
    </div>



            <!-- Image 1 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="image" class="form-label fw-bold">Room Image 1</label>
                <input type="file" name="image" class="form-control" required="required">
            </div>
            <!-- Image 2 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="picture" class="form-label fw-bold">Room Image 2</label>
                <input type="file" name="picture" class="form-control">
            </div>
             <!-- Image 3 -->
             <div class="form-outline mb-4 w-50 m-auto">
                <label for="photo" class="form-label fw-bold">Room Image 3</label>
                <input type="file" name="photo" class="form-control">
            </div>
            <!-- Image 4 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="pic" class="form-label fw-bold">Room Image 4</label>
                <input type="file" name="pic" class="form-control">
            </div>
             <!-- <div class="form-outline mb-4 w-50 m-auto">
                <label for="picimg" class="form-label fw-bold">Room Image 4</label>
                <input type="file" name="picimg" class="form-control">
            </div> -->

            

            
            <!-- Price -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="price" class="form-label fw-bold">Room Booking Price Per Day</label>
                <input type="text" name="price" class="form-control" placeholder="Enter Room Booking Price Per Day" autocomplete="off" required="required">
            </div>

            <!-- Rating -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="rating" class="form-label fw-bold">In-room Amenities Count</label>
                <input type="text" name="rating" class="form-control" placeholder="In-room Amenities Count" autocomplete="off" required="required">
            </div>

            <!-- Noise Level -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="noise" class="form-label fw-bold">Noise Level (in dB) </label>
                <input type="text" name="noise" class="form-control" placeholder="Noise Level [in dB]" autocomplete="off" required="required">
            </div>

            <!-- Room Temperature -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="temp" class="form-label fw-bold">Room Temperature (C)</label>
                <input type="text" name="temp" class="form-control" placeholder="Room Temperature" autocomplete="off" required="required">
            </div>

             <!-- Light Intensity  -->
             <div class="form-outline mb-4 w-50 m-auto">
                <label for="intensity" class="form-label fw-bold">Light Intensity (Lumens)</label>
                <input type="text" name="intensity" class="form-control" placeholder="Light Intensity" autocomplete="off" required="required">
            </div>

             <!-- WiFi Speed -->
             <div class="form-outline mb-4 w-50 m-auto">
                <label for="wifi" class="form-label fw-bold">WiFi Speed (Mbps)</label>
                <input type="text" name="wifi" class="form-control" placeholder="Wifi Speed" autocomplete="off" required="required">
            </div>

            <!-- Room Size -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="size" class="form-label fw-bold">Room Size (sq. feet)</label>
                <input type="text" name="size" class="form-control" placeholder="Room Size (sq. feet)" autocomplete="off" required="required">
            </div>
            
            <!-- Insert Room button -->
        <div class="text-center">
            <button name="upload" class="bg-dark text-light border-0 p-2 my-3">Insert Room</button>
        </div>

            <!-- <button name="upload" class="bg-dark text-light border-0 p-2 my-3">Insert Room</button> -->

        </body>
</html>