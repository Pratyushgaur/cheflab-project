<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AdminMasters;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\CartProductAddon;
use App\Models\CartProductVariant;
use App\Models\Catogory_master;
use App\Models\Cuisines;
use App\Models\Product_master;
use App\Models\User;
use App\Models\Variant;
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
                    $product=Product_master::where('userId', $request->vendor_id)->where('id', $p['product_id'])->first();
                    if (!isset($product->id)) {
                        return response()->json(['status' => false, 'error' => 'provided product not available under given vendor.'], 401);
                    }
                    $cart_products = new CartProduct($p);
                    $cart_obj->products()->save($cart_products);

                    if($product->customizable=='false'){//if product is not customizable ,then product qty=primary variant qty
                        $verint_obj=Variant::where('product_id',$product->id)->first();
                        if(isset($verint_obj->id)){
                            $CartProductVariant                  = new CartProductVariant();
                            $CartProductVariant->cart_product_id = $cart_products->id;
                            $CartProductVariant->variant_id      = $verint_obj->id;
                            $CartProductVariant->variant_qty     = $p['product_qty'];
                            $CartProductVariant->save();
                        }
                    }

                    if (isset($p['variants']) && $product->customizable=='true')
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

                $cart_objs = Cart::where('user_id', $request->user()->id)->get();
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

            $cart_sub_toatl_amount =0; $wallet_amount = 0;
            $u                     = User::select('wallet_amount')->find($request->user_id);
            if (isset($u->wallet_amount))
                $wallet_amount = $u->wallet_amount;

            $pro      = Product_master::select('cart_products.product_qty', 'products.product_name', 'products.product_image', 'products.category', 'products.menu_id',
                'products.dis', 'products.type', 'products.product_price', 'products.customizable', 'products.product_for', 'products.product_rating', 'products.cuisines',
                'products.addons', 'variants.id as variant_id', 'variants.*', 'addons',
                'cart_product_variants.*', 'products.id as product_id'
//                'cart_products.id as cart_product_id', 'cart_product_addons.id as cart_product_addon_id', 'cart_product_variants.id as cart_product_variant_id'
            )
                ->where('products.status', 1)->where('products.product_approve', 1)
                ->join('cart_products', 'products.id', 'cart_products.product_id')
                ->where('cart_products.cart_id', $cart_id)
                ->leftJoin('variants', 'products.id', 'variants.product_id')
                ->leftJoin('cart_product_variants', 'variants.id', 'cart_product_variants.variant_id')
                ->get()->toArray();
            $responce = [];

            foreach ($pro as $k => $product) {
                if ($product['product_id'] != '' && !isset($responce[$product['product_id']])) {

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

                    $variants = Variant::where('product_id', '=', $product['product_id'])->select('variant_name', 'variant_price', 'id as variant_id')->get();
                    if (isset($variants[0]))//if product have variants
                        foreach ($variants as $vkey => $vvalue) {
                            $exist = CartProduct::where('cart_id', '=', $cart_id)->where('product_id', '=', $product['product_id'])
                                ->leftJoin('cart_product_variants', 'cart_products.id', '=', 'cart_product_variants.cart_product_id')
                                ->where('cart_product_variants.variant_id', '=', $vvalue['variant_id'])
                                ->first();

                            if (!empty($exist)) {//if product have variants get and add qty and price
//                                echo "$cart_sub_toatl_amount    += ".$vvalue['variant_price']." -----------";
//                                echo "<br/>$cart_sub_toatl_amount+ $exist->variant_qty*".$vvalue['variant_price'];
                                $cart_sub_toatl_amount    += ($vvalue['variant_price']*$product['product_qty']);
//                                echo "=$cart_sub_toatl_amount";
                                $variants[$vkey]['added'] = true;
//                            $variants[$vkey]['qty'] = $exist->product_qty;
                                $variants[$vkey]['qty'] = $exist->variant_qty;

                            } else {
                                $variants[$vkey]['added'] = false;
                            }
                        }
                    else {//product have no variants
//                        dd("sdfs");
                        $cart_sub_toatl_amount    += ($product['product_price']*$product['product_qty']);
                    }
                    //     $responce[$product['product_id']]['variants'][$product['variant_id']]['variant_price'] = $product['variant_price'];
                    //     $responce[$product['product_id']]['variants'][$product['variant_id']]['variant_qty']   = $product['variant_qty'];
                    // if ($product['variant_id'] != '') {
                    //     $responce[$product['product_id']]['variants'][$product['variant_id']]['variant_name']  = $product['variant_name'];
                    //     $responce[$product['product_id']]['variants'][$product['variant_id']]['variant_price'] = $product['variant_price'];
                    //     $responce[$product['product_id']]['variants'][$product['variant_id']]['variant_qty']   = $product['variant_qty'];
                    // }
                    $responce[$product['product_id']]['variants'] = $variants;
                }
            }

            if (is_array($responce) && !empty($responce)) {
                foreach ($responce as $i => $p) {

                    $r[$i]['variants'] = $p['variants'];
                    if ($p['addons'] != '') {
                        $addons        = explode(',', $p['addons']);
                        $productAddons = \App\Models\Addons::select('id', 'addon', 'price')->whereIn('addons.id', $addons)->get()->toArray();
                        foreach ($productAddons as $akey => $avalue) {
                            $exist = CartProduct::where('cart_id', '=', $cart_id)->where('product_id', '=', $p['product_id'])
                                ->leftJoin('cart_product_addons', 'cart_products.id', '=', 'cart_product_addons.cart_product_id')
                                ->where('cart_product_addons.addon_id', '=', $avalue['id'])->first();
                            if (!empty($exist)) {

                                $productAddons[$akey]['added'] = true;
                                $productAddons[$akey]['qty']   = $exist->addon_qty;
                                $cart_sub_toatl_amount    +=  ($exist->addon_qty*$productAddons[$akey]['price']);

                            } else {
                                $productAddons[$akey]['added'] = false;
                            }
                        }

                        $r[$i]['addons'] = $productAddons;
                    }
                    unset($p['variants']);
                    unset($p['cuisines']);
                    unset($p['addons']);
                    $r[$i] = array_merge($r[$i], $p);
                }
                $r = array_values($r);

            } else
                $r = [];

            $admin_setting = AdminMasters::select('max_cod_amount','platform_charges')->find(config('custom_app_setting.admin_master_id'));

            $vendors = get_restaurant_near_me('','',['vendors.id'=>$cart_users->vendor_id],$request->user()->id)
                ->get();

            foreach ($vendors as $key => $value) {
                $banners = json_decode($value->banner_image);
                if (is_array($banners))
                    $urlbanners = array_map(function ($banner) {
                        return URL::to('vendor-banner/') . '/' . $banner;
                    }, $banners);
                else
                    $urlbanners = [];

                $vendors[$key]->banner_image   = $urlbanners;
                $vendors[$key]->cuisines       = Cuisines::whereIn('cuisines.id', explode(',', $value->deal_cuisines))->pluck('name');
                $category                      = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                $vendors[$key]->categories     = $category;
                $vendors[$key]->next_available = next_available_day($value->id);
            }
            $vendors=$vendors[0];


            return response()->json(['status'   => true,
                                     'message'  => 'Data Get Successfully',
                                     'response' => ["cart_id"        => $cart_id,
                                                    'cart_sub_toatl_amount'=>$cart_sub_toatl_amount,
                                                    "cart"           => $r,
                                                    "vendor"         => $vendors,
                                                    'wallet_amount'  => $wallet_amount,
                                                    'max_cod_amount' => @$admin_setting->max_cod_amount,
                                                    'platform_charges' => @$admin_setting->platform_charges,
                                                    'tax' => 5
                                     ]
            ], 200);
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
                    $product=Product_master::where('userId', $request->vendor_id)->where('id', $p['product_id'])->first();
                    if (!isset($product->id)) {
                        return response()->json(['status' => false, 'error' => 'provided product not available under given vendor.'], 401);
                    }

                    $cart_products = CartProduct::where('product_id', $p['product_id'])->where('cart_id', $cart_id)->first();
                    if ($p['product_qty'] <= 0) {
                        if (isset($cart_products->id))
                            @$cart_products->delete();
                        continue;
                    }

                    if (!$cart_products)
                        $cart_products = new CartProduct($p);
                    else {

                        $cart_products->product_id  = $p['product_id'];
                        $cart_products->product_qty = $p['product_qty'];
                    }

                    $cart_obj->products()->save($cart_products);
                    $cart_products_id[] = $cart_products->id;


                    if($product->customizable=='false'){//if product is not customizable ,then product qty=primary variant qty
                        $verint_obj=Variant::where('product_id',$product->id)->first();
                        if(isset($verint_obj->id)){
                            $CartProductVariant = CartProductVariant::where('cart_product_id', $cart_products->id)->where('variant_id', $verint_obj->id)->first();
                            if (!$CartProductVariant) {
                                $CartProductVariant                  = new CartProductVariant();
                                $CartProductVariant->cart_product_id = $cart_products->id;
                                $CartProductVariant->variant_id      = $verint_obj->id;
                            }
                            $CartProductVariant->variant_qty = $p['product_qty'];
                            $CartProductVariant->save();
                        }
                    }

                    if (isset($p['variants']) && $product->customizable=='true') {
                        foreach ($p['variants'] as $k => $v) {
                            $CartProductVariant = CartProductVariant::where('cart_product_id', $cart_products->id)->where('variant_id', $v['variant_id'])->first();
                            if ($v['variant_qty'] <= 0) {
                                if (isset($CartProductVariant->id))
                                    @$CartProductVariant->delete();
                                continue;
                            }


                            if (!$CartProductVariant) {
                                $CartProductVariant                  = new CartProductVariant();
                                $CartProductVariant->cart_product_id = $cart_products->id;
                                $CartProductVariant->variant_id      = $v['variant_id'];
                            }
                            $CartProductVariant->variant_qty = $v['variant_qty'];
                            $CartProductVariant->save();
                        }

                    }
                    if (isset($p['addons']) && $p['addons'] != '')
                        foreach ($p['addons'] as $k => $a) {
                            $CartProductAddon = CartProductAddon::where('cart_product_id', $cart_products->id)->where('addon_id', $a['addon_id'])->first();
                            if ($a['addon_qty'] <= 0) {
                                if (isset($CartProductAddon->id))
                                    @$CartProductAddon->delete();
                                continue;
                            }

                            if (!$CartProductAddon) {
                                $CartProductAddon                  = new CartProductAddon();
                                $CartProductAddon->cart_product_id = $cart_products->id;
                                $CartProductAddon->addon_id        = $a['addon_id'];
                            }
                            $CartProductAddon->addon_qty = $a['addon_qty'];
                            $CartProductAddon->save();
//                            $cart_products_addons_id[] = $CartProductAddon->id;
                        }
                }
                if (!CartProduct::where('cart_id', $cart_id)->exists()) {
                    Cart::find($cart_id)->delete();
                    CartProduct::where('cart_id', $cart_id)->delete();
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

            $cart_users = Cart::select('vendor_id', 'id')->withCount(['products'])->where('user_id', $request->user_id)->first();

            if (!isset($cart_users->id))
                return response()->json(['status' => false, 'error' => "your cart is empty"], 401);

            $r                 = $cart_users->toArray();
            $ven = Vendors::where('id','=',$r['vendor_id'])->select('name')->first();
            $cart_id           = $cart_users->id;
            $r['restaurant_name'] = $ven->name;
            $cartTotal         = CartProduct::where('cart_id', '=', $cart_id);
            $cartVarintProduct = $cartTotal->join('cart_product_variants', 'cart_products.id', '=', 'cart_product_variants.cart_product_id');
            $cartVarintProduct = $cartVarintProduct->join('variants', 'cart_product_variants.variant_id', '=', 'variants.id');
            $cartVarintProduct = $cartVarintProduct->select(DB::raw('IFNULL(SUM(variants.variant_price*cart_products.product_qty),0) as total'));
            $cartVarintProduct = $cartVarintProduct->first();
            //
            $cartWithOutVariant = CartProduct::where('cart_id', '=', $cart_id);
            $cartWithOutVariant = $cartWithOutVariant->leftJoin('cart_product_variants', 'cart_products.id', '=', 'cart_product_variants.cart_product_id');
            $cartWithOutVariant = $cartWithOutVariant->join('products', 'cart_products.product_id', '=', 'products.id');
            $cartWithOutVariant = $cartWithOutVariant->whereNull('cart_product_variants.id');
            $cartWithOutVariant = $cartWithOutVariant->select(DB::raw('IFNULL(SUM(products.product_price*cart_products.product_qty),0) as total'));
            $cartWithOutVariant = $cartWithOutVariant->first();
            //
            $cartAddon  = CartProduct::where('cart_id', '=', $cart_id);
            $cartAddon  = $cartAddon->join('cart_product_addons', 'cart_products.id', '=', 'cart_product_addons.cart_product_id');
            $cartAddon  = $cartAddon->join('addons', 'cart_product_addons.addon_id', '=', 'addons.id');
            $cartAddon  = $cartAddon->select(DB::raw('IFNULL(SUM(addons.price*cart_product_addons.addon_qty),0) as total'));
            $cartAddon  = $cartAddon->first();
            $total      = $cartVarintProduct->total + $cartWithOutVariant->total + $cartAddon->total;
            $r['total'] = $total;
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
