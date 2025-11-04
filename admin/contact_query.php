<?php
// Start session and check login
include 'session.php'; // Make sure session.php is in the same admin folder
include '../conn.php';  // Database connection

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Queries - Admin Panel</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<style>
body { background-color: #f8f9fa; color: #333; }
h2 { margin-top: 20px; margin-bottom: 30px; }
.table th, .table td { text-align: center; vertical-align: middle; }
.btn-back { margin-top: 20px; }
</style>
</head>
<body>

<div class="container">
    <h2 class="text-center">All User Queries</h2>

    <?php
    $sql = "SELECT * FROM contact_query ORDER BY query_id DESC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table table-bordered table-striped">';
        echo '<thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact No.</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
              </thead><tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            $status = ($row['query_status'] == 2) ? "Pending" : "Resolved";

            echo '<tr>';
            echo '<td>' . $row['query_id'] . '</td>';
            echo '<td>' . $row['query_name'] . '</td>';
            echo '<td>' . $row['query_mail'] . '</td>';
            echo '<td>' . $row['query_number'] . '</td>';
            echo '<td>' . $row['query_message'] . '</td>';
            echo '<td>' . $status . '</td>';
            echo '<td>' . $row['query_date'] . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<div class="alert alert-info text-center">No user queries found.</div>';
    }

    mysqli_close($conn);
    ?>

    <div class="text-center btn-back">
        <a href="dashboard.php" class="btn btn-primary">← Back to Dashboard</a>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>
</html>
