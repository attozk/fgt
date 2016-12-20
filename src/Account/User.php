<?php
namespace FinanceGeni\Interview\Account;

/**
 * Class User
 */
class User
{
    const CURRENCY = '$';

    /**
     * @var string name of account holder
     */
    protected $name;

    /**
     * @var string credit card number
     */
    protected $cardNumber;

    /**
     * @var bool true when card number passes Luhn 10
     */
    protected $isValidCard = false;

    /**
     * @var int balnce on card
     */
    protected $balance = 0;

    /**
     * @param string $name assume unique name here
     */
    private function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $amount e.g. $40
     *
     * @return int amount without currency sign
     */
    protected function parseAmount($amount)
    {
        return ltrim($amount, self::CURRENCY);
    }

    /**
     * @return string $amount
     */
    public function getBalance()
    {
        return self::CURRENCY . $this->balance;
    }

    /**
     * Removes account
     */
    public function remove()
    {
        Registry::del('users', $this->name);
    }

    /**
     * Add a new card
     *
     * - "Add" will create a new credit card account for a given name, card number, and limit
     *      - Card numbers should be validated using Luhn 10
     *      - New cards start with a $0 balance
     *
     * @param string $cardNumber e.g. 4111111111111111
     * @param string $amount e.g. $40
     */
    public function addCard($cardNumber, $amount)
    {
        $this->cardNumber = $cardNumber;
        $this->isValidCard = Helper::isValidLuhn10($cardNumber);

        if ($this->isValidCard)
            $this->balance = $this->parseAmount($amount);
    }

    /**
     * Charges card
     *
     * - "Charge" will increase the balance of the card associated with the provided name by the amount specified
     *    - Charges that would raise the balance over the limit are ignored as if they were declined
     *    - Charges against Luhn 10 invalid cards are ignored
     *
     * @param string $amount e.g. $40
     */
    public function chargeCard($amount)
    {
        if ($this->isValidCard)
            $this->balance += $this->parseAmount($amount);
    }

    /**
     * Credit on card
     *
     * - "Credit" will decrease the balance of the card associated with the provided name by the amount specified
     *      - Credits that would drop the balance below $0 will create a negative balance
     *      - Credits against Luhn 10 invalid cards are ignored
     *
     * @param string $amount e.g. $40
     */
    public function creditCard($amount)
    {
        if ($this->isValidCard)
            $this->balance -= $this->parseAmount($amount);
    }

    /**
     * Returns true if card number is valid..
     */
    public function isCardValid()
    {
       return $this->isValidCard;
    }

    /**
     * Users registry
     *
     * @param $name
     *
     * @return \FinanceGeni\Interview\Account\User|mixed
     */
    public static function getInstance($name)
    {
        $userClass = Registry::get('users', $name);

        if (!$userClass instanceof User)
        {
            $userClass = new User($name);
            Registry::set('users', $name, $userClass);
        }

        return $userClass;
    }
}