<?php


namespace App\Repository;


use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderDetail;
use Yajra\DataTables\Facades\DataTables;

class OrderRepository extends Repository
{
    public function dataTable(): mixed
    {
        return DataTables::of(Order::with('customer'))
            ->addColumn('date', fn($row) => $row->date)->make(true);
    }

    public function detailDataTable($id): mixed
    {
        return DataTables::of(OrderDetail::where('order_id', $id))->make(true);
    }

    public function list(): OrderCollection
    {
        $orders = Order::with('detail');
            //->where('customer_id', auth()->guard('customer')->id

        return new OrderCollection(request()->page == 'all' ? $orders->get() : $orders->paginate(20));
    }

    public function getById($id): OrderResource
    {
        $order = Order::with('detail')
            //->where('customer_id', auth()->guard('customer')->id
            ->where('id', $id)
            ->firstOrFail();

        return new OrderResource($order);
    }

    public function save(): Order
    {
        $order = Order::create(array_merge(['customer_id' => 1, 'status' => 1], request()->only(['quantity', 'total'])));

        $order->detail()->create(request()->only(['feature_id', 'feature_items', 'feature_options', 'price']));

        return $order;
    }
}
