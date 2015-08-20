<?php
/**
 * Created by PhpStorm.
 * User: petun
 * Date: 19.08.15
 * Time: 19:37
 */

class BasketHandler {

	private $_basket;

	public function __construct(Basket $basket) {
		$this->_basket = $basket;
	}

	public function process() {
		$type = $_REQUEST['type'];

		if (method_exists($this, '_type'.ucfirst($type))) {
			if ($this->{'_type'.ucfirst($type)}($_REQUEST))  {
				$this->_success();
			} else {
				$this->_error('Error while execute '. $type);
			}
		} else {
			$this->_error('There is no API for type - '.$type);
		}
	}

	private function _typeAddItem($params) {
		$id = $params['id']*1;
		$count = $params['count']*1;

		if ($id && $count) {
			return $this->_basket->addItem($id, $count);
		}
		return false;
	}

	private function _typeAddItems($params) {
		parse_str($params['data'], $data);

		$result = true;
		if (is_array($data['id']) && is_array($data['count'])) {
			foreach ($data['id'] as $i => $id) {
				// todo not working if $result = $result && $this->_basket->addItem($id, $data['count'][$i]);.. if some count is 0
				$this->_basket->addItem($id, $data['count'][$i]);
			}
		}

		return $result;
	}

	private function _typeRemoveItem($params) {
		$id = $params['id']*1;

		if ($id) {
			return $this->_basket->removeItem($id);
		}
		return false;
	}

	private function _typeClear() {
		return $this->_basket->clear();
	}

	private function _typeInfo() {
		return true;
	}



	private function _error($string) {
		echo json_encode(
			array('r'=> false, 'message' => $string)
		);
	}

	private function _success() {
		echo json_encode(
			array('r'=> true, 'items' => $this->_basket->items(),'count' => $this->_basket->count(), 'total_price' => $this->_basket->totalPrice())
		);
	}


}