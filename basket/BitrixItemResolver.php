<?php


class BitrixItemResolver implements IItemResolver {

	function getItem(BasketItem $id) {
		return new BasketItem(1,'name', 1500, array('INODE_ID' => 1));
	}

	function __construct($priceField) {
		$this->_priceField = $priceField;
		$this->_setPriceField($priceField);
	}

	private function _setPriceField($field) {
		$this->_priceField = $field;
		$this->_priceDisplayField = 'PROPERTY_'.$field.'_VALUE';
	}



}