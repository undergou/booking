<?php
    require_once(__DIR__ .'\../../php/header.php');
    ?>
    <?php
    $id=$_GET["id"];
    require_once(__DIR__ .'\../../models/BookingType.php');
    $model = new BookingType();
    $result = $model->getOneBookingType($id);
    ?>


    <title>Update <?= $result["title"] ?></title>
    <?php
        require_once(__DIR__ .'\../../php/head-styles.php');
    ?>
<div class="admin-content">
    <h1>Update <?= $result["title"] ?></h1>
    <?php
        require_once(__DIR__ .'\_form.php');
        $model->updateBookingType($id);
    ?>
</div>
<?php
require_once(__DIR__ .'\../../php/foot.php');
?>