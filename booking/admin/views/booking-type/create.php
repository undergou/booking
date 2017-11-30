<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create new Booking Type</title>

<?php
require_once('../../php/head-styles.php');
?>
<div class="admin-content">
    <h1>Create new Booking Type</h1>

    <?php
        require_once('_form.php');
        require_once('../../models/BookingType.php');
        $model = new BookingType();
        $model->createBookingType();
    ?>

</div>

<?php
    require_once('../../php/foot.php');
?>
