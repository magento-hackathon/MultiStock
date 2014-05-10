<?php
/**
 * This file is part of a FireGento e.V. module.
 *
 * This FireGento e.V. module is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License version 3 as
 * published by the Free Software Foundation.
 *
 * This script is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * PHP version 5
 *
 * @category  FireGento
 * @package   FireGento_MultiStock
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2013 FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 */

/**
 * Helper Class
 *
 * @category FireGento
 * @package  FireGento_MultiStock
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MultiStock_Block_Adminhtml_Stock_Grid_Container extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * The constructor
     */
    public function __construct()
    {
        $this->_blockGroup = 'FireGento_MultiStock_adminhtml';
        $this->_controller = 'stock';
        $this->_headerText = $this->helper('FireGento_MultiStock_adminhtml')->__(
            'Stock Information for %s', $this->getProduct()->getName()
        );

        parent::__construct();

        $this->_removeButton('add');

        $this->_addButton(
            'setAllNotInStock', array('label' => $this->helper('FireGento_MultiStock_adminhtml')->__(
                    'Set All as not in stock'
                ), 'onclick'                  => 'stock_gridJsObject.updateStock(\'' . $this->jsQuoteEscape(
                    $this->getUpdateAllUrl(array('setInStock' => 0))
                ) . '\');', 'class'           => 'update',)
        );

        $this->_addButton(
            'setAllInStock',
            array('label'                 => $this->helper('FireGento_MultiStock_adminhtml')->__('Set All as in stock'),
                  'onclick'               => 'stock_gridJsObject.updateStock(\'' . $this->jsQuoteEscape(
                          $this->getUpdateAllUrl(array('setInStock' => 1))
                      ) . '\');', 'class' => 'update',)
        );

        $this->_addButton(
            'update', array('label'               => $this->helper('FireGento_MultiStock_adminhtml')->__('Save stocks'),
                            'onclick'             =>
                                'stock_gridJsObject.updateStock(\'' . $this->jsQuoteEscape($this->getUpdateUrl())
                                . '\');', 'class' => 'update',)
        );

    }

    /**
     * Get the url to send data to.
     *
     * @param  array $additional url options
     *
     * @return string
     */
    public function getUpdateUrl($additional = array())
    {
        $additional['_current'] = true;

        return $this->getUrl('*/*/save', $additional);
    }

    /**
     * Url to update all stocks at once.
     *
     * @param  array $additonal url options
     *
     * @return string
     */
    public function getUpdateAllUrl($additonal = array())
    {
        $additonal['_current'] = true;

        return $this->getUrl('*/*/saveAll', $additonal);
    }

    /**
     * The current product.
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function getProduct()
    {
        return Mage::registry('current_product');
    }

}
