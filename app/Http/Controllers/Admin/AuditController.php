<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:audits-list',  ['only' => ['index']]);
        $this->middleware('permission:audits-view',  ['only' => ['show']]);
        $this->middleware('permission:audits-create',['only' => ['create','store']]);
        $this->middleware('permission:audits-edit',  ['only' => ['edit','update']]);
        $this->middleware('permission:audits-delete',['only' => ['destroy']]);
    }
    // public static function middleware(): array
    // {
    //     return [
    //         new Middleware('permission:audits-list', only: ['index']),
    //         new Middleware('permission:audits-view', only: ['show']),
    //         new Middleware('permission:audits-create', only: ['create', 'store']),
    //         new Middleware('permission:audits-edit', only: ['edit', 'update']),
    //         new Middleware('permission:audits-delete', only: ['destroy']),
    //     ];
    // }
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $audits = Audit::with('user')->orderBy('created_at', 'desc')->paginate();

	    return view('admin.audit.index', compact('audits'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $audit = Audit::find($id);

        return view('admin.audit.show', compact('audit'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $audit = Audit::find($id)->delete();

        return redirect()->route('audits.index')
            ->with('success', 'Audit deleted successfully.');
    }
}
