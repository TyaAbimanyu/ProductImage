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
                'productUuid' => $product->product_uuid,
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

    public function updateQuantity(){
        $data = $this->request->getPost();
        $productUuid = $data['productUuid'];
        $quantity = $data['quantity'] ;
        $token = $data['token'];

        $productModel = new ProductModel();
        $cartItemModel = new CartItemModel();
        $cartModel = new CartModel();
        $memberTokenModel = new MemberTokenModel();

        $memberToken = $memberTokenModel->where('member_token_uuid', $token)->first();

        if(!$memberToken){
            return $this->fail('Token Not Found');
        }

        $memberId = $memberToken->member_id;
        $cart = $cartModel->where('member_id', $memberId)->first();

        if(!$cart){
            return $this->fail('Cart Not Found');
        }

        $product = $productModel->where('product_uuid', $productUuid)->first();

        if(!$product){
            return $this->fail('Product Not Found');
        }

        $cartItem = $cartItemModel->where('cart_id', $cart->cart_id)
                          ->where('product_id', $product->product_id)
                          ->first();


        if(!$cartItem){
            return $this->fail('Cart Item Not Found');
        }

        $cartItem->cart_item_quantity = $quantity;
        $cartItem->cart_item_total_price =  $product->product_price * $quantity;
 
        $cartItemModel->save($cartItem);

        $cartItems = $cartItemModel->where('cart_id', $cart->cart_id)->findAll();
        $cartTotalPrice = array_reduce($cartItems, function($acc,$item){
            return $acc + $item->cart_item_total_price;
        }, 0);

        $cart->cart_total_price = $cartTotalPrice;
        $cartModel->save($cart);
        
        return $this->respond(['status' => 'success update data']);
    }

    public function deleteDataCart(){
        $data = $this->request->getPost();

        $token = $data['token'];
        $productUuids = $data['productUuids'];
    
        $memberTokenModel = new MemberTokenModel();
        $cartModel = new CartModel();
        $cartItemModel = new CartItemModel();
        $productModel = new ProductModel();

        $meberToken = $memberTokenModel->where('member_token_uuid', $token)->first();

        if(!$meberToken){
            return $this->fail('Token Not Found');
        }

        $memberId = $meberToken->member_id;
        $cart = $cartModel->where('member_id', $memberId)->first();

        if(!$cart){
            return $this->fail('Cart Not Found');
        }

        $cartId = $cart->cart_id;

        foreach($productUuids as $productUuid){
            $product = $productModel->where('product_uuid', $productUuid)->first();

            if($product){
                $cartItemModel->where('cart_id', $cartId)
                ->where('product_id', $product->product_id)->delete();
            }
        }
        $cartItems = $cartItemModel->where('cart_id', $cartId)->findAll();
        $cartTotalPrice = array_sum(array_map(function($item){
            return $item->cart_item_total_price;
        }, $cartItems));

        $cart->cart_total_price = $cartTotalPrice;
        $cartModel->save($cart);

        return $this->respond(['status' => 'Data Success Deleted']);
    }

    public function updateCartTotalPrice(){
        $data = $this->request->getPost();
        $token = $data['token'];
        $productUuids = $data['productUuids'];
        
        $memberTokenModel = new MemberTokenModel();
        $cartModel = new CartModel();
        $cartItemModel = new CartItemModel();
        $prodcutModel = new ProductModel();

        $memberToken = $memberTokenModel->where('member_token_uuid', $token)->first();
        if(!$memberToken){
            return $this->fail('Token Not Found');
        }

        $memberId = $memberToken->member_id;
        $cart = $cartModel->where('member_id', $memberId)->first();

        if(!$cart){
            return $this->fail('Cart Not Found');
        }

        $cartId = $cart->cart_id;
        $cartTotalPrice = 0;

        foreach($productUuids as $productUuid){
            $product = $prodcutModel->where('product_uuid', $productUuid)->first();
            if($product){
                $cartItem = $cartItemModel->where('cart_id', $cartId)
                ->where('product_id', $product->product_id)->first();

                if($cartItem){
                    $cartTotalPrice += $cartItem->cart_item_total_price;
                }
            }
        }
        $cart->cart_total_price = $cartTotalPrice;
        $cartModel->save($cart);

        return $this->respond(['cartTotalPrice' => $cartTotalPrice]);
    }
}