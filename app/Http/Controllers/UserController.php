<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use ErrorException;
use App\User;
use Illuminate\Http\Response;
use App\Http\Requests\CreateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $limit = $this->getLimit();
        return User::take($limit)->get();
    }

    /**
     * Get limit from query params.
     *
     * @return int
     */
    public function getLimit() {
        try {
            $limit = request()->query()['limit'];
        } catch (ErrorException $e) {
            $limit = 10;
        }
        return (int) $limit;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $created = User::create($request->all());
        return  Response(['id' => $created->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->showOrDelete($id);
    }

    private function showOrDelete($id, $delete = false) {
        $record = User::find($id);
        ($delete) ? $record->delete() : null;
        return $this->existsRecord($record);
    }

    /**
     * Response success or not found.
     *
     * @param User|null $record
     * @return Response
     */
    private function existsRecord($record) {
        if (!empty($record)) {
            return Response($record, 200);
        } else  {
            return Response([
                'message' => 'record not found'
            ], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $record = User::find($id);
        if ($record) {
            $record->update($request->all());
        }
        return $this->existsRecord($record);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->showOrDelete($id, true);
    }
}
