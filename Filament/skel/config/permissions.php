<?php

return [
  [ "id" => "adm", "parent" => "#", "text" => "Administración" ],
  [ "id" => "app", "parent" => "#", "text" => "Aplicación" ],

  [ "id" => "role", "parent" => "adm", "text" => "Roles" ],
  [ "id" => "role.index", "parent" => "role", "text" => "Listar" ],
  [ "id" => "role.create", "parent" => "role", "text" => "Agregar" ],
  [ "id" => "role.view", "parent" => "role", "text" => "Ver" ],
  [ "id" => "role.update", "parent" => "role", "text" => "Editar" ],
  [ "id" => "role.delete", "parent" => "role", "text" => "Eliminar" ],
  [ "id" => "role.toggleflag-active", "parent" => "role", "text" => "Alternar Activo" ],
  [ "id" => "role.toggleflag-blocked", "parent" => "role", "text" => "Alternar Admin" ],

  [ "id" => "user", "parent" => "adm", "text" => "Usuarios" ],
  [ "id" => "user.index", "parent" => "user", "text" => "Listar" ],
  [ "id" => "user.create", "parent" => "user", "text" => "Agregar" ],
  [ "id" => "user.view", "parent" => "user", "text" => "Ver" ],
  [ "id" => "user.update", "parent" => "user", "text" => "Editar" ],
  [ "id" => "user.delete", "parent" => "user", "text" => "Eliminar" ],
  [ "id" => "user.toggleflag-active", "parent" => "user", "text" => "Alternar Activo" ],
  [ "id" => "user.toggleflag-blocked", "parent" => "user", "text" => "Alternar Bloqueado" ],
  [ "id" => "user.set-password", "parent" => "user", "text" => "Fijar Contraseña" ],


];
