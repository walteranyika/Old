<?php

namespace App\Traits;

trait UssdMenus
{
    public function showMainMenu()
    {
        $start = "Welcome\n";
        $start .= "1. Skiza Download\n";
        $start .= "2. Mkononi Royalty Advance Service";
        return $this->ussd_proceed($start);
    }

    public function showSkizaMainMenu()
    {
        $start = "Skiza Tunes\n";
        $start .= "1. Search\n";
        $start .= "2. Top Worship Songs\n";
        $start .= "3. Skiza Bible verses\n";
        $start .= "4. Motivational Tunes\n";
        $start .= "5. Best EPL Tunes\n";
        $start .= "6. Online Catalogue\n";
        $start .= "0. Free data";
        return $this->ussd_proceed($start);
    }

    public function showSearchMenu()
    {
        $start = "Skiza Tunes\n";
        $start .= "1. Search By Artist\n";
        $start .= "2. Search By Song Title";
        return $this->ussd_proceed($start);
    }

    public function showSearchByArtistMenu()
    {
        $start = "Enter Artist Name\n";
        return $this->ussd_proceed($start);
    }
    public function showSearchBySongMenu()
    {
        $start = "Enter Song Title\n";
        return $this->ussd_proceed($start);
    }



    public function showMkononiMainMenu()
    {
        $start = "Mkononi Royalty\n";
        $start .= "1. Check Limit\n";
        $start .= "2. Request Advance";
        return $this->ussd_proceed($start);
    }

    public function showLimitMenu($limit)
    {
        $limit = number_format($limit, 2);
        $start = "Your Mkononi Advance Service limit is Ksh.$limit.";
        return $this->ussd_stop($start);
    }

    public function showAdvanceAmountMenu()
    {
        $start = "Enter the advance amount";
        return $this->ussd_proceed($start);
    }

    public function showDurationsMenu()
    {
        $start = "Please select your preffered repayment option\n";
        $start .= "1. 6 Months\n";
        $start .= "2. 12 Months";
        return $this->ussd_proceed($start);
    }

    public function accentDeclineLoan($amount, $duration)
    {
        $amount = number_format($amount, 2);
        $start = "Royalty Advance amount is Ksh $amount, repayment period is $duration months\n";
        $start .= "1. Accept\n";
        $start .= "2. Cancel";
        return $this->ussd_proceed($start);
    }

    public function showAmountLimitErrorMenu($amount, $limit)
    {
        $amount = number_format($amount, 2);
        $limit = number_format($limit, 2);
        $start = "The requested amount of Ksh.$amount cannnot exceed the loan limit of Ksh.$limit.";
        return $this->ussd_stop($start);
    }

    public function showAcceptDeclineTermsMenu()
    {
        $start = "Terms and conditions\n";
        $start .= "1. Accept and Proceed\n";
        $start .= "2. Decline and Cancel";
        return $this->ussd_proceed($start);
    }

    public function showFinalAdvanceMenu()
    {
        $start = "Your advance request has been received and will be processed shortly.";
        return $this->ussd_stop($start);
    }
    public function showRejectMenu()
    {
        $start = "Transaction was canceled. Thank you";
        return $this->ussd_stop($start);
    }

    public function showTermsAndContionsMenu()
    {
        $start = "Terms and conditions can be found atn\n";
        $start .= "www.mkononi.co.ke/AdvanceTerms";

        return $this->ussd_stop($start);
    }


    public function showLoginMenu()
    {
        $start = "Mkononi Royalty Advance System\n";
        $start .= "Please Enter Your PIN";
        return $this->ussd_proceed($start);
    }

    public function showNewPINMenu()
    {
        $start = "Mkononi Royalty Advance System\n";
        $start .= "Please setup your preffered 4 Digit PIN";
        return $this->ussd_proceed($start);
    }


    public function showSomethingBadMenu($text = "Invalid input. Please try again")
    {
        return $this->ussd_stop($text);
    }
}
