<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;

use App\Models\DashboardModel;
use App\Models\Config\IconModel;
use App\Models\Config\BlocoModel;

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

        //
            $DBicons = IconModel::all();
            $DBblocos = BlocoModel::all();

        $forms = [
            'titulo' => ['tag'=>'input','type'=>'text','title'=>'Titulo','id'=>'titulo','row'=>'col-md-12','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
            'link' => ['tag'=>'input','type'=>'text','title'=>'Link','id'=>'link','row'=>'col-md-12','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
            'icons_id' => ['tag'=>'select','type'=>'','title'=>'Icons','id'=>'icons_id','row' => 'col-md-6', 'connection' => $DBicons,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
            'bloco_id' => ['tag'=>'select','type'=>'','title'=>'Bloco Administravo','id'=>'bloco_id','row' => 'col-md-6', 'connection' => $DBblocos,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
            'descricao' => ['tag'=>'textarea','title'=>'Descrição Dashboard','id'=>'descricao','row' => 'col-md-12','value'=>''],
        ];

        return view('views.admin.dashboard.create',[
            'title' => $title,
            'forms' => $forms,
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
            $data = $request->only('titulo','link','icons_id','bloco_id','descricao');

        //Conexão Banco
            $dbDashboard = new DashboardModel;

        //Salvando dados
        $validator = Validator::make($data, [
            'titulo' => 'required|string|unique:tb_dashboard|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashbooard.create')->withErrors($validator)->withInput();
        }

        //Gravando dados no banco
            foreach ($data as $key => $value){
                $dbDashboard->$key = $value;
            }
            $dbDashboard->save();

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
            $DBicons = IconModel::all();
            $DBblocos = BlocoModel::all();

            $forms = [
                'titulo' => ['tag'=>'input','type'=>'text','title'=>'Titulo','id'=>'titulo','row'=>'col-md-12','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$dashboard->titulo],
                'link' => ['tag'=>'input','type'=>'text','title'=>'Link','id'=>'link','row'=>'col-md-12','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$dashboard->link],
                'icons_id' => ['tag'=>'select','type'=>'','title'=>'Icons','id'=>'icons_id','row' => 'col-md-6', 'connection' => $DBicons,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$dashboard->icons_id],
                'bloco_id' => ['tag'=>'select','type'=>'','title'=>'Bloco Administravo','id'=>'bloco_id','row' => 'col-md-6', 'connection' => $DBblocos,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$dashboard->bloco_id],
                'descricao' => ['tag'=>'textarea','title'=>'Descrição Dashboard','id'=>'descricao','row' => 'col-md-12','value'=>$dashboard->descricao],
            ];

        return view('views.admin.dashboard.edit',[
            'title'=>$title,
            'forms'=>$forms,
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
        $data = $request->only('titulo','link','icons_id','bloco_id','descricao');

        //Conexão Banco
            $dbDashboard = DashboardModel::find($id);

        //Salvando dados
        $validator = Validator::make($data, [
            'titulo' => 'required|string|unique:tb_dashboard|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashbooard.edit',['dashboard'=>$id])->withErrors($validator)->withInput();
        }

        //Gravando dados no banco
            foreach ($data as $key => $value){
                $dbDashboard->$key = $value;
            }
            $dbDashboard->save();

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
