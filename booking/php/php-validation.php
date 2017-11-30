<?php

function validateEmail($orderEmail){
    return filter_var($orderEmail, FILTER_VALIDATE_EMAIL);
}
function validatePhone($orderPhone){
    if(preg_match('/^[0-9\- +]+$/', $orderPhone)){
        return true;
    } else {
        return false;
    }
}
function validateDays($orderCountDays){
    if(preg_match('/^[0-9]+$/', $orderCountDays) && $orderCountDays > 0 && $orderCountDays < 30){
        return true;
    } else {
        return false;
    }
}
function validateDate($orderStartDate){
    if(preg_match('/^([0][1-9]|[1-2][0-9]|[3][0-1])\-([0][1-9]|[1][0-2])\-[2][0][1][789]$/', $orderStartDate)){
        return true;
    } else {
        return false;
    }
}