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
class FireGento_MultiStock_Model_Stock_Item extends Mage_CatalogInventory_Model_Stock_Item
{

    protected $_eventPrefix = 'multistock_stock_item';

    /**
     * Get the stock id.
     *
     * @return mixed
     */
    public function getStockId()
    {
        if (!$this->hasData('stock_id')) {
            $this->setData('stock_id', Mage_CatalogInventory_Model_Stock::DEFAULT_STOCK_ID);
        }

        return $this->getData('stock_id');
    }

}
