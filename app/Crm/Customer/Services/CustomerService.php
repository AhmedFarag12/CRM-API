<?php

namespace Crm\Customer\Services;

use Crm\Customer\Events\CustomerCreation;
use Crm\Customer\Models\Customer;
use Crm\Customer\Repositories\CustomerRepository;
use Crm\Customer\Requests\CreateCustomer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerService
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository){

        $this->customerRepository = $customerRepository;
    }

    public function index(){

        return  $this->customerRepository->all();
    }

    public function create(CreateCustomer $request){
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->save();

        event(new CustomerCreation($customer));
         return $customer;
    }

    public function show($id){
        return $this->customerRepository->find($id);


    }

    public function update(Request $request , $id){
        $customer =  Customer::find($id);

        if(! $customer){
            return response()->json(['status'=>'Not Found!'], Response::HTTP_NOT_FOUND);
        }
        $customer->name = $request->name;
        $customer->save();
        return $customer;
    }
    public function delete(Request $request , int $id){
        $customer =  Customer::find($id);

        if(! $customer){
            return response()->json(['status'=>'Not Found!'],Response::HTTP_NOT_FOUND);
        }
        $customer->delete();
        return response()->json(['status'=>'Deleted!'],Response::HTTP_OK);
    }
}
