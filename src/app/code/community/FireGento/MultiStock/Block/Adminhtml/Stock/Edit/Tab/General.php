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
 * Tab Block
 *
 * @category FireGento
 * @package  FireGento_MultiStock
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_MultiStock_Block_Adminhtml_Stock_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    /**
     * Just prepare the form.
     *
     * @return mixed
     */
    protected function _prepareForm()
    {
        $data = $this->helper('firegento_multistock')->getCurrentStock();

        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset(
            'firegento_multistock_stock_form', array('legend' => $this->__('General'))
        );
        /*
        $fieldset->addField(
            'stock_id_text', 'note', array('label' => $this->__('Stock ID'), 'name' => 'stock_id_text', 'text' => $this->helper('firegento_multistock')->getNextStockId())
        );
        $fieldset->addField(
            'stock_id', 'hidden',
            array('value' => $this->helper('firegento_multistock')->getNextStockId())
        );
        */


        $fieldset->addField(
            'stock_name', 'text',
            array('label' => $this->__('Name'), 'class' => 'required-entry', 'required' => true,
                  'name'  => 'stock_name')
        );

        $this->setForm($form);
        if ($data) {
            $form->setValues($data);
        }

        return parent::_prepareForm();
    }

    /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('General Information');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('General Information');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}
