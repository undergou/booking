<!DOCTYPE html>
<html lang="en">
<head>

    <?php
    $id=$_GET["id"];
    require_once('../../models/BookingType.php');
    $model = new BookingType();
    $result = $model->getOneBookingType($id);
    ?>

    <meta charset="UTF-8">
    <title>Update <?= $result["title"] ?></title>
    <?php
        require_once('../../php/head-styles.php');
    ?>


<div class="admin-content">
    <h1>Update <?= $result["title"] ?></h1>
    <?php
        require_once('_form.php');
        $model->updateBookingType($id);
    ?>
</div>

<?php
require_once('../../php/foot.php');
?>
