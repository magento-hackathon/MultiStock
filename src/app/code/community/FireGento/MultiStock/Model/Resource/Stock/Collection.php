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
class FireGento_MultiStock_Model_Resource_Stock_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Magento internal constuct
     */
    protected function _construct()
    {
        $this->_init('cataloginventory/stock');
    }

    /**
     * exclude the default stock
     */
    public function excludeDefaultStock()
    {
        $this->addFieldToFilter('`main_table`.`stock_id`', array('gt' => 1));
    }

    /**
     * Join tables to have all stock items.
     *
     * @param  Mage_Catalog_Model_Product $product the product to add the data
     *
     * @return FireGento_MultiStock_Model_Resource_Stock_Collection
     */
    public function joinStockItemsForProduct($product)
    {
        $this->getSelect()->joinLeft(
            array('stock_item_table' => $this->getTable('cataloginventory/stock_item')), implode(
                ' AND ',
                array('`main_table`.`stock_id` = `stock_item_table`.`stock_id`', $this->getConnection()->quoteInto(
                    '`stock_item_table`.`product_id` = ?', $product->getId()
                ))
            ), array('item_id'     => 'item_id', 'qty' => 'IF (qty IS NULL,0,qty)',
                     'is_in_stock' => 'IF (is_in_stock IS NULL,0,is_in_stock)',
                     'empty'       => 'IF (qty IS NULL,true,false)',)
        );

        return $this;
    }

    /**
     * Retrieve collection empty item
     *
     * @return Varien_Object
     */
    public function getNewEmptyItem()
    {
        return new FireGento_MultiStock_Model_Stock();
    }

}
