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
class FireGento_MultiStock_Model_Resource_Stock extends Mage_CatalogInventory_Model_Resource_Stock
{

    /**
     * add join to select only in stock products
     *
     * @param  Mage_Catalog_Model_Resource_Product_Link_Product_Collection $collection collection to add filter
     *
     * @return Mage_CatalogInventory_Model_Resource_Stock
     */
    public function setInStockFilterToCollection($collection)
    {
        $this->_initConfig();
        $manageStock = Mage::getStoreConfig(Mage_CatalogInventory_Model_Stock_Item::XML_PATH_MANAGE_STOCK);
        $cond = array('{{table}}.use_config_manage_stock = 0 AND {{table}}.manage_stock=1 AND {{table}}.is_in_stock=1',
                     '{{table}}.use_config_manage_stock = 0 AND {{table}}.manage_stock=0',);

        if ($manageStock) {
            $cond[] = '{{table}}.use_config_manage_stock = 1 AND {{table}}.is_in_stock=1';
        } else {
            $cond[] = '{{table}}.use_config_manage_stock = 1';
        }

        $collection->joinField(
            'inventory_in_stock', 'cataloginventory/stock_item', 'is_in_stock', 'product_id=entity_id', join(
                ' AND ', array('(' . join(') OR (', $cond) . ')',
                               $this->getReadConnection()->quoteInto('stock_id = ? ', $this->_stock->getId()))
            )
        );

        return $this;
    }


}
