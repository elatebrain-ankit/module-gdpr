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

namespace Elatebrain\Gdpr\Block\Forms;
use Elatebrain\Gdpr\Helper\Data;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\RequestInterface;

/**
 *
 */
class Consent extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Data
     */
    protected $_helper;
    /**
     * @var RequestInterface
     */
    protected $_request;

    /**
     * Consent constructor.
     * @param Template\Context $context
     * @param Data $helper
     * @param RequestInterface $request
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Data $helper,
        RequestInterface $request,
        array $data = []
    )
    {
        $this->_helper = $helper;
        $this->_request = $request;
        parent::__construct($context, $data);
    }

    /**
     * @param null $form
     * @return string|null
     */
    protected function getCurrentForm($form = null)
    {
        $currentRequest =  $this->_request->getModuleName()."_".$this->_request->getActionName();

        if($form != null){
            $currentRequest = $form;
        }

        switch ($currentRequest){
            case "customer_create":
                return \Elatebrain\Gdpr\Model\Config\Source\FrontendForms::REGISTER_FORM;

            case "contact_index":
                return \Elatebrain\Gdpr\Model\Config\Source\FrontendForms::CONTACT_FORM;

            case "checkout_index":
                return \Elatebrain\Gdpr\Model\Config\Source\FrontendForms::CHECKOUT_FORM;

            case "newsletter":
                return \Elatebrain\Gdpr\Model\Config\Source\FrontendForms::NEWSLETTER_FORM;
        }
        return null;
    }

    /**
     * @return array
     */
    public function getConsent()
    {
        $currentForm = $this->getCurrentForm($this->getForm());
        return $this->_helper->getConsentCollection($currentForm);
    }
}