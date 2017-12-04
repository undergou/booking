<?php
require_once('admin/models/BookingType.php');
require_once('admin/models/UserField.php');

class BookingHelper
{
    public function getBookingHelper(){
        $model = new BookingType();
        $result = $model->getAvailableBookingTypes();
        $userField = new UserField();
        $alluserfields = $userField->getAvailableUserFields();

        echo '<div class="booking">
                <form action="index.php" method="POST" id="formx">
                    <label>Name <br><div class="wrap-for-input"><input type="text" id="order-name" class="necessary" name="name" placeholder="Name..."></div></label>
                    <br><br><label>Email <br><div class="wrap-for-input"><input type="text" id="order-email" class="necessary" name="email" placeholder="Email..."></div></label>
                    <br><br><label>Phone <br><div class="wrap-for-input"><input type="text" id="order-phone" class="necessary" name="phone" placeholder="Phone..."></div></label>
                    <br><br><label>Booking element
                    <br><div class="wrap-for-input"><select name="booking-element" class="necessary">';
                            foreach($result as $row){
                                echo '<option value="'.$row['id'].'">'.$row['title'].'</option>';
                            }

                    echo '</select></div></label>
                    <br><br><label>Start Date <br><div class="wrap-for-input"><input type="text" id="datepicker0" class="necessary" name="start-date" placeholder="Start Date..."></div></label>
                    <br><br><label>Amount of days <br><div class="wrap-for-input"><input type="text" id="order-count-days" class="necessary" name="days" placeholder="Amount of days..."></div></label>';
                    foreach($alluserfields as $oneField){
                        echo '<br><br><label>'.$oneField["placeholder"].'<br><div class="wrap-for-input"><input '.(($oneField['type']=="Date")? "id='datepicker".$oneField['id']."'":"").' type="text" '. (($oneField["necessary"])? "class='necessary'": "").' name="user-field['.$oneField["id"].']" placeholder="'.$oneField["placeholder"].'..." data-type="'.$oneField["type"].'"></div></label>';
                    }
                    echo '<br><br><div id="wrap-for-button"><button id="button-request" >Send</button></div>
                </form>
                <div id="result"></div>
            </div>';
    }
}