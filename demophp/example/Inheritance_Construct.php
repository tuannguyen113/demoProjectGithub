<?php
//$this doi tuong noi tai cua class do
class BankAccount{
    private $balance;

    public function __construct($balance){
        $this->balance=$balance;

    }
    public function getBalance()
    {
        return $this->balance;
    }
    public function deposit($amount){
        if($amount>0){
            $this->balance+=$amount;
        }
        return $this;
    }

}
class SavingAccount extends BankAccount{
    private $interestRate;
    public function __construct($balance,$interestRate)
    {
        parent::__construct($balance);//call constructor from parent class
        $this->interestRate = $interestRate;
    }

    public function setInterestRate($interestRate){
        $this->interestRate=$interestRate;
    }
    public function addInterest(){
        $interest = $this->interestRate * $this->getBalance();
        $this->deposit($interest);
    }
}
$account = new SavingAccount(5000,0.01);
/*$account->deposit(5000);
$account->setInterestRate(0.01);*/
$account->addInterest();
echo $account->getBalance();