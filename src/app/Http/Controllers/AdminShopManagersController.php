<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminShopManagersController extends Controller
{
    public function index(Request $request){
        $query = User::where('role', 2);

        if($request->filled('keyword')){
            $keyword = '%' . $request->input('keyword') . '%';
            $query->where(function($query) use ($keyword){
                $query->where('name', 'like', $keyword)
                    ->orWhere('email', 'like', $keyword);
            });
        }

        $shopManagers = $query->paginate(10);

        return view('admin.index', compact('shopManagers'));
    }

    public function show($id){
        $shopManager = User::find($id);
        if(!$shopManager){
            return response()->view('errors.shopManager-detail', ['message' => '該当のユーザーが存在しません。'], 404);
        }
        return view('admin.detail', compact('shopManager'));
    }

}
