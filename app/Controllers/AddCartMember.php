<?php

namespace App\Controllers;

use App\Models\CartItemModel;
use App\Models\CartModel;
use App\Models\MemberTokenModel;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;
use Ramsey\Uuid\Uuid;

class AddCartMember extends BaseController{
    use ResponseTrait;

    public function AddToCartDetail(){
        $productModel = new ProductModel();
        $cartModel = new CartModel();
        $cartItemModel = new CartItemModel();
        $memberTokenModel = new MemberTokenModel();
        $data = $this->request->getPost();

        $token = $data['token'];
        $price = $data['price'];
        $quantity = $data['quantity'];
        $totalPrice = $data['TotalPrice'];
        $productId = $data['productId'];

        $memberData = $memberTokenModel->select('member_id')->where('member_token_uuid', $token)->first();
        $memberId = $memberData->member_id;

        $uuid = Uuid::uuid4()->toString();
        $currDate = date('Y-m-d');
        if($memberData){

            $cartData = $cartModel->select('cart_id')->where('member_id', $memberId)->first();
            
            $cartItemData = [
                'cart_id' => $cartData->cart_id,
                'product_id' =>$productId,
                'cart_item_uuid' => $uuid,
                'cart_item_quantity' => $quantity,
                'cart_item_price' => $price,
                'cart_item_total_price' => $totalPrice,
                'created_at' => $currDate
            ];

            $cartUpdateData = [
                'cart_total_price' => $cartData->cart_total_price + $totalPrice
            ];

            if($cartItemModel->insert($cartItemData)){
                if($cartModel->where('cart_id',$cartData->cart_id)->update(null, $cartUpdateData)){
                    return $this->respond('Success Add Item to Cart');
                }
            }
        }
        return $this->fail('Member Data is Not Found or Invalid');
    }
}