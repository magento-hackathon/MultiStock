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
class FireGento_MultiStock_Adminhtml_MultistockController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Initialize product from request parameters
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _initProduct()
    {
        if (!Mage::registry('product')) {
            $productId = (int)$this->getRequest()->getParam('id');
            /** @var $product Mage_Catalog_Model_Product */
            $product   = Mage::getModel('catalog/product')->setStoreId($this->getRequest()->getParam('store', 0));
            if ($productId) {
                $product->load($productId);
                Mage::register('product', $product);
                Mage::register('current_product', $product);
            }
        }

        return Mage::registry('product');
    }

    /**
     * display default layout
     */
    public function indexAction()
    {
        $this->_initProduct();
        $this->loadLayout()->renderLayout();
    }

    /**
     * display grid
     */
    public function gridAction()
    {
        $this->_initProduct();
        $this->loadLayout()->renderLayout();
    }

    /**
     * save one stock item
     */
    public function saveAction()
    {
        $product = $this->_initProduct();

        $postData = $this->getRequest()->getPost('data');

        $stockCollection = Mage::getModel('cataloginventory/stock')->getCollection();
        /* @var $stockCollection FireGento_MultiStock_Model_Resource_Stock_Collection */
        $stockCollection->joinStockItemsForProduct($product);

        foreach (
            $stockCollection as $stock
        ) {
            /* @var $stock FireGento_MultiStock_Model_Stock */
            if (isset($postData[$stock->getId()])) {
                $newData = $postData[$stock->getId()];

                $stockItem = Mage::getModel('cataloginventory/stock_item');
                /* @var $stockItem FireGento_MultiStock_Model_Stock_Item */

                if ($newData['item_id'] && is_numeric($newData['item_id'])) {
                    $stockItem->load($newData['item_id']);
                }
                $stockItem->setProduct($product);
                $stockItem->addData(
                    array('stock_id'    => $stock->getId(),
                          'qty'         => $newData['qty'],
                          'is_in_stock' => $newData['is_in_stock'])
                );
                $stockItem->save();
            }
        }

        $this->_forward('grid');
    }

    /**
     * save alle stocks at once
     */
    public function saveAllAction()
    {
        $product = $this->_initProduct();
        $inStock = $this->getRequest()->getParam('setInStock');

        $stockCollection = Mage::getModel('cataloginventory/stock')->getCollection();
        /* @var $stockCollection FireGento_MultiStock_Model_Resource_Stock_Collection */
        $stockCollection->joinStockItemsForProduct($product);

        foreach (
            $stockCollection as $stock
        ) {
            /* @var $stock FireGento_MultiStock_Model_Stock */
            $stockItem = Mage::getModel('cataloginventory/stock_item')->setStockId($stock->getId())->loadByProduct(
                $product
            );
            /* @var $stockItem FireGento_MultiStock_Model_Stock_Item */
            $stockItemId = $stockItem->getId();
            if (empty($stockItemId)) {
                $stockItem->setProduct($product);
                $stockItem->setStockId($stock->getId());
            }
            if ($inStock) {
                $stockItem->setIsInStock(1);
            } else {
                $stockItem->setIsInStock(0);
            }

            $stockItem->save();
        }

        $this->_forward('grid');
    }


}
