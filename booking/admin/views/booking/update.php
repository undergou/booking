<?php
require_once(__DIR__ .'\../../php/header.php');
?>
<title>Update booking</title>
<?php require_once(__DIR__ .'\../../php/head-styles.php');
$id=$_GET["id"];
require_once(__DIR__ .'\../../models/BookingType.php');
require_once(__DIR__ .'\../../models/Booking.php');
$model = new Booking();
$result = $model->getOneBooking($id);
$types = BookingType::getAvailableTypeTitles();
?>
    <div class="admin-content"><h1>Update booking from <?= $result["name"] ?></h1><?php require_once(__DIR__ .'\_form.php');
        $model->updateBooking($id);
    ?></div>
<?php
require_once(__DIR__ .'\../../php/foot.php');
?>
