<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AdminMasters;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\CartProductAddon;
use App\Models\CartProductVariant;
use App\Models\Product_master;
use App\Models\User;
use App\Models\Vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use URL;
use Validator;


class CartApiController extends Controller
{

//    public function add_to_cart(Request $request)
//    {
//        try {
////            dd(json_encode($request->all()));
//            $validateUser = Validator::make(
//                $request->all(),
//                [
//                    'user_id'                           => 'required|numeric',
//                    'vendor_id'                         => 'required|numeric',
//                    'products.*.product_id'             => 'required|numeric',
//                    'products.*.product_qty'            => 'required|numeric',
//                    'products.*.variants.*.variant_id'  => 'numeric|nullable',
//                    'products.*.variants.*.variant_qty' => 'string|nullable',
//                    'products.*.addons.*.addon_id'      => 'numeric|nullable',
//                    'products.*.addons.*.addon_qty'     => 'string|nullable',
//
//                    // 'addons.*.id' => 'numeric|nullable',
//                    // 'addons.*.addon_qty' => "numeric|nullable"
//                ]
//
//            );
//
//            if ($validateUser->fails()) {
//                $error = $validateUser->errors();
//                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
//            }
//            global $cart_id;
//            try {
//                DB::beginTransaction();
//                // database queries here
//                $is_exist = Cart::where('user_id', $request->user_id)->first();
//                if (isset($is_exist->id)) {
//                    $error = 'Another Cart is already exist.So that you can not create new one';
//                    return response()->json(['status' => false, 'error' => $error], 401);
//                }
//
//                $cart_obj            = new Cart($request->all());
//                $cart_obj->user_id   = $request->user_id;
//                $cart_obj->vendor_id = $request->vendor_id;
//                $cart_obj->saveOrFail();
//                $cart_id = $cart_obj->id;
//                foreach ($request->products as $k => $p) {
//                    if (!Product_master::where('userId', $request->vendor_id)->where('id', $p['product_id'])->exists()) {
//                        return response()->json(['status' => false, 'error' => 'provided product not available under given vendor.'], 401);
//                    }
//                    $cart_products = new CartProduct($p);
//                    $cart_obj->products()->save($cart_products);
//                    if (isset($p['variants']))
//                        foreach ($p['variants'] as $k => $v) {
//                            $CartProductVariant                  = new CartProductVariant();
//                            $CartProductVariant->cart_product_id = $cart_products->id;
//                            $CartProductVariant->variant_id      = $v['variant_id'];
//                            $CartProductVariant->variant_qty     = $v['variant_qty'];
//                            $CartProductVariant->save();
//                        }
//
//                    if (isset($p['addons']))
//                        foreach ($p['addons'] as $k => $a) {
//                            $CartProductAddon                  = new CartProductAddon();
//                            $CartProductAddon->cart_product_id = $cart_products->id;
//                            $CartProductAddon->addon_id        = $a['addon_id'];
//                            $CartProductAddon->addon_qty       = $a['addon_qty'];
//                            $CartProductAddon->save();
//                        }
//                }
//
//                DB::commit();
//
//                return response()->json(['status' => true, 'message' => 'Data Get Successfully', 'response' => ["cart_id" => $cart_id]], 200);
//            } catch (PDOException $e) {
//                // Woopsy
//                DB::rollBack();
//                return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
//            }
//        } catch (Throwable $th) {
//            return response()->json(['status' => False, 'error' => $th->getMessage()], 500);
//        }
//    }
    public function add_to_cart(Request $request)
    {
        try {
//            dd(json_encode($request->all()));
            $validateUser = Validator::make(
                $request->all(),
                [
                    'user_id'                           => 'required|numeric',
                    'vendor_id'                         => 'required|numeric',
                    'products.*.product_id'             => 'required|numeric',
                    'products.*.product_qty'            => 'required|numeric',
                    'products.*.variants.*.variant_id'  => 'numeric|nullable',
                    'products.*.variants.*.variant_qty' => 'string|nullable',
                    'products.*.addons.*.addon_id'      => 'numeric|nullable',
                    'products.*.addons.*.addon_qty'     => 'string|nullable',

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
                $cart_obj = Cart::where('user_id', $request->user_id)->where('vendor_id', $request->vendor_id)->first();

                if (!isset($cart_obj->id))
                    $cart_obj = new Cart();


                $cart_obj->user_id   = $request->user_id;
                $cart_obj->vendor_id = $request->vendor_id;
                $cart_obj->saveOrFail();
                $cart_id = $cart_obj->id;
                foreach ($request->products as $k => $p) {
                    if (!Product_master::where('userId', $request->vendor_id)->where('id', $p['product_id'])->exists()) {
                        return response()->json(['status' => false, 'error' => 'provided product not available under given vendor.'], 401);
                    }
                    $cart_products = new CartProduct($p);
                    $cart_obj->products()->save($cart_products);
                    if (isset($p['variants']))
                        foreach ($p['variants'] as $k => $v) {
                            $CartProductVariant                  = new CartProductVariant();
                            $CartProductVariant->cart_product_id = $cart_products->id;
                            $CartProductVariant->variant_id      = $v['variant_id'];
                            $CartProductVariant->variant_qty     = $v['variant_qty'];
                            $CartProductVariant->save();
                        }

                    if (isset($p['addons']))
                        foreach ($p['addons'] as $k => $a) {
                            $CartProductAddon                  = new CartProductAddon();
                            $CartProductAddon->cart_product_id = $cart_products->id;
                            $CartProductAddon->addon_id        = $a['addon_id'];
                            $CartProductAddon->addon_qty       = $a['addon_qty'];
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
                return response()->json(['status' => true, 'message' => 'Successfully'], 200);
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

            $cart_users = Cart::select('user_id', 'vendor_id', 'id')->where('user_id', $request->user_id)->first();
            if (!isset($cart_users->id))
                return response()->json(['status' => false, 'error' => "your cart is empty"], 401);
            $cart_id = $cart_users->id;

            $e = Cart::where('id', $cart_id)->exists();
            if (!$e)
                return response()->json(['status' => false, 'error' => 'Cart does not exists.'], 401);

            $wallet_amount = 0;
            $u             = User::select('wallet_amount')->find($request->user_id);
            if (isset($u->wallet_amount))
                $wallet_amount = $u->wallet_amount;

            $pro      = Product_master::select('cart_products.product_qty', 'products.product_name', 'products.product_image', 'products.category', 'products.menu_id',
                'products.dis', 'products.type', 'products.product_price', 'products.customizable', 'products.product_for', 'products.product_rating', 'products.cuisines',
                'products.addons', 'variants.id as variant_id', 'variants.*', 'cuisines.*', 'cuisines.id as cuisine_id', 'addons',
                'cart_product_variants.*',
                'products.id as product_id',
//                'cart_products.id as cart_product_id', 'cart_product_addons.id as cart_product_addon_id', 'cart_product_variants.id as cart_product_variant_id'
            )
                ->where('products.status', 1)
                ->join('cart_products', 'products.id', 'cart_products.product_id')
                ->where('cart_products.cart_id', $cart_id)
                ->leftJoin('variants', 'products.id', 'variants.product_id')
                ->leftJoin('cart_product_variants', 'variants.id', 'cart_product_variants.variant_id')
                ->leftJoin('cuisines', 'products.cuisines', 'cuisines.id')
                ->get()->toArray();
            $responce = [];

            foreach ($pro as $k => $product) {
                if ($product['product_id'] != '') {

                    $responce[$product['product_id']]['product_id']     = $product['product_id'];
                    $responce[$product['product_id']]['product_name']   = $product['product_name'];
                    $responce[$product['product_id']]['product_qty']    = $product['product_qty'];
                    $responce[$product['product_id']]['product_image']  = asset('products') . '/' . $product['product_image'];
                    $responce[$product['product_id']]['category']       = $product['category'];
                    $responce[$product['product_id']]['menu_id']        = $product['menu_id'];
                    $responce[$product['product_id']]['dis']            = $product['dis'];
                    $responce[$product['product_id']]['type']           = $product['type'];
                    $responce[$product['product_id']]['product_price']  = $product['product_price'];
                    $responce[$product['product_id']]['customizable']   = $product['customizable'];
                    $responce[$product['product_id']]['product_for']    = $product['product_for'];
                    $responce[$product['product_id']]['product_rating'] = $product['product_rating'];
                    $responce[$product['product_id']]['addons']         = $product['addons'];
//                    $responce[$product['product_id']]['cart_product_id']         = $product['cart_product_id'];
//                    $responce[$product['product_id']]['cart_product_addon_id']   = $product['cart_product_addon_id'];
//                    $responce[$product['product_id']]['cart_product_variant_id'] = $product['cart_product_variant_id'];


                    if ($product['variant_id'] != '') {
                        $responce[$product['product_id']]['variants'][$product['variant_id']]['variant_name']  = $product['variant_name'];
                        $responce[$product['product_id']]['variants'][$product['variant_id']]['variant_price'] = $product['variant_price'];
                        $responce[$product['product_id']]['variants'][$product['variant_id']]['variant_qty']   = $product['variant_qty'];
                    }

                    if ($product['cuisine_id'] != '') {
                        $responce[$product['product_id']]['cuisines'][$product['cuisine_id']]['name']          = $product['name'];
                        $responce[$product['product_id']]['cuisines'][$product['cuisine_id']]['cuisinesImage'] = $product['cuisinesImage'];
                    }
                }
            }
//            dd($responce);
            if (is_array($responce) && !empty($responce)) {
                foreach ($responce as $i => $p) {

                    if (isset($p['variants']))
                        $r[$i]['variants'] = array_values($p['variants']);

                    if (isset($p['cuisines']))
                        $r[$i]['cuisines'] = array_values($p['cuisines']);

                    if ($p['addons'] != '') {
                        $addons          = explode(',', $p['addons']);
                        $r[$i]['addons'] = \App\Models\Addons::select('id', 'addon', 'price')->whereIn('id', $addons)->get()->toArray();
                    }
                    unset($p['variants']);
                    unset($p['cuisines']);
                    unset($p['addons']);
                    $r[$i] = array_merge($r[$i], $p);
//                    dd($r);
                }
                $r = array_values($r);
            } else
                $r = [];

            $admin_setting = AdminMasters::select('max_cod_amount')->find(config('custom_app_setting.admin_master_id'));

            $vendor = Vendors::find($cart_users->vendor_id);
            return response()->json(['status'   => true,
                                     'message'  => 'Data Get Successfully',
                                     'response' => ["cart_id"        => $cart_id,
                                                    "cart"           => $r,
                                                    "vendor"         => $vendor,
                                                    'wallet_amount'  => $wallet_amount,
                                                    'max_cod_amount' => @$admin_setting->max_cod_amount]], 200);
        } catch (Throwable $th) {
            return response()->json(['status' => False, 'error' => $th->getTrace()], 500);
        }
    }

//    public function update_cart(Request $request)
//    {
//        try {
//            $validateUser = Validator::make(
//                $request->all(),
//                [
//                    'cart_id'                           => 'required|numeric',
//                    'user_id'                           => 'required|numeric',
//                    'vendor_id'                         => 'required|numeric',
//                    'products.*.product_id'             => 'required|numeric',
//                    'products.*.product_qty'            => 'required|numeric',
//                    'products.*.variants.*.variant_id'  => 'numeric|nullable',
//                    'products.*.variants.*.variant_qty' => 'numeric|nullable',
//                    'products.*.addons.*.addon_id'      => 'numeric|nullable',
//                    'products.*.addons.*.addon_qty'     => 'numeric|nullable',
//                ]
//            );
//
//            if ($validateUser->fails()) {
//                $error = $validateUser->errors();
//                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
//            }
////            dd($request->all());
//            global $cart_id;
//            try {
//                DB::beginTransaction();
//                // database queries here
//                $cart_products_addons_id = [];
//                $cart_obj                = Cart::find($request->cart_id);
//                if (!$cart_obj) {
//                    return response()->json(['status' => false, 'error' => 'Cart not found'], 401);
//                }
//
//                $cart_obj->user_id   = $request->user_id;
//                $cart_obj->vendor_id = $request->vendor_id;
//                $cart_obj->saveOrFail();
//                $cart_id = $cart_obj->id;
//                foreach ($request->products as $k => $p) {
//                    if (!Product_master::where('userId', $request->vendor_id)->where('id', $p['product_id'])->exists()) {
//                        return response()->json(['status' => false, 'error' => 'provided product not available under given vendor.'], 401);
//                    }
//
//                    $cart_products = CartProduct::where('product_id', $p['product_id'])->where('cart_id', $cart_id)->first();
//
//
//                    if (!$cart_products)
//                        $cart_products = new CartProduct($p);
//                    else {
//                        $cart_products->product_id  = $p['product_id'];
//                        $cart_products->product_qty = $p['product_qty'];
//                    }
//
//                    $cart_obj->products()->save($cart_products);
//                    $cart_products_id[] = $cart_products->id;
//                    if (isset($p['variants'])) {
//                        foreach ($p['variants'] as $k => $v) {
//                            $CartProductVariant = CartProductVariant::where('cart_product_id', $cart_products->id)->where('variant_id', $v['variant_id'])->first();
//
//                            if (!$CartProductVariant) {
//                                $CartProductVariant                  = new CartProductVariant();
//                                $CartProductVariant->cart_product_id = $cart_products->id;
//                                $CartProductVariant->variant_id      = $v['variant_id'];
//                            }
//                            $CartProductVariant->variant_qty = $v['variant_qty'];
//                            $CartProductVariant->save();
//                            $cart_products_variant_id[] = $CartProductVariant->id;
//                        }
//                        $cart_obj->cart_product_variants()->whereNotIn('cart_product_variants.id', $cart_products_variant_id)->delete();
//                    }
//                    if (isset($p['addons']) && $p['addons'] != '')
//                        foreach ($p['addons'] as $k => $a) {
//                            $CartProductAddon = CartProductAddon::where('cart_product_id', $cart_products->id)->where('addon_id', $a['addon_id'])->first();
//                            if (!$CartProductAddon) {
//                                $CartProductAddon                  = new CartProductAddon();
//                                $CartProductAddon->cart_product_id = $cart_products->id;
//                                $CartProductAddon->addon_id        = $a['addon_id'];
//                            }
//                            $CartProductAddon->addon_qty = $a['addon_qty'];
//                            $CartProductAddon->save();
//                            $cart_products_addons_id[] = $CartProductAddon->id;
//                        }
//                    $cart_obj->cart_product_addons()->whereNotIn('cart_product_addons.id', $cart_products_addons_id)->delete();
//                }
//
//                $cart_obj->products()->whereNotIn('id', $cart_products_id)->delete();
//
//                DB::commit();
//
//                return response()->json(['status' => true, 'message' => 'Data Get Successfully', 'response' => ["cart_id" => $cart_id]], 200);
//            } catch (PDOException $e) {
//                // Woopsy
//                DB::rollBack();
//                return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
//            }
//        } catch (Throwable $th) {
//            return response()->json(['status' => False, 'error' => $th->getMessage()], 500);
//        }
//    }

    public function update_cart(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'cart_id'                           => 'required|numeric',
                    'user_id'                           => 'required|numeric',
                    'vendor_id'                         => 'required|numeric',
                    'products.*.product_id'             => 'required|numeric',
                    'products.*.product_qty'            => 'required|numeric',
                    'products.*.variants.*.variant_id'  => 'numeric|nullable',
                    'products.*.variants.*.variant_qty' => 'numeric|nullable',
                    'products.*.addons.*.addon_id'      => 'numeric|nullable',
                    'products.*.addons.*.addon_qty'     => 'numeric|nullable',
                ]
            );

            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
//            dd($request->all());
            global $cart_id;
            try {
                DB::beginTransaction();
                // database queries here
                $cart_products_addons_id = [];
                $cart_obj                = Cart::find($request->cart_id);
                if (!$cart_obj) {
                    return response()->json(['status' => false, 'error' => 'Cart not found'], 401);
                }
                $cart_id = $cart_obj->id;
                foreach ($request->products as $k => $p) {
                    if (!Product_master::where('userId', $request->vendor_id)->where('id', $p['product_id'])->exists()) {
                        return response()->json(['status' => false, 'error' => 'provided product not available under given vendor.'], 401);
                    }

                    $cart_products = CartProduct::where('product_id', $p['product_id'])->where('cart_id', $cart_id)->first();


                    if (!$cart_products)
                        $cart_products = new CartProduct($p);
                    else {
                        $cart_products->product_id  = $p['product_id'];
                        $cart_products->product_qty = $p['product_qty'];
                    }

                    $cart_obj->products()->save($cart_products);
                    $cart_products_id[] = $cart_products->id;
                    if (isset($p['variants'])) {
                        foreach ($p['variants'] as $k => $v) {
                            $CartProductVariant = CartProductVariant::where('cart_product_id', $cart_products->id)->where('variant_id', $v['variant_id'])->first();

                            if (!$CartProductVariant) {
                                $CartProductVariant                  = new CartProductVariant();
                                $CartProductVariant->cart_product_id = $cart_products->id;
                                $CartProductVariant->variant_id      = $v['variant_id'];
                            }
                            $CartProductVariant->variant_qty = $v['variant_qty'];
                            $CartProductVariant->save();
                            $cart_products_variant_id[] = $CartProductVariant->id;
                        }
                        if(isset($cart_products_variant_id) && !empty($cart_products_variant_id) && is_array($cart_products_variant_id)){
                            $cart_obj->cart_product_variants()->whereNotIn('cart_product_variants.id', $cart_products_variant_id)->delete();
                            unset($cart_products_variant_id);
                        }

                    }
                    if (isset($p['addons']) && $p['addons'] != '')
                        foreach ($p['addons'] as $k => $a) {
                            $CartProductAddon = CartProductAddon::where('cart_product_id', $cart_products->id)->where('addon_id', $a['addon_id'])->first();
                            if (!$CartProductAddon) {
                                $CartProductAddon                  = new CartProductAddon();
                                $CartProductAddon->cart_product_id = $cart_products->id;
                                $CartProductAddon->addon_id        = $a['addon_id'];
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
                'user_id'   => 'required|numeric',
                'vendor_id' => 'required|numeric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }

            \DB::enableQueryLog();
            $cart_users = Cart::where(['vendor_id' => $request->vendor_id, 'user_id' => $request->user_id])->first();
            if (!isset($cart_users->id))
                return response()->json(['status' => false, 'error' => "your cart is empty"], 401);
            $cart_id = $cart_users->id;

            $wallet_amount = 0;
            $u             = User::select('wallet_amount')->find($request->user_id);
            if (isset($u->wallet_amount))
                $wallet_amount = $u->wallet_amount;

            $pro      = Product_master::select('cart_products.product_qty', 'products.product_name', 'products.product_image', 'products.category', 'products.menu_id',
                'products.dis', 'products.type', 'products.product_price', 'products.customizable', 'products.product_for', 'products.product_rating', 'products.cuisines',
                'products.addons', 'variants.id as variant_id', 'variants.*', 'cuisines.*', 'cuisines.id as cuisine_id', 'addons',
                'cart_product_variants.*',
                'products.id as product_id',
//                'cart_products.id as cart_product_id', 'cart_product_addons.id as cart_product_addon_id', 'cart_product_variants.id as cart_product_variant_id'
            )
                ->where('products.status', 1)
                ->join('cart_products', 'products.id', 'cart_products.product_id')
                ->where('cart_products.cart_id', $cart_id)
                ->leftJoin('variants', 'products.id', 'variants.product_id')
                ->leftJoin('cart_product_variants', 'variants.id', 'cart_product_variants.variant_id')
                ->leftJoin('cuisines', 'products.cuisines', 'cuisines.id')
                ->get()->toArray();
            $responce = [];

            foreach ($pro as $k => $product) {
                if ($product['product_id'] != '') {

                    $responce[$product['product_id']]['product_id']     = $product['product_id'];
                    $responce[$product['product_id']]['product_name']   = $product['product_name'];
                    $responce[$product['product_id']]['product_qty']    = $product['product_qty'];
                    $responce[$product['product_id']]['product_image']  = asset('products') . '/' . $product['product_image'];
                    $responce[$product['product_id']]['category']       = $product['category'];
                    $responce[$product['product_id']]['menu_id']        = $product['menu_id'];
                    $responce[$product['product_id']]['dis']            = $product['dis'];
                    $responce[$product['product_id']]['type']           = $product['type'];
                    $responce[$product['product_id']]['product_price']  = $product['product_price'];
                    $responce[$product['product_id']]['customizable']   = $product['customizable'];
                    $responce[$product['product_id']]['product_for']    = $product['product_for'];
                    $responce[$product['product_id']]['product_rating'] = $product['product_rating'];
                    $responce[$product['product_id']]['addons']         = $product['addons'];
//                    $responce[$product['product_id']]['cart_product_id']         = $product['cart_product_id'];
//                    $responce[$product['product_id']]['cart_product_addon_id']   = $product['cart_product_addon_id'];
//                    $responce[$product['product_id']]['cart_product_variant_id'] = $product['cart_product_variant_id'];


                    if ($product['variant_id'] != '') {
                        $responce[$product['product_id']]['variants'][$product['variant_id']]['variant_name']  = $product['variant_name'];
                        $responce[$product['product_id']]['variants'][$product['variant_id']]['variant_price'] = $product['variant_price'];
                        $responce[$product['product_id']]['variants'][$product['variant_id']]['variant_qty']   = $product['variant_qty'];
                    }

                    if ($product['cuisine_id'] != '') {
                        $responce[$product['product_id']]['cuisines'][$product['cuisine_id']]['name']          = $product['name'];
                        $responce[$product['product_id']]['cuisines'][$product['cuisine_id']]['cuisinesImage'] = $product['cuisinesImage'];
                    }
                }
            }
            foreach ($responce as $i => $p) {

                if (isset($p['variants']))
                    $r[$i]['variants'] = array_values($p['variants']);

                if (isset($p['cuisines']))
                    $r[$i]['cuisines'] = array_values($p['cuisines']);

                if ($p['addons'] != '') {
                    $addons          = explode(',', $p['addons']);
                    $r[$i]['addons'] = \App\Models\Addons::select('addons.id', 'addon', 'price', 'cart_product_addons.addon_qty')
                        ->leftJoin('cart_product_addons', 'cart_product_addons.addon_id', 'addons.id')
                        ->whereIn('addons.id', $addons)->get()->toArray();
                }
                unset($p['variants']);
                unset($p['cuisines']);
                unset($p['addons']);
                $r[$i] = array_merge($r[$i], $p);
            }
            $r             = array_values($r);
            $admin_setting = AdminMasters::select('max_cod_amount')->find(config('custom_app_setting.admin_master_id'));

            return response()->json(['status'   => true, 'message' => 'Data Get Successfully',
                                     'response' => ["cart" => $r, 'wallet_amount' => $wallet_amount, 'max_cod_amount' => @$admin_setting->max_cod_amount]], 200);
        } catch (Throwable $th) {
            return response()->json(['status' => False, 'error' => $th->getMessage()], 500);
        }
    }

    public function get_cart(Request $request)
    {
        try {
//            $validateUser = Validator::make($request->all(), [
//                'user_id' => 'required|numeric'
//            ]);
//            if ($validateUser->fails()) {
//                $error = $validateUser->errors();
//                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
//            }

            $cart_users = Cart::select('user_id', 'vendor_id', 'id')->with(['products'])->where('user_id', $request->user()->id)->first();
            if (!isset($cart_users->id))
                return response()->json(['status' => false, 'error' => "your cart is empty"], 401);

            $r                          = $cart_users->toArray();
            $cart_pro                   = CartProduct::where('cart_id', $cart_users->id)->select(DB::raw('SUM(product_qty) as total_product_qty'))->groupBy('cart_id')->get();
            $r['total_product_in_cart'] = $cart_pro[0]->total_product_qty;
            return response()->json(['status'   => true,
                                     'message'  => 'Data Get Successfully',
                                     'response' => [
                                         "cart" => $r,
                                     ]], 200);
        } catch (Throwable $th) {
            return response()->json(['status' => False, 'error' => $th->getTrace()], 500);
        }
    }

    public function delete_product_from_cart(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'product_id' => 'required|numeric'
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }

            $cart_users = Cart::where('user_id', $request->user()->id)->first();
            if (!isset($cart_users->id))
                return response()->json(['status' => false, 'error' => "your cart is empty"], 401);

            $r        = $cart_users->toArray();
            $cart_pro = CartProduct::where('cart_id', $cart_users->id)->where('product_id', $request->product_id)->delete();

            return response()->json(['status'  => true,
                                     'message' => 'Data Get Successfully',
            ], 200);
        } catch (Throwable $th) {
            return response()->json(['status' => False, 'error' => $th->getTrace()], 500);
        }
    }
}
