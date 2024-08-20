<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .img {
            object-fit: contain;
            height: 100px;
            width: 100px;
        }

        /* Add styles for forms and buttons */
        form {
            margin-bottom: 20px; /* Adjust the margin as needed */
        }

        input[type="text"],
        select {
            width: 200px; /* Adjust the width as needed */
            padding: 10px; /* Adjust the padding as needed */
            margin-bottom: 10px; /* Adjust the margin as needed */
        }

        button {
            background-color: black; /* Green color */
            color: white;
            padding: 10px 15px; /* Adjust the padding as needed */
            border: none;
            border-radius: 5px; /* Adjust the border radius as needed */
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049; /* Darker green color on hover */
        }
    </style>
</head>

<body>
<h3 class="text-center py-4 text-dark fs-4 fw-bold text-uppercase border-bottom"><i class="fa fa-users fa-2x"></i> Staffs</h3>
<table class="table table-bordered border-dark mt-5">
    <thead class="bg-dark text-center text-light">
        <tr>
            <th>S.No.</th>
            <th>Staff Name</th>
            <th>Staff Email</th>
            <th>Staff Designation</th>
            <th>Shift</th>
            <th>Join Date</th>
            <th>Salary</th>
            
            
        </tr>
    </thead>
    <tbody>
        <?php
            $pic = mysqli_query($con, "SELECT * FROM `user_table` where user_type='staff'");
            $number=0;
            while($row = mysqli_fetch_array($pic)){
                $user_id=$row['id'];
                $NAME = $row['username'];
                $EMAIL = $row['email'];
                $user_image = $row['user_image'];
                $title = $row['Designation'];
                $shift = $row['Shift'];
                $join_date = $row['join_date'];
                $salary = $row['Salary'];
                $number++;
                    echo "<tr class='text-center'>
                    <td>$number</td>
                    <td>$NAME</td>
                    <td>$EMAIL</td>
                    <td>$title</td>
                    <td>$shift</td>
                    <td>$join_date</td>
                    <td>रु $salary</td>
                    </tr>";
            
                ?>
                
<?php
            }
        

?>        
    </tbody>
</table>


    <h3 class="text-center py-4 text-dark fs-4 fw-bold text-uppercase border-bottom"><i class="fa fa-users fa-2x"></i> Updae Information</h3>

    <table class="table table-bordered border-dark mt-5">
        <thead class="bg-dark text-center text-light">
            <tr>
                <th>S.No.</th>
                <th>Staff Name</th>
                <th>Staff Designation</th>
                <th>Shift</th>
                <th>Joining Date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Assuming you have a database connection established in $con
            include 'config.php'; // Include your database connection file

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $user_id = $_POST['user_id'];

                // Update Designation
                if (isset($_POST['staff_designation'])) {
                    $designation = $_POST['staff_designation'];
                    $updateQuery = "UPDATE user_table SET Designation = '$designation' WHERE id = $user_id";

                    if (mysqli_query($con, $updateQuery)) {
                        echo "Designation updated successfully.";
                    } else {
                        echo "Error updating designation: " . mysqli_error($con);
                    }
                }

                // Update Shift
                if (isset($_POST['user_type'])) {
                    $shift = $_POST['user_type'];
                    $updateQuery = "UPDATE user_table SET Shift = '$shift' WHERE id = $user_id";

                    if (mysqli_query($con, $updateQuery)) {
                        echo "Shift updated successfully.";
                    } else {
                        echo "Error updating shift: " . mysqli_error($con);
                    }
                }

                // Update Salary
                if (isset($_POST['staff_salary'])) {
                    $salary = $_POST['staff_salary'];
                    $updateQuery = "UPDATE user_table SET Salary = '$salary' WHERE id = $user_id";

                    if (mysqli_query($con, $updateQuery)) {
                        echo "Salary updated successfully.";
                    } else {
                        echo "Error updating salary: " . mysqli_error($con);
                    }
                }
            }

            // Fetch and display user information
            $pic = mysqli_query($con, "SELECT * FROM `user_table` where user_type='staff'");
            $number = 0;
            while ($row = mysqli_fetch_array($pic)) {
                $user_id = $row['id'];
                $NAME = $row['username'];
                $join_date = $row['join_date'];
                $number++;
                echo "<tr class='text-center'>
                    <td>$number</td>
                    <td>$NAME</td>
                    <td>
                        <form method='post' action=''>
                            <input type='text' name='staff_designation' placeholder='Enter Staff Designation' required>
                            <input type='hidden' name='user_id' value='$user_id'><br>
                            <button type='submit'>Submit Designation</button>
                        </form>
                    </td>
                    <td>
                        <form method='post' action=''>
                            <label for='user_type'>Select Shift:</label>
                            <select name='user_type' class='form-select'>
                                <option value='Morning'>Morning</option>
                                <option value='Day'>Day</option>
                                <option value='Night'>Night</option>
                            </select>
                            <input type='hidden' name='user_id' value='$user_id'><br>
                            <button type='submit'>Submit Shift</button>
                        </form>
                    </td>
                    <td>$join_date</td>
                    <td>
                        <form method='post' action=''>
                            <label for='staff_salary'>Enter Staff Salary:</label>
                            <input type='text' name='staff_salary' required>
                            <input type='hidden' name='user_id' value='$user_id'><br>
                            <button type='submit'>Submit Salary</button>
                        </form>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>
