<?php

require_once (__DIR__ .'\../config.php');
require_once (__DIR__ .'\../admin/models/BookingType.php');
require_once (__DIR__ .'\../admin/models/Calendar.php');
require_once (__DIR__ .'\php-validation.php');

$orderName = $_POST['name'];
$orderEmail = $_POST['email'];
$orderPhone = $_POST['phone'];
$orderBookingElement = $_POST['booking-element'];
$bookingTypeTitle = BookingType::getTypeTitleById($orderBookingElement);
$orderStartDate = $_POST['start-date'];
$orderCountDays = $_POST['days'];
$orderDate = date('d-m-Y');
if(isset($_POST['user-field'])){
    $serializeData = implode(', ',$_POST['user-field']);
} else{
    $serializeData = "";
}

$intCountDays = (int) $orderCountDays;
$startDateForDb = Calendar::getDbDateFormat($orderStartDate);
$endDateForDb = Calendar::getEndDateForDb($startDateForDb, $intCountDays);
$arrayRequestedDates = Calendar::getDatesRangeArray($startDateForDb, $intCountDays);
$modelBookingType = new BookingType();
$countBookingType = $modelBookingType->getOneBookingType($orderBookingElement)['count'];
if($orderName && $orderEmail && $orderPhone && $orderCountDays && $orderStartDate){
    if(!validateEmail($orderEmail)){
        $arr = ['message' => 'Enter correct email address', 'classStyle' =>'alert-danger', 'id'=> 'result-error'];
        echo json_encode($arr);
    } elseif(!validatePhone($orderPhone)){
        $arr = ['message' => 'Enter correct phone number', 'classStyle' =>'alert-danger', 'id'=> 'result-error'];
        echo json_encode($arr);
    } elseif(!validateDays($orderCountDays)){
        $arr = ['message' => 'Enter correct amount of days (more than 0, less than 30)', 'classStyle' =>'alert-danger', 'id'=> 'result-error'];
        echo json_encode($arr);
    } elseif(!validateDate($orderStartDate)){
        $arr = ['message' => 'Enter date in correct format (dd-mm-yyy)', 'classStyle' =>'alert-danger', 'id'=> 'result-error'];
        echo json_encode($arr);
    } else{
        $sqlCheckCalendar = "SELECT * FROM calendar WHERE id_type='$orderBookingElement' AND date BETWEEN '$startDateForDb' AND '$endDateForDb'";
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
                $sqlInsertForNewDate = Calendar::getSqlStringForNewDate($arrayWithoutMatchedDates, $orderBookingElement);
                $pdo->query("$sqlInsertForNewDate");
                for($i=0;$i<count($newArrayExistsDates);$i++){
                    $sqlUpdateExistsDates = "UPDATE calendar SET count_date = count_date+1 WHERE id_type = '$orderBookingElement' AND date = '$newArrayExistsDates[$i]'";
                    $pdo->query("$sqlUpdateExistsDates");
                }
//                $insertSql = "INSERT INTO booking (type_id, type, name, email, phone, date_start, count_days, date_create, data)" . "VALUES ('{$orderBookingElement}', '{$bookingTypeTitle}', '{$orderName}', '{$orderEmail}', '{$orderPhone}', '{$startDateForDb}', '{$orderCountDays}', '{$orderDate}', '{$serializeData}')";
                $insertSql = "INSERT INTO booking (type_id, type, name, email, phone, date_start, count_days, date_create, data)"."VALUES (".$pdo->quote( $orderBookingElement ).", ".$pdo->quote( $bookingTypeTitle ).", ".$pdo->quote( $orderName ).", ".$pdo->quote( $orderEmail ).", ".$pdo->quote( $orderPhone ).", ".$pdo->quote( $startDateForDb ).", ".$pdo->quote( $orderCountDays ).", ".$pdo->quote( $orderDate ).", ".$pdo->quote( $serializeData ).")";
                $rows = $pdo->query("$insertSql");
//                mail($orderEmail, 'Booking success', 'Your booking was successfully adopted!');
//                mail($adminEmail, 'New booking!', 'There is a new booking!');
                $arr = ['id' => 'result-success', 'message' => 'Your booking finished successfully!', 'classStyle' =>'alert-success'];
                echo json_encode($arr);
            } else{
                $arr = ['message' => 'There are no free items for booking on this time!', 'classStyle' =>'alert-danger', 'id'=> 'result-error'];
                echo json_encode($arr);
            }
        } else {
            $sqlAllNewDates = Calendar::getSqlStringForNewDate($arrayRequestedDates, $orderBookingElement);
            $pdo->query("$sqlAllNewDates");
//            $insertSql = "INSERT INTO booking (type_id, type, name, email, phone, date_start, count_days, date_create, data)" . "VALUES ('{$orderBookingElement}', '{$bookingTypeTitle}', '{$orderName}', '{$orderEmail}', '{$orderPhone}', '{$startDateForDb}', '{$orderCountDays}', '{$orderDate}', '{$serializeData}')";
            $insertSql = "INSERT INTO booking (type_id, type, name, email, phone, date_start, count_days, date_create, data)"."VALUES (".$pdo->quote( $orderBookingElement ).", ".$pdo->quote( $bookingTypeTitle ).", ".$pdo->quote( $orderName ).", ".$pdo->quote( $orderEmail ).", ".$pdo->quote( $orderPhone ).", ".$pdo->quote( $startDateForDb ).", ".$pdo->quote( $orderCountDays ).", ".$pdo->quote( $orderDate ).", ".$pdo->quote( $serializeData ).")";
            $rows = $pdo->query("$insertSql");
            //                mail($orderEmail, 'Booking success', 'Your booking was successfully adopted!');
//                mail($adminEmail, 'New booking!', 'There is a new booking!');
            $arr = ['message' => 'Your booking finished successfully!', 'classStyle' =>'alert-success', 'id'=> 'result-success'];
            echo json_encode($arr);
        }
    }
} else {
    $arr = ['message' => 'There are empty fields that are necessary to fill', 'classStyle' =>'alert-danger', 'id'=> 'result-error'];
    echo json_encode($arr);
}



