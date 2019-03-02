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

use Elatebrain\Gdpr\Helper\Data;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface as Logger;

/**
 *
 */
class Delete extends \Elatebrain\Gdpr\Controller\Account
{

    /**
     * @var CustomerRepositoryInterface
     */
    protected $_customerRepository;
    /**
     * @var Data
     */
    protected $_helper;
    /**
     * @var Registry
     */
    protected $_registry;
    /**
     * @var Logger
     */
    protected $_logger;

    /**
     * Delete constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param CustomerRepositoryInterface $customerRepository
     * @param Registry $registry
     * @param Logger $logger
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        CustomerRepositoryInterface $customerRepository,
        Registry $registry,
        Logger $logger,
        Data $helper
    )
    {
        $this->_customerRepository = $customerRepository;
        $this->_helper = $helper;
        $this->_registry = $registry;
        $this->_logger = $logger;
        parent::__construct($context, $customerSession);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        if(!$this->_helper->isEnabled() || !$this->_helper->canDeleteAccount() || !$this->_customerSession->isLoggedIn()){
            $this->_registry->register('use_page_cache_plugin', false);
            $this->_forward("noRoute");
            return;
        }

        $customerId = $this->_customerSession->getCustomerId();
        $customer = $this->_customerRepository->getById($customerId);
        $token = new \Magento\Framework\DataObject(['flag' => true]);

        $this->_eventManager->dispatch("gdpr_customer_account_delete_before",['customer' => $customer, 'token' => $token]);

        if($token->getFlag() !== true){
            $this->_registry->register('use_page_cache_plugin', false);
            $this->_forward('noRoute');
            return;
        }

        try{
            $this->_registry->register("isSecureArea", true, true);
            $this->_customerSession->logout();
            $this->_customerRepository->delete($customer);

            $this->_eventManager->dispatch("gdpr_customer_account_delete_after",['customer' => $customer]);

            $redirectionPath = "*/*/deleteSuccess";
        }
        catch(\Exception $e){
            $this->_logger->critical($e->getMessage());
            $this->messageManager->addErrorMessage(__('Something went wrong while deleting you account. Please contact store support.'));
            $redirectionPath = "*/*/";
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($redirectionPath);

        return $resultRedirect;
    }
}
