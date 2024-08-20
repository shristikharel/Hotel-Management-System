<?php
include('config.php');
include_once('../functions/common_function.php');

if (isset($_POST['insert_category'])) {
    $user_id = get_user_id_admin();
    $category_name = $_POST['category_name'];

    // Select data from Database
    $select_query = "SELECT * FROM `categories`";
    $result_select = mysqli_query($con, $select_query);

    // Check if category already exists
    $category_exists = false;
    while ($row = mysqli_fetch_assoc($result_select)) {
        if ($row["name"] == $category_name) {
            $category_exists = true;
            echo "<script>alert('Category already exists!')</script>";
            break;
        }
    }

    if (!$category_exists) {
        // Insert category into the database
        $insert_query = "INSERT INTO `categories` (`user_id`, `name`) VALUES ('$user_id', '$category_name')";
        $result = mysqli_query($con, $insert_query);

        if ($result) {
            echo "<script>alert('Category has been inserted successfully')</script>";
            echo "<script>window.open('admin.php?insert_category', '_self')</script>";
        } else {
            echo "<script>alert('Error inserting category: " . mysqli_error($con) . "')</script>";
        }
    }
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<h2 class="text-center"><i class="bi bi-arrow-down-circle-fill"></i> Insert Category</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-dark text-white" id="basic-addon1"><i class="bi bi-receipt"></i></span>
        <input type="text" class="form-control" name="category_name" placeholder="Insert Category" aria-label="categories" aria-describedby="basic-addon1" required="required">
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="bg-dark text-white border-0 p-2 my-3" name="insert_category" value="Insert Category">
    </div>
</form>

<h3 class="text-center py-4 text-dark fs-4 fw-bold text-uppercase border-bottom"><i class="bi bi-house-gear-fill fa-2x"></i> Available Categories</h3>
<table class="table table-bordered border-dark mt-5">
    <thead class="bg-dark text-center text-light">
        <tr>
            <th>S.No.</th>
            <th>Category Name</th>
            <th colspan="2">Operations</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $select_categories = "SELECT * FROM `categories`";
        $result_categories = mysqli_query($con, $select_categories);

        if ($result_categories) {
            if (mysqli_num_rows($result_categories) > 0) {
                $number = 0;

                while ($row = mysqli_fetch_array($result_categories)) {
                    $category_id = $row['id'];
                    $category_name = $row['name'];
                    $number++;
                    echo "<tr class='text-center'>
                    <td>$number</td>
                    <td>$category_name</td>
                    <td><a href='admin.php?edit_category=$category_id' class='text-dark'><i class='fas fa-edit text-dark'></i></td>
                    <td><a href='admin.php?delete_category=$category_id' class='text-dark'><i class='fas fa-trash'></i></a></td>
                    </tr>";
                }
            } else {
                echo "No Categories Added :(";
            }
        }
        ?>
    </tbody>
</table>
