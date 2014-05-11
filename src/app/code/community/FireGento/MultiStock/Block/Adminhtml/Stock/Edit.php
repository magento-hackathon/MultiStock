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
class FireGento_MultiStock_Block_Adminhtml_Stock_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Class Constructor

     */
    public function __construct()
    {
        parent::__construct();
        $this->_objectId   = 'id';
        $this->_blockGroup = 'firegento_multistock';
        $this->_controller = 'adminhtml_stock';
        $this->_mode       = 'edit';

        $this->_updateButton(
            'save', 'label', $this->__('Save')
        );
        $this->_updateButton(
            'delete', 'label', $this->__('Delete')
        );

        $this->_addButton(
            'save_and_continue', array('label'   => Mage::helper('adminhtml')->__('Save And Continue Edit'),
                                       'onclick' => 'saveAndContinueEdit()', 'class' => 'save',), -100
        );

        $this->_formScripts[]
            = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * getHeaderText
     * Returns the headline for the edit form
     *
     * @see Mage_Adminhtml_Block_Widget_Container::getHeaderText()
     * @return string Headline
     */
    public function getHeaderText()
    {
        if ($this->helper('firegento_multistock')->getCurrentStock()) {
            return $this->__('Edit Stock');
        } else {
            return $this->__('New Stock');
        }
    }
}
