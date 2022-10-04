<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Addons;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\CartProductAddon;
use App\Models\CartProductVariant;
use App\Models\Product_master;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use URL;
use Validator;


class CartApiController extends Controller
{

    public function add_to_cart(Request $request)
    {
        try {
//            dd(json_encode($request->all()));
            $validateUser = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric',
                    'vendor_id' => 'required|numeric',
                    'products.*.product_id' => 'required|numeric',
                    'products.*.product_qty' => 'required|numeric',
                    'products.*.variants.*.variant_id' => 'numeric|nullable',
                    'products.*.variants.*.variant_qty' => 'string|nullable',
                    'products.*.addons.*.addon_id' => 'numeric|nullable',
                    'products.*.addons.*.addon_qty' => 'string|nullable',

                    // 'addons.*.id' => 'numeric|nullable',
                    // 'addons.*.addon_qty' => "numeric|nullable"
                ]

            );

            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            global $cart_id;
            try {
                DB::beginTransaction();
                // database queries here
                $is_exist=Cart::where('user_id',$request->user_id)->first();
                if(isset($is_exist->id)){
                    $error ='Another Cart is already exist.So that you can not create new one';
                    return response()->json(['status' => false, 'error' => $error], 401);
                }

                $cart_obj = new Cart($request->all());
                $cart_obj->user_id = $request->user_id;
                $cart_obj->vendor_id = $request->vendor_id;
                $cart_obj->saveOrFail();
                $cart_id = $cart_obj->id;
                foreach ($request->products as $k => $p) {
                    $cart_products = new CartProduct($p);
                    $cart_obj->products()->save($cart_products);
                    if (isset($p['variants']))
                        foreach ($p['variants'] as $k => $v) {
                            $CartProductVariant = new CartProductVariant();
                            $CartProductVariant->cart_product_id = $cart_products->id;
                            $CartProductVariant->variant_id = $v['variant_id'];
                            $CartProductVariant->variant_qty = $v['variant_qty'];
                            $CartProductVariant->save();
                        }

                    if (isset($p['addons']))
                        foreach ($p['addons'] as $k => $a) {
                            $CartProductAddon = new CartProductAddon();
                            $CartProductAddon->cart_product_id = $cart_products->id;
                            $CartProductAddon->addon_id = $a['addon_id'];
                            $CartProductAddon->addon_qty = $a['addon_qty'];
                            $CartProductAddon->save();
                        }
                }

                DB::commit();

                return response()->json(['status' => true, 'message' => 'Data Get Successfully', 'response' => ["cart_id" => $cart_id]], 200);
            } catch (PDOException $e) {
                // Woopsy
                DB::rollBack();
                return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
            }
        } catch (Throwable $th) {
            return response()->json(['status' => False, 'error' => $th->getMessage()], 500);
        }
    }


    public function empty_cart(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), ['user_id' => 'required|numeric']);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            global $cart_id;
            try {
                DB::beginTransaction();
                // database queries here

                $cart_objs = Cart::where('user_id', $request->user_id)->get();
                foreach ($cart_objs as $k => $cart_obj) {
                    $cart_obj->cart_product_variants()->delete();
                    $cart_obj->cart_product_addons()->delete();
                    $cart_obj->products()->delete();
                    $cart_obj->delete();
                }
                DB::commit();
                return response()->json(['status' => true, 'message' => 'Data Get Successfully'], 200);
            } catch (PDOException $e) {
                // Woopsy
                DB::rollBack();
                return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
            }
        } catch (Throwable $th) {
            return response()->json(['status' => False, 'error' => $th->getMessage()], 500);
        }
    }


    public function view_cart(Request $request)
    {

        try {
            $validateUser = Validator::make($request->all(), [
                'user_id' => 'required|numeric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }

            $cart_users=Cart::where('user_id',$request->user_id)->first();
            if(!isset($cart_users->id))
                return response()->json(['status' => false, 'error' => "your cart is empty"], 401);
            $cart_id = $cart_users->id;

            $e = Cart::where('id', $cart_id)->exists();
            if (!$e)
                return response()->json(['status' => false, 'error' => 'Cart does not exists.'], 401);

            $wallet_amount = 0;
            $u = User::select('wallet_amount')->find($request->user_id);
            if (isset($u->wallet_amount))
                $wallet_amount = $u->wallet_amount;


//            $pro = Product_master::select('products.*')->where('status', 1)
//                ->whereIn(
//                    "products.id",
//                    function ($query) use ($cart_id) {
//                        $query->select('product_id as product_id')->from('cart_products')->where('cart_id', $cart_id);
//                    }
//                )
//                ->with(['product_variants', 'cuisines'])->get();
            \DB::enableQueryLog();
            $pro = Product_master::select('cart_products.product_qty','products.product_name','products.product_image','products.category','products.menu_id','products.dis','products.type','products.product_price','products.customizable', 'products.product_for' ,'products.product_rating','products.cuisines','products.addons')
                ->where('status', 1)
                ->leftJoin('cart_products','products.id','cart_products.product_id')
                ->where('cart_products.cart_id', $cart_id)
                ->with(['product_variants'=>function($q){
//                    $q->select('id','product_id','variant_name', 'variant_price');
                }, 'cuisines'=>function($q){
                    $q->select('id', 'name', 'cuisinesImage', 'position', 'is_active');
                    $q->where('is_active',1);
                }])
                ->get();


            if ($pro != null)
                $pro = $pro->toArray();

//            dd(\DB::getQueryLog ());
            $variants = CartProductVariant::select('*')
                ->where('cart_products.cart_id', $cart_id)
                ->join('cart_products', 'cart_products.id', '=', 'cart_product_variants.cart_product_id')
                ->pluck('variant_qty', 'variant_id');
            if ($variants != null)
                $variants = $variants->toArray();

            foreach ($pro as $k => $product) {
                unset($pro[$k]['variants']);
                unset($pro[$k]['created_at']);
                unset($pro[$k]['updated_at']);
                unset($pro[$k]['deleted_at']);
                $pro[$k]['cuisines'] = $product['cuisines']['name'];
                $pro[$k]['product_image'] = asset('products') . '/' . $product['product_image'];


                if ($product['addons'] != '') {
                    $pro[$k]['addons'] = @Addons::select(DB::raw('distinct addons.id,addon_id, addon, price, addon_qty'))
                        // select('addon_id', 'addon', 'price', 'addon_qty')
                        ->whereIn('addons.id', explode(',', $product['addons']))
                        ->leftJoin('cart_product_addons', 'cart_product_addons.addon_id', '=', 'addons.id')
                        ->get()->toArray();
                }
                if (count($product['product_variants']) > 0) {
                    foreach ($product['product_variants'] as $k1 => $product_variants) {
                        unset($pro[$k]['product_variants'][$k1]['deleted_at']);
                        unset($pro[$k]['product_variants'][$k1]['created_at']);
                        unset($pro[$k]['product_variants'][$k1]['updated_at']);

                        if (isset($variants[$product_variants['id']]))
                            $pro[$k]['product_variants'][$k1]['variant_qty'] = $variants[$product_variants['id']];
                        else
                            $pro[$k]['product_variants'][$k1]['variant_qty'] = 0;
                    }
                }
            }

            return response()->json(['status' => true, 'message' => 'Data Get Successfully', 'response' => ["cart" => $pro, 'wallet_amount' => $wallet_amount]], 200);
        } catch (Throwable $th) {
            return response()->json(['status' => False, 'error' => $th->getMessage()], 500);
        }
    }

    public function update_cart(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'cart_id' => 'required|numeric',
                    'user_id' => 'required|numeric',
                    'vendor_id' => 'required|numeric',
                    'products.*.product_id' => 'required|numeric',
                    'products.*.product_qty' => 'required|numeric',
                    'products.*.variants.*.variant_id' => 'numeric|nullable',
                    'products.*.variants.*.variant_qty' => 'string|nullable',
                    'products.*.addons.*.addon_id' => 'numeric|nullable',
                    'products.*.addons.*.addon_qty' => 'string|nullable',
                ]

            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            global $cart_id;
            try {
                DB::beginTransaction();
                // database queries here
                $cart_products_addons_id=[];
                $cart_obj = Cart::find($request->cart_id);
                if (!$cart_obj) {
                    return response()->json(['status' => false, 'error' => 'Cart not found'], 401);
                }

                $cart_obj->user_id = $request->user_id;
                $cart_obj->vendor_id = $request->vendor_id;
                $cart_obj->saveOrFail();
                $cart_id = $cart_obj->id;
                foreach ($request->products as $k => $p) {
                    $cart_products = CartProduct::where('product_id', $p['product_id'])->where('cart_id', $cart_id)->first();


                    if (!$cart_products)
                        $cart_products = new CartProduct($p);
                    else {
                        $cart_products->product_id = $p['product_id'];
                        $cart_products->product_qty = $p['product_qty'];
                    }

                    $cart_obj->products()->save($cart_products);
                    $cart_products_id[] = $cart_products->id;
                    if (isset($p['variants'])) {
                        foreach ($p['variants'] as $k => $v) {
                            $CartProductVariant = CartProductVariant::where('cart_product_id', $cart_products->id)->where('variant_id', $v['variant_id'])->first();

                            if (!$CartProductVariant) {
                                $CartProductVariant = new CartProductVariant();
                                $CartProductVariant->cart_product_id = $cart_products->id;
                                $CartProductVariant->variant_id = $v['variant_id'];
                            }
                            $CartProductVariant->variant_qty = $v['variant_qty'];
                            $CartProductVariant->save();
                            $cart_products_variant_id[] = $CartProductVariant->id;
                        }
                        $cart_obj->cart_product_variants()->whereNotIn('cart_product_variants.id', $cart_products_variant_id)->delete();
                    }
                    if (isset($p['addons']) && $p['addons'] != '')
                        foreach ($p['addons'] as $k => $a) {
                            $CartProductAddon = CartProductAddon::where('cart_product_id', $cart_products->id)->where('addon_id', $a['addon_id'])->first();
                            if (!$CartProductAddon) {
                                $CartProductAddon = new CartProductAddon();
                                $CartProductAddon->cart_product_id = $cart_products->id;
                                $CartProductAddon->addon_id = $a['addon_id'];
                            }
                            $CartProductAddon->addon_qty = $a['addon_qty'];
                            $CartProductAddon->save();
                            $cart_products_addons_id[] = $CartProductAddon->id;
                        }
                    $cart_obj->cart_product_addons()->whereNotIn('cart_product_addons.id', $cart_products_addons_id)->delete();
                }

                $cart_obj->products()->whereNotIn('id', $cart_products_id)->delete();

                DB::commit();

                return response()->json(['status' => true, 'message' => 'Data Get Successfully', 'response' => ["cart_id" => $cart_id]], 200);
            } catch (PDOException $e) {
                // Woopsy
                DB::rollBack();
                return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
            }
        } catch (Throwable $th) {
            return response()->json(['status' => False, 'error' => $th->getMessage()], 500);
        }
    }

    public function view_cart_vendor(Request $request)
    {

        try {
            $validateUser = Validator::make($request->all(), [
                'user_id' => 'required|numeric',
                'vendor_id' => 'required|numeric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }

            \DB::enableQueryLog();
            $cart_users=Cart::where(['vendor_id'=>$request->vendor_id,'user_id'=>$request->user_id])->first();
            if(!isset($cart_users->id))
                return response()->json(['status' => false, 'error' => "your cart is empty"], 401);
            $cart_id = $cart_users->id;

            $wallet_amount = 0;
            $u = User::select('wallet_amount')->find($request->user_id);
            if (isset($u->wallet_amount))
                $wallet_amount = $u->wallet_amount;

//dd($cart_id);
            $pro = Product_master::select('cart_products.product_qty','products.product_name','products.product_image','products.category','products.menu_id','products.dis','products.type','products.product_price','products.customizable', 'products.product_for' ,'products.product_rating','products.cuisines','products.addons')
                ->where('status', 1)
                ->leftJoin('cart_products','products.id','cart_products.product_id')
                ->where('cart_products.cart_id', $cart_id)
                ->with(['product_variants'=>function($q){
                    $q->select('id','product_id','variant_name', 'variant_price');
                }, 'cuisines'=>function($q){
                    $q->select('id', 'name', 'cuisinesImage', 'position', 'is_active');
                    $q->where('is_active',1);
                }])
                ->get();

            if ($pro != null)
                $pro = $pro->toArray();
//            dd(\DB::getQueryLog ());
//            dd($pro);
            $variants = CartProductVariant::select('*')
                ->where('cart_products.cart_id', $cart_id)
                ->join('cart_products', 'cart_products.id', '=', 'cart_product_variants.cart_product_id')
                ->pluck('variant_qty', 'variant_id');
            if ($variants != null)
                $variants = $variants->toArray();

            foreach ($pro as $k => $product) {
                unset($pro[$k]['variants']);
                unset($pro[$k]['created_at']);
                unset($pro[$k]['updated_at']);
                unset($pro[$k]['deleted_at']);
                $pro[$k]['cuisines'] = $product['cuisines']['name'];
                $pro[$k]['product_image'] = asset('products') . '/' . $product['product_image'];


                if ($product['addons'] != '') {
                    $pro[$k]['addons'] = @Addons::select(DB::raw('distinct addons.id,addon_id, addon, price, addon_qty'))
                        // select('addon_id', 'addon', 'price', 'addon_qty')
                        ->whereIn('addons.id', explode(',', $product['addons']))
                        ->leftJoin('cart_product_addons', 'cart_product_addons.addon_id', '=', 'addons.id')
                        ->get()->toArray();
                }
                if (count($product['product_variants']) > 0) {
                    foreach ($product['product_variants'] as $k1 => $product_variants) {
                        unset($pro[$k]['product_variants'][$k1]['deleted_at']);
                        unset($pro[$k]['product_variants'][$k1]['created_at']);
                        unset($pro[$k]['product_variants'][$k1]['updated_at']);

                        if (isset($variants[$product_variants['id']]))
                            $pro[$k]['product_variants'][$k1]['variant_qty'] = $variants[$product_variants['id']];
                        else
                            $pro[$k]['product_variants'][$k1]['variant_qty'] = 0;
                    }
                }
            }
            // dd($pro);
            //    dd(\DB::getQueryLog ());

            return response()->json(['status' => true, 'message' => 'Data Get Successfully', 'response' => ["cart" => $pro, 'wallet_amount' => $wallet_amount]], 200);
        } catch (Throwable $th) {
            return response()->json(['status' => False, 'error' => $th->getMessage()], 500);
        }
    }

}
