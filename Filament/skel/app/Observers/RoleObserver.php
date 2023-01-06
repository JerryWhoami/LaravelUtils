<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver extends BaseObserver
{
  public $modelName = "Role";
  public $modelKey = "name";

}
