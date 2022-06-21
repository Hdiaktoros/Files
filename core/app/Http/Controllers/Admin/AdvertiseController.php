<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertise;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class AdvertiseController extends Controller
{
    public function adds() {
        $pageTitle = 'Adds';
        $adds = Advertise::latest()->paginate(getPaginate());
        $emptyMessage = 'No add found';
        return view('admin.advertise',compact('pageTitle','adds','emptyMessage'));
    }

    public function addsStore(Request $request) {

        $this->validate($request,[
            'add_size'=>'required|in:540x776,540x984,300x250,1188x80,3033x375',
            'url'=>'required|url|max:190',
            'image' => ['required', new FileTypeValidate(['jpeg', 'jpg', 'png', 'gif'])]
        ]);

        $add_image = '';
        if($request->image){
            if ($request->image->getClientOriginalExtension() == 'gif'){

                list($width, $height) = getimagesize($request->image);
                $size = $width.'x'.$height;
                if($request->add_size != $size){
                    $notify[]=['error','Sorry image size has to be '.$request->add_size];
                    return back()->withNotify($notify);
                }

                $add_image = uploadFile($request->image, 'assets/images/front-image/');
            }else{
                list($width, $height) = getimagesize($request->image);
                $size = $width.'x'.$height;
                if($request->add_size != $size){
                    $notify[]=['error','Sorry image size has to be '.$request->add_size];
                    return back()->withNotify($notify);
                }
                $add_image = uploadImage($request->image,'assets/images/front-image/');
            }
        }

        Advertise::create([
            'add_size' => $request->add_size,
            'image' => $add_image,
            'url' => $request->url,
            'status' => isset($request->status) ? 1 : 0,
        ]);

        $notify[] = ['success', 'Advertise has been added'];
        return back()->withNotify($notify);
    }

    public function addsUpdate(Request $request,$id) {

        $this->validate($request,[
            'url'=>'required|url|max:190',
            'image' => ['nullable', new FileTypeValidate(['jpeg', 'jpg', 'png', 'gif'])]
        ]);

        $add = Advertise::findOrFail($id);

        if($request->image){

            $old = $add->image ?? null;
            if ($request->image->getClientOriginalExtension() == 'gif'){
                list($width, $height) = getimagesize($request->image);
                $size = $width.'x'.$height;

                if($add->add_size != $size){
                    $notify[]=['error','Sorry image size has to be '.$add->add_size];
                    return back()->withNotify($notify);
                }
                $add->image = uploadFile($request->image, 'assets/images/front-image/',null,$old);
            }else{
                list($width, $height) = getimagesize($request->image);
                $size = $width.'x'.$height;
                if($add->add_size != $size){
                    $notify[]=['error','Sorry image size has to be '.$add->add_size];
                    return back()->withNotify($notify);
                }
                $add->image = uploadImage($request->image,'assets/images/front-image/',null,$old);
            }
        }

        if (isset($request->status)) {
            $add->status = 1;
        }else{
            $add->status = 0;
        }

        $add->url = $request->url;
        $add->save();

        $notify[] = ['success', 'Advertise has been Updated'];
        return back()->withNotify($notify);

    }
}
