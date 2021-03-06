<?php
require_once (__DIR__ .'/Model.php');
require_once (__DIR__ .'/Booking.php');

class BookingType extends Model
{
    public function defineVariables()
    {
        $data['title'] = $_POST["title"];
        $data['count'] = $_POST["count"];
        if(isset($_POST["available"])){
            $data['available'] = (int) $_POST["available"];
        } else{
            $data['available'] = 0;
        }
        return $data;
    }
   public function createBookingType()
   {
       $pdo = $this->createPdo();
        if(isset($_POST['formSent'])){
            $data = $this->defineVariables();
            $sql = "INSERT INTO booking_type (title, count, available) VALUES (".$pdo->quote( $data['title'] ).", ".$pdo->quote( $data['count'] ).", ".$pdo->quote( $data['available'] ).")";
            $pdo->query("$sql");
            setcookie('message-create', '<div class="alert alert-success">Booking Element was successfully created.</div>');
            header("Location: /project3-1/booking/admin/views/booking-type/index.php");
        }
   }
    public function getBookingTypes()
    {
            $pdo = $this->createPdo();
            $sql = "SELECT * FROM booking_type";
            return $pdo->query("$sql")->fetchAll();
    }
    public function getOneBookingType($id)
    {
        $pdo = $this->createPdo();
        $sql = "SELECT * FROM booking_type WHERE id=".$pdo->quote( $id );
        return $pdo->query("$sql")->fetch(PDO::FETCH_NAMED);
    }
    public function updateBookingType($id)
    {
        $prevTitle = $this->getOneBookingType($id)['title'];
        $pdo = $this->createPdo();
        if (isset($_POST['formSent'])) {
            $data = $this->defineVariables();

            $dateNow = date('Y-m-d');
            $sqlCheckCount = "SELECT * FROM calendar WHERE id_type=".$pdo->quote( $id )." AND date BETWEEN '$dateNow' AND '2030-11-11'";
            $result = $pdo->query("$sqlCheckCount")->fetchAll();

            $arrayCounts = array();
            foreach($result as $date){
                array_push($arrayCounts, $date['count_date']);
            }
            $maxCount = max($arrayCounts);

            if($maxCount<=$data['count']){
                $sql = "UPDATE booking_type SET title=".$pdo->quote( $data['title'] ).", count=".$pdo->quote( $data['count']  ).", available=".$pdo->quote( $data['available']  )."  WHERE id=".$pdo->quote( $id );
                $pdo->query("$sql");
                $sqlBooking = "UPDATE booking SET type=".$pdo->quote( $data['title'] )." WHERE type='$prevTitle'";
                $pdo->query("$sqlBooking");
                setcookie('message-update', '<div class="alert alert-success">Booking Element was successfully updated.</div>');
                header("Location: /project3-1/booking/admin/views/booking-type/index.php");
            } else{
                echo '<div class="alert alert-danger">Booking Element can not be updated: elements count is more than count active bookings </div>';
            }
        }
    }
    public function deleteBookingType($id){
        $pdo = $this->createPdo();
        $delete_sql = "DELETE FROM booking_type WHERE id=".$pdo->quote( $id );
        $deleteBookings = "DELETE FROM booking WHERE type_id=".$pdo->quote( $id );
        $deleteBookingsCalendar = "DELETE FROM calendar WHERE id_type=".$pdo->quote( $id );

        $pdo->query("$deleteBookings");
        $pdo->query("$deleteBookingsCalendar");
        $pdo->query("$delete_sql");
        setcookie('message-delete', '<div class="alert alert-success">Booking Element was successfully deleted.</div>');
        header("Location: /project3-1/booking/admin/views/booking-type/index.php");
    }
    public static function getTypeTitleById($id){
        $t = new self();
        return $t->getOneBookingType($id)['title'];
    }
    public static function getTypeTitles(){
        $t = new self();
        $pdo = $t->createPdo();
        $sql = "SELECT id, title FROM booking_type";
        return $pdo->query("$sql")->fetchAll();
    }
    public static function getAvailableTypeTitles(){
        $t = new self();
        $pdo = $t->createPdo();
        $sql = "SELECT id, title FROM booking_type WHERE available=1";
        return $pdo->query("$sql")->fetchAll();
    }
    public static function getOnlyTypeTitles()
    {
        $t = new self();
        $pdo = $t->createPdo();
        $sql = "SELECT title FROM booking_type";
        return $pdo->query("$sql")->fetchAll(PDO::FETCH_NAMED);
    }
    public function getAvailableBookingTypes()
    {
        $pdo = $this->createPdo();
        $sql = "SELECT * FROM booking_type WHERE available=1";
        return $pdo->query("$sql")->fetchAll(PDO::FETCH_NAMED);
    }
}
?>
