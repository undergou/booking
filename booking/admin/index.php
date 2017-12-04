<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrator panel</title>
</head>

<?php
    require_once('php/head-styles.php');
    require_once('models/Booking.php');
    require_once('../config.php');
    $model = new Booking();
?>
<?php if(!defined('SITE_ADMIN')): ?>
    <div class="admin-content">
        <h1>Admin panel</h1>
       <p>There is administrator panel of booking module!</p>
        <h2>Active bookings today:</h2>
        <?php
        $arrayBookingActiveToday = $model->getArrayForActiveBookings();
        if(count($arrayBookingActiveToday)){
            foreach ($arrayBookingActiveToday as $row){
                echo '<div class="one-booking-index">
                       <strong>Type:</strong> '. $row["type"] .'
                       <br /><strong>Name of customer:</strong> '. $row["name"] .'
                       <br /><strong>Email:</strong> '. $row["email"] .'
                       <br /><strong>Start date:</strong> '. $row["date_start"] .'
                       <br /><strong>Amount of days:</strong> '. $row["count_days"] .'
                      </div>';
            }
        } else {
            echo '<div class="one-booking-index">There is no active bookings today</div>';
        }
        ?>
        <h2>Last 3 bookings:</h2>
        <?php
           $result = $model->getArrayForLastBookings();
            foreach ($result as $row){
                echo '<div class="one-booking-index">
                       <strong>Type:</strong> '. $row["type"] .'
                       <br /><strong>Name of customer:</strong> '. $row["name"] .'
                       <br /><strong>Email:</strong> '. $row["email"] .'
                       <br /><strong>Start Date:</strong> '. $row["date_start"] .'
                       <br /><strong>Amount of days:</strong> '. $row["count_days"] .'
                      </div>';
            }
        ?>
    </div>

<?php else: ?>
<?php echo 'You do not have access to this part of the site'; ?>
<?php endif; ?>
<?php
require_once('php/foot.php');
?>
