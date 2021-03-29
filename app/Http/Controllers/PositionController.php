<?php

namespace App\Http\Controllers;

use App\Models\EmployeeModel;
use App\Models\PositionModel;
use App\Services\Miscellaneous;
use Database\Seeders\PositionModelSeeder;
use Illuminate\Http\Request;

class PositionController extends Controller
{

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_higherups(Request $request)
    {
       $position_id = $request->position_id; 
       $search = $request->search;  

       if(PositionModel::orderBy('id')->first() == null){

        $higher_ups = EmployeeModel::limit(100)->get();
 
        $higher_ups = $higher_ups->map(function ($higher_up, $key){
            return ['id' => $higher_up->id, 'text' => $higher_up->first_name.' '.$higher_up->last_name];
        });

       return response($higher_ups,200);
       }

       if($position_id == EmployeeModel::orderBy('id')->first()){
        $chief = EmployeeModel::where('position_id',PositionModel::where('priority',$position_id )->first()->id)->first();
        if($chief == null){
            $higher_ups = [];
        }
        else{
            $higher_ups = [['id' => $chief->id, 'text' => $chief->first_name.' '.$chief->last_name]];
        }
        
       }
       else{
           
        $higher_ups = EmployeeModel::where('position_id',$position_id - 1)
        ->where(function ($query) use($search){
            $query->where('first_name', 'like',"%" . $search . "%")
            ->orWhere('last_name', 'like',"%" . $search . "%");
        })->limit(100)->get();

        $higher_ups = $higher_ups->map(function ($higher_up, $key){
            //return $higher_up->only(['id', 'first_name', 'last_name']);
            return ['id' => $higher_up->id, 'text' => $higher_up->first_name.' '.$higher_up->last_name];
           });
        //  return $higher_ups;

       }

       return response($higher_ups,200);
    }

    public function datatable(Request $request)
    {

        $positions = PositionModel::where('id', '>', 0);

        $search = trim($request->search['value']);
        if(strlen($search)){
            $positions = $positions
            ->where('position', 'like',"%" . $search . "%");
        }

        return datatables()
        ->eloquent($positions)
        ->addColumn('position', function (PositionModel $position)  use ($search){
         //return '<div class="text-center"><span class="align-middle">'.$employee->first_name.' '.$employee->last_name.'</span></div>';
         $url = route('positions.show', ['position' => $position]);
         return '<div class="text-center"><a href="'.$url.'">'.Miscellaneous::highlightsubstr($position,$search).'</a></div>';
        })
        ->addColumn('position', function (PositionModel $position) use ($search){
            $url = route('positions.show', ['position' => $position]);
            return '<div class="text-center"><a href="'.$url.'">'.Miscellaneous::highlightsubstr($position->position,$search).'</a></div>';
        })
        ->addColumn('applicants', function (PositionModel $position){
            return '<div class="text-center">'.$position->applicants()->count().'</div>';
        })
        ->addColumn('rank', function (PositionModel $position){
            return '<div class="text-center">'.$position->priority.'</div>';
        })
        ->addColumn('can_be_head_to', function (PositionModel $position){
         $html = '<div class="text-center">';
         $can_be_head_to = PositionModel::where('priority', '>', $position->priority)->get();

         if($can_be_head_to->isNotEmpty()){
            foreach($can_be_head_to->pluck('position','id')->toArray() as $id => $position){
                $url = route('positions.show', ['position' => PositionModel::find($id)]);
                $html .= '<p><div class="text-center"><a href="'.$url.'">'.$position.'</a></div></p>';
            }
         }
         else{
            $html .= '<p><div class="text-center">-</div></p>';
         }
         $html .= '</div>';
         return $html;
        })
        ->addColumn('more', function (PositionModel $position){
            $html = '<table style="padding-left:50px;width: 100%">';
            $html .= '<tr class="text-center">';
            $html .= '<th>'.'Created At'.'</th><th>'.'Updated At'.'</th><th>'.'Show'.'</th><th>'.'Edit'.'</th><th>'.'Delete'.'</th>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td><div class="text-center">'.$position->created_at.'</td>';
            $html .= '<td><div class="text-center">'.$position->updated_at.'</td>';
            $html .= '<td><div class="text-center">
            <a href="'.route('positions.show',[$position->id]).'" class="btn btn-sm btn-primary m-r-5">
            <i class="fas fa-eye"></i></a><div></td>';
            $html .= '<td><div class="text-center">
            <a href="'.route('positions.edit',[$position->id]).'" class="btn btn-sm btn-warning m-r-5">
            <i class="fas fa-pen"></i></a><div></td>';
            $html .= '<td><div class="text-center">
            <a href="#" class="btn btn-sm btn-danger m-r-5" data-toggle="modal" data-target="#deletePositionModal" data-position_id="'.$position->id.'" 
            data-position="'.$position->position.'"
            data-employees="'.$position->applicants()->count().'">
            <i class="far fa-times-circle"></i></a><div></td>';
            $html .= '</table>';
             return $html;
        })
        ->rawColumns(['position','applicants','rank','can_be_head_to','more'])
        ->toJson();
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = 'positions.index';
        return view('positions.index', compact('active'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {



        $active = 'positions.create';

        $priorities = PositionModel::orderByDesc('priority')->get();

        $available_priorities = [];

        if($priorities->isEmpty()){

            $lowest_priority = 1;

        }
        else{

            $lowest_priority = $priorities->first()->priority;
            $priorities = $priorities->keyBy('priority');

            for($i=1; $i<=$lowest_priority; $i++){
                if(!isset($priorities[$i])){
                    $available_priorities[] = $i;
                }
            }
            //dd($available_priorities);
            $lowest_priority++;
            
        }



        return view('positions.create', compact('active','available_priorities','lowest_priority'));
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
            'position' => 'required',
            'priority' => 'required',
          ]);
        $position = new PositionModel();
        $position->position = $request->position;
        $position->priority = $request->priority;
        $position->updated_at = now();
        $position->save();   
    
        return redirect()->route('positions.show', ['position' => $position])
            ->with('success', 'Данные должности изменены');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $active = 'positions.show';
        // return view('positions.show', compact('active'));
        $position = PositionModel::find($id);
        $active = 'position.show';
        if($position){
        return view('positions.show', compact('active','position'));
        }
        else{
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PositionModel $position)
    {

        $active = 'positions.create';

        $priorities = PositionModel::orderByDesc('priority')->get();

        $available_priorities = [];

        if($priorities->isEmpty()){

            $lowest_priority = 1;

        }
        else{

            $lowest_priority = $priorities->first()->priority;
            $priorities = $priorities->keyBy('priority');

            for($i=1; $i<=$lowest_priority; $i++){
                if(!isset($priorities[$i])){
                    $available_priorities[] = $i;
                }
            }
            //dd($available_priorities);
            $lowest_priority++;
            
        }


        // $priorities = PositionModel::orderByDesc('priority')->get();

        // $lowest_priority = $priorities->first()->priority;

        return view('positions.edit', compact('position','available_priorities','lowest_priority'));

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
        $request->validate([
            'position' => 'required',
            'priority' => 'required',
        ]);

        $position = PositionModel::find($id);
        $position->position = $request->position;
        $position->priority = $request->priority;
        $position->updated_at = now();
        $position->save();   
    
        return redirect()->route('positions.show', ['position' => $position])
            ->with('success', 'Данные должности изменены');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $first_name = EmployeeModel::find($id)->first_name;
        // $last_name = EmployeeModel::find($id)->last_name;

        // $updated = EmployeeModel::where('higher_up_id', $id)->update(['higher_up_id' => null]);
        // EmployeeModel::where('id', $id)->delete();

        // return response()->json([
        //     'name' => $first_name.' '.$last_name,
        //     'updated' => $updated
        // ]);
        $position = PositionModel::find($id)->position;
        $employees = EmployeeModel::where('position_id',$id)->update(['position_id' => null]);
        PositionModel::where('id', $id)->delete();
        
        return response()->json([
            'position' => $position,
            'updated' => $employees
        ]);
    }
}
