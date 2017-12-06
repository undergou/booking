<?php
require_once (__DIR__ .'/Model.php');
require_once (__DIR__ .'/BookingType.php');
require_once (__DIR__ .'/Calendar.php');

class Booking extends Model
{
    public function defineVariables()
    {
        $data['name'] = $_POST["name"];
        $data['email'] = $_POST["email"];
        $data['phone'] = $_POST["phone"];
        $data['type_id'] = $_POST["type_id"];
        $data['type'] = BookingType::getTypeTitleById($data['type_id']);
        $data['date_start_db'] = Calendar::getDbDateFormat($_POST['date_start']);
        $data['date_start'] = $_POST['date_start'];
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
            if($this->increaseCountInCalendar($data)){
                $sql = $this->getInsertSqlQuery($data);
                $pdo->query("$sql");
                $this->getMessageCreate();
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
        $sql = "SELECT * FROM booking ORDER BY id DESC LIMIT 5 OFFSET ".$pdo->quote( $offset ) ;
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
        $sql = "SELECT * FROM booking WHERE id=".$pdo->quote( $id );
        return $pdo->query("$sql")->fetch(PDO::FETCH_NAMED);
    }
    public function updateBooking($id)
    {
        if (isset($_POST['formSent'])) {
            $oneBooking = $this->getOneBooking($id);
            $data = $this->defineVariables();
            if($data['date_start'] != $oneBooking['date_start'] || $data['count_days'] != $oneBooking['count_days'] || $data['type_id'] != $oneBooking['type_id']){
                $this->reduceCountInCalendar($id);
                    if($this->increaseCountInCalendar($data)){
                        $this->completeSqlUpdate($data, $id);
                        $this->getMessageUpdate();
                    } else {
                        $this->increaseBack($id);
                    }
            } else{
                $this->completeSqlUpdate($data, $id);
                $this->getMessageUpdate();
            }
        }
    }
    public function completeSqlUpdate($data, $id)
    {
        $pdo = $this->createPdo();
        $date = date_create($data['date_start']);
        $data['new_date'] = date_format($date, 'Y-m-d');
        $sql = "UPDATE booking SET name=".$pdo->quote( $data['name'] ).", email=".$pdo->quote( $data['email'] ).", phone=".$pdo->quote( $data['phone'] ).", type_id=".$pdo->quote( $data['type_id'] ).", type=".$pdo->quote( $data['type'] ).", date_start=".$pdo->quote( $data['new_date'] ).", count_days=".$pdo->quote( $data['count_days'] ).", data=".$pdo->quote( $data['data'] )."  WHERE id=".$pdo->quote( $id );
        $pdo->query("$sql");
    }
    public function deleteBooking($id){
        $pdo = $this->createPdo();
        $this->reduceCountInCalendar($id);
        $delete_sql = "DELETE FROM booking WHERE id=".$pdo->quote( $id );
        $pdo->query("$delete_sql");
        setcookie('message-delete', '<div class="alert alert-success">Booking was successfully deleted.</div>');
        header("Location: /project3-1/booking/admin/views/booking/index.php");
    }
    public function getTypeIdByBookingId($id){
        $pdo = $this->createPdo();
        $sql = "SELECT type_id FROM booking WHERE id=".$pdo->quote( $id );
        return $pdo->query("$sql")->fetch()['type_id'];
    }
    public function getInsertSqlQuery($data){
        $pdo = $this->createPdo();
        return "INSERT INTO booking (name, email, phone, type_id, type, date_start, count_days, date_create, data) VALUES (".$pdo->quote($data['name']).", ".$pdo->quote($data['email']).", ".$pdo->quote($data['phone']).", ".$pdo->quote($data['type_id']).", ".$pdo->quote($data['type']).", ".$pdo->quote($data['date_start_db']).", ".$pdo->quote($data['count_days']).", ".$pdo->quote($data['date_create']).", ".$pdo->quote($data['data']).")";
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
    $sql30days = "SELECT * FROM booking WHERE date_start BETWEEN ".$pdo->quote( $date30 )." AND ".$pdo->quote( $dateNow );
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
public function reduceCountInCalendar($id)
{
    $pdo = $this->createPdo();
    $type_id = $this->getTypeIdByBookingId($id);
    $oneBooking = $this->getOneBooking($id);
    $startOneBooking = $oneBooking['date_start'];
    $countDaysOneBooking = $oneBooking['count_days'];
    $arrayDates = Calendar::getDatesRangeArray($startOneBooking,$countDaysOneBooking);
    for($i=0;$i<count($arrayDates);$i++){
        $sqlReduceCount = "UPDATE calendar SET count_date = count_date-1 WHERE id_type = ".$pdo->quote( $type_id )." AND date = '$arrayDates[$i]'";
        $pdo->query("$sqlReduceCount");
    }
}
    public function increaseBack($id)
    {
        $pdo = $this->createPdo();
        $type_id = $this->getTypeIdByBookingId($id);
        $oneBooking = $this->getOneBooking($id);
        $startOneBooking = $oneBooking['date_start'];
        $countDaysOneBooking = $oneBooking['count_days'];
        $arrayDates = Calendar::getDatesRangeArray($startOneBooking,$countDaysOneBooking);
        for($i=0;$i<count($arrayDates);$i++){
            $sqlReduceCount = "UPDATE calendar SET count_date = count_date+1 WHERE id_type = ".$pdo->quote( $type_id )." AND date = '$arrayDates[$i]'";
            $pdo->query("$sqlReduceCount");
        }
    }
public function increaseCountInCalendar($data)
{
    $pdo = $this->createPdo();
    $intCountDays = (int) $data['count_days'];
    $type_id = $data['type_id'];
    $startDateForDb = Calendar::getDateFormatForDB($data['date_start']);
    $endDateForDb = Calendar::getEndDateForDb($startDateForDb, $intCountDays);
    $arrayRequestedDates = Calendar::getDatesRangeArray($startDateForDb, $intCountDays);
    $modelBookingType = new BookingType();
    $countBookingType = $modelBookingType->getOneBookingType($type_id)['count'];
    $sqlCheckCalendar = "SELECT * FROM calendar WHERE id_type=".$pdo->quote( $type_id )." AND date BETWEEN ".$pdo->quote( $startDateForDb )." AND ".$pdo->quote( $endDateForDb );
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
                $sqlUpdateExistsDates = "UPDATE calendar SET count_date = count_date+1 WHERE id_type = ".$pdo->quote( $type_id )." AND date = '$newArrayExistsDates[$i]'";
                $pdo->query("$sqlUpdateExistsDates");
            }
            return true;
        } else{
            echo '<div class="alert alert-danger" data-result="error">There are no free items for booking on this time!</div>';
            return false;
        }
    } else {
        $sqlAllNewDates = Calendar::getSqlStringForNewDate($arrayRequestedDates, $type_id);
        $pdo->query("$sqlAllNewDates");
        return true;
    }
}
    public function getMessageCreate()
    {
        setcookie('message-create', '<div class="alert alert-success">Booking was successfully created.</div>');
        header("Location: /project3-1/booking/admin/views/booking/index.php");
    }

    public function getMessageUpdate()
    {
        setcookie('message-update', '<div class="alert alert-success">Booking was successfully updated.</div>');
        header("Location: /project3-1/booking/admin/views/booking/index.php");
    }
}
