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
 * @copyright 2014 FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 */

/**
 * Helper Class
 *
 * @category FireGento
 * @package  FireGento_MultiStock
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MultiStock_Block_Adminhtml_Stock_Tab extends Mage_Adminhtml_Block_Widget
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    /**
     * @return Mage_Catalog_Model_Product
     */
    protected function getProduct()
    {
        return Mage::registry('current_product');
    }

    // implements Mage_Adminhtml_Block_Widget_Tab_Interface {
    /**
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Multiple inventories');
    }

    /**
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Multiple inventories');
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return $this->getProduct() ? true : false;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return !$this->canShowTab();
    }


    // ajaxifies the tab
    /**
     * @return string
     */
    public function getTabUrl()
    {
        return $this->getUrl('stocks/stock/index', array('_current' => true));
    }

    /**
     * @return string
     */
    public function getTabClass()
    {
        return 'ajax';
    }

    /**
     * @return bool
     */
    public function getSkipGenerateContent()
    {
        return true;
    }

    // place after the normal inventory tab
    /**
     * @return string
     */
    public function getAfter()
    {
        return 'inventory';
    }

}
