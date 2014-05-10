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
class FireGento_MultiStock_Block_Adminhtml_Stock_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * a constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('stock_grid');
        $this->setDefaultSort('stock_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
    }

    /**
     * Get the current product.
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function getProduct()
    {
        return Mage::registry('current_product');
    }

    /**
     * Prepare the collection.
     *
     * @return $this
     */
    protected function _prepareCollection()
    {
        $stockCollection = Mage::getModel('firegento_multistock/stock')->getCollection();
        /* @var $stockCollection FireGento_MultiStock_Model_Resource_Stock_Collection */
        $stockCollection->excludeDefaultStock();
        $stockCollection->joinStockItemsForProduct($this->getProduct());
        if (strlen($this->getRequest()->getParam('sort')) && strlen($this->getRequest()->getParam('dir'))) {
            $dir = strtoupper($this->getRequest()->getParam('dir'));
            $stockCollection->setOrder($this->getRequest()->getParam('sort'), $dir);
        }
        $this->setCollection($stockCollection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare the columns.
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'stock_id', array('header' => $this->__('Stock ID'), 'index' => 'stock_id', 'column_css_class' => 'id',
                              'width'  => '60px'
            )
        );

        $this->addColumn(
            'item_id',
            array('header' => $this->__('Stock Item ID'), 'index' => 'item_id', 'column_css_class' => 'item_id',
                  'width'  => '60px')
        );

        $this->addColumn(
            'stock_name', array('header' => $this->__('Stock Name'), 'index' => 'stock_name')
        );

        $this->addColumn(
            'qty', array('header' => $this->__('Qty'), 'type' => 'number', 'validate_class' => 'validate-number',
                         'index'  => 'qty', 'column_css_class' => 'qty', 'editable' => true)
        );

        $this->addColumn(
            'is_in_stock',
            array('header' => $this->__('Is In Stock'), 'type' => 'checkbox', 'column_css_class' => 'is_in_stock',
                  'index'  => 'is_in_stock', 'value' => '1', 'sortable' => false, 'editable' => false)
        );

        return parent::_prepareColumns();
    }

    /**
     * The current grid url.
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('stocks/stock/grid', array('_current' => true));
    }
}
