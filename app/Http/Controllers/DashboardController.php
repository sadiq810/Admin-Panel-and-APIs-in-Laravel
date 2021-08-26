<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Language;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Load dashboard view.
     */
    public function index()
    {
        return view('dashboard',[
            'orders'     => Order::count(),
            'categories' => Category::count(),
            'languages'  => Language::active()->count()
        ]);
    }//..... end of index() .....//
}
