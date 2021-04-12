<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customer([
          'name'     => $row[0],
          'email'    => $row[1],
          'region' => $row[2],
          'province' => $row[3],
          'city' => $row[4],
          'cap' => $row[5],
          'address' => $row[6],
        ]);
    }
}
