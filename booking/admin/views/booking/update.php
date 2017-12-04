<?php
require_once('../../php/header.php');
?>
<title>Update booking</title>
<?php require_once('../../php/head-styles.php');
$id=$_GET["id"];
require_once('../../models/BookingType.php');
require_once('../../models/Booking.php');
$model = new Booking();
$result = $model->getOneBooking($id);
//    var_dump($result);die;
$types = BookingType::getAvailableTypeTitles();
?>
    <div class="admin-content"><h1>Update booking from <?= $result["name"] ?></h1><?php require_once('_form.php');
        $model->updateBooking($id);
    ?></div>
<?php
require_once('../../php/foot.php');
?>
