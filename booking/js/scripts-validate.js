var btnSend = document.querySelector('#button-request');
var btnAjaxCalendar = document.querySelector('#get-calendar-ajax');
var necessary = document.querySelectorAll('.necessary');
var datepickerStart = document.querySelector('#datepicker-start');
var datepickerEnd = document.querySelector('#datepicker-end');
if(datepickerEnd){
    datepickerEnd.addEventListener('blur', validateRangeDate);
}
if(datepickerStart){
    datepickerStart.addEventListener('blur', validateRangeDate);
}


for(var i=0;i<necessary.length;i++){
    necessary[i].addEventListener('blur', validateData);
}
function createError(text, el){
    clearErrors(el);
    var error = document.createElement('div');
    error.setAttribute('class', 'error-validate');
    error.innerHTML = text;
    el.parentNode.appendChild(error);
    if(btnSend){
        btnSend.setAttribute('disabled', 'disabled');
    }
    if(btnAjaxCalendar){
        btnAjaxCalendar.setAttribute('disabled', 'disabled');
    }

}
function clearErrors(el){
    if(el.nextElementSibling){
        el.nextElementSibling.remove();
    }
}
function validateData(){

    if(!this.value){
        var text = 'Cannot be blank';
        createError(text, this);
    } else {
        if (this.nextElementSibling){
            this.nextElementSibling.remove();
            if(btnSend){
                btnSend.removeAttribute('disabled');
            }
        }
        if(this.dataset.type == 'Date'){
            validateDate(this.value, this);
        } else if(this.dataset.type == 'Integer'){
            validateNumber(this.value, this);
        }
        switch(this.name){
            case "days": validateDays(this.value, this);
                break;
            case "phone": validatePhone(this.value, this);
                break;
            case "email": validateEmail(this.value, this);
                break;
            case "start-date": validateDate(this.value, this);
                break;
        }
    }
}
function validateEmail(value,el){
var regEmail = /.+@.+\..+/;
    if(!value.match(regEmail)){
        var text = "Enter the correct email address";
        createError(text, el);
        return false;
    } else {
        return true;
    }
}
function validatePhone(value, el){
    var regPhone = /^[0-9\- +]+$/;
    if(!value.match(regPhone)){
        var text = "Enter the correct phone number";
        createError(text, el);
    }
}
function validateDate(value, el){
    var regDate = /^([0][1-9]|[1-2][0-9]|[3][0-1])\-([0][1-9]|[1][0-2])\-[2][0][1][789]$/;
    if(!value.match(regDate)){
        var text = "Enter correct date format (dd-mm-yyyy) until 2019";
        createError(text, el);
    } else {
        var secNow = getSecNow();
        var startDate = getNumbersForGetTime(value);
        var secStart = getSecDate(startDate);
        if(secStart<secNow){
            var text = "Date must not be earlier than tomorrow";
            createError(text, el);
        }
    }
}
function validateDays(value, el){
    var regDays = /^[0-9]+$/;
    if(!value.match(regDays) || value<1 || value>30){
        var text = "Amount of days must be a number less than 30 and more than 0"
        createError(text, el);
    }
}
function validateNumber(value, el){
    var regDays = /^[0-9]+$/;
    if(!value.match(regDays)){
        var text = "This field must contain a number"
        createError(text, el);
    }
}
function validateRangeDate(){
    var arrayDate = getNumbersForGetTime(this.value);
    var arrayStartDate = getNumbersForGetTime(datepickerStart.value);
    var arrayEndDate = getNumbersForGetTime(datepickerEnd.value);

    var secNow = getSecNow();

    var secOfDate= getSecDate(arrayDate);
    var secOfDateStart = getSecDate(arrayStartDate);
    var secOfDateEnd = getSecDate(arrayEndDate);

    if(!this.value){
        var text = 'Cannot be blank';
        createError(text, this);
    } else if(secOfDate<=secNow){
        var text = "Date must not be earlier than tomorrow";
        createError(text, this);
    } else if(secOfDateEnd<=secOfDateStart){
        var text = "End Date must be later than Start Date";
        createError(text, datepickerEnd);
    }  else if (this.nextElementSibling){
        this.nextElementSibling.remove();
        if(btnAjaxCalendar){
            btnAjaxCalendar.removeAttribute('disabled');
        }
    }
    if(datepickerStart.value && datepickerEnd.value){
        var range = parseInt(secOfDateEnd)-parseInt(secOfDateStart);
        var countDays = range/1000/60/60/24;
        if(countDays>10){
            var text = "Range can not be more than 10 days";
            createError(text, datepickerEnd);
        }
    }
}
function getNumbersForGetTime(dateString){
    var arrayDate = [];
    arrayDate['year'] = parseInt(dateString.slice(-4));
    arrayDate['month'] = parseInt(dateString.slice(3,5))-1;
    arrayDate['date'] = parseInt(dateString.slice(0,2));
    return arrayDate;
}
function getSecDate(array){
    var newDate = new Date(array['year'],array['month'],array['date']);
    return newDate.getTime();
}
function getSecNow(){
    var dateNow = new Date();
    return dateNow.getTime();
}