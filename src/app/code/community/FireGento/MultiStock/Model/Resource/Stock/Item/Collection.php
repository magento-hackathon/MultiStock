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
class FireGento_MultiStock_Model_Resource_Stock_Item_Collection
    extends Mage_CatalogInventory_Model_Resource_Stock_Item_Collection
{

    /**
     * Join the stock entities for stock names
     *
     * @return FireGento_MultiStock_Model_Resource_Stock_Item_Collection
     */
    public function joinStock()
    {
        $this->getSelect()->joinLeft(
            array('stock_table' => $this->getTable('cataloginventory/stock')),
            '`main_table`.`stock_id`=`stock_table`.`stock_id`', array('stock_name')
        );

        return $this;
    }


    /**
     * Select the stock from given store.
     *
     * @param  Mage_Core_Model_Store $store to look up stock
     *
     * @return FireGento_MultiStock_Model_Resource_Stock_Item_Collection
     */
    public function selectStockFromStore($store)
    {
        $this->getSelect()->where('stock_id = ?', $store->getStockId());

        return $this;
    }

    /**
     * Joins the ProductType
     *
     * @param  Mage_Catalog_Model_Product_Type $type product type
     *
     * @return FireGento_MultiStock_Model_Resource_Stock_Item_Collection
     */
    public function joinProductType($type)
    {
        $this->getSelect()->join(
            array('product' => 'catalog_product_entity'), 'product.entity_id=main_table.product_id'
        );
        $this->getSelect()->where('product.type_id = ?', $type);

        return $this;
    }

    /**
     * Joins the ProductAttributes
     *
     * @param  array $attributes a list of attributes
     *
     * @return FireGento_MultiStock_Model_Resource_Stock_Item_Collection
     */
    public function joinProductAttributes($attributes)
    {
        $this->getSelect()->join(
            array('product_flat' => 'catalog_product_flat_1'), 'product.entity_id=product_flat.entity_id', $attributes
        );

        return $this;
    }

    /**
     * Filter the Products to the Category
     *
     * @param  Mage_Catalog_Model_Category $category the category
     *
     * @return FireGento_MultiStock_Model_Resource_Stock_Item_Collection
     */
    public function addCategoryFilter($category)
    {
        $this->getSelect()->join(
            array('category_product' => 'catalog_category_product'), 'category_product.product_id=product.entity_id'
        );
        $this->getSelect()->where('category_product.category_id = ?', $category->getId());

        return $this;
    }
}
