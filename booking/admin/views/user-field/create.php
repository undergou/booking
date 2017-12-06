<?php
require_once(__DIR__ .'\../../php/header.php');
?>
    <title>Create new User Field</title>

<?php
require_once(__DIR__ .'\../../php/head-styles.php');
?>
<div class="admin-content">
    <h1>Create new User Field</h1>

    <?php
        require_once(__DIR__ .'\../../models/UserField.php');
        $model = new UserField();
        $model->createUserField();
        $types = $model->getUserFieldsTypes();
        require_once(__DIR__ .'\_form.php');
    ?>
</div>

<?php
    require_once(__DIR__ .'\../../php/foot.php');
?>