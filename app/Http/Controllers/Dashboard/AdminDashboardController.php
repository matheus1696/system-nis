<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\LogModel;
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

        //Logs
            $log = new LogModel;
            $log->user_id = intval(Auth::id());
            $log->action = "Lista de Dashboard";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.dashboard.admin.adm_index',[
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
        //Titulo
            $title = 'Criando Dashboard';

        //Conexão com Banco de Dados
            $DBicons = IconModel::all();
            $DBblocos = BlocoModel::all();

        //Formulário
            $forms = [
                'titulo' => ['tag'=>'input','type'=>'text','title'=>'Titulo','id'=>'titulo','row'=>'col-md-12','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                'link' => ['tag'=>'input','type'=>'text','title'=>'Link','id'=>'link','row'=>'col-md-12','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                'icons_id' => ['tag'=>'select','type'=>'','title'=>'Icons','id'=>'icons_id','row' => 'col-md-6', 'connection' => $DBicons,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                'bloco_id' => ['tag'=>'select','type'=>'','title'=>'Bloco Administravo','id'=>'bloco_id','row' => 'col-md-6', 'connection' => $DBblocos,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                'descricao' => ['tag'=>'textarea','title'=>'Descrição Dashboard','id'=>'descricao','row' => 'col-md-12','value'=>''],
            ];
        
        //Logs
            $log = new LogModel;
            $log->user_id = intval(Auth::id());
            $log->action = "Formulário de Gerenciamento de Dashboard";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.dashboard.admin.adm_create',[
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

            //Logs            
                $log = new LogModel;          
                $log->user_id = intval(Auth::id());
                $log->action = "Erro de Criação de Dashboard";
                $log->date = date("Y-m-d H:i:s");
                $log->save();

            return redirect()->route('dashboard.create')->withErrors($validator)->withInput();
        }

        //Gravando dados no banco
            foreach ($data as $key => $value){
                $dbDashboard->$key = $value;
            }
            $dbDashboard->save();

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Criação de Dashboard ". $dbDashboard->titulo;
            $log->date = date("Y-m-d H:i:s");
            $log->save();

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

        //Formulário
            $forms = [
                'titulo' => ['tag'=>'input','type'=>'text','title'=>'Titulo','id'=>'titulo','row'=>'col-md-12','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$dashboard->titulo],
                'link' => ['tag'=>'input','type'=>'text','title'=>'Link','id'=>'link','row'=>'col-md-12','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$dashboard->link],
                'icons_id' => ['tag'=>'select','type'=>'','title'=>'Icons','id'=>'icons_id','row' => 'col-md-6', 'connection' => $DBicons,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$dashboard->icons_id],
                'bloco_id' => ['tag'=>'select','type'=>'','title'=>'Bloco Administravo','id'=>'bloco_id','row' => 'col-md-6', 'connection' => $DBblocos,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$dashboard->bloco_id],
                'descricao' => ['tag'=>'textarea','title'=>'Descrição Dashboard','id'=>'descricao','row' => 'col-md-12','value'=>$dashboard->descricao],
            ];

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Formulário de Edição de Dashboard";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.dashboard.admin.adm_edit',[
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
            'titulo' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            //Logs            
                $log = new LogModel;          
                $log->user_id = intval(Auth::id());
                $log->action = "Erro na Edição de Dashboard ". $dbDashboard->titulo;
                $log->date = date("Y-m-d H:i:s");
                $log->save();

            return redirect()->route('dashboard.edit',['dashboard'=>$id])->withErrors($validator)->withInput();
        }

        //Gravando dados no banco
            foreach ($data as $key => $value){
                $dbDashboard->$key = $value;
            }
            $dbDashboard->save();

            //Logs            
                $log = new LogModel;          
                $log->user_id = intval(Auth::id());
                $log->action = "Edição de Dashboard ". $dbDashboard->titulo;
                $log->date = date("Y-m-d H:i:s");
                $log->save();

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

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Deletando de Dashboard ". $db->titulo;
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return redirect()->route('dashboard.index');

    }
}
