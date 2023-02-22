<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Requests\OrganizationRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = false;
        $data=[];
        $message='';
        try{
            $data = Organization::all();
            if($data) {
                $message = 'Organization list fetched';
                $status = true;
            }
        } catch (\Exception $e) {
            $message = 'something went wrong';
        }

        return response()->json([
            'status' => $status,
            'data' => $data,
            'message' => $message,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationRequest $request)
    {
        $status = false;
        $org_data = null;
        try{
            $data = $request->validated();
            $data = $this->setupDatabase($data);
            $this->sendRequest($data);
            $org_data = Organization::create($data);
            if($org_data){
                $status = true;
                $message = 'Organization details added successfully';
            } else {
                $message = 'Organization details not added';
            }
        } catch (\Exception $e) {
            $message = 'something went wrong';
            $message = $e->getMessage();
        }
        return response()->json([
            'status' => $status,
            'data' => $org_data,
            'message' => $message,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        //
    }

    public function setupDatabase($data = [])
    {
        $data['db_name'] = $data['name'].'_db_'.rand(2,1000);
        $data['db_username'] = 'user_'.$data['name'].rand(2,1000);
        $data['db_password'] = Str::random(40);
        $db = DB::statement('CREATE DATABASE '.$data['db_name']);
        $user = DB::statement("CREATE USER ".$data['db_username']. " WITH ENCRYPTED PASSWORD '". $data['db_password']."'");
        $grant = DB::statement("GRANT ALL PRIVILEGES ON DATABASE ".$data['db_name']." TO ".$data['db_username']);
        return $data;
    }

    public function sendRequest($data)
    {
        $response = Http::post('http://localhost:9100/',[
            'db_name' => $data['db_name'],
            'db_username' => $data['db_username'],
            'db_password' => $data['db_password']
        ]);
    }
}
