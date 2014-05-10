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
 * @category  FireGento
 * @package   FireGento_MultiStock
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2014 FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 */
/*
 * Extends varienGrid (js/grid.js) with a a method to submit stock data
 */
varienGrid.prototype.updateStock = function(url) {
    this.reloadParams = this.getGridData();
    this.reload(url);
    this.reloadParams = false;
};

varienGrid.prototype.getGridData = function() {
    var data = {};
    $$('#stock_grid_table tbody tr').each(function(tr,index) {
        tr = $(tr);
        var id = 1 * tr.down('td.id').innerHTML;
        data['data['+id+'][item_id]'] = tr.down('td.item_id').innerHTML.strip();
        data['data['+id+'][qty]'] = 1 * tr.down('td.qty').down('input').value;
        data['data['+id+'][is_in_stock]'] = 1 * tr.down('td.is_in_stock').down('input').checked;
    });
    return data;
};

