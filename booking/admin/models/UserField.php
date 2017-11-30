<?php
require_once ('Model.php');

class UserField extends Model
{
    public function defineVariables()
    {
        $data['placeholder'] = $_POST["placeholder"];
        $data['type'] = $_POST["type"];
        if(isset($_POST["available"])){
            $data['available'] = (int) $_POST["available"];
        } else{
            $data['available'] = 0;
        }
        if(isset($_POST["necessary"])){
            $data['necessary']= (int) $_POST["necessary"];
        } else{
            $data['necessary'] = 0;
        }
        return $data;
    }
   public function createUserField()
   {
       $pdo = $this->createPdo();
        if(isset($_POST['formSent'])){
           $data = $this->defineVariables();
            $sql = "INSERT INTO user_field (placeholder, type, available, necessary) VALUES ('".$data['placeholder']."', '".$data['type']."', '".$data['available']."', '".$data['necessary']."')";
            $pdo->query("$sql");
            setcookie('message-create', '<div class="alert alert-success">User Field was successfully created.</div>');
            header("Location: /project3-1/booking/admin/views/user-field/index.php");
        }
   }
    public function getUserFields()
    {
            $pdo = $this->createPdo();
            $sql = "SELECT * FROM user_field";
            if($pdo->query("$sql")){
                return $pdo->query("$sql")->fetchAll();
            }
    }
    public function getOneUserField($id)
    {
        $pdo = $this->createPdo();
        $sql = "SELECT * FROM user_field WHERE id='$id'";
        return $result = $pdo->query("$sql")->fetch(PDO::FETCH_NAMED);
    }
    public function updateUserField($id)
    {
        $pdo = $this->createPdo();
        if(isset($_POST['formSent'])){
            $data = $this->defineVariables();
            $sql = "UPDATE user_field SET placeholder='".$data['placeholder']."', type='".$data['type']."', available='".$data['available']."', necessary='".$data['necessary']."'  WHERE id='$id'";
            $pdo->query("$sql");
            setcookie('message-update', '<div class="alert alert-success">User Field was successfully updated.</div>');
            header("Location: /project3-1/booking/admin/views/user-field/index.php");

        }
    }
    public function deleteUserField($id){
        $pdo = $this->createPdo();
        $delete_sql = "DELETE FROM user_field WHERE id=".$id;
        $resultDel = $pdo->query("$delete_sql");
        setcookie('message-delete', '<div class="alert alert-success">User Field was successfully deleted.</div>');
        header("Location: /project3-1/booking/admin/views/user-field/index.php");
    }
    public function getUserFieldsTypes(){
        return [
            0 => 'String',
            1 => 'Integer',
            2 => 'Date'
        ];
    }
    public function getAvailableUserFields()
    {
        $pdo = $this->createPdo();
        $sql = "SELECT * FROM user_field WHERE available=1";
        if($pdo->query("$sql")){
            return $pdo->query("$sql")->fetchAll(PDO::FETCH_NAMED);
        }

    }
}
?>
