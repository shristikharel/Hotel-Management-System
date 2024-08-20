<?php
include('../admin/config.php');
include_once('../functions/common_function.php');

// Insert Facility
if (isset($_POST['insert_facility'])) {
    $user_id = get_user_id_admin();
    $facility_title = $_POST['fac_title'];
    $facility_about = $_POST['about_facility'];

    // File Upload
    $image = $_FILES['fac_image']['name'];
    $target_dir = "../uploads/facilities/";

    move_uploaded_file($_FILES['fac_image']['tmp_name'], $target_dir . $image);

    // Select data from Database
    $select_query = "SELECT * FROM `facilities`";
    $result_select = mysqli_query($con, $select_query);

    // Check if facility already exists
    $facility_exists = false;
    while ($row = mysqli_fetch_assoc($result_select)) {
        if ($row["facility_title"] == $facility_title) {
            $facility_exists = true;
            echo "<script>alert('Facility already exists!')</script>";
            break;
        }
    }

    if (!$facility_exists) {
        // Insert facility into the database
        $insert_query = "INSERT INTO `facilities` (`user_id`, `facility_title`, `about_facility`, `facility_image`) VALUES ('$user_id', '$facility_title', '$facility_about', '$image')";
        $result = mysqli_query($con, $insert_query);

        if ($result) {
            echo "<script>alert('Facility has been inserted successfully')</script>";
            echo "<script>window.open('./admin.php?view_facilities', '_self')</script>";
        } else {
            echo "<script>alert('Error inserting facility: " . mysqli_error($con) . "')</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shristi - FACILITIES</title>
    <style>
        .img{
            object-fit: contain;
            height: 100px;
            width: 100px;
        }
        .pop:hover {
            border-top-color: var(--teal) !important;
            transform: scale(1.03);
            transition: 0.3s;
        }
    </style>
</head>

<body class="bg-light">

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center"><i class="bi bi-arrow-down-circle-fill"></i> Insert Facility</h2>
        <div class="h-line bg-dark"></div>
    </div>

    <!-- Insert Facility Form -->
    <form action="" method="post" class="mb-2" enctype="multipart/form-data">
        <div class="input-group w-90 mb-2">
            <span class="input-group-text bg-dark text-white" id="basic-addon1"><i class="bi bi-receipt"></i></span>
            <input type="text" class="form-control" name="fac_title" placeholder="Insert Facility Title" aria-label="facilities" aria-describedby="basic-addon1" required="required">
        </div>
        <div class="input-group w-90 mb-2">
            <span class="input-group-text bg-dark text-white" id="basic-addon1"><i class="bi bi-receipt"></i></span>
            <input type="text" class="form-control" name="about_facility" placeholder="Insert Facility Description" aria-label="facilities" aria-describedby="basic-addon1" required="required">
        </div>
        <div class="input-group w-90 mb-2">
            <input type="file" class="form-control" name="fac_image" accept="image/*" class="img" required="required">
        </div>
        <div class="input-group w-10 mb-2 m-auto">
            <input type="submit" class="bg-dark text-white border-0 p-2 my-3" name="insert_facility" value="Insert Facilities">
        </div>
    </form>

    <!-- Display Facilities Table -->
    <div class="container">
        <h3 class="text-center py-4 text-dark fs-4 fw-bold text-uppercase border-bottom"><i class="bi bi-house-gear-fill fa-2x"></i> Available Facilities</h3>
        <table class="table table-bordered border-dark mt-5">
            <thead class="bg-dark text-center text-light">
                <tr>
                    <th>S.No.</th>
                    <th>Facility Provided</th>
                    <th>About Facility</th>
                    <th>Image</th>
                    <th colspan="2">Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $user_id = get_user_id_staff();
                $pic = "SELECT * FROM `facilities`";
                $result_select = mysqli_query($con, $pic);

                if ($result_select) {
                    if (mysqli_num_rows($result_select) > 0) {
                        $number = 0;

                        while ($row = mysqli_fetch_array($result_select)) {
                            $facility_id = $row['facility_id'];
                            $facility_title = $row['facility_title'];
                            $facility_about = $row['about_facility'];
                            $facility_image = $row['facility_image'];
                            $number++;
                            echo "<tr class='text-center'>
                                    <td>$number</td>
                                    <td>$facility_title</td>
                                    <td>$facility_about</td>
                                    <td><img src='../uploads/facilities/$facility_image' class='img'></td>
                                    <td><a href='admin.php?edit_facility=$facility_id' class='text-dark'><i class='fas fa-edit text-dark'></i></td>
                                    <td><a href='admin.php?delete_facility=$facility_id' class='text-dark'><i class='fas fa-trash'></i></a></td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No Facilities Added :(</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
