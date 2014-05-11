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
 * Grid Block
 *
 * @category FireGento
 * @package  FireGento_MultiStock
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MultiStock_Block_Adminhtml_Stock_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Class Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('stock_grid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        /* @var $collection FireGento_MultiStock_Model_Resource_Stock_Collection */
        $collection = Mage::getModel('firegento_multistock/stock')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepares the columns for the grid
     *
     * @return  $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'stock_id',
            array('header' => $this->__('Stock ID'), 'align' => 'left', 'index' => 'stock_id', 'width' => '50px')
        );
        $this->addColumn(
            'stock_name', array('header' => $this->__('Name'), 'align' => 'left', 'index' => 'stock_name')
        );

        return parent::_prepareColumns();
    }

    /**
     * Returns the row url
     *
     * @param Object $row row
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        $url = $this->getUrl('*/*/edit', array('stock_id' => $row->getStockId()));

        return $url;
    }

}
