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
class FireGento_MultiStock_Model_Stock extends Mage_CatalogInventory_Model_Stock
{
    /**
     * Get the id.
     *
     * @return mixed
     */
    public function getId()
    {
        if (!$this->hasData('stock_id')) {
            $this->setData('stock_id', Mage::helper('firegento_multistock')->getNextStockId());
        }

        return $this->getData('stock_id');
    }

    /**
     * Get the name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->getData('stock_name');
    }

    /**
     * Delete a stock.
     *
     * @return $this|Mage_Core_Model_Abstract
     */
    public function delete()
    {
        if (intval($this->getId()) == self::DEFAULT_STOCK_ID) {
            Mage::logException(new Exception('default or unknown stock can\'t be deleted'));
        } else {
            parent::delete();
        }

        return $this;
    }
}
