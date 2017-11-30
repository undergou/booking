<?php
require_once ('Model.php');

class Calendar extends Model
{
    public function getCountDays($date1, $date2){
        $diff = strtotime($date2) - strtotime($date1);
       return $diff/60/60/24;
    }
    public static function getDbDateFormat($date){
        $year = substr($date, -4);
        $month = substr($date, 3,2);
        $day = substr($date, 0,2);
        return $year.'-'.$month.'-'.$day;
    }
    public static function getEndDateForDb($startDate, $countDays){
        $count = $countDays-1;
        $date = date_create($startDate);
            if($countDays==1){
                $modify = '1 day';
            } else {
                $modify = $count.' days';
            }
        date_modify($date, $modify);
        return date_format($date, 'Y-m-d');
    }
    public static function getDatesRangeArray($date1, $count){
//        $t = new self();
//        $countDays = $t->getCountDays($date1, $date2);
//        $startDateDb = $t->getDbDateFormat($date1);
//        var_dump($countDays);die;
        $array = array();
//        array_push($array, $date1);
        for($i=0;$i<$count;$i++){
            $date = date_create($date1);
            if($i==1){
                $modify = '1 day';
            } else {
                $modify = $i.' days';
            }
            date_modify($date, $modify);
            $newDate = date_format($date, 'Y-m-d');
            array_push($array, $newDate);
        }
        return $array;
    }
//    public function getMinusDatesRangeArray($date1, $count){
//        $array = array();
//        for($i=0;$i<$count;$i++){
//            $date = date_create($date1);
//            if($i==1){
//                $modify = '-1 day';
//            } else {
//                $modify = '-'.$i.' days';
//            }
//            date_modify($date, $modify);
//            $newDate = date_format($date, 'Y-m-d');
//            array_push($array, $newDate);
//        }
//        return $array;
//    }
    public static function getNotExistsDates($existsDates, $allDates){
        $newArray = array();
        for($i=0;$i<count($allDates);$i++){
            $isExist = false;
            for($j=0;$j<count($existsDates);$j++){
                if($existsDates[$j] == $allDates[$i]){
                    $isExist = true;
                }
            }
            if(!$isExist){
                array_push($newArray, $allDates[$i]);
            }
        }
        return $newArray;
    }
    public static function getSqlStringForNewDate($datesArray, $type_id){
        $stringForNewDates ='';
        for($i=0;$i<count($datesArray);$i++){
            $stringForNewDates .= " ('".$datesArray[$i]."', '".$type_id."', '". 1 ."'),";
        }
        $stringForSqlNewDates = substr($stringForNewDates, 0, -1);
        return "INSERT INTO calendar (date, id_type, count_date) VALUES".$stringForSqlNewDates;
    }
    public function getDatesOfBookingType($date1, $date2, $id)
    {
        $pdo = $this->createPdo();
        $sql = "SELECT * FROM calendar WHERE id_type='$id' AND date BETWEEN '$date1' AND '$date2'";
        return $pdo->query("$sql")->fetchAll();
    }
    public function getDayTitle($date)
    {
        $dateArray = explode("-", $date);
        return date("w", mktime(0, 0, 0, $dateArray[1], $dateArray[2], $dateArray[0]));
    }
    public function getArraysOneDate($datesOfBookingType, $arrayDates, $one){
        $arrayOne = array();
        foreach($datesOfBookingType as $key => $oneDateBookingType) {
            $arrayOne[$key] = array();
            for($i=0;$i<count($arrayDates);$i++){
                if($arrayDates[$i] == $oneDateBookingType['date']){
                    $availableItems = $one["count"] - $oneDateBookingType['count_date']+1;
                    array_push($arrayOne[$key], $availableItems);
                } else {
                    array_push($arrayOne[$key], false);
                }
            }
        }
        $arrayComplex = $this->getComplexArrayDates($arrayOne, count($arrayDates));
        return $arrayComplex;
    }
    public function getComplexArrayDates($arrayOne, $countDays){
        $arrayComplex = array();
        for($i=0;$i<$countDays;$i++){
            array_push($arrayComplex, false);
        }
        for($i=0;$i<count($arrayOne);$i++){
            for($j=0;$j<count($arrayOne[$i]);$j++){
                if($arrayOne[$i][$j]){
                    $arrayComplex[$j] = $arrayOne[$i][$j];
                }
            }
        }
        return $arrayComplex;
    }
}
?>