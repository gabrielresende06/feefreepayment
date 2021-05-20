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
 */

/**
 * Metadata version
 */
$sMetadataVersion = '2.1';

/**
 * Module information
 */
$aModule = [
    'id'           => 'project/feefreepayments',
    'title'        => [
        'de'    =>  'Kostenlose Zahlungsarten (Modulskelett)',
        'en'    =>  'Fee Free Payments (module skeleton)'
    ],
    'description'  => [
        'de' => 'Filter für die Anzeige ausschlie&szlig;lich kostenloser Zahlungsarten.',
        'en' => 'Filter for displaying free payment options only.',
    ],
    'thumbnail'    => 'logo.png',
    'version'      => '1.0.2',
    'author'       => 'OXID Academy',
    'url'          => 'https://www.oxid-esales.com/oxid-welt/academy/schulungen/',
    'email'        => 'academy@oxid-esales.com',
    'extend'       => [
        \OxidEsales\Eshop\Application\Model\PaymentList::class => \OxidAcademy\FeeFreePayments\Model\PaymentList::class,
    ],
];
