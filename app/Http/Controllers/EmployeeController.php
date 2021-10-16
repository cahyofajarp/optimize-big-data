<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::limit(400)->get();
        $perPage = 10;
        $page = count($employees) / $perPage;
        $number_page = 31;
        $current_page = $number_page > $page ? 1 : $number_page; 

        //-----------------------------------------------------------------------
        $a = 0;
        $b = $page + 1;
        //-----------------------------------------------------------------------
        
        for($i = 1; $i <= $page; $i++){
            $a++;
            $b--;
            if($current_page < 5){
                if($a > 6 && $i < $page){
                    continue;
                }
                else if($a == 6){
                    echo '... ';
                }
                else{
                    echo $a.' ';
                }
            }
            else if($current_page >= 5){
                
                if($a == 1 || $a == 40){
                    echo $a.' ';
                }
                else if($a == $current_page - 2 || $a == $page -1 ){
                    echo '... ';
                }
                else if($a <= $current_page - 3  || $a > $current_page + 1 && $a < $page){
                    continue;
                }

                else {
                    echo $a.' ';
                }
            }
        }

        // return view('employee.index',compact('employees'));
    }

    public function lazyload(Request $request)
    {
        $employees = Employee::paginate(10);

        // if($request->ajax()){
            $employees = Employee::paginate(10);
            return response()->json(['html' => $employees]);

        // }
        
        // return view('employee.lazyload',compact('employees'));

    }   
    
    public function lazyload2(Request $request)
    {
        if($request->ajax()){
            if($request->boolean == 'false'){
                $employees = Employee::limit(10)->get();
            }else{
                $employees = Employee::limit(10)->where('id','>',(int) $request->whereId)->get(); 
            }
            return response()->json(['html' => $employees]);

        }
        
        return view('employee.lazyload2');

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
