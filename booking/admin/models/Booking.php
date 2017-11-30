<?php
require_once ('Model.php');
require_once ('BookingType.php');
require_once ('Calendar.php');

class Booking extends Model
{
    public function defineVariables()
    {
        $data['name'] = $_POST["name"];
        $data['email'] = $_POST["email"];
        $data['phone'] = $_POST["phone"];
        $data['type_id'] = $_POST["type_id"];
        $data['type'] = BookingType::getTypeTitleById($data['type_id']);
        $data['date_start'] = $_POST["date_start"];
        $data['count_days'] = $_POST["count_days"];
        $data['date_create'] = date('d-m-Y');
        $data['data'] = $_POST["data"];

        return $data;
    }
   public function createBooking()
   {
       $pdo = $this->createPdo();
        if(isset($_POST['formSent'])){
            $data = $this->defineVariables();
            $intCountDays = (int) $data['count_days'];
            $type_id = $data['type_id'];
            $startDateForDb = Calendar::getDbDateFormat($data['date_start']);
            $endDateForDb = Calendar::getEndDateForDb($startDateForDb, $intCountDays);
            $arrayRequestedDates = Calendar::getDatesRangeArray($startDateForDb, $intCountDays);
            $modelBookingType = new BookingType();
            $countBookingType = $modelBookingType->getOneBookingType($type_id)['count'];
            $sqlCheckCalendar = "SELECT * FROM calendar WHERE id_type='$type_id' AND date BETWEEN '$startDateForDb' AND '$endDateForDb'";
            $rowsExistDates = $pdo->query("$sqlCheckCalendar")->fetchAll(PDO::FETCH_NAMED);
            if(count($rowsExistDates)){
                $isCountMore = false;
                foreach($rowsExistDates as $date){
                    if($date['count_date']>=$countBookingType){
                        $isCountMore = true;
                    }
                }
                if(!$isCountMore){
                    $arrayExistsDates = array();
                    foreach($rowsExistDates as $date){
                        array_push($arrayExistsDates, $date['date']);
                    }
                    $newArrayExistsDates = array_unique($arrayExistsDates);
                    $arrayWithoutMatchedDates = Calendar::getNotExistsDates($arrayExistsDates, $arrayRequestedDates);

                    $sqlInsertForNewDate = Calendar::getSqlStringForNewDate($arrayWithoutMatchedDates, $type_id);
                    $pdo->query("$sqlInsertForNewDate");

                    for($i=0;$i<count($newArrayExistsDates);$i++){
                        $sqlUpdateExistsDates = "UPDATE calendar SET count_date = count_date+1 WHERE id_type = '$type_id' AND date = '$newArrayExistsDates[$i]'";
                        $pdo->query("$sqlUpdateExistsDates");
                    }
                    $sql = $this->getInsertSqlQuery($data);
                    $pdo->query("$sql");
                    setcookie('message-create', '<div class="alert alert-success">Booking was successfully created.</div>');
                    header("Location: /project3-1/booking/admin/views/booking/index.php");
                } else{
                        echo '<div class="alert alert-danger" data-result="error">There are no free items for booking on this time!</div>';
                }
            } else {
                $sqlAllNewDates = Calendar::getSqlStringForNewDate($arrayRequestedDates, $type_id);
                $pdo->query("$sqlAllNewDates");
                $sql = $this->getInsertSqlQuery($data);
                $pdo->query("$sql");
                setcookie('message-create', '<div class="alert alert-success">Booking was successfully created.</div>');
                header("Location: /project3-1/booking/admin/views/booking/index.php");
            }
        }
   }
    public function getBookings()
    {
            $pdo = $this->createPdo();
            $sql = "SELECT * FROM booking";
            return $pdo->query("$sql")->fetchAll();
    }
    public function getBookingsWithoutOffset()
    {
        $pdo = $this->createPdo();
        $sql = "SELECT * FROM booking ORDER BY id DESC LIMIT 5";
        return $pdo->query("$sql")->fetchAll();
    }
    public function getBookingsWithOffset($offset)
    {
        $pdo = $this->createPdo();
        $sql = "SELECT * FROM booking ORDER BY id DESC LIMIT 5 OFFSET ".$offset ;
//        var_dump($sql);die;
        return $pdo->query("$sql")->fetchAll();
    }
    public function getCountBookings(){
        $pdo = $this->createPdo();
        $sql = "SELECT * FROM booking";
        return count($pdo->query("$sql")->fetchAll());

    }
    public function getOneBooking($id)
    {
        $pdo = $this->createPdo();
        $sql = "SELECT * FROM booking WHERE id='$id'";
        return $pdo->query("$sql")->fetch(PDO::FETCH_NAMED);
    }
    public function updateBooking($id)
    {
        $pdo = $this->createPdo();
        if (isset($_POST['formSent'])) {
            $data = $this->defineVariables();
            $sql = "UPDATE booking SET name='".$data['name']."', email='".$data['email']."', phone='".$data['phone']."', type_id='".$data['type_id']."', type='".$data['type']."', date_start='".$data['date_start']."', count_days='".$data['count_days']."', data='".$data['data']."'  WHERE id='$id'";
            $pdo->query("$sql");
            setcookie('message-update', '<div class="alert alert-success">Booking was successfully updated.</div>');
            header("Location: /project3-1/booking/admin/views/booking/index.php");
        }
    }
    public function deleteBooking($id){
        $pdo = $this->createPdo();
        $type_id = $this->getTypeIdByBookingId($id);
        $oneBooking = $this->getOneBooking($id);
        $startOneBooking = $oneBooking['date_start'];
        $countDaysOneBooking = $oneBooking['count_days'];
        $startDay = Calendar::getDbDateFormat($startOneBooking);
        $arrayDates = Calendar::getDatesRangeArray($startDay,$countDaysOneBooking);
        for($i=0;$i<count($arrayDates);$i++){
            $sqlReduceCount = "UPDATE calendar SET count_date = count_date-1 WHERE id_type = '$type_id' AND date = '$arrayDates[$i]'";
            $pdo->query("$sqlReduceCount");
        }
        $delete_sql = "DELETE FROM booking WHERE id=".$id;
        $resultDel = $pdo->query("$delete_sql");
        setcookie('message-delete', '<div class="alert alert-success">Booking was successfully deleted.</div>');
        header("Location: /project3-1/booking/admin/views/booking/index.php");
    }
    public function getTypeIdByBookingId($id){
        $pdo = $this->createPdo();
        $sql = "SELECT type_id FROM booking WHERE id='$id'";
        return $pdo->query("$sql")->fetch()['type_id'];
    }
    public function getInsertSqlQuery($data){
        return "INSERT INTO booking (name, email, phone, type_id, type, date_start, count_days, date_create, data) VALUES ('".$data['name']."', '".$data['email']."', '".$data['phone']."', '".$data['type_id']."', '".$data['type']."', '".$data['date_start']."', '".$data['count_days']."', '".$data['date_create']."', '".$data['data']."')";
    }
    public function get30DaysEarly($date){
        $newDate = date_create($date);
        date_modify($newDate, '-30 days');
        return date_format($newDate, 'd-m-Y');
}
public function getArrayForActiveBookings()
{
    $pdo = $this->createPdo();
    $dateNow = date('Y-m-d');
    $date30 = $this->get30DaysEarly($dateNow);
    $sql30days = "SELECT * FROM booking WHERE date_start BETWEEN '$date30' AND '$dateNow'";
    $resultBookings30Days = $pdo->query("$sql30days")->fetchAll();
    $arrayBookingActiveToday = array();
    foreach($resultBookings30Days as $oneBooking){
        $endDateBooking = Calendar::getEndDateForDb($oneBooking['date_start'], $oneBooking['count_days']);
        if($endDateBooking>=$dateNow){
            array_push($arrayBookingActiveToday, $oneBooking);
        }
    }
    return $arrayBookingActiveToday;
}
public function getArrayForLastBookings()
{
    $pdo = $this->createPdo();
    $sql = "SELECT * FROM booking ORDER BY id DESC LIMIT 3";
    return $pdo->query("$sql")->fetchAll();
}
}
