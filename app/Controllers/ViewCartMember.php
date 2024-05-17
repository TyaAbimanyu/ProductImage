<?php

namespace App\Controllers;
use App\Models\CartItemModel;
use App\Models\CartModel;
use App\Models\MemberTokenModel;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;

class ViewCartMember extends BaseController{
    use ResponseTrait;

    public function getDataCart(){
        $data = $this->request->getPost();
        $productModel = new ProductModel();
        $cartItemModel = new CartItemModel();
        $cartModel = new CartModel();
        $memberTokenModel = new MemberTokenModel();
        $productImageModel = new ProductImageModel();

        $tokenData = $data['token'] ;
        $memberToken = $memberTokenModel->where('member_token_uuid', $tokenData)->first();
        if(!$memberToken){
            return $this->fail('Token Not Found');
        }

        $memberId = $memberToken->member_id;

        $cart = $cartModel->where('member_id', $memberId)->first();
        if(!$cart){
            return $this->fail('Cart Not Found');
        }

        $cartId = $cart->cart_id;
        $cart_total_price = $cart->cart_total_price;


        $cartItems = $cartItemModel->where('cart_id', $cartId)->findAll();
        $cartData = [];

        foreach($cartItems as $cartItem){
            $product = $productModel->find($cartItem->product_id);
            $productImages = $productImageModel->where('product_id', $cartItem->product_id)->findAll();

            $cartData[] = [
                'title' => $product->product_title,
                'images' => array_map(function ($img){
                    return $img->product_image;
                }, $productImages),
                'quantity' => $cartItem->cart_item_quantity,
                'price' => $product->product_price,
                'totalPrice' => $cartItem->cart_item_total_price
            ];
        }

        return $this->respond([
            'cartItems' => $cartData,
            'cartTotalPrice' => $cart_total_price
        ]);
    }
}