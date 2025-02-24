<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

/**
 * Class ProvinceController
 * @package App\Http\Controllers
 */
class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:provinces-list',  ['only' => ['index']]);
        $this->middleware('permission:provinces-view',  ['only' => ['show']]);
        $this->middleware('permission:provinces-create',['only' => ['create','store']]);
        $this->middleware('permission:provinces-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:provinces-delete',['only' => ['destroy']]);
    }
//     public static function middleware(): array
// {
//     return [
//         new Middleware('permission:provinces-list', only: ['index']),
//         new Middleware('permission:provinces-view', only: ['show']),
//         new Middleware('permission:provinces-create', only: ['create', 'store']),
//         new Middleware('permission:provinces-edit', only: ['edit', 'update']),
//         new Middleware('permission:provinces-delete', only: ['destroy']),
//     ];
// }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $provinces = Province::paginate();

        return view('admin.province.index', compact('provinces'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $province = new Province();

        return view('admin.province.create', compact('province'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $province = Province::create($request->all());

        return redirect()->route('provinces.index')
            ->with('success', 'Province created successfully.');
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $province = Province::find($id);

        return view('admin.province.show', compact('province'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $province = Province::find($id);

        return view('admin.province.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  Province $province
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Province $province)
    {
        $province->update($request->all());

        return redirect()->route('provinces.index')
            ->with('success', 'Province updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $province = Province::find($id)->delete();

        return redirect()->route('provinces.index')
            ->with('success', 'Province deleted successfully');
    }
}
