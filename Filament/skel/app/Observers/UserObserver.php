<?php

namespace App\Observers;

use App\Models\User;

class UserObserver extends BaseObserver
{
  public $modelName = "Usuario";
  public $modelKey = "username";

}
