<?php
namespace FinanceGeni\Interview\Account;

/**
 * Helper class
 */
class Helper
{
    /**
     * @url https://gist.github.com/troelskn/1287893
     * @see http://en.wikipedia.org/wiki/Luhn_algorithm
     *
     * @param $cardNumber
     *
     * @return bool
     */
    public static function isValidLuhn10($cardNumber)
    {
        $card_number_checksum = '';

        foreach (str_split(strrev((string) $cardNumber)) as $i => $d) {
            $card_number_checksum .= $i %2 !== 0 ? $d * 2 : $d;
        }

        return array_sum(str_split($card_number_checksum)) % 10 === 0;
    }

}