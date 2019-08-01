<?php
namespace App\Http\Repositories;

use App\User;
use Illuminate\Http\Request;

class CrudRepository
{
    protected $crudInterfac;

    public function __constrct(CrudInterface $crudInterface)
    {
        $this->crudInterfac = $crudInterface;
    }

    // Show list of the user
    public function index(){
        return "I am from here";
    }

    // Show user create form
    public function create(){

    }

    // Store a new user record
    public function store(Request $request){

    }

    // Show User edit form
    public function edit($id){

    }

    // Update user's existing data.
    public function put(Request $request, $id){

    }

    // Delete a user
    public function delete($id){
        
    }
}
