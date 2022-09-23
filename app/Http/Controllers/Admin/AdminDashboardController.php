<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\DashboardModel;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Titulo
            $title = 'Dashboards';
        
        //Conexão Banco
            $dashboards = DashboardModel::all();

        return view('views.admin.dashboard.index',[
            'title'=>$title,
            'dashboards'=>$dashboards
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
        $title = 'Criando Dashboard';

        return view('views.admin.dashboard.create',[
            'title'=>$title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Redebendo dados Request
            $data = $request->only('tituloDashboard','linkDashboard','descricaoDashboard');

        //Conexão Banco
            $db = new DashboardModel;

        //Salvando dados
            $db->titulo = $data['tituloDashboard'];
            $db->link = $data['linkDashboard'];
            $db->descricao = $data['descricaoDashboard'];
            $db->save();

            return redirect()->route('dashboard.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Titulo
            $title = 'Editar Dashboards';
        
        //Conexão Banco
            $dashboard = DashboardModel::find($id);

        return view('views.admin.dashboard.edit',[
            'title'=>$title,
            'dashboard'=>$dashboard
        ]);
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
        //Redebendo dados Request
        $data = $request->only('tituloDashboard','linkDashboard','descricaoDashboard');

        //Conexão Banco
            $db = DashboardModel::find($id);

        //Salvando dados
            $db->titulo = $data['tituloDashboard'];
            $db->link = $data['linkDashboard'];
            $db->descricao = $data['descricaoDashboard'];
            $db->save();

            return redirect()->route('dashboard.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Conecção com Banco de Dado
            $db = DashboardModel::find($id);

        //Deletando Dados do Banco
            $db->delete();

        return redirect()->route('dashboard.index');

    }
}
