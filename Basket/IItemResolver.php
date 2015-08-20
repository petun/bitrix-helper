<?php
/**
 * Created by PhpStorm.
 * User: petun
 * Date: 20.08.15
 * Time: 13:18
 */

interface IItemResolver {
	function __construct($priceField);

	/**
	 * @param BasketItem $id
	 *
	 * @return mixed
	 */
	function getItem(BasketItem $id);
}