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
class FireGento_MultiStock_Helper_Data extends Mage_Core_Helper_Data
{
    const CURRENT_STOCK = 'current_stock';

    /**
     * Get the current stock stored in registry.
     *
     * @return mixed
     */
    public function getCurrentStock()
    {
        return Mage::registry(self::CURRENT_STOCK);
    }

    /**
     * Set the given stock in registry.
     *
     * @param Mage_CatalogInventory_Model_Stock $stock the stock to store
     */
    public function setCurrentStock(Mage_CatalogInventory_Model_Stock $stock)
    {
        Mage::register(self::CURRENT_STOCK, $stock);
    }

    public function getNextStockId()
    {
        $tableName = 'information_schema.tables';
        $db = Mage::getConfig()->getResourceConnectionConfig('default_setup')->dbname;
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $result =$read->fetchRow("SELECT AUTO_INCREMENT FROM $tableName WHERE table_schema = '$db' AND table_name = '".Mage::getSingleton('core/resource')->getTableName('cataloginventory/stock')."'");
        return $result['AUTO_INCREMENT'];
    }
}
