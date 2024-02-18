<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Resources\V1\CustomerCollection;
use App\Filters\V1\CustomerFilter;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //it assume the every customer is customerresource see postalCode is jason file
        //return new CustomerCollection(Customer::all());
        // we may use this for pagination
        $filter = new CustomerFilter();
        $filterItems = $filter->transform($request); // [['column', 'operator', 'value']]
        
        $includeInvoices = $request->query('includeInvoices');
        
        $costumers = Customer::where($filterItems);
        
        if($includeInvoices){
            $costumers = $costumers->with('invoices');
        }
        return new CustomerCollection($costumers->paginate()->appends($request->query()));


    }

    public function create()
    {
        
    }

    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    public function show(Customer $customer)
    {
        $includeInvoices = request()->query('includeInvoices');
        if($includeInvoices){
            return new CustomerResource($customer->loadMissing('invoices'));
        }
        return new CustomerResource($customer);
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());
    }

    public function destroy($id)
    {
        
    }
}