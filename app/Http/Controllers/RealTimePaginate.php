<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Student;
use Illuminate\Http\Request;

class RealTimePaginate extends Controller
{
    public function index()
    {   // dd($employess);
        // $dt = 'ma';

        // $employees = Student::orderBy('id','ASC')
        
        // ->where('name', 'LIKE', '%' . $dt . '%')
        // ->orWhere('tanggal_lahir', 'LIKE', '%' . $dt . '%')
        
        // ->limit(10)
        // ->get();
        
        // $max = \DB::table('students')
        // ->orderBy('id','ASC')
        // ->where('name', 'LIKE', '%' . 'ma' . '%')
        // ->orWhere('tanggal_lahir', 'LIKE', '%' . '' . '%')
        // ->limit(10)->get();

        // dd($max);
        
        // $max = Student::orderBy('id','ASC')
        // ->where('name', 'LIKE', '%' . 'ma' . '%')
        // ->orWhere('tanggal_lahir', 'LIKE', '%' . '' . '%')
        // ->limit(10)->get();
        


        // $employees = Student::orderBy('id','ASC')
        // ->where('id','>','')
        // ->where('name', 'LIKE', '%' . 'ma' . '%')
        // ->orWhere('tanggal_lahir', 'LIKE', '%' . '' . '%')
        // ->limit(10)
        // ->get();


        // dd($employees->max('id'));
        return view('paginate.index');
    }

    public function showEmployee()
    {       
        $limit = 10;
        
        $count = Student::orderBy('id','ASC')->count();

        $employess = Student::limit($limit)->orderBy('id','ASC')->get();

        $max = $employess->max('id');

        return response()->json([
            'employees' => $employess,
            'limit' => $limit,
            'count' => $count,
            'max' => $max 
        ]);
    }

    public function changeNumber($id)
    {
        
        $limit = 10;
        $max = 0;
        
        $count = Student::orderBy('id','ASC')->count();

        if($id == 0){
            $employees = Student::limit($limit)->get();
        }
        else if($id > 1){
            $employees = Student::skip($id)->limit($limit)->get(); 
            $max = $employees->max('id');
        }
        return response()->json([
            'employees' => $employees,
            'limit' => $limit,
            'max' => $max,
            'count' => $count,
        ]);
    }

    public function searchStudents(Request $request)
    {   
        
        $limit = 10;

        if($request->data != '' || $request->data != null){
            
            $max = 0;
            
            $count = Student::orderBy('id','ASC')->count();

            $employees = Student::limit($limit)->get();

            $count = Student::where('name', 'LIKE', '%' . $request->data . '%')
            ->orWhere('tanggal_lahir', 'LIKE', '%' . $request->data . '%')
            ->orderBy('id','ASC')
            ->count();
            
            $employees = Student::orderBy('id','ASC')
            ->where('name', 'LIKE', '%' . $request->data . '%')
            ->orWhere('tanggal_lahir', 'LIKE', '%' . $request->data . '%')
            ->limit($limit)
            ->skip($request->page ? $request->page : 0)
            ->get();

            if($employees->count() > 0){
                $max = $employees->max('id');
            }
            
            return response()->json([
                'employees' => $employees,
                'limit' => $limit,
                'max' => $employees->count(),
                'count' => $count,
            ]);

        }else{

            $limit = 10;
            
            $count = Student::orderBy('id','ASC')->count();

            $employees = Student::limit($limit)->get();
            
            $max = 0;
            
        //    if((int) $request->page){

                
                if((int) $request->page == 0){
                    $employees = Student::limit($limit)->get();
                    $max = $employees->count();
                }
                else if((int) $request->page > 1){
                    $employees = Student::skip($request->page)->limit($limit)->get(); 
                    $max = $employees->count();
                }
        //    }
                
            return response()->json([
                'employees' => $employees,
                'limit' => $limit,
                'max' => $max,
                'count' => $count,
            ]);
        }

    
    }

}
