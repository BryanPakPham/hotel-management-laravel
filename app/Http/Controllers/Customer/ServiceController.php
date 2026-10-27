<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('customer.services.index', compact('services'));
    }
}
