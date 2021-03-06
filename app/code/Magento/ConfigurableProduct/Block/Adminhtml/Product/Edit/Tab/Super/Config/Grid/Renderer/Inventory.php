<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

/**
 * Configurable product assocciated products grid in stock renderer
 */
namespace Magento\ConfigurableProduct\Block\Adminhtml\Product\Edit\Tab\Super\Config\Grid\Renderer;

class Inventory extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * Renders grid column value
     *
     * @param \Magento\Framework\Object $row
     * @return string
     */
    public function render(\Magento\Framework\Object $row)
    {
        $inStock = $this->_getValue($row);
        return $inStock ? __('In Stock') : __('Out of Stock');
    }
}
