<?php
include 'session.php';
include 'conn.php';

// Mark query as Read if id is passed
if(isset($_GET['id'])){
    $que_id = intval($_GET['id']);
    $sql_update = "UPDATE contact_query SET query_status=1 WHERE query_id={$que_id}";
    mysqli_query($conn, $sql_update);
    header("Location: query.php"); // Refresh to show updated status
    exit;
}

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$count = $offset + 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Queries - Admin</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<style>
#he{ font-size:14px; font-weight:600; text-transform:uppercase; padding:3px 7px; color:#fff; border-radius:3px;}
</style>
</head>
<body>

<div class="container">
    <h2 class="text-center">User Queries</h2>

    <?php
    $sql = "SELECT * FROM contact_query ORDER BY query_id DESC LIMIT {$offset}, {$limit}";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        echo '<div class="table-responsive"><table class="table table-bordered text-center">';
        echo '<thead><tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Message</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr></thead><tbody>';

        while($row = mysqli_fetch_assoc($result)){
            $status = ($row['query_status']==1) ? "Read" : '<a href="query.php?id='.$row['query_id'].'">Pending</a>';
            echo '<tr>
                    <td>'.$count++.'</td>
                    <td>'.$row['query_name'].'</td>
                    <td>'.$row['query_mail'].'</td>
                    <td>'.$row['query_number'].'</td>
                    <td>'.$row['query_message'].'</td>
                    <td>'.$row['query_date'].'</td>
                    <td>'.$status.'</td>
                    <td id="he">
                        <a style="background-color:red;color:white;padding:3px 7px;border-radius:3px;" 
                           href="delete_query.php?id='.$row['query_id'].'" onclick="return confirm(\'Are you sure you want to delete this query?\');">Delete</a>
                    </td>
                  </tr>';
        }
        echo '</tbody></table></div>';
    } else {
        echo '<div class="alert alert-info text-center">No queries found.</div>';
    }
    ?>

    <!-- Pagination -->
    <?php
    $sql_total = "SELECT COUNT(*) AS total FROM contact_query";
    $res_total = mysqli_query($conn, $sql_total);
    $total_records = mysqli_fetch_assoc($res_total)['total'];
    $total_pages = ceil($total_records / $limit);

    if($total_pages > 1){
        echo '<ul class="pagination text-center">';
        if($page > 1){
            echo '<li><a href="query.php?page='.($page-1).'">Prev</a></li>';
        }
        for($i=1; $i<=$total_pages; $i++){
            $active = ($i==$page) ? "class='active'" : "";
            echo '<li '.$active.'><a href="query.php?page='.$i.'">'.$i.'</a></li>';
        }
        if($page < $total_pages){
            echo '<li><a href="query.php?page='.($page+1).'">Next</a></li>';
        }
        echo '</ul>';
    }
    ?>
</div>

</body>
</html>
