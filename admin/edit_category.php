<?php
include('config.php');
include_once('../functions/common_function.php');

$user_id = get_user_id_staff();

// Update Category
if(isset($_POST['update_category'])){
    $category_id = $_POST['category_id'];
    $new_category_name = $_POST['new_category_name'];
    
    // Update query
    $update_query = "UPDATE `categories` SET `name` = '$new_category_name' WHERE `id` = $category_id";
    
    $result_update = mysqli_query($con, $update_query);
    
    if($result_update){
        echo "<script>alert('Category Updated Successfully!')</script>";
        echo "<script>window.open('admin.php?insert_categories', '_self')</script>";
    } else {
        echo "<script>alert('Error updating category: " . mysqli_error($con) . "')</script>";
    }
}
if (isset($_GET['edit_category'])) {
    $edit_category_id = $_GET['edit_category'];

    // Select query to retrieve category details
    $select_query = "SELECT * FROM `categories` WHERE `id` = $edit_category_id";

    $result_select = mysqli_query($con, $select_query);

    if ($result_select && mysqli_num_rows($result_select) > 0) {
        $row = mysqli_fetch_assoc($result_select);
        $edit_category_name = $row['name'];
    } else {
        echo "<script>alert('Error retrieving category details: " . mysqli_error($con) . "')</script>";
        echo "<script>window.open('admin.php?insert_categories', '_self')</script>";
    }
}

?>

<!-- Edit Category Form -->
<h2 class="text-center"><i class="bi bi-arrow-up-circle-fill"></i> Edit Category</h2>
<form action="" method="post" class="mb-2">
    <input type="hidden" name="category_id" value="<?php echo $edit_category_id; ?>">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-dark text-white" id="basic-addon1"><i class="bi bi-receipt"></i></span>
        <input type="text" class="form-control" name="new_category_name" value="<?php echo $edit_category_name; ?>" placeholder="Edit Category" aria-label="categories" aria-describedby="basic-addon1" required="required">
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="bg-dark text-white border-0 p-2 my-3" name="update_category" value="Update Category">
    </div>
</form>
