<?php

class BasketServiceObserver implements \SplObserver{

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Receive update from subject
	 *
	 * @link http://php.net/manual/en/splobserver.update.php
	 *
	 * @param SplSubject $subject <p>
	 *                            The <b>SplSubject</b> notifying the observer of an update.
	 *                            </p>
	 *
	 * @return void
	 */
	public function update(SplSubject $subject) {
		if ($subject instanceof Basket) {
			$items = $subject->items();
			if (!empty($items)) {
				foreach ($items as $item) {
					if ($item['IBLOCK_ID'] == 3 && $item['COUNT'] > 1) {
						$subject->setItemCount($item['ID'], 1);
					}
				}
			}
		}
	}
}