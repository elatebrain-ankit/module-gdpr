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
namespace Elatebrain\Gdpr\Controller\Account;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Elatebrain\Gdpr\Helper\Data;


/**
 *
 */
class Access extends \Elatebrain\Gdpr\Controller\Account
{

    /**
     * @var Data
     */
    protected $_helper;

    /**
     * Access constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        Data $helper
    )
    {
        $this->_helper = $helper;
        parent::__construct($context, $customerSession);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page|void
     */
    public function execute()
    {
        if(!$this->_helper->isEnabled() || !$this->_customerSession->isLoggedIn()){
            $this->_forward("noRoute");
            return;
        }
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        if ($navigationBlock = $resultPage->getLayout()->getBlock('customer_account_navigation')) {
            $navigationBlock->setActive('gdpr/account');
        }
        $resultPage->getConfig()->getTitle()->set(__('Account Data Access'));
        return $resultPage;
    }
}
