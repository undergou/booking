<?php require_once('../../php/header.php'); ?><title>Create new Booking</title>
<?php require_once('../../php/head-styles.php');?><div class="admin-content"><h1>Create new Booking</h1><?php
        require_once('../../models/BookingType.php');
        require_once('../../models/Booking.php');
        $model = new Booking();
        $model->createBooking();
        $types = BookingType::getAvailableTypeTitles();
//        var_dump($types);die;
        require_once('_form.php'); ?></div>
<?php
    require_once('../../php/foot.php');
?>