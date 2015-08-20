<?php

class Basket implements  \SplSubject
{

	private $_priceField;

	private $_priceDisplayField;

	private $_observers;

	private $_resolver;

	public function __construct(IItemResolver $resolver) {

		$this->_resolver = $resolver;
		$this->_observers = new \SplObjectStorage();
	}

	public function clear() {
		unset($_SESSION['basket']['items']);
		return true;
	}

	public function items() {
		return $_SESSION['basket']['items'] ? $_SESSION['basket']['items'] : array();
	}


	public function addItem($id, $count) {
		$product = $this->_resolver->getItem($id);

		if (!$product) {
			return false;
		}


		if ($product->getPrice() && $count > 0) {
			if (!empty($_SESSION['basket']['items'][$id])) {
				$_SESSION['basket']['items'][$id]['COUNT'] += $count;
			} else {
				// todo add props to array
				$_SESSION['basket']['items'][$id] = array_merge($product, array('COUNT' => $count, 'PRICE' => $product[$this->_priceDisplayField]));
			}

			// update TOTAL_PRICE
			// todo may be include in BasketItem.class
			$_SESSION['basket']['items'][$id]['TOTAL_PRICE'] = $this->_updateTotalPrice($_SESSION['basket']['items'][$id]);

			// update observers
			$this->notify();

			return true;
		}

		return false;
	}

	public function setItemCount($id, $count) {
		$_SESSION['basket']['items'][$id]['COUNT'] = $count;
		$_SESSION['basket']['items'][$id]['TOTAL_PRICE'] = $this->_updateTotalPrice($_SESSION['basket']['items'][$id]);

		// update observers
		$this->notify();
	}

	private function _updateTotalPrice($item) {
		return $item['COUNT'] * $item['PRICE'];
	}

	public function removeItem($id) {
		if (!empty($_SESSION['basket']['items'][$id])) {
			unset($_SESSION['basket']['items'][$id]);
			return true;
		}

		return false;
	}

	public function count() {
		$count = 0;
		foreach ($this->items() as $item) {
			$count += $item['COUNT'];
		}
		return $count;
	}

	public function totalPrice() {
		$price = 0;
		foreach ($this->items() as $item) {
			$price += $item['PRICE'] * $item['COUNT'];
		}
		return $price;
	}



	public function countItems() {
		return count($this->items());
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Attach an SplObserver
	 *
	 * @link http://php.net/manual/en/splsubject.attach.php
	 *
	 * @param SplObserver $observer <p>
	 *                              The <b>SplObserver</b> to attach.
	 *                              </p>
	 *
	 * @return void
	 */
	public function attach(SplObserver $observer) {
		$this->_observers->attach($observer);
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Detach an observer
	 *
	 * @link http://php.net/manual/en/splsubject.detach.php
	 *
	 * @param SplObserver $observer <p>
	 *                              The <b>SplObserver</b> to detach.
	 *                              </p>
	 *
	 * @return void
	 */
	public function detach(SplObserver $observer) {
		$this->_observers->detach($observer);
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Notify an observer
	 *
	 * @link http://php.net/manual/en/splsubject.notify.php
	 * @return void
	 */
	public function notify() {
		foreach ($this->_observers as $observer) {
			$observer->update($this);
		}
	}


}