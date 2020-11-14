<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hobby;

class HobbyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->query('sort');
        $search = $request->query('search');

        $data = Hobby::select('hobbies.*');
        if($sort=="true"){
            $data->orderBy('name', 'asc');
        }else if($sort=="false"){
            $data->orderBy('name', 'desc');
        }

        if($search){
            $data->where('name', 'like', '%'.$search.'%');
        }

        return $data->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:4|unique:hobbies,name'
        ]);
        return Hobby::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            Hobby::findOrFail($id);
        }catch(\Exception $error){
            return response()->json([
                'error' => 'NO_CONTENT',
                'message' => "Hobby not found."
            ], 204);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|unique:hobbies,name'
        ]);
        try{
            Hobby::findOrFail($id)->update($data);
            return response()->json([
                'message' => "Hobby updated."
            ], 200);
        }catch(\Exception $error){
            return response()->json([
                'error' => 'NO_CONTENT',
                'message' => "Hobby not found."
            ], 204);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $data = Hobby::findOrFail($id);
            if($data){
                $data->delete();
                return response()->json([
                    'message' => "Hobby deleted."
                ], 200);
            }
        }catch(\Exception $error){
            return response()->json([
                'error' => 'NO_CONTENT',
                'message' => "Hobby not found."
            ], 204);
        }
    }
}
