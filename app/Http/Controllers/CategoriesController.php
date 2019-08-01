<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CrudRepository;
use App\Http\Repositories\CategoriesRepository;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
    	$crud = new CrudRepository(new CategoriesRepository());

        return $crud->index();
    }
}
