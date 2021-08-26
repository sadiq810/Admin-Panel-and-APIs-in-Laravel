<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Repository\OrderRepository;

class OrderController extends Controller
{
    public function list(): OrderCollection
    {
        return (new OrderRepository())->list();
    }

    public function getById($id): OrderResource
    {
        return (new OrderRepository())->getById($id);
    }

    public function save(): array
    {
        $order = (new OrderRepository())->save();

        return ['status' => true, 'message' => 'Order saved successfully.', 'data' => $order];
    }
}
