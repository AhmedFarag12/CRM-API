<?php

namespace App\Http\Controllers;

use Crm\Customer\Requests\CreateCustomer;
use Crm\Customer\Services\CustomerExportService;
use Crm\Customer\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    private CustomerService $customerService;
    private CustomerExportService $customerExportService;


    public function __construct(CustomerService $customerService ,CustomerExportService $customerExportService)
    {
        $this->customerService = $customerService;
        $this->customerExportService = $customerExportService;

    }

    public function index(Request $request)
    {
        return $this->customerService->index($request);
    }

    public function create(CreateCustomer $request)
    {
        return $this->customerService->create($request);

    }

    public function show($id)
    {
        return $this->customerService->show($id)?? response()->json(['status'=>'Not Found!'], Response::HTTP_NOT_FOUND);

    }

    public function update(Request $request, $id)
    {
        return $this->customerService->update($request, $id);

    }

    public function delete(Request $request, $id)
    {
        return $this->customerService->delete($request, (int)$id);

    }

    public function export(Request $request){
         $this->customerExportService->export($request->get('format','json'));
    }
}
