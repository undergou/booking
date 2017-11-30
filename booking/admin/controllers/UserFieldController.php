<?php
//require_once ('Controller.php');
require_once ('UserField.php');

class UserFieldController
{
    public function createUserField()
    { $model = new UserField();
        $pdo = $model->createPdo();
        if(isset($_POST['formSent'])){
            $data = $model->defineVariables($_POST);
            $sql = "INSERT INTO user_field (placeholder, type, available, necessary) VALUES ('".$data['placeholder']."', '".$data['type']."', '".$data['available']."', '".$data['necessary']."')";
            $pdo->query("$sql");
            setcookie('message-create', '<div class="alert alert-success">User Field was successfully created.</div>');
            header("Location: /project3-1/booking/admin/views/user-field/index.php");
        }
    }
}
?>
