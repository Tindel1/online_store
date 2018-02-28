<?php

namespace app\models;
use yii\db\ActiveRecord;
// корзина
class Cart extends ActiveRecord {

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }	

	// добавление товара в корзину, хранящуюся в сессии
	public function addToCart($product, $qty = 1) {
		$mainImg = $product->getImage();
		if(isset($_SESSION['cart'][$product->id])) {
			$_SESSION['cart'][$product->id]['qty'] += $qty;
		} else {
			$_SESSION['cart'][$product->id] = [
				'qty' => $qty,
				'name' => $product->name,
				'price' => $product->price,
				'img' => $mainImg->getUrl('x50')
			];
		}
		// общая сумма и стоимость по всем продуктам
		$_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
		$_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * $product->price : $qty * $product->price;
	}

	// принимает id товара, пересчитывает общее кол-во, стоимость товаров в корзине,
	// удаляет товар из корзины
	public function recalc($id) {
		// существует ли элемент в сессии в корзине
		if(!isset($_SESSION['cart'][$id])) return false; 
		// получить кол-во, стоимость
		$qtyMinus = $_SESSION['cart'][$id]['qty'];
		$sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
		$_SESSION['cart.qty'] -= $qtyMinus;
		$_SESSION['cart.sum'] -= $sumMinus;
		// удаление текущего тоавара
		unset($_SESSION['cart'][$id]);


	}


}