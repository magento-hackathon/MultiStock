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
class FireGento_MultiStock_Model_Observer
{
    /**
     * We need to put the main stock id into the indexing process. If we don't we get duplicate entries
     * errors.
     *
     * @param  Varien_Event_Observer $observer the observer
     *
     * @return FireGento_MultiStock_Model_Observer
     */
    public function prepareCatalogProductIndexSelect(Varien_Event_Observer $observer)
    {
        $select = $observer->getEvent()->getSelect();
        //the prefix is hardcode because the root haven't a constant for that.
        $select->where('ciss.stock_id = ?', Mage_CatalogInventory_Model_Stock::DEFAULT_STOCK_ID);

        return $this;
    }
}
