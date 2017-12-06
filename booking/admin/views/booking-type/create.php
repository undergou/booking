<?php
require_once(__DIR__ .'\../../php/header.php');
?>
    <title>Create new Booking Type</title>

<?php
require_once(__DIR__ .'\../../php/head-styles.php');
?>
<div class="admin-content">
    <h1>Create new Booking Type</h1>

    <?php
        require_once(__DIR__ .'\_form.php');
        require_once(__DIR__ .'\../../models/BookingType.php');
        $model = new BookingType();
        $model->createBookingType();
    ?>

</div>

<?php
    require_once(__DIR__ .'\../../php/foot.php');
?>
