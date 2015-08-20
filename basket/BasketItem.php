<?php


class BasketItem {

	private $id;

	private $name;

	private $price;

	private $count;

	private $params;

	public function __construct($id, $name, $price, $params) {

		$this->id = $id;
		$this->name = $name;
		$this->price = $price;
		$this->params = $params;
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * @return mixed
	 */
	public function getCount() {
		return $this->count;
	}

	/**
	 * @return mixed
	 */
	public function getParams() {
		return $this->params;
	}


}