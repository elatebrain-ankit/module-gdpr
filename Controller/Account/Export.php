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
use Magento\Directory\Model\CountryFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\File\Csv;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 *
 */
class Export extends \Elatebrain\Gdpr\Controller\Account
{

    /**
     * @var FileFactory
     */
    protected $_fileFactory;
    /**
     * @var Csv
     */
    protected $_csvProcessor;
    /**
     * @var DirectoryList
     */
    protected $_directoryList;

    /**
     * @var CountryFactory
     */
    protected $_countryFactory;

    /**
     * @var Data
     */
    protected $_helper;

    /**
     * Export constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param FileFactory $fileFactory
     * @param Csv $csvProcessor
     * @param DirectoryList $directoryList
     * @param CountryFactory $countryFactory
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        FileFactory $fileFactory,
        Csv $csvProcessor,
        DirectoryList $directoryList,
        CountryFactory $countryFactory,
        Data $helper
    )
    {
        $this->_fileFactory = $fileFactory;
        $this->_csvProcessor = $csvProcessor;
        $this->_directoryList = $directoryList;
        $this->_countryFactory = $countryFactory;
        $this->_helper = $helper;
        parent::__construct($context, $customerSession);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function execute()
    {
        if(!$this->_helper->isEnabled() || !$this->_helper->canExportData() || !$this->_customerSession->isLoggedIn()){
            $this->_forward("noRoute");
            return;
        }

        $fileName = 'customer_information.csv';
        $filePath = $this->_directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR). "/" . $fileName;

        $customer = $this->_customerSession->getCustomer();
        $personalData = $this->getCustomerInformation($customer);



        try{
            $this->_csvProcessor
                ->setDelimiter(',')
                ->setEnclosure('"')
                ->saveData(
                    $filePath,
                    $personalData
                );
        }
        catch(\Exception $e){

        }

        return $this->_fileFactory->create(
            $fileName,
            [
                'type' => "filename",
                'value' => $fileName,
                'rm' => true,
            ],
            \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR,
            'application/octet-stream'
        );
    }

    /**
     * @param \Magento\Customer\Model\Customer $customer
     * @return array
     */
    public function getCustomerInformation(\Magento\Customer\Model\Customer $customer)
    {
        $result = [];
        $customerData = $customer->getData();
        $result[] = [
            'address_id',
            'firstname',
            'middlename',
            'lastname',
            'email',
            'company',
            'Phone',
            'street',
            'city',
            'state',
            'zip',
            'country',
        ];

        $result[] = [
            null,
            $customerData['firstname'],
            $customerData['middlename'],
            $customerData['lastname'],
            $customerData['email'],
            null,
            null,
            null,
            null,
            null,
        ];

        foreach ($customer->getAddresses() as $address) {
            $country = $this->_countryFactory->create()->loadByCode($address->getData("country_id"))->getName();
            $result[] = [
                $address->getData("entity_id"),
                $address->getData("firstname"),
                $address->getData("middlename"),
                $address->getData("lastname"),
                null,
                $address->getData("company"),
                $address->getData("telephone"),
                $address->getData("street"),
                $address->getData("city"),
                $address->getData("region"),
                $address->getData("postcode"),
                $country,
            ];
        }

        return $result;
    }
}