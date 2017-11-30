<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Fields Index</title>

<?php
require_once('../../php/head-styles.php');
?>
<div class="admin-content">
    <h1>User Fields!</h1>
    <?php
        if(isset($_COOKIE['message-create'])){
        echo $_COOKIE['message-create'];
        setcookie('message-create', '<div class="alert alert-success">User Field was successfully created.</div>', time() - 60*60*24*32);
        }
    if(isset($_COOKIE['message-update'])){
        echo $_COOKIE['message-update'];
        setcookie('message-update', '<div class="alert alert-success">User Field was successfully updated.</div>', time() - 60*60*24*32);
    }
    if(isset($_COOKIE['message-delete'])){
        echo $_COOKIE['message-delete'];
        setcookie('message-delete', '<div class="alert alert-success">User Field was successfully deleted.</div>', time() - 60*60*24*32);
    }
    ?>
    <div class="wrap-for-create"><a class="create-new-element" href="create.php">Create new User Field</a></div>
    <div>
        <?php
            require_once('../../models/UserField.php');
            $model = new UserField();
            $result = $model->getUserFields();
            $pdo = $model->createPdo();
        ?>
            <table class="padding">
                <tr class="bold-in-table">
                    <td>ID</td>
                    <td>Placeholder</td>
                    <td>Type</td>
                    <td>Available</td>
                    <td>Necessary</td>
                    <td>Actions</td>
                </tr>
        <?php
            if(isset($_GET['del'])) {
                $model->deleteUserField($_GET['del']);
            }
            if($result){
                foreach ($result as $row){
                    echo '<tr>
                            <td>'.$row["id"].'</td>
                            <td>'.$row["placeholder"].'</td>
                            <td>'.$row["type"].'</td>
                            <td>'.(($row['available']) ? 'Available' : 'Not Available').'</td>
                            <td>'.(($row['necessary']) ? 'Necessary' : 'Not Necessary').'</td>
                            <td>
                                <a href="update.php?id='.$row["id"].'"><img class="actions-in-table" src="/project3-1/booking/admin/images/edit.jpg" title="update item"></a>
                                <a class="deletes" href="index.php?del='.$row["id"].'"><img  class="actions-in-table"src="/project3-1/booking/admin/images/remove.png" title="delete item"></a>
                            </td>
                      </tr>';

                }
            }


        ?>
            </table>
    </div>
</div>

<?php
require_once('../../php/foot.php');
?>
