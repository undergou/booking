<?php
require_once('../../php/header.php');
?>
    <title>Booking Index</title><?php
require_once('../../php/head-styles.php');
?>
<div class="admin-content">
    <h1>Bookings!</h1>
    <?php
        if(isset($_COOKIE['message-create'])){
        echo $_COOKIE['message-create'];
        setcookie('message-create', '<div class="alert alert-success">Booking was successfully created.</div>', time() - 60*60*24*32);
        }
    if(isset($_COOKIE['message-update'])){
        echo $_COOKIE['message-update'];
        setcookie('message-update', '<div class="alert alert-success">Booking was successfully updated.</div>', time() - 60*60*24*32);
    }
    if(isset($_COOKIE['message-delete'])){
        echo $_COOKIE['message-delete'];
        setcookie('message-delete', '<div class="alert alert-success">Booking was successfully deleted.</div>', time() - 60*60*24*32);
    }
    ?>
    <div class="wrap-for-create"><a class="create-new-element" href="create.php">Create new Booking</a></div>
    <div>
        <?php
            require_once('../../models/Booking.php');
            require_once('../../models/Calendar.php');
            $limit = 5;
            $model = new Booking();
            $pdo = $model->createPdo();
        if(isset($_GET['page'])){
            $offset = $limit* ((int) $_GET['page'])-$limit;
            $result = $model->getBookingsWithOffset($offset);
                } else{
            $result = $model->getBookingsWithoutOffset();
        }
        ?>
            <table>
                <tr class="bold-in-table">
                    <td>ID</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>Type</td>
                    <td>Date Start</td>
                    <td>Count of Days</td>
                    <td>Data</td>
                    <td>Actions</td>
                </tr>
        <?php


//            var_dump($arrayDates);die;
            if(isset($_GET['del'])) {
                $model->deleteBooking($_GET['del']);

            }
            if($result){
                foreach ($result as $row){
                    echo '<tr>
                            <td>'.$row["id"].'</td>
                            <td>'.$row["name"].'</td>
                            <td>'.$row["email"].'</td>
                            <td>'.$row["phone"].'</td>
                            <td>'.$row["type"].'</td>
                            <td>'.$row["date_start"].'</td>
                            <td>'.$row["count_days"].'</td>
                            <td>'.$row["data"].'</td>
                            <td>
                                <a href="update.php?id='.$row["id"].'"><img class="actions-in-table" src="/project3-1/booking/admin/images/edit.jpg" title="update item"></a>
                                <a class="deletes" href="index.php?del='.$row["id"].'"><img  class="actions-in-table"src="/project3-1/booking/admin/images/remove.png" title="delete item"></a>
                            </td>
                      </tr>';

                }
            }
        ?>
            </table>
        <div class="pagination">
            <?php
                $countBookings = $model->getCountBookings();
                $countPages = (int) ceil($countBookings/$limit);
                $isTrue = true;
                for($i=0;$i<$countPages;$i++){
//                    if($isTrue){
//                        echo '<div class="page alert alert-button-active"><a href="/project3-1/booking/admin/views/booking/index.php?page='.($i+1).'">'.($i+1).'</a></div>';
//                        $isTrue = false;
//                    } else{
                        echo '<div class="div-for-page"><a class="alert alert-button page" href="/project3-1/booking/admin/views/booking/index.php?page='.($i+1).'">'.($i+1).'</a></div>';
//                    }
                }
//                var_dump($countPages);die;
            ?>
        </div>
    </div>
</div>

<?php
require_once('../../php/foot.php');
?>
