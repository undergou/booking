<?php
require_once(__DIR__ .'\../../php/header.php');
?>
<?php
$id=$_GET["id"];
require_once(__DIR__ .'\../../models/BookingType.php');
$model = new BookingType();
$result = $model->getOneBookingType($id);
?>
    <title><?= $result["title"] ?></title>

    <?php
        require_once(__DIR__ .'\../../php/head-styles.php');
    ?>

<div class="admin-content">
    <h1><?= $result["title"] ?></h1>
    <?php
        if(isset($_COOKIE['message'])){
            echo $_COOKIE['message'];
            setcookie('message-update', '<div class="alert alert-success">Booking Element was successfully updated.</div>', time() - 60*60*24*32);
        }
    ?>
    <table>
        <tr><td class="bold-in-table">ID</td><td><?= $result["id"] ?></td></tr>
        <tr><td class="bold-in-table">Title</td><td><?= $result["title"] ?></td></tr>
        <tr><td class="bold-in-table">Count</td><td><?= $result["count"] ?></td></tr>
        <tr><td class="bold-in-table">Available</td><td><?= ($result["available"]) ? 'Available' : 'Not available' ?></td></tr>
    </table>
</div>
<?php
require_once(__DIR__ .'\../../php/foot.php');
?>