<?php
/**
 * Created by PhpStorm.
 * @author yogasukma <mail.yogasukma@gmail.com>
 */

namespace App\Http\Controllers;


use App\Payment;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;

class PlansController extends Controller
{
    public function getIndex()
    {
        return view('layouts.new-index');
    }

    public function getMonthly()
    {
        return view('payment.monthly');
    }

    public function getYearly()
    {
        return view('payment.yearly');
    }

    public function postMonthly()
    {

    }

    public function postIpn()
    {
        Log::info('1');
        // Read POST data
        $raw_post_data = file_get_contents('php://input');

        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }
        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        foreach ($myPost as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }

        if (env('PAYPAL_ENV') == 'production') {
            $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
        } else {
            $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        }

        $ch = curl_init($paypal_url);
        if ($ch == false) {
            return false;
        }
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        if (env('PAYPAL_ENV') == 'local') {
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        }

        // cert
        curl_setopt($ch, CURLOPT_CAINFO, $this->getDir());

        $res = curl_exec($ch);
        if (curl_errno($ch) != 0) {
            // cURL error

            error_log(
                date('[Y-m-d H:i e] ') . "Can't connect to PayPal to validate IPN message: " . curl_error(
                    $ch
                ) . PHP_EOL,
                3,
                base_path('storage/logs/error.log')
            );
            curl_close($ch);
            exit;
        } else {
            // Log the entire HTTP response if debug is switched on.
            error_log(
                date('[Y-m-d H:i e] ') . 'HTTP request of validation request:' . curl_getinfo(
                    $ch,
                    CURLINFO_HEADER_OUT
                ) . " for IPN payload: $req" . PHP_EOL,
                3,
                base_path('storage/logs/error.log')
            );
            error_log(
                date('[Y-m-d H:i e] ') . "HTTP response of validation request: $res" . PHP_EOL,
                3,
                base_path('storage/logs/error.log')
            );
            curl_close($ch);
        }

        // Split response headers and payload, a better way for strcmp
        Log::info('2');
        $tokens = explode("\r\n\r\n", trim($res));
        $res = trim(end($tokens));
        if (strcmp($res, 'VERIFIED') == 0) {
            Log::info('3');
            // check whether the payment_status is Completed
            // @TODO: below validation
            // check that txn_id has not been previously processed
            // check that receiver_email is your PayPal email
            // check that payment_amount/payment_currency are correct
            if (Input::get('payment_status') == 'Completed') {
                Log::info('4');
                // assign posted variables to local variables
                $payment = new Payment();
                $payment->txn_id = Input::get('txn_id');
                $payment->ipn_track_id = Input::get('ipn_track_id');
                $payment->code = Input::get('custom');
                $payment->user_id = !empty(Input::get('custom')) ? Hashids::decode(Input::get('custom'))[0] : '0';
                $payment->buyer_email = Input::get('payer_email');
                $payment->receiver_email = Input::get('receiver_email');
                $payment->amount = Input::get('mc_gross');
                $payment->currency = Input::get('mc_currency');
                $payment->type = 'posthurry';
                $payment->status = Input::get('payment_status');
                $payment->save();
            }

            error_log(
                date('[Y-m-d H:i e] ') . "Verified IPN: $req " . PHP_EOL,
                3,
                base_path('storage/logs/error.log')
            );
        } elseif (strcmp($res, 'INVALID') == 0) {
            error_log(
                date('[Y-m-d H:i e] ') . "Invalid IPN: $req" . PHP_EOL,
                3,
                base_path('storage/logs/error.log')
            );
        }

        Log::info('5');
    }

    public function getDir()
    {
        return base_path('public/cacert.pem');
    }
}