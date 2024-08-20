<?php
include('../admin/config.php');
include_once('../functions/common_function.php');

if (isset($_POST['insert_feature'])) {
    $user_id = get_user_id_admin();
    $feature_title = $_POST['feat_title'];

    // Select data from Database
    $select_query = "SELECT * FROM `features`";
    $result_select = mysqli_query($con, $select_query);

    // Check if feature already exists
    $feature_exists = false;
    while ($row = mysqli_fetch_assoc($result_select)) {
        if ($row["feature_title"] == $feature_title) {
            $feature_exists = true;
            echo "<script>alert('Feature already exists!')</script>";
            break;
        }
    }

    if (!$feature_exists) {
        // Insert feature into the database
        $insert_query = "INSERT INTO `features` (`user_id`, `feature_title`) VALUES ('$user_id', '$feature_title')";
        $result = mysqli_query($con, $insert_query);

        if ($result) {
            echo "<script>alert('Feature has been inserted successfully')</script>";
            echo "<script>window.open('admin.php?view_features', '_self')</script>";
        } else {
            echo "<script>alert('Error inserting feature: " . mysqli_error($con) . "')</script>";
        }
    }
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<h2 class="text-center"><i class="bi bi-arrow-down-circle-fill"></i> Insert Feature</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-dark text-white" id="basic-addon1"><i class="bi bi-receipt"></i></span>
        <input type="text" class="form-control" name="feat_title" placeholder="Insert Feature" aria-label="features" aria-describedby="basic-addon1" required="required">
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="bg-dark text-white border-0 p-2 my-3" name="insert_feature" value="Insert Features">
    </div>
</form>

<style>
    .img {
        object-fit: contain;
        height: 100px;
        width: 100px;
    }
</style>

<h3 class="text-center py-4 text-dark fs-4 fw-bold text-uppercase border-bottom"><i class="bi bi-house-gear-fill fa-2x"></i> Available Features</h3>
<table class="table table-bordered border-dark mt-5">
    <thead class="bg-dark text-center text-light">
        <tr>
            <th>S.No.</th>
            <th>Features Provided</th>
            <th colspan="2">Operations</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $pic = "SELECT * FROM `features`";
        $result_select = mysqli_query($con, $pic);

        if ($result_select) {
            if (mysqli_num_rows($result_select) > 0) {
                $number = 0;

                while ($row = mysqli_fetch_array($result_select)) {
                    $feature_id = $row['feature_id'];
                    $feature_title = $row['feature_title'];
                    $number++;
                    echo "<tr class='text-center'>
                    <td>$number</td>
                    <td>$feature_title</td>
                    <td><a href='admin.php?edit_features=$feature_id' class='text-dark'><i class='fas fa-edit text-dark'></i></td>
                    <td><a href='admin.php?delete_features=$feature_id' class='text-dark'><i class='fas fa-trash'></i></a></td>
                    </tr>";
                }
            } else {
                echo "No Features Added :(";
            }
        }
        ?>
    </tbody>
</table>
