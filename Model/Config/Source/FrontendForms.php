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

namespace Elatebrain\Gdpr\Model\Config\Source;


/**
 *
 */
class FrontendForms implements \Magento\Framework\Option\ArrayInterface
{

    /**
     *
     */
    public const REGISTER_FORM = "register";
    /**
     *
     */
    public const CONTACT_FORM = "contact";
    /**
     *
     */
    public const NEWSLETTER_FORM = "newsletter";

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::REGISTER_FORM, 'label' => __('Create Account')],
            ['value' => self::CONTACT_FORM, 'label' => __('Contact Us')],
            ['value' => self::NEWSLETTER_FORM, 'label' => __('Newsletter Form')]
        ];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [self::REGISTER_FORM => __('Create Account'), self::CONTACT_FORM => __('Contact Us'), self::NEWSLETTER_FORM => __('Newsletter Form')];
    }
}