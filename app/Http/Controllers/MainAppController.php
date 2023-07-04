<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use App\Traits\UssdMenus;
use Illuminate\Support\Facades\Hash;

class MainAppController extends Controller
{
    use UssdMenus;

    public function ussdRequestHandler(Request $request)
    {
        $sessionId   = $request["sessionId"];
        $serviceCode = $request["serviceCode"];
        $phone       = str_replace("+", "", $request["phoneNumber"]);
        $text        = $request["text"];
        $exploded_text = explode("*", $text);


        if (empty($text)) {
            return $this->showMainMenu();
        } elseif ($exploded_text[0] == "1") {
            return $this->handleSkizaTune($phone, $exploded_text);
        } elseif ($exploded_text[0] == "2") {
            return  $this->handleAdvanceService($phone, $exploded_text);
        } else {
            return $this->showWrongInputMenu();
        }
    }

    private function handleSkizaTune($phone, $exploded_text)
    {
        $size = sizeof($exploded_text);
        if ($size == 1) { //1
            return $this->showSkizaMainMenu();
        } else if ($size == 2 and $exploded_text[1] == "1") { //1*1 Search menu
            //search menu
            return $this->showSearchMenu();
        } else if ($size == 3 and $exploded_text[1] == "1" and $exploded_text[2] == "1") { //1*1*1 Search artist
            //search by artist
            return $this->showSearchByArtistMenu();
        } else if ($size == 3 and $exploded_text[1] == "1" and $exploded_text[2] == "2") { //1*1*1 Search artist
            //search by song
            return  $this->showSearchBySongMenu();
        }else{
            return $this->showSomethingBadMenu("Skiza services are currently down. Please try again later");
        }
        //TODO Handle other paths
    }

    private function handleAdvanceService($phone, $exploded_text) //check if phone is registered and show the right pin menu
    {
        $size = sizeof($exploded_text);
        $artist = Artist::where(['phone' => $phone])->first();
       // dd($artist);
        if ($size == 1) { //1 ->>ask for new pin setup or enter a pin
            if ($artist == null) {
                return $this->showSomethingBadMenu("You have not been registered to use this service.");
            } else if ($artist->pin != null) { //ask for the pin
                return $this->showLoginMenu();
            } else if ($artist->pin == null) { //set up a new pin
                return $this->showNewPINMenu();
            }
        } else if ($size == 2) { //either logging in or 
            $pin = $exploded_text[1];
            if ($artist->pin == null) { //register
                $artist->pin = Hash::make($pin);
                $artist->save();
                //show message for success
                return $this->showSomethingBadMenu("You have set up your pin successfully. You can now start again and use Mkononi Advance service");
            } else { //login
                if ((Hash::check($pin, $artist->pin))) {
                    //
                    return $this->showAcceptDeclineTermsMenu();
                } else {
                    return $this->showSomethingBadMenu("Wrong PIN. Please try again");
                }
            }
        } else if ($size == 3) { //accept or decline terms and conditions
            if ($exploded_text[2] == "1") {
                return $this->showMkononiMainMenu();
            }else{
                return $this->showRejectMenu();
            }
        } else if($size == 4){
            $pin = $exploded_text[1];
            if (!Hash::check($pin, $artist->pin)) {
                return $this->showSomethingBadMenu("Wrong PIN. Please try again");
            }

            if ($exploded_text[3] == "1") {
                $loans = $artist->loans->sum('amount');
                $payments = $artist->payments->sum('amount');
                $difference = $loans - $payments;
                $limit = $artist->amountLimit->advance_limit - $difference;
                return $this->showLimitMenu($limit);
            } else if ($exploded_text[3] == "2") {
                //Start requesting for advance
                return $this->showAdvanceAmountMenu();
            } else  {
                //show terms and conditions
                return $this->showSomethingBadMenu("Invalid entry. Please try again");
            }
        } else if($size == 5 and $exploded_text[3] == "2"){
            $amount =  $exploded_text[4];
            $loans = $artist->loans->sum('amount');
            $payments = $artist->payments->sum('amount');
            $difference = $loans-$payments;
            $limit = $artist->amountLimit->advance_limit - $difference;

            if( $amount > $limit){
                return $this->showAmountLimitErrorMenu($amount, $limit);
            }
            return $this->showDurationsMenu();
        } else if ($size == 6 and $exploded_text[3] == "2") {
            $duration = $exploded_text[5] == "1" ? 6 : 12;
            $amount =  $exploded_text[4] ;
            return $this->accentDeclineLoan($amount, $duration);
        } else if ($size == 7 and $exploded_text[3] == "2") { //final 
            if($exploded_text[6] == "1" and $exploded_text[2] == "1"){
                    $pin = $exploded_text[1];
                    if (!Hash::check($pin, $artist->pin)) {
                        return $this->showSomethingBadMenu("Wrong PIN. Please try again");
                    }
                    $amount = $exploded_text[4];
                    $duration = $exploded_text[5] == "1" ? 6 : 12;
                    $artist->loans()->create(['amount' => $amount, 'duration' => $duration]);
                    return  $this->showFinalAdvanceMenu();
            }else{
                    return $this->showRejectMenu();
            }
        }else{
            return $this->showSomethingBadMenu("We could not understand your request. Please try again");  
        }
    }
   


    public function ussd_proceed($ussd_text)
    {
        return response("CON $ussd_text", 200)
            ->header('Content-Type', 'text/plain');
    }
    public function ussd_stop($ussd_text)
    {
        return response("END $ussd_text", 200)
            ->header('Content-Type', 'text/plain');
    }
}
