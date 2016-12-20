<?php
namespace FinanceGeni\Interview;


use FinanceGeni\Interview\Account\Registry;
use FinanceGeni\Interview\Account\User;

class App
{
    /**
     * @param $args array of format:
     *              - filepath : path of file name containing commands
     *              - stdin : string of commands delimited by line sperator
     *
     * @throws \Exception
     */
    public static function exectue($args)
    {

        if (isset($args['filepath']))
        {
            $filePath = $args['filepath'];
            if (is_file($filePath) && ($handle = fopen($filePath, "r")))
            {
                while (($line = fgets($handle)) !== false)
                    self::processLine($line);

                fclose($handle);
            }
            else
                throw new \Exception('File name or path invalid');
        }
        else if (isset($args['stdin']))
        {
            $lines = explode("\n", $args['stdin']);

            foreach($lines as $line)
                self::processLine($line);

        }


        self::printSummary();
    }

    /**
     * Process one line of command at a time
     *
     * @param string $line of format:
     *  Add <Name> <Number> <Amount>
     *  Charge <Name> <Amount>
     *  Credit <Name> <Amount>
     *  Remove <Name>
     */
    public static function processLine($line)
    {
        $line = trim($line);
        @list($command, $name, $arg1, $arg2) = explode(' ', $line);

        /**
         * @var $userClass User
         */
        $userClass = User::getInstance($name);

        switch($command)
        {
            case 'Add':
                $userClass->addCard($arg1, $arg2);
                break;

            case 'Charge':
                $userClass->chargeCard($arg1);
                break;

            case 'Credit':
                $userClass->creditCard($arg1);
                break;

            case 'Remove':
                $userClass->remove();
                break;

            default:
                break;
        }
    }

    /**
     * Prints summary of accounts
     */
    public static function printSummary()
    {
        $storage = Registry::$storage;
        ksort($storage);

        foreach($storage as $userClass)
        {
            /**
             * @var $userClass User
             */
            $balance = 'error';
            if ($userClass->isCardValid())
                $balance = $userClass->getBalance();

            echo sprintf("%s: %s\n", $userClass->getName(), $balance);
        }
    }
}
