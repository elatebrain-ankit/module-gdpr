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

namespace Elatebrain\Gdpr\Block\Account;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

/**
 *
 */
class Access extends \Magento\Customer\Block\Account\Dashboard
{
    /**
     * @var \Elatebrain\Gdpr\Helper\Data
     */
    protected $_helper;

    /**
     * Access constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param AccountManagementInterface $customerAccountManagement
     * @param \Elatebrain\Gdpr\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory,
        CustomerRepositoryInterface $customerRepository,
        AccountManagementInterface $customerAccountManagement,
        \Elatebrain\Gdpr\Helper\Data $helper,
        array $data = []
    )
    {
        parent::__construct($context, $customerSession, $subscriberFactory, $customerRepository, $customerAccountManagement, $data);
        $this->_helper = $helper;
    }

    /**
     * @return mixed
     */
    public function getAccountDataAccessContent()
    {
        return $this->_helper->getAccountDataAccessContent();
    }

    /**
     * @return array|bool
     */
    public function getAllowedActions()
    {
        $allowedActions = [];
        if($this->_helper->canDeleteAccount() == 1){
            $allowedActions[] = "delete_account";
        }
        if($this->_helper->canExportData() == 1){
            $allowedActions[] = "export_data";
        }
        if(!empty($allowedActions)){
            return $allowedActions;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getAccountDeleteUrl()
    {
        return $this->_helper->getAccountDeleteUrl();
    }

    /**
     * @return string
     */
    public function getDataExportUrl()
    {
        return $this->_helper->getDataExportUrl();
    }
}