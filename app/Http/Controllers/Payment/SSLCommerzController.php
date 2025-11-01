<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Mail\OrderPlaced;
use App\Models\District;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SSLCommerzController extends Controller
{
    public function redirect(Request $request)
    {
        $data = session('ssl_payment_data');

        if (!$data) {
            return abort(404, 'Payment data not found');
        }

        $postData = [
            'total_amount' => $data['grand_total'],
            'currency' => "BDT",
            'tran_id' => $data['order_id'],
            'product_category' => "Goods",
            'product_name' => "Jersey",
            'product_profile' => "physical-goods",
            'cus_name' => $data['name'],
            'cus_email' => $data['email'] ?? 'customer@example.com',
            'cus_add1' => $data['shipping_address'],
            'cus_phone' => $data['phone'],
            'ship_name' => $data['name'],
            'ship_add1' => $data['shipping_address'],
            'ship_city' => District::find($data['district_id'])?->name ?? 'Unknown',
            'ship_country' => "Bangladesh",
            'shipping_method' => "Courier",
            'ship_postcode' => '1200',
            'success_url' => route('sslcommerz.success'),
            'fail_url' => route('sslcommerz.fail'),
            'cancel_url' => route('sslcommerz.cancel'),
            'value_a' => json_encode($data),
        ];

        $sslc = new SslCommerzNotification();
        $payment_options = $sslc->makePayment($postData, 'hosted');

        if (is_array($payment_options) && isset($payment_options['GatewayPageURL'])) {
            return redirect()->away($payment_options['GatewayPageURL']);
        }

        return abort(500, 'SSLCommerz Payment Gateway Error');
    }


    public function success(Request $request)
    {
        // $sslc = new SslCommerzNotification();

        // // ✅ UPDATED: Decode value_a instead of using session
        // $data = json_decode($request->value_a, true); // This was the fix!

        // // ✅ Handle missing or invalid JSON
        // if (!$data) {
        //     \Log::error('SSLCommerz success - value_a decoding failed', [
        //         'value_a' => $request->value_a,
        //         'request' => $request->all(),
        //     ]);
        //     return abort(400, 'Invalid payment data received.');
        // }

        // // ✅ Validate the payment
        // if ($sslc->orderValidate($request->all(), $request->tran_id, $request->amount, $request->currency)) {

        //     // ✅ Create the order
        //     $order = Order::create([
        //         'order_id' => $data['order_id'],
        //         'user_id' => $data['user_id'],
        //         'user_type' => 'customer',
        //         'name' => $data['name'],
        //         'email' => $data['email'],
        //         'phone' => $data['phone'],
        //         'shipping_address' => $data['shipping_address'],
        //         'district_id' => $data['district_id'],
        //         'payment_type' => 'sslcommerz',
        //         'shipping_method' => $data['shipping_method_id'],
        //         'shipping_cost' => $data['shipping_charge'],
        //         'order_date' => now(),
        //         'note' => $data['note'],
        //         'grand_total' => $data['grand_total'],
        //         'subtotal' => $data['subtotal'],
        //         'cupon_code' => $data['coupon']['code'] ?? null,
        //         'coupon_discount' => $data['coupon']['discount'] ?? 0,
        //     ]);

        //     // ✅ Insert order items
        //     foreach ($data['cart'] as $item) {
        //         $product = Product::find($item['product_id']);
        //         if ($product && $product->quantity >= $item['quantity']) {
        //             $price = $item['offer_price'];
        //             $product->decrement('quantity', $item['quantity']);

        //             $orderItem = $order->orderItems()->create([
        //                 'product_id' => $product->id,
        //                 'quantity' => $item['quantity'],
        //                 'price' => $price,
        //             ]);

        //             // Insert item variations
        //             foreach (['size', 'color'] as $attr) {
        //                 if (!empty($item[$attr])) {
        //                     $orderItem->orderItemVariations()->create([
        //                         'attribute_name' => $attr,
        //                         'attribute_value' => $item[$attr],
        //                     ]);
        //                 }
        //             }
        //         }
        //     }

        //     // ✅ Send confirmation email
        //     Mail::to(config('app.email'))->send(new OrderPlaced($order));

        //     // ✅ Clear cart and coupon sessions
        //     session()->forget('cart');
        //     session()->forget('applied_coupon');
        //     session()->forget('ssl_payment_data'); // this was the original session key

        //     // ✅ Redirect to order success page
        //     return redirect()->route('success.order', ['order_id' => $order->order_id]);
        

        // return redirect()->route('sslcommerz.fail');
    }



    public function fail()
    {
        return view('payment.fail');
    }

    public function cancel()
    {
        return view('frontend.pages.payment.cancel');
    }

}
