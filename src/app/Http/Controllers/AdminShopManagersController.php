<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Http\Requests\ShopManagerRequest;
use Illuminate\Support\Facades\Hash;

class AdminShopManagersController extends Controller
{
    public function index(Request $request)
    {
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

    public function show($manager_id)
    {
        $shopManager = User::find($manager_id);

        if(!$shopManager){
            return $this->errorResponse('該当の店舗責任者が存在しません。', 404);
        }

        $shopManagerShops = Shop::where('user_id', $manager_id)->paginate(5);

        return view('admin.detail', compact('shopManager', 'shopManagerShops'));
    }

    public function update(ShopManagerRequest $request, $manager_id)
    {
        $shopManager = User::find($manager_id);

        if(!$shopManager){
            return $this->errorResponse('該当の店舗責任者が存在しません。', 404);
        }

        $shopManagerData = $request->only(['name','email']);
        $shopManager->update($shopManagerData);

        return back()->with('success', '保存が成功しました。');
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(ShopManagerRequest $request)
    {
        User::create([
            'role' => 2,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        return back()->with('success', '店舗責任者が作成されました。');
    }

}
