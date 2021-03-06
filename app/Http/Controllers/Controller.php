<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
  	protected function buildFailedValidationResponse(\Illuminate\Http\Request $request, array $errors)
  	{
      	return response(["success"=> false , "message" => $errors],401);
  	}
}
