<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Management</title>
    <style>
        /* Add styles for forms and buttons */
        form {
            display: flex; /* Use flexbox for layout */
            align-items: center; /* Center items vertically */
            flex-direction: column; /* Stack items vertically */
            margin-bottom: 20px; /* Adjust the margin as needed */
        }

        input[type="text"] {
            width: 100px; /* Adjust the width as needed */
            padding: 5px; /* Adjust the padding as needed */
            margin-bottom: 5px; /* Adjust the margin as needed */
        }

        button {
            background-color: black; /* Green color */
            color: white;
            padding: 5px 10px; /* Adjust the padding as needed */
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
<h3 class="text-center py-4 text-dark fs-4 fw-bold text-uppercase border-bottom"><i class="bi bi-house-check-fill fa-2x"></i> Complaint Management</h3>
<table class="table table-bordered border-dark mt-5">
    <thead class="bg-dark text-center text-light">
        <tr>
            <th>S.No.</th>
            <th>Complainant Name</th>
            <th>Complaint Type</th>
            <th>Complaint</th>
            <th>Created At</th>
            <th>Resolved At</th>
            <th>Budget</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $pic = "SELECT * FROM `complaints`";
            $result_select=mysqli_query($con,$pic);
        if (mysqli_num_rows($result_select) > 0) {
                 
            $number=0;

            while($row = mysqli_fetch_array($result_select)){
                $room_id=$row['room_id'];
                $c_name = $row['complainant_name'];
                $c_type = $row['complaint_type'];
                $complaint = $row['complaint'];
                $created_at = $row['created_at'];
                $resolved_at = $row['resolved_at'];
                $budget = $row['budget'];
                $number++;
                    echo "<tr class='text-center'>
                    <td>$number</td>
                    <td>$c_name</td>
                    <td>$c_type</td>
                    <td>$complaint</td>
                    <td>$created_at</td>
                    <td>$resolved_at</td>
                    <td>$budget</td>

                    </tr>";
            
                ?>
                
<?php
            }
        } else{
            echo "No Complaints Yet! :)";
        }
        

?>        
    </tbody>
</table>

    <h3 class="text-center py-4 text-dark fs-4 fw-bold text-uppercase border-bottom"><i
            class="bi bi-house-check-fill fa-2x"></i> Complaint Management</h3>
    <table class="table table-bordered border-dark mt-5">
        <thead class="bg-dark text-center text-light">
            <tr>
                <th>S.No.</th>
                <th>Complainant Name</th>
                <th>Complaint Type</th>
                <th>Complaint</th>
                <th>Created At</th>
                <th>Resolved At</th>
                <th>Budget</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $pic = "SELECT * FROM `complaints`";
            $result_select = mysqli_query($con, $pic);
            if (mysqli_num_rows($result_select) > 0) {

                $number = 0;

                while ($row = mysqli_fetch_array($result_select)) {
                    $room_id = $row['room_id'];
                    $c_name = $row['complainant_name'];
                    $c_type = $row['complaint_type'];
                    $complaint = $row['complaint'];
                    $created_at = $row['created_at'];
                    $resolved_at = $row['resolved_at'];
                    $budget = $row['budget'];
                    $number++;

                    echo "<tr class='text-center'>
                        <td>$number</td>
                        <td>$c_name</td>
                        <td>$c_type</td>
                        <td>$complaint</td>
                        <td>$created_at</td>
                        <td>$resolved_at</td>
                        <td>
                            <form method='post' action=''>
                                <input type='text' name='new_budget_$room_id' placeholder='Enter Budget' required>
                                <input type='hidden' name='complaint_id' value='$room_id'>
                                <button type='submit'>Submit Budget</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "No Complaints Yet! :)";
            }

            // Handle form submission to update budget
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'new_budget_') !== false) {
                        $complaint_id = substr($key, 12); // Extract complaint_id from the input name
                        $new_budget = mysqli_real_escape_string($con, $value);

                        $update_query = "UPDATE `complaints` SET `budget`='$new_budget', `resolved_at`=NOW() WHERE `room_id`='$complaint_id'";
                        mysqli_query($con, $update_query);
                    }
                }
            }
            ?>
        </tbody>
    </table>
</body>

</html>
