<?php require_once(__DIR__ .'\../../php/header.php'); ?><title>Create new Booking</title>
<?php require_once(__DIR__ .'\../../php/head-styles.php');?><div class="admin-content"><h1>Create new Booking</h1><?php
        require_once(__DIR__ .'\../../models/BookingType.php');
        require_once(__DIR__ .'\../../models/Booking.php');
        $model = new Booking();
        $model->createBooking();
        $types = BookingType::getAvailableTypeTitles();
        require_once(__DIR__ .'\_form.php'); ?></div>
<?php
    require_once(__DIR__ .'\../../php/foot.php');
?>