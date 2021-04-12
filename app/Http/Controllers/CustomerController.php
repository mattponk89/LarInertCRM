<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Exports\CustomersExport;
use App\Imports\Customersimport;
use Excel;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Customers',[
            'customers' => Customer::when($request->term,(function ($query, $term){
                $query->where('name', 'LIKE', '%'.$term.'%');
            }))->orderBy('name')->paginate()->through(function ($item){
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'email' => $item->email,
                    'region' => $item->region,
                    'province' => $item->province,
                    'city' => $item->city,
                    'cap'=> $item->cap,
                    'address' => $item->address,
                ];
            })
        ]);
    }

    public function create()
    {
      return Inertia::render('CustomersCreate', [
        'customer' => [
          'id' => "",
          'name' => "",
          'email' => "",
          'address' => "",
          'city' => "",
          'region' => "",
          'province' => "",
          'cap' => "",
        ],
      ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'region' => 'required',
            'province' => 'required',
            'city' => 'required',
            'cap'=> 'required',
            'address' => 'required'
        ]);

        $newCustomer = new Customer();
        $newCustomer->name = $request->name;
        $newCustomer->email = $request->email;
        $newCustomer->region = $request->region;
        $newCustomer->province = $request->province;
        $newCustomer->city = $request->city;
        $newCustomer->cap = $request->cap;
        $newCustomer->address = $request->address;

        $newCustomer->save();
        return redirect()->route('customers.index')
            ->with('message', 'Customer Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

  public function edit(Customer $customer)
  {
    return Inertia::render('CustomersEdit', [
      'customer' => [
        'id' => $customer->id,
        'name' => $customer->name,
        'email' => $customer->email,
        'address' => $customer->address,
        'city' => $customer->city,
        'region' => $customer->region,
        'province' => $customer->province,
        'cap' => $customer->cap,
      ],
    ]);
  }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'region' => 'required',
            'province' => 'required',
            'city' => 'required',
            'cap'=> 'required',
            'address' => 'required'
        ]);

        $newCustomer = Customer::find($id);
        $newCustomer->name = $request->name;
        $newCustomer->email = $request->email;
        $newCustomer->region = $request->region;
        $newCustomer->province = $request->province;
        $newCustomer->city = $request->city;
        $newCustomer->cap = $request->cap;
        $newCustomer->address = $request->address;

        $newCustomer->save();

        return redirect()->route('customers.index')
          ->with('message', 'Customer Created Successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')
            ->with('message', 'Customer Deleted Successfully.');
    }


    /*
     * IMPORT & EXPORT EXCEL ETC
     *
     * */
    public function fileImportExport()
    {
      return Inertia::render('ImportExport');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileImport(Request $request)
    {
      $this->validate($request, [
        'file' => 'required',
      ]);

      Excel::import(new CustomersImport, $request->file('file')->store('temp'));
      return redirect()->route('customers.index')
        ->with('message', 'Customer Deleted Successfully.');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileExport()
    {
      return Excel::download(new CustomersExport, 'customers-collection.xlsx');
    }
}
