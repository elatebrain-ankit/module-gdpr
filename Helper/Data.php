<?php
/**
 * ElateBrain
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the elatebrain.com license which is available at https://www.elatebrain.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer version in the future.
 * If you wish to customize this extension for your needs, please refer to https://magento.com for more information.
 *
 * @category    Elatebrain
 * @package     Elatebrain_GDPR
 * @version     1.0.1
 * @copyright   Copyright (c) 2019 Elatebrain (https://www.elatebrain.com/)
 * @license     https://www.elatebrain.com/LICENSE.txt
 */

namespace Elatebrain\Gdpr\Helper;

/**
 *
 */
class Data extends \Elatebrain\Core\Helper\AbstractData
{
    /**
     * @param null $storeId
     * @return mixed
     */
    public function isEnabled($storeId = null)
    {
        return $this->getConfig("ebgdpr/general/enabled", $storeId);
    }

    /**
     * @param null $storeId
     * @return mixed
     */
    public function getAccountDataAccessContent($storeId = null)
    {
        return $this->getConfig("ebgdpr/general/access_page_content", $storeId);
    }

    /**
     * @param null $storeId
     * @return mixed
     */
    public function canExportData($storeId = null)
    {
        return $this->getConfig("ebgdpr/general/allow_export_customer_data", $storeId);
    }

    /**
     * @param null $storeId
     * @return mixed
     */
    public function canDeleteAccount($storeId = null)
    {
        return $this->getConfig("ebgdpr/general/allow_delete_customer_account", $storeId);
    }

    /**
     * @param null $storeId
     * @return mixed
     */
    public function canDeleteAddress($storeId = null)
    {
        return $this->getConfig("ebgdpr/general/allow_delete_default_address", $storeId);
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getAccountDeleteUrl($storeId = null)
    {
        return $this->_getUrl("customer/account/delete", $storeId);
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getDataExportUrl($storeId = null)
    {
        return $this->_getUrl("customer/account/export", $storeId);
    }

    /**
     * @param null $form
     * @param null $storeId
     * @return array
     */
    public function getConsentCollection($form = null, $storeId = null)
    {
        $consents = array();
        for($i = 1; $i <= 5; $i++){
            $consentConfig = $this->getConfig("ebgdpr/consent_config".$i, $storeId);
            $consentConfig['id'] = "consent_control_".$i;
            if($consentConfig['enabled']){
                if($form != null){
                    $consentConfig['forms'] = explode(",", $consentConfig['forms']);
                    if(isset($consentConfig['forms']) && in_array($form, $consentConfig['forms'])){
                        $consents[] = $consentConfig;
                    }
                }
                else{
                    $consents[] = $consentConfig;
                }
            }
        }
        return $consents;
    }
}