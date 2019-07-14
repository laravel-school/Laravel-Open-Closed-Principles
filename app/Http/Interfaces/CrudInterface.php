<?php namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface CrudInterface{
	// Show list of the user
	public function index();

	// Show create form
	public function create();

    // Store a new record
    public function store(Request $request);

    // Show edit form
    public function edit($id);

    // Update an existing record.
    public function put(Request $request, $id);

    // Delete a record
    public function delete($id);
}
