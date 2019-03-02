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

namespace Elatebrain\Gdpr\Model\Plugin\Customer\Block\Address;


use Elatebrain\Gdpr\Helper\Data;

/**
 *
 */
class Book
{
    /**
     * @var Data
     */
    protected $_helper;

    /**
     * Book constructor.
     * @param Data $helper
     */
    public function __construct(Data $helper)
    {
        $this->_helper = $helper;
    }

    /**
     * @param \Magento\Customer\Block\Address\Book $subject
     * @param \Closure $proceed
     * @param $address
     * @return mixed|string
     */
    public function aroundGetAddressHtml(\Magento\Customer\Block\Address\Book $subject, \Closure $proceed, $address)
    {
        $result = $proceed($address);

        if(!$this->_helper->isEnabled() || !$this->_helper->canDeleteAddress()){
            return $result;
        }

        $primaryAddressIds = [$subject->getDefaultBilling(), $subject->getDefaultShipping()];
        if(in_array($address->getId(), $primaryAddressIds)){
            $result = $result . ' <ul class="default-address-delete"><li class="item"><a href="#" class="action delete default-address-delete" role="delete-address" data-address="'.$address->getId().'">Delete Address</a></li></ul>';
            return $result;
        }
        return $result;
    }
}