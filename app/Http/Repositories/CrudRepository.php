<?php
namespace App\Http\Repositories;

use App\User;
use Illuminate\Http\Request;

class CrudRepository
{
    protected $crudInterface;

    public function __constrct(CrudInterface $crudInterface)
    {
        $this->crudInterface = $crudInterface;
    }

    // Show list of the user
    public function index(){
        return "Return the view page from the index";
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
