<?php

namespace App\Http\Controllers;

use App\Http\Repository\ProductRepository;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $carts = ProductRepository::index();
        return $this->success($carts, trans('general.fetch'));
    }
}
