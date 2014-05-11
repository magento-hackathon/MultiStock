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
class FireGento_MultiStock_Adminhtml_StockController extends Mage_Adminhtml_Controller_Action
{
    /**
     * _initAction()
     *
     * @return $this
     */
    protected function _initAction()
    {
        // Make the active menu match the menu config nodes (without 'children' inbetween)
        $this->loadLayout()->_setActiveMenu('')->_title($this->__('Multistock'))->_title(
            $this->__('Stock')
        )->_addBreadcrumb($this->__('Multistock'), $this->__('Multistock'))->_addBreadcrumb(
                $this->__('Stock'), $this->__('Stock')
            );

        return $this;
    }


    /**
     * display default layout
     */
    public function indexAction()
    {
        $this->_initAction()->renderLayout();
    }

    /**
     * newAction
     *
     * @return void
     */
    public function newAction()
    {
        // We just forward the new action to a blank edit form
        $this->_forward('edit');
    }

    /**
     * Edit stock entry controller
     *
     * @return void
     */
    public function editAction()
    {
        $this->_initAction();

        // Get id if available
        $id    = $this->getRequest()->getParam('stock_id');
        $model = Mage::getModel('firegento_multistock/stock');

        if ($id) {
            // Load record
            $model->load($id);

            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This stock no longer exists.'));
                $this->_redirect('*/*/');

                return;
            }
        }

        $this->_title($model->getId() ? $model->getName() : $this->__('New Stock'));

        Mage::helper('firegento_multistock')->setCurrentStock($model);

        $this->_initAction()->_addBreadcrumb(
            $id ? $this->__('Edit Stock') : $this->__('New Stock'),
            $id ? $this->__('Edit Stock') : $this->__('New Stock')
        )->renderLayout();
    }

    /**
     * saveAction
     *
     * @return void
     */
    public function saveAction()
    {
        $stockId      = $this->getRequest()->getParam('stock_id');
        $redirectBack = $this->getRequest()->getParam('back', false);
        if ($postData = $this->getRequest()->getPost()) {
            /** @var $stock FireGento_MultiStock_Model_Stock */
            $stock = Mage::getSingleton('firegento_multistock/stock');
            $stock->setData($postData);
            //we are in editing mode.
            if ($stockId) {
                $stock->setId($stockId);
            }

            try {
                $stock->save();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The stock has been saved.'));
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::logException($e);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    $this->__('An error occurred while saving this stock.')
                );
                Mage::logException($e);
            }
            if ($redirectBack) {
                $this->_redirect(
                    '*/*/edit', array('stock_id' => $stockId, '_current' => true)
                );
            } else {
                $this->_redirect('*/*/');
            }
        }
    }

    /**
     * deleteAction
     *
     * @return void
     */
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('stock_id')
        ) {
            $stock = Mage::getModel('firegento_multistock/stock')->load($id);
            try {
                $stock->delete();
                $this->_getSession()->addSuccess($this->__('The stock has been deleted.'));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

}
