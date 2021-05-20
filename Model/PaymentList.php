<?php
/**
 * This Software is the property of OXID eSales and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * @author        OXID Academy
 * @link          https://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2019
 *
 * User: michael
 * Date: 23.04.19
 * Time: 14:36
 */

namespace OxidAcademy\FeeFreePayments\Model;

use DateTime;
use OxidEsales\Eshop\Application\Model\Payment;

/**
 * Class PaymentList
 * @package OxidAcademy\FeeFreePayments\Model
 */
class PaymentList extends PaymentList_parent
{

    public function getPaymentList($shipSetId, $price, $user) {
        return $this->getFreePaymentList($shipSetId, $price, $user);
    }

    public function getFreePaymentList($shipSetId, $price, $user = null)
    {
        $paymentList = parent::getPaymentList($shipSetId, $price, $user);
        $basket = $this->getSession()->getBasket();

        foreach ($paymentList as $paymentId => $payment) {
            $payment->calculate($basket);
            $paymentPrice = $payment->getPrice();

            if (($paymentPrice instanceof Price) && ($paymentPrice->getPrice() > 0)) {
                unset($paymentList[$paymentId]);
            }
        }

        return $paymentList;
    }

    public function isTrue() {
        return true;
    }

    public function isAFloat($number) {
        return is_float($number);
    }

    public function getDateAsString(DateTime $date, $format = 'Y-m-d H:i:s') {
        return $date->format($format);
    }

    public function getSomeList() 
    {
        return [
            'a',
            'b',
            'c',
        ];
    }
}
