<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\CrudRepository;
use App\Http\Repositories\UsersRepository;

class UsersController extends Controller
{
    public function index()
    {
    	$crud = new CrudRepository(new UsersRepository());

        return $crud->index();
    }

    public function create()
    {
    	# code...
    }

    public function store(Request $request)
    {
    	# code...
    }

    public function show($id)
    {
    	# code...
    }

    public function edit(Request $request, $id)
    {
    	# code...
    }

    public function delete($id)
    {
    	# code...
    }
}
