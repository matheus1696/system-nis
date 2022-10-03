<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\LogModel;
use App\Models\DashboardModel;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Sala de Situação';

        //Conexão com Banco
            $dashboards = DashboardModel::all();

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Acessando Painel da Saúde";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.dashboard.index',[
            'title'=>$title,
            'dashboards'=>$dashboards,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Conexão com Banco de Dados
            $dashboard = DashboardModel::find($id);

        //Titulo
            $title = $dashboard->titulo;

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Acessando Painel da Saúde " . $dashboard->titulo;
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.dashboard.show',[
            'title'=>$title,
            'dashboard'=>$dashboard,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
