<?php

namespace app\components;
use yii\base\Widget;
use app\models\Category;
use Yii;

class MenuWidget extends Widget {

	public $tpl;
	public $model;
	public $data; // записи категорий из бд
	public $tree; // дерево категорий
	public $menuHtml; // готовый html

	public function init() {
		parent::init();
		if($this->tpl === null) { // если параметр не передан, то = menu
			$this->tpl = 'menu';

		}
		$this->tpl .= '.php';
	}

	public function run() {

		// только если используется в шаблоне menu.php
		if($this->tpl === 'menu.php') {
			$menu = Yii::$app->cache->get('menu'); // если есть что-то в кэше, то отдать от туда
			if($menu) return $menu;		
		}

		$this->data = Category::find()->indexBy('id')->asArray()->all();
		$this->tree = $this->getTree();
		$this->menuHtml = $this->getMenuHtml($this->tree);

		if($this->tpl === 'menu.php') {
			Yii::$app->cache->set('menu', $this->menuHtml, 60);
		}

		return $this->menuHtml;
	}

	protected function getTree() { //проходится по массиву и строит дерево.
		$tree = [];
		foreach($this->data as $id=>&$node) {
			if(!$node['parent_id'])
				$tree[$id] = &$node;
			else
				$this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
		}
		return $tree;
	}

	protected function getMenuHtml($tree, $tab = '') { // принимает дерево, 
		$str = '';
		foreach($tree as $category) {
			$str .= $this->catToTemplate($category, $tab); // подключение шаблона для узла
		}
		return $str;
	}
	// tab для отступов вложенных категорий
	protected function catToTemplate($category, $tab) {
		ob_start();
		include __DIR__ . '/menu_tpl/' . $this->tpl;
		return ob_get_clean();
	}



}