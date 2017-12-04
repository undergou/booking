<?php

require_once ('../config.php');
require_once ('../admin/models/Calendar.php');
require_once ('../admin/models/BookingType.php');

$startDate = $_POST['start-date'];
$endDate = $_POST['end-date'];


$modelCalendar = new Calendar();
$modelBookingType = new BookingType();

$startDateForDb = $modelCalendar->getDbDateFormat($startDate);
$endDateForDb = $modelCalendar->getDbDateFormat($endDate);

$pdo = $modelCalendar->createPdo();
$allBookingTypes = $modelBookingType->getBookingTypes();
$countDays = $modelCalendar->getCountDaysForCalendar($startDate, $endDate);
$arrayDates = $modelCalendar->getDatesRangeArray($startDate, $countDays);

foreach($allBookingTypes as $key => $one){
    $datesOfBookingType = $modelCalendar->getDatesOfBookingType($startDateForDb, $endDateForDb, $one['id']);
    $arrayComplex[$key] = $modelCalendar->getArraysOneDate($datesOfBookingType, $arrayDates, $one);
}

$arr = ['allBookingTypes' => $allBookingTypes, 'arrayDates' => $arrayDates, 'arrayComplex' => $arrayComplex];
$jsonData = json_encode($arr);
echo $jsonData;

