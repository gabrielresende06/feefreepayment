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
 * Date: 24.04.19
 * Time: 13:15
 */

namespace OxidAcademy\FeeFreePayments\Tests\Unit\Model;

use DateTime;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\Payment;
use OxidEsales\Eshop\Application\Model\PaymentList;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Application\Model\Payment as ModelPayment;
use OxidEsales\TestingLibrary\UnitTestCase;

class PaymentListTest extends UnitTestCase
{
    /**
     * Holds the demo payment objects.
     * Gets filled up by \OxidAcademy\FeeFreePayments\Tests\Unit\Model\PaymentListTest::setUp and
     * \OxidAcademy\FeeFreePayments\Tests\Unit\Model\PaymentListTest::tearDown
     *
     * @var Payment[]
     */
    protected $savedPayments = [];

    public function setUp(): void {
        parent::setUp();

        $this->addToDatabase("REPLACE INTO `oxdeliveryset` (`OXID`, `OXSHOPID`, `OXACTIVE`, `OXACTIVEFROM`, `OXACTIVETO`, `OXTITLE`, `OXTITLE_1`, `OXTITLE_2`, `OXTITLE_3`, `OXPOS`) VALUES
        ('test_deliveryset', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Test', 'Test', '', '', 10);", "oxdeliveryset");

        $this->addToDatabase("REPLACE INTO `oxpayments` (`OXID`, `OXACTIVE`, `OXDESC`, `OXADDSUM`, `OXADDSUMTYPE`, `OXADDSUMRULES`, `OXFROMBONI`, `OXFROMAMOUNT`, `OXTOAMOUNT`, `OXVALDESC`, `OXCHECKED`, `OXDESC_1`, `OXVALDESC_1`, `OXDESC_2`, `OXVALDESC_2`, `OXDESC_3`, `OXVALDESC_3`, `OXLONGDESC`, `OXLONGDESC_1`, `OXLONGDESC_2`, `OXLONGDESC_3`, `OXSORT`, `OXTIMESTAMP`) VALUES 
        ('test_payment',1,'Test',0,'abs',0,0,0,1000000,'',0,'Test','','','','','','','','','',0,'2021-05-19 16:30:00');", "oxpayments");
        
        $this->addToDatabase("REPLACE INTO `oxarticles` (`OXID`, `OXSHOPID`, `OXPARENTID`, `OXACTIVE`, `OXACTIVEFROM`, `OXACTIVETO`, `OXARTNUM`, `OXEAN`, `OXDISTEAN`, `OXMPN`, `OXTITLE`, `OXSHORTDESC`, `OXPRICE`, `OXBLFIXEDPRICE`, `OXPRICEA`, `OXPRICEB`, `OXPRICEC`, `OXBPRICE`, `OXTPRICE`, `OXUNITNAME`, `OXUNITQUANTITY`, `OXEXTURL`, `OXURLDESC`, `OXURLIMG`, `OXVAT`, `OXTHUMB`, `OXICON`, `OXPIC1`, `OXPIC2`, `OXPIC3`, `OXPIC4`, `OXPIC5`, `OXPIC6`, `OXPIC7`, `OXPIC8`, `OXPIC9`, `OXPIC10`, `OXPIC11`, `OXPIC12`, `OXWEIGHT`, `OXSTOCK`, `OXSTOCKFLAG`, `OXSTOCKTEXT`, `OXNOSTOCKTEXT`, `OXDELIVERY`, `OXINSERT`, `OXTIMESTAMP`, `OXLENGTH`, `OXWIDTH`, `OXHEIGHT`, `OXFILE`, `OXSEARCHKEYS`, `OXTEMPLATE`, `OXQUESTIONEMAIL`, `OXISSEARCH`, `OXISCONFIGURABLE`, `OXVARNAME`, `OXVARSTOCK`, `OXVARCOUNT`, `OXVARSELECT`, `OXVARMINPRICE`, `OXVARMAXPRICE`, `OXVARNAME_1`, `OXVARSELECT_1`, `OXVARNAME_2`, `OXVARSELECT_2`, `OXVARNAME_3`, `OXVARSELECT_3`, `OXTITLE_1`, `OXSHORTDESC_1`, `OXURLDESC_1`, `OXSEARCHKEYS_1`, `OXTITLE_2`, `OXSHORTDESC_2`, `OXURLDESC_2`, `OXSEARCHKEYS_2`, `OXTITLE_3`, `OXSHORTDESC_3`, `OXURLDESC_3`, `OXSEARCHKEYS_3`, `OXBUNDLEID`, `OXFOLDER`, `OXSUBCLASS`, `OXSTOCKTEXT_1`, `OXSTOCKTEXT_2`, `OXSTOCKTEXT_3`, `OXNOSTOCKTEXT_1`, `OXNOSTOCKTEXT_2`, `OXNOSTOCKTEXT_3`, `OXSORT`, `OXSOLDAMOUNT`, `OXNONMATERIAL`, `OXFREESHIPPING`, `OXREMINDACTIVE`, `OXREMINDAMOUNT`, `OXAMITEMID`, `OXAMTASKID`, `OXVENDORID`, `OXMANUFACTURERID`, `OXSKIPDISCOUNTS`, `OXRATING`, `OXRATINGCNT`, `OXMINDELTIME`, `OXMAXDELTIME`, `OXDELTIMEUNIT`, `OXUPDATEPRICE`, `OXUPDATEPRICEA`, `OXUPDATEPRICEB`, `OXUPDATEPRICEC`, `OXUPDATEPRICETIME`, `OXISDOWNLOADABLE`, `OXSHOWCUSTOMAGREEMENT`, `OXHIDDEN`) VALUES 
        ('test_article',1,'',1,'0000-00-00 00:00:00','0000-00-00 00:00:00','test','','','','','',7.99,0,0,0,0,0,0,'',0,'','','',NULL,'','','','','','','','','','','','','','',0,6,1,'','','0000-00-00','2010-12-06','2021-04-21 09:50:35',0,0,0,'','','','',0,0,'',0,0,'',0,0,'','','','','','','','','','','','','','','','','','','','','oxarticle','','','','','','',0,0,0,0,0,0,'','','','',0,0,0,1,3,'WEEK',0,0,0,0,'0000-00-00 00:00:00',0,1,0);", "oxarticles");

    }

    public function tearDown(): void {
        parent::tearDown();
    }

    public function testGetPaymentListFiltersOnlyPaymentsWithFees() {
        $sAdminId = '48094d07a9a6046470e8f7cb727bc921';
        $sShipSetId = 'test_deliveryset';
        $sArticleId = 'test_article';

        $oUser = oxNew(User::class);
        $oUser->load($sAdminId);

        $oBasket = $this->getSession()->getBasket();
        $oBasket->setBasketUser($oUser);

        $oBasket->addToBasket($sArticleId, 1);
        $oBasket->calculateBasket();

        $oPaymentList = oxNew(PaymentList::class);
        $paymentList = $oPaymentList->getFreePaymentList($sShipSetId, 1000, $oUser);

        $this->assertCount(0, $paymentList);
    }

    public function testTrue() {
        $oPaymentList = oxNew(PaymentList::class);
        $this->assertTrue($oPaymentList->isTrue());
    }

    /** @test */
    public function numberIsFloat() {
        $oPaymentList = oxNew(PaymentList::class);
        $this->assertFalse($oPaymentList->isAFloat('asdf'));
        $this->assertTrue($oPaymentList->isAFloat(100.00));
    }

    /** @test */
    public function formatDate() {
        $oPaymentList = oxNew(PaymentList::class);
        $now = new DateTime();
        $this->assertEquals($now->format('Y-m-d H:i:s'), $oPaymentList->getDateAsString($now));
        $this->assertEquals('20.05.2021', $oPaymentList->getDateAsString($now, 'd.m.Y'));
    }
}
