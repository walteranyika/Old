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
                return $this->showWrongInputMenu("You have not been registered to use this service.");
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
                return $this->showWrongInputMenu("You have set up your pin successfully. You can now start again and use Mkononi Advance service");
            } else { //login
                if ((Hash::check($pin, $artist->pin))) {
                    return $this->showMkononiMainMenu();
                } else {
                    return $this->showWrongInputMenu("Wrong PIN. Please try again");
                }
            }
        } else if ($size == 3) { //1*PIN*1
            if ($exploded_text[2] == "1") {
                $amount = $artist->amountLimit->advance_limit;
                return $this->showLimitMenu($amount);
            } else if ($exploded_text[2] == "2") {
                //Start requesting for advance
                return $this->showAdvanceAmountMenu();
            } else if ($exploded_text[2] == "3") {
                //show terms and conditions
                return $this->showTermsAndContionsMenu();
            }
        } else if ($size == 4 and $exploded_text[2] == "2") {
            return $this->showAdvanceOptionsMenu();
        } else if ($size == 5 and $exploded_text[2] == "2") {
            return $this->showAcceptDeclineTermsMenu();
        } else if ($size == 6 and $exploded_text[2] == "2") {
                //check if it was accepted and show the processing message
            if ($exploded_text[5] == "1") { //accedpted
                //Collect the data and insert into the DB
                $amount = $exploded_text[3];
                $duration = $exploded_text[4]=="1"? 6 : 12;
                $artist->loans()->create(['amount'=>$amount, 'duration'=>$duration]);
                return  $this->showFinalAdvanceMenu();
            } else {//rejected
                return $this->showRejectMenu();
            }
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