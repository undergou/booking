<?php
require_once(__DIR__ .'\../../php/header.php');
?>
    <?php
    $id=$_GET["id"];
    require_once(__DIR__ .'\../../models/UserField.php');
    $model = new UserField();
    $result = $model->getOneUserField($id);
    $types = $model->getUserFieldsTypes();
    ?>
    <title>Update <?= $result["placeholder"] ?></title>
    <?php
    require_once(__DIR__ .'\../../php/head-styles.php');
    ?>


<div class="admin-content">
    <h1>Update <?= $result["placeholder"] ?></h1>
    <?php
        require_once(__DIR__ .'\_form.php');
        $model->updateUserField($id);
    ?>
</div>

<?php
require_once(__DIR__ .'\../../php/foot.php');
?>
