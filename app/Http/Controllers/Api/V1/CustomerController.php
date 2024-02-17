<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Resources\V1\CustomerCollection;
use App\Services\V1\CustomerQuery;


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
        $filter = new CustomerQuery();
        $queryItems = $filter->transform($request); // [['column', 'operator', 'value']]

        if(count($queryItems) == 0){
            return new CustomerCollection(Customer::paginate());
        } else {
            return new CustomerCollection(Customer::where($queryItems)->paginate());
        }
    }

    public function create()
    {
        // Logic to show the form for creating a new customer
    }

    public function store(Request $request)
    {
        // Logic to store a newly created customer in the database
    }

    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    public function edit($id)
    {
        // Logic to show the form for editing the specified customer
    }

    public function update(Request $request, $id)
    {
        // Logic to update the specified customer in the database
    }

    public function destroy($id)
    {
        // Logic to remove the specified customer from the database
    }
}