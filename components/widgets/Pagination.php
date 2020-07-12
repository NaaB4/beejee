<?php

namespace app\components\widgets;

use app\components\Templater;
use app\components\Request;


class Pagination {

	// Templater $_t
	private $_t;

	// Request $_r
	private $_r;

	private $onPage;
	private $currentPage;
	private $orderBy;
	private $skipElements;
	private $totalCount;
	private $pages;

	public function __construct() {
		$this->_t = new Templater("widgets");
		$this->_r = (new Request)->get();
		$this->onPage = 3;
		$this->currentPage = $this->_r->page ?? 1;
		$this->orderBy = $this->order();

		$this->skipElements = $this->currentPage == 1 ? 0 : ($this->currentPage * $this->onPage) - $this->onPage;

	}

	public static function init() {
		return new Pagination();
	}

	public function getLimit() {
		return $this->skipElements . ", " . $this->onPage;
	}

	public function getOrder() {
		return $this->orderBy;
	}

	private function order() {
		$order = $this->_r->sort;
		if(!$order) return "id DESC";
		$orderBy = explode("__", $order);
		if(!isset($orderBy[1])) $orderBy[1] = "DESC";
		return $orderBy[0]. " " . mb_strtoupper($orderBy[1]);
	}

	public function render() {
		$pagination = $this->_t->renderPartial("pagination", [
			"currentPage" => $this->currentPage,
			"pages" => $this->pages,
			"_r" => $this->_r,
		]);
		return $pagination;
	}

	public function setTotalCount($totalCount) {
		$this->totalCount = $totalCount;
		$this->pages = ceil($totalCount / $this->onPage);
		if(($this->currentPage > $this->pages || $this->currentPage < 0) && $totalCount > 0) throw new \Exception("А пагинация для чего? :)");
		
 	}

}