<?php

namespace app\blocks;

use app\models\Users;
use app\components\Templater;


class rightBlock {

	private $_t;

	public function __construct() {
		$this->_t = new Templater("blocks");
	}
	public function render() {
		$rightBlock = $this->_t->renderPartial("rightBlock");
		if(Users::isLogin()) {
			return $rightBlock . $this->_t->renderPartial("userRightBlock");
		} else {
			return $rightBlock . $this->_t->renderPartial("guestRightBlock");
		}
	}



}