<div class="div-for-from">
    <form action="<?= ((isset($id)) ? 'update.php?id='.$id : 'create.php') ?>" method="POST">
        <label>Title
            <br><input type="text" name="title" value="<?= ((isset($id)) ? $result['title'] : '') ?>"></label>
        <br><br><label>Count <br><input type="text" name="count" value="<?= ((isset($id)) ? $result['count'] : '') ?>"></label>
        <br><br><label>Available <br><input type="checkbox" name="available" value="1" <?= ((isset($id) && $result['available']) ? 'checked' : '') ?>></label>
        <input type="hidden" name="formSent">
        <br><br><button type="submit" class="create-new-element"><?= (isset($id) ? 'Update' : 'Create') ?></button>
    </form>
</div>