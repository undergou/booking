<div class="div-for-from">
    <form action="<?= ((isset($id)) ? 'update.php?id='.$id : 'create.php') ?>" method="POST">
        <label>Placeholder
            <br><input type="text" name="placeholder" value="<?= ((isset($id)) ? $result['placeholder'] : '') ?>"></label>
        <br><br><label>Type <br><select name="type">
        <?php
        foreach($types as $row){
            echo '<option value="'.$row.'" '.(($row == $result['type']) ? 'selected' : '').'>'.$row.'</option>';
        }
        ?>
        </select>
        <br><br><label>Available <br><input type="checkbox" name="available" value="1" <?= ((isset($id) && $result['available']) ? 'checked' : '') ?>></label>
        <br><br><label>Necessary <br><input type="checkbox" name="necessary" value="1" <?=((isset($id) && $result['necessary'])?'checked':'')?>></label>

        <input type="hidden" name="formSent">
            <br><button class="create-new-element"><?php if(isset($id)){echo 'Update';}else{echo 'Create';};?></button></form></div>