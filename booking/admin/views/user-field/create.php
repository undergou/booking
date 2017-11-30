<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create new User Field</title>

<?php
require_once('../../php/head-styles.php');
?>
<div class="admin-content">
    <h1>Create new User Field</h1>

    <?php

        require_once('../../models/UserField.php');
        $model = new UserField();
        $model->createUserField();
        $types = $model->getUserFieldsTypes();
        require_once('_form.php');
    ?>

</div>

<?php
    require_once('../../php/foot.php');
?>
