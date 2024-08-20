<?php
include('admin/config.php');
error_log("Minimum Price: " . $_POST["minimum_price"]);
error_log("Maximum Price: " . $_POST["maximum_price"]);

if (isset($_POST["action"])) {
    $query = "SELECT * FROM rooms WHERE 1";

    $params = array();
    $types = "";

    if(isset($_POST["categories"]) && !empty($_POST["categories"])){
        foreach ($_POST["categories"] as $key => $category) {
            $query .= " AND Category like ?";
            array_push($params, $category);
            $types .= "s";
        }
    }

    if (isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"])) {
        $query .= " AND price BETWEEN ? AND ?";
        $params[] = $_POST["minimum_price"];
        $params[] = $_POST["maximum_price"];
        $types .= "ss";
    }
    // die(print_r($query));

    $statement = $con->prepare($query);

    if ($types != "") {
        $bind_params = array($types);
        foreach ($params as &$param) {
            $bind_params[] = &$param;
        }
        // die(print_r($bind_params));
        call_user_func_array(array($statement, 'bind_param'), $bind_params);
    }

    $statement->execute();
    $result = $statement->get_result();

    $total_row = $result->num_rows;
    $output = '';

    if ($total_row > 0) {
        while ($row = $result->fetch_assoc()) {
            $room_name = $row['Name'];
            $price_per_night = $row['Price'];
            $room_image = $row['Image'];
            $adult = $row['Adults'];
            $child = $row['Children'];
            $facility = $row['Facilities'];
            $feature = $row['Features'];

            $facilitiesArray = explode(",", $facility);
            $featuresArray = explode(",", $feature);

            $output .= '
            <div class="card mb-4 border-0 shadow">
                <div class="row g-0">
                    <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                        <img src="uploads/rooms/' . $room_image . '" class="img-fluid rounded" style="height: 100%;">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h5 class="mb-3">' . $room_name . '</h5>
                            <div class="features mb-3">
                                <h6 class="mb-1">Features</h6>';
            foreach ($featuresArray as $featureTitle) {
                $output .= '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $featureTitle . '</span>';
            }
            $output .= '</div>
                            <div class="facilities mb-3">
                                <h6 class="mb-1">Facilities</h6>';
            foreach ($facilitiesArray as $facilityTitle) {
                $output .= '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $facilityTitle . '</span>';
            }
            $output .= '</div>
                            <div class="guests">
                                <h6 class="mb-1">Guests</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">' . $adult . ' Adults</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">' . $child . ' Children</span>
                            </div>
                            <h6 class="mb-4">रु ' . $price_per_night . ' per night</h6>
                            <a href="book.php?room_id=' . $row['room_id'] . '" class="btn btn-sm btn-outline-dark shadow-none">Book Now</a>
                            <span style="margin-bottom: 10px;"></span>
                            <a href="viewmore.php?room_id=' . $row['room_id'] . '" class="btn btn-sm btn-outline-dark shadow-none">View More</a>
                        </div>
                    </div>
                </div>
            </div>';
        }
    } else {
        $output = '<div class="col-12 text-center"><p>No rooms available with the selected facilities and categories.</p></div>';
    }

    echo $output;
}
?>
