<?php //

require_once $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";


/**
 * Class with a main method to illustrate the usage of the service PagSeguroInstallmentService
 */
class GetInstallments
{
    private $credentials;
    
    public function __construct($email, $token) {

        \PagSeguro\Library::initialize();
        \PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
        \PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");
        
        try {
            \PagSeguro\Configuration\Configure::setEnvironment('sandbox');//production or sandbox
            \PagSeguro\Configuration\Configure::setAccountCredentials(
                $email,
                $token
            );

        } catch (Exception $e) {
            die($e->getMessage());
        }
        
    }
    
    private function _getInstallmentsObjects($options) {
        try {
            $result = \PagSeguro\Services\Installment::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials(),
                $options
            );
            

            $installmentObjectArray = $result->getInstallments();
            return $installmentObjectArray;
                    
        } catch (Exception $e) {
            die($e->getMessage());
            return false;
        }

    }
    
    public function getInstallments($amount, $cardBrand = false, $maxInstallmentNoInterest = false) {
        
        $options = [
            'amount'                        => $amount, //Required
            'card_brand'                    => $cardBrand, //Optional
            'max_installment_no_interest'   => $maxInstallmentNoInterest //Optional
        ];
        
        $installmentObjectArray = $this->_getInstallmentsObjects($options);
        
        
        if (!$installmentObjectArray) return false;
            
        $installmentArray = array();
            
        foreach($installmentObjectArray as $i => $installmentObject) {
            $installmentArray[$installmentObject->getQuantity()] = array(
                'cardBrand'     => $installmentObject->getCardBrand(),
                'amount'        => $installmentObject->getAmount(),
                'totalAmount'   => $installmentObject->getTotalAmount(),
                'interestFree'  => $installmentObject->getInterestFree()
            );
        }
        
        return $installmentArray;

    }

}
