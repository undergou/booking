$(document).ready(function(){
$('#get-calendar-ajax').click(function(e){
            $('#result').html('');
            e.preventDefault();
            var data = $('#form-date-calendar').serialize();
            $.ajax({
                url: '/project3-1/booking/php/ajax-calendar.php',
                type: 'POST',
                data: data,
                success: function(response){
                    var obj = JSON.parse(response);
                    var table = document.createElement('table');
                    var trHead = document.createElement('tr');
                    var tdLeftUp = document.createElement('td');
                    trHead.append(tdLeftUp);
                    for(var i = 0; i<obj.arrayDates.length; i++){
                        var tdHead = document.createElement('td');
                        var dateFull = new Date(obj.arrayDates[i].slice(0,4), obj.arrayDates[i].slice(5,7)-1, obj.arrayDates[i].slice(8,10));
                        var day = dateFull.getDay();
                        if(day==6 || day==0){
                            tdHead.setAttribute('class', 'weekend');
                        }
                        tdHead.innerHTML = obj.arrayDates[i];
                        trHead.append(tdHead);
                    }
                    table.append(trHead);
                    for(var i = 0; i<obj.allBookingTypes.length;i++){
                        var tr = document.createElement('tr');
                        var tdLeft = document.createElement('td');
                        tdLeft.innerHTML = obj.allBookingTypes[i]['title'];
                        tr.append(tdLeft);
                        for(var j=0;j<obj.arrayDates.length; j++){
                            if(obj.arrayComplex[i][j]){
                                if (obj.arrayComplex[i][j] == 1){
                                    var td = document.createElement('td');
                                    td.setAttribute('class', 'not-available');
                                } else{
                                    var td = document.createElement('td');
                                    td.innerHTML = parseInt(obj.arrayComplex[i][j])-1;
                                }
                            } else {
                                var td = document.createElement('td');
                                td.innerHTML = obj.allBookingTypes[i]['count'];
                            }
                            tr.append(td);
                        }
                        table.append(tr);
                    }
                    $('#result').html(table);
                }
            });
});
});