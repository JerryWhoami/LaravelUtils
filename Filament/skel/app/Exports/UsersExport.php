<?php

namespace App\Exports;

use Maatwebsite\Excel\Excel;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Responsable;

class UsersExport implements FromCollection, Responsable
{
  use Exportable;

  private Collection $records;
  private $fileName = 'users.xlxs';
  private $writerType = Excel::XLSX;
  private $headers = [
    // 'Content-Type' => 'text/csv',
    'Content-Type' => 'application/vnd.ms-excel',
  ];

  public function __construct(Collection $records=null)
  {
    $this->records = $records;
  }

  public function collection()
  {
    if (! $this->records) {
      return User::all();
    }
    return $this->records;
  }
}
