<!DOCTYPE html>
<html lang="en">
<head>

    <?php
    $id=$_GET["id"];
    require_once('../../models/UserField.php');
    $model = new UserField();
    $result = $model->getOneUserField($id);
    $types = $model->getUserFieldsTypes();
    ?>

    <meta charset="UTF-8">
    <title>Update <?= $result["placeholder"] ?></title>
    <?php
    require_once('../../php/head-styles.php');
    ?>


<div class="admin-content">
    <h1>Update <?= $result["placeholder"] ?></h1>
    <?php
        require_once('_form.php');
        $model->updateUserField($id);
    ?>
</div>

<?php
require_once('../../php/foot.php');
?>
