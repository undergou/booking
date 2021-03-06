<?php
require_once(__DIR__ .'\../../php/header.php');
?>
    <title>Booking Types Index</title>
<?php
require_once(__DIR__ .'\../../php/head-styles.php');
?>
<div class="admin-content">
    <h1>Booking types!</h1>
    <?php
        if(isset($_COOKIE['message-create'])){
        echo $_COOKIE['message-create'];
        setcookie('message-create', '<div class="alert alert-success">Booking Element was successfully created.</div>', time() - 60*60*24*32);
        }
    if(isset($_COOKIE['message-update'])){
        echo $_COOKIE['message-update'];
        setcookie('message-update', '<div class="alert alert-success">Booking Element was successfully updated.</div>', time() - 60*60*24*32);
    }
    if(isset($_COOKIE['message-delete'])){
        echo $_COOKIE['message-delete'];
        setcookie('message-delete', '<div class="alert alert-success">Booking Element was successfully deleted.</div>', time() - 60*60*24*32);
    }
    ?>
    <div class="wrap-for-create"><a class="create-new-element" href="create.php">Create new booking type</a></div>
    <div>
        <?php
            require_once(__DIR__ .'\../../models/BookingType.php');
            $model = new BookingType();
            $pdo = $model->createPdo();
            $result = $model->getBookingTypes();
        ?>
            <table class="padding">
                <tr class="bold-in-table">
                    <td>ID</td>
                    <td>Title</td>
                    <td>Count</td>
                    <td>Available</td>
                    <td>Actions</td>
                </tr>
        <?php
            if(isset($_GET['del'])) {
                $model->deleteBookingType($_GET['del']);
            }
            foreach ($result as $row){
                echo '<tr>
                            <td>'.$row["id"].'</td>
                            <td>'.$row["title"].'</td>
                            <td>'.$row["count"].'</td>
                            <td>'.(($row['available']) ? 'Available' : 'Not Available').'</td>
                            <td>
                                <a href="view.php?id='.$row["id"].'"><img class="actions-in-table" src="/project3-1/booking/admin/images/view.jpg" title="view item"></a>
                                <a href="update.php?id='.$row["id"].'"><img class="actions-in-table" src="/project3-1/booking/admin/images/edit.jpg" title="update item"></a>
                                <a class="deletes" href="index.php?del='.$row["id"].'"><img  class="actions-in-table"src="/project3-1/booking/admin/images/remove.png" title="delete item"></a>
                            </td>
                      </tr>';
            }
        ?>
            </table>
    </div>
</div>
<?php
require_once(__DIR__ .'\../../php/foot.php');
?>