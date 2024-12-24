<?php
    
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
    
class PermissionController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $permissions = Permission::orderBy('id','DESC')->paginate(5);
        
        return view('permissions.index',compact('permissions'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $permission = Permission::get();
        return view('permissions.create', compact('permission'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'permission_name' => 'required|unique:permissions,name',
        ]);
    
        $permission = Permission::create(['name' => $request->input('permission_name')]);
    
        return redirect()->route('permissions.index')
                        ->with('success','Permission created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $permission = Permission::find($id);
    
        return view('permissions.edit',compact('permission'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'permission_name' => 'required',
        ]);
    
        $permission = Permission::find($id);
        $permission->name = $request->input('permission_name');
        $permission->save();
    
        return redirect()->route('permissions.index')
                        ->with('success','Permission updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        DB::table('permissions')->where('id', $id)->delete();

        return redirect()->route('permissions.index')
                        ->with('success','Permission deleted successfully');
    }
}
