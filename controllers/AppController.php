<?php

namespace app\controllers;

use yii\web\Controller;
// базовый котроллер приложения, его будут наследовать остальные, вместо yii\web\Contoller
class AppController extends Controller {
	// ставит мета-теги для вида
	protected function setMeta($title = null, $keywords = null, $description = null) {
		$this->view->title = $title;
		$this->view->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
		$this->view->registerMetaTag(['name' => 'desctiption', 'content' => $description]);		
	}
}
 