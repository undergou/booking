<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Calendar</title>

<?php
require_once('../../php/head-styles.php');
?>
<div class="admin-content">
    <h1>Booking Calendar!</h1>

    <?php
    require_once('../../models/BookingType.php');
    require_once('../../models/Calendar.php');
    $model = new BookingType();
    $modelCalendar = new Calendar();
    $dateNow = date('Y-m-d');
    $allBookingTypes = $model->getBookingTypes();
    $arrayDates = $modelCalendar->getDatesRangeArray($dateNow, 10);
    $pdo = $model->createPdo();
    ?>

    <div class="choose-date">
        <form action="index.php" method="POST" id="form-date-calendar">
            <label>Select start date: <br><div class="wrap-for-input"><input id="datepicker-start" type="text" name="start-date"></div></label>
            <br><br><label>Select end date: <br><div class="wrap-for-input"><input id="datepicker-end" type="text" name="end-date"></div></label>
            <button id="get-calendar-ajax">Choose Dates</button>
        </form>
    </div>

    <div id="result">
        <table>
            <tr><?php
                    echo '<td></td>';
                    for($i=0;$i<count($arrayDates);$i++){
                        if($modelCalendar->getDayTitle($arrayDates[$i]) == 6 || $modelCalendar->getDayTitle($arrayDates[$i]) == 0){
                            echo '<td class="weekend">'.$arrayDates[$i].'</td>';
                        } else{
                            echo '<td>'.$arrayDates[$i].'</td>';
                        }
                    }
                ?></tr>
                <?php
                    foreach($allBookingTypes as $one){
                        echo '<tr><td>'.$one["title"].'</td>';
                        $datesOfBookingType = $modelCalendar->getDatesOfBookingType($dateNow, $arrayDates[9], $one['id']);
                        $arrayComplex = $modelCalendar->getArraysOneDate($datesOfBookingType, $arrayDates, $one);
                        for($i=0;$i<count($arrayComplex);$i++){
                            if($arrayComplex[$i]){
                                if($arrayComplex[$i] == 1){
                                    $arrayComplex[$i]--;
                                    echo '<td class="not-available"></td>';
                                } else{
                                    $arrayComplex[$i]--;
                                    echo '<td>'.$arrayComplex[$i].'</td>';
                                }
                            }
                            else{
                                echo '<td>'.$one['count'].'</td>';
                            }
                        }
                        echo '</tr>';
                    }
                ?>
        </table>
    </div>
</div>

<?php
require_once('../../php/foot.php');
//                                if($arrayDates[$i] == $oneDateBookingType['date']){
//                                    $availableItems = $one["count"] - $oneDateBookingType['count_date'];
//                                    if($availableItems == 0){
//                                        echo '<td class="not-available"></td>';
//                                    } else{
//                                        echo '<td>'.$availableItems.'</td>';
//                                    }
//                                } else{
//                                    echo '<td>'.$one["count"].'</td>';
//                                }
//                        }
?>
