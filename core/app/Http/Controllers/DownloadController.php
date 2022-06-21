<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class DownloadController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function order(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|gt:0'
        ]);



        $product = Product::where('status',1)->findOrFail($request->product_id);
        $general = GeneralSetting::first();
        $user = auth()->user();


        if ($product->type == 0 && $product->price == null) {

            $order = new Download();
            $order->user_id = $user->id;
            $order->product_id = $product->id;
            $order->price = null;
            $order->currency = null;
            $order->save();

            $product->download += 1;
            $product->save();

            $notify[] = ['success', 'Download Successful!! You can download your product from here.'];
            return redirect()->route('user.downloads')->withNotify($notify);

        }elseif($product->type == 1 && $product->price){

            if ($user->balance >= $product->price) {

                $user->balance -= $product->price;
                $user->save();

                $transection = new Transaction();
                $transection->user_id = $user->id;
                $transection->amount = $product->price;
                $transection->post_balance = $user->balance;
                $transection->trx_type = '-';
                $transection->trx = getTrx();
                $transection->details = 'Subtracted from your balance for purchasing product';
                $transection->save();

                $order = new Download();
                $order->user_id = $user->id;
                $order->product_id = $product->id;
                $order->price = $product->price;
                $order->currency = $general->cur_text;
                $order->save();

                $product->download += 1;
                $product->save();

                notify($user, 'PRODUCT_PURCHASED', [
                    'trx' => $transection->trx,
                    'amount' => showAmount($product->price),
                    'currency' => $general->cur_text,
                    'post_balance' => showAmount($user->balance),
                    'product' => $product->name
                ]);

                $notify[] = ['success', 'Download Successful!! You can download your product from here.'];
                return redirect()->route('user.downloads')->withNotify($notify);

            }elseif($user->balance < $product->price){

                $notify[] = ['error', 'You do not have sufficient balance. Make some balance from here'];
                return redirect()->route('user.deposit')->withNotify($notify);
            }else{

                $notify[] = ['error', 'Something goes wrong.'];
                return redirect()->route('home')->withNotify($notify);
            }
        }else{
            $notify[] = ['error', 'Something goes wrong.'];
            return redirect()->route('home')->withNotify($notify);
        }
    }

    public function downloads()
    {
        $pageTitle = 'Your Downloads';
        $emptyMessage = 'You have no downloads yet';

        $downloads = Download::where('user_id',auth()->user()->id)->latest()->with('product')->paginate(getPaginate());

        return view($this->activeTemplate . 'user.downloaded', compact('pageTitle','downloads','emptyMessage'));
    }

    public function productDownload($id)
    {
        $product = Product::findOrFail(Crypt::decrypt($id));

        $file = $product->file;
        $full_path = 'assets/product/' . $file;
        $title = Str::snake($product->name);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mimetype = mime_content_type($full_path);
        header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
        header("Content-Type: " . $mimetype);
        return readfile($full_path);
    }

    public function rating(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|gt:0|max:5',
            'product_id' => 'required|integer|gt:0',
            'review' => 'required',
        ]);

        $product = Download::where('product_id',$request->product_id)->where('user_id',auth()->user()->id)->first();

        if ($product == null) {
            $notify[] = ['error', 'Something goes wrong'];
            return back()->withNotify($notify);
        }

        $rating = new Rating();
        $rating->product_id = $request->product_id;
        $rating->user_id = auth()->user()->id;
        $rating->rating = $request->rating;
        $rating->review = $request->review;
        $rating->save();

        $totalRatingProduct = $product->product->total_rating + $request->rating;
        $totalResponseProduct = $product->product->total_response + 1;
        $avgRatingProduct = round($totalRatingProduct / $totalResponseProduct);

        $product->product->total_rating = $totalRatingProduct;
        $product->product->total_response = $totalResponseProduct;
        $product->product->avg_rating = $avgRatingProduct;
        $product->product->save();

        $notify[] = ['success', 'Thanks for your review'];
        return back()->withNotify($notify);
    }
}
