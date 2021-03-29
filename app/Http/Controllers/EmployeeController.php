<?php

namespace App\Http\Controllers;

use App\Models\EmployeeModel;
use App\Models\PositionModel;
use App\Services\Miscellaneous;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
      * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = 'employees.index';
        return view('employees.index', compact('active'));
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function datatable(Request $request)
    {

        $employees = EmployeeModel::with('position');

        $search = trim($request->search['value']);
        if(strlen($search)){
            $employees = $employees
            ->where('first_name', 'like',"%" . $search . "%")
            ->orwhere('last_name', 'like',"%" . $search . "%")
            ->orWhere('email', 'like',"%" . $search . "%")
            ->orWhere('phone', 'like',"%" . $search . "%")
            ->orWhereHas('position', function($position) use($search){
                $position->where('position', 'like',"%" . $search . "%");
            })
            ->orWhereHas('higher_up', function($higher_up) use($search){
                $higher_up->where('first_name', 'like',"%" . $search . "%")->orWhere('last_name', 'like',"%" . $search . "%");
            });
          }

        return datatables()
        ->eloquent($employees)
        ->addColumn('name', function (EmployeeModel $employee)  use ($search){
         //return '<div class="text-center"><span class="align-middle">'.$employee->first_name.' '.$employee->last_name.'</span></div>';
         $name = $employee->first_name.' '.$employee->last_name;
         $url = route('employees.show', ['employee' => $employee]);
         return '<div class="text-center"><a href="'.$url.'">'.Miscellaneous::highlightsubstr($name,$search).'</a></div>';
        })
        ->addColumn('position', function (EmployeeModel $employee) use ($search){
            if($employee->position_id != null){
                // return '<div class="text-center">'.$employee->position->position.'</div>';
                $position = $employee->position;
                $url = route('positions.show', ['position' => $position]);
                return '<div class="text-center"><a href="'.$url.'">'.Miscellaneous::highlightsubstr($position->position,$search).'</a></div>';
            }
            else{
                return '<div class="text-center">'.'-'.'</div>';
            }
        })
        ->addColumn('higher_up', function (EmployeeModel $employee) use ($search){
            if($employee->higher_up_id != null){
                //return '<div class="text-center">'.$employee->higher_up->first_name.' '.$employee->higher_up->last_name.'</div>'; //.' ('.$employee->higher_up->position->position.')'
                $name = $employee->higher_up->first_name.' '.$employee->higher_up->last_name;
                $url = route('employees.show', ['employee' => $employee->higher_up]);
                return '<div class="text-center"><a href="'.$url.'">'.Miscellaneous::highlightsubstr($name,$search).'</a></div>';
            }
            else{
                return '<div class="text-center">'.'-'.'</div>';
            }


         })
        ->addColumn('email', function (EmployeeModel $employee) use ($search){
            //return '<div class="text-center">'.$employee->email.'</div>';
            $email = $employee->email;
           // $url = route('positions.show', ['position' => $position]);
            return '<div class="text-center">'.Miscellaneous::highlightsubstr($email,$search).'</div>';
        })
        ->addColumn('phone_number', function (EmployeeModel $employee) use ($search){
            $phone = $employee->phone;
             return '<div class="text-center">'.Miscellaneous::highlightsubstr($phone,$search).'</div>';
        })
        ->addColumn('photo', function (EmployeeModel $employee){
            return '<div class="text-center">'.'<img src="'.asset($employee->photo).'" style="max-height:100px;max-width:100px">'.'</div>';
        })
        ->addColumn('salary', function (EmployeeModel $employee){
            return '<div class="text-center">'.$employee->salary.'</div>';
        })
        ->addColumn('more', function (EmployeeModel $employee){
            $html = '<table style="padding-left:50px;width: 100%">';
            $html .= '<tr class="text-center">';
            $html .= '<th>'.'Recruitment Date'.'</th><th>'.'Updated At'.'</th><th>'.'Show'.'</th><th>'.'Edit'.'</th><th>'.'Delete'.'</th>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td><div class="text-center">'.$employee->recruitment_date.'</td>';
            $html .= '<td><div class="text-center">'.$employee->updated_at.'</td>';
            $html .= '<td><div class="text-center">
            <a href="'.route('employees.show',[$employee->id]).'" class="btn btn-sm btn-primary m-r-5">
            <i class="fas fa-eye"></i></a><div></td>';
            $html .= '<td><div class="text-center">
            <a href="'.route('employees.edit',[$employee->id]).'" class="btn btn-sm btn-warning m-r-5">
            <i class="fas fa-pen"></i></a><div></td>';
            $html .= '<td><div class="text-center">
            <a href="#" class="btn btn-sm btn-danger m-r-5 delete-position" data-toggle="modal" data-target="#deleteEmployeeModal" data-employee="'.$employee->id.'" 
            data-name="'.$employee->first_name.' '.$employee->last_name.'"><i class="far fa-times-circle"></i></a><div></td>';
            $html .= '</table>';
             return $html;
        })
        ->rawColumns(['higher_up','name','position','photo','actions','more','phone_number','salary','email'])
        ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = PositionModel::orderBy('priority')->get();

        $active = 'employees.create';

        if($positions->isEmpty()){
            $higher_ups = collect([]);
        }
        else{
            $higher_ups = EmployeeModel::where('position_id',PositionModel::orderByDesc('priority')->first()->priority)->limit(100)->get();
        }

        return view('employees.create', compact('active', 'positions', 'higher_ups'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       

            $request->validate([
                'logo' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'position' => 'required',
                'salary' => 'required',
                // 'higher_up' => 'required',
                'date_of_employment' => 'required'
                // 'website' => 'required',
              ]);
        
            $employee = new EmployeeModel();
            $employee->photo = 'dist/img/user2-160x160.jpg';
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->email = $request->email;
            $employee->phone = '+380'.$request->phone;
            if($request->position){
                $employee->position_id = $request->position;
            }
            else{
                $employee->position_id =null;
            }
            $employee->salary = $request->salary;
    
            if($request->higher_up){
                $employee->higher_up_id = $request->higher_up;
            }
            else{
                $employee->position_id =null;
            }

            $employee->recruitment_date = $request->date_of_employment;
            $employee->admin_created_id = auth()->user()->id;
            $employee->admin_updated_id = auth()->user()->id;
            $employee->updated_at = now();
            $employee->save();
  
            if($request->logo){

                $imageName = time().'.'.$request->logo->extension();  
                $request->logo->move(public_path('assets/logos/'.$employee->id), $imageName);

                $employee = EmployeeModel::find($employee->id);
                $employee->photo = 'assets/logos/'.$employee->id.'/'.$imageName;
                $employee->save();

            }    
        
            return redirect()->route('employees.show', ['employee' => $employee])
                ->with('success', 'Данные сотрудника изменены');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmployeeModel  
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $employee = EmployeeModel::find($id);
        $active = 'position.show';
        if($employee){
        return view('employees.show', compact('active','employee'));
        }
        else{
            abort(404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeeModel
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeModel $employee)
    {

        $positions = PositionModel::orderBy('priority')->get();

        //вассал моего вассала  - не мой вассал
        if($employee->position_id == null || $positions->isEmpty()){
            $higher_ups = [];
        }
        else{

            if($employee->position->priority > 1){
                $higher_ups = EmployeeModel::where('position_id',PositionModel::where('priority','<', $employee->position->priority)->orderByDesc('priority')->get()->pluck('priority')->first())->limit(100)->get();
            }
            else{
                $higher_ups = EmployeeModel::where('position_id',PositionModel::where('priority',$employee->position->priority)->first()->id)->get();
            }

         }

        return view('employees.edit', compact('employee','positions','higher_ups'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeModel 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeModel $employee)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'position' => 'required',
            'salary' => 'required',
            'date_of_employment' => 'required'
          ]);
    
        //   $employee = EmployeeModel::find($employee->id);
        $employee = EmployeeModel::find($employee->id);

        if($request->logo != null){
            $employee->photo = $request->logo;
        }
        // else{
        //     $employee->photo =null;
        // }

        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->email = $request->email;
        $employee->phone = '+380'.$request->phone;

        if($request->position){
            $employee->position_id = $request->position;
        }
        else{
            $employee->position_id =null;
        }

        $employee->salary = $request->salary;

        if($request->higher_up){
            $employee->higher_up_id = $request->higher_up;
        }
        else{
            $employee->position_id =null;
        }

        $employee->recruitment_date = $request->date_of_employment;
        $employee->admin_updated_id = auth()->user()->id;
        $employee->updated_at = now();
        
        $employee->save();

    
        return redirect()->route('employees.show', ['employee' => $employee])
            ->with('success', 'Данные компании изменены');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeModel 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $first_name = EmployeeModel::find($id)->first_name;
        $last_name = EmployeeModel::find($id)->last_name;

        $updated = EmployeeModel::where('higher_up_id', $id)->update(['higher_up_id' => null]);
        EmployeeModel::where('id', $id)->delete();

        return response()->json([
            'name' => $first_name.' '.$last_name,
            'updated' => $updated
        ]);
    }
}
