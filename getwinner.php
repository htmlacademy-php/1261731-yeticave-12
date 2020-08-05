<?php
require_once('vendor/autoload.php');
require_once('functions/config.php');


$array_id_winner_lots = getIdWinnerLots();
foreach($array_id_winner_lots as $value) {
    foreach($value as $value1) {        
        $last_rate_lots = getLastRateForWinnerLot($value1);        
        if (!empty($last_rate_lots)) {           
            inputUseridInLotsTable($last_rate_lots["user_id"], $last_rate_lots["lot_id"]);
            $information_user = getUserInformation($last_rate_lots["user_id"]);
            
            $info_about_lot = getInfoLotForEmail($last_rate_lots["lot_id"]);
            $text_messge = includeTemplate('email.php', 
            [
                "user_name" => $information_user["name"],
                "lot_name" => $info_about_lot["name"],
                "lot_id" => $last_rate_lots["lot_id"]
            ]);
            
            sendEmailToUser($text_messge, $information_user["email"], $information_user["name"]);
            
    }
}

}



