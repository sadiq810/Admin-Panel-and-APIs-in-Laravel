<?php

namespace App\Http\Controllers;

use App\Repository\OrderRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('order.index');
    }

    public function list(): mixed
    {
        return (new OrderRepository())->dataTable();
    }

    public function detail()
    {
        return (new OrderRepository())->detailDataTable(request()->id);
    }
}
