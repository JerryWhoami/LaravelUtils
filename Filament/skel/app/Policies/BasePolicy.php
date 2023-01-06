<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
  public $name = "";
  use HandlesAuthorization;

  public function viewAny(User $user)
  {
    return $user->hasPermission("{$this->name}.viewAny");
  }

  public function view(User $user)
  {
    return $user->hasPermission("{$this->name}.view");
  }

  public function create(User $user)
  {
    return $user->hasPermission("{$this->name}.create");
  }

  public function update(User $user)
  {
    return $user->hasPermission("{$this->name}.update");
  }

  public function delete(User $user)
  {
    return $user->hasPermission("{$this->name}.delete");
  }

  public function deleteAny(User $user)
  {
    return $user->hasPermission("{$this->name}.deleteAny");
  }

  public function restore(User $user)
  {
    return $user->hasPermission("{$this->name}.restore");
  }

  public function forceDelete(User $user)
  {
    return $user->hasPermission("{$this->name}.destroy");
  }

  public function toggleflagActive(User $user)
  {
    return $user->hasPermission("{$this->name}.toggleflagActive");
  }


  public function bulkToggleflagActive(User $user)
  {
    return $user->hasPermission("{$this->name}.bulkToggleflagActive");
  }

}
