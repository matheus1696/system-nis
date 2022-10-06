<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\LogModel;

use App\Models\Config\BlocoModel;
use App\Models\Config\StatusUnidadeModel;
use App\Models\Config\UnidadeModel;

class UnidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index()
    {
        //Titulo
            $title = 'Lista de Unidades';

        //Conexão com Banco de Dados
            $DBunidades = UnidadeModel::all();

                    
        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Acessando Lista de Unidades";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.config.unidade.index',[
            'title'=>$title,
            'DBunidades'=>$DBunidades,
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
            $title = 'Cadastro de Unidade';

        //Conexão com Banco de Dados
            $DBblocos = BlocoModel::all();
            $DBstatus = StatusUnidadeModel::all();

        //Formulário
            $forms = [
                'cnep' => ['tag'=>'input','type'=>'text','title'=>'CNES','id'=>'cnes','row'=>'col-md-2','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'6','maxlength'=>'6','value'=>''],
                'name' => ['tag'=>'input','type'=>'text','title'=>'Unidade de Saúde','id'=>'name','row'=>'col-md-7','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                'bloco_id'=>['tag'=>'select','type'=>'','title'=>'Bloco Administrativo','id'=>'bloco_id','row'=>'col-md-3','connection'=>$DBblocos,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                'end_logradouro' => ['tag'=>'input','type'=>'text','title'=>'Logradouro','id'=>'end_logradouro','row'=>'col-md-7','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                'end_num' => ['tag'=>'input','type'=>'text','title'=>'Nº','id'=>'end_num','row'=>'col-md-2','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                'end_bairro' => ['tag'=>'input','type'=>'text','title'=>'Bairro','id'=>'end_bairro','row'=>'col-md-3','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                'end_complemento' => ['tag'=>'input','type'=>'text','title'=>'Complemento','id'=>'end_complemento','row'=>'col-md-12','connection'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                'end_log' => ['tag'=>'input','type'=>'number','title'=>'Longitude','id'=>'end_log','row'=>'col-md-4','connection'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                'end_lat' => ['tag'=>'input','type'=>'number','title'=>'Latitude','id'=>'end_lat','row'=>'col-md-4','connection'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                'status_id'=>['tag'=>'select','type'=>'','title'=>'Status','id'=>'status_id','row'=>'col-md-4','connection'=>$DBstatus,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                ];

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Acessando Formulário de Criação de Unidades";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.config.unidade.create',[
            'title'=>$title,
            'forms'=>$forms,
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
        //Declarando Variáveis enviadas via POST
            $data = $request->only('cnes','name','bloco_id','end_logradouro','end_num','end_bairro','end_complemento','end_log','end_lat','status_id');

        //Conexão com Banco de Dados
            $DBunidades = new UnidadeModel;

        //Validação de Dados
            $validator = Validator::make($data, [
                'cnes' => 'required|integer|unique:tb_config_unidades|min:6',
                'name' => 'required',
            ]);        

            if ($validator->fails()) {

                //Logs            
                    $log = new LogModel;          
                    $log->user_id = intval(Auth::id());
                    $log->action = "Erro na Gravando de Unidade no banco de dados";
                    $log->date = date("Y-m-d H:i:s");
                    $log->save();

                return redirect()->route('unidade.create')->withErrors($validator)->withInput();
            }

        //Gravando dados no banco
            foreach ($data as $key => $value){
                $DBunidades->$key = $value;
            }
            $DBunidades->save();

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Gravando Unidade no banco de dados";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return redirect()->route('unidade.index');
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
            $title = 'Editar de Unidade';

        //Conexão com Banco de Dados
            $DBunidades = UnidadeModel::find($id);
            $DBblocos = BlocoModel::all();
            $DBstatus = StatusUnidadeModel::all();

        //Formulário
            $forms = [
                'cnep' => ['tag'=>'input','type'=>'text','title'=>'CNES','id'=>'cnes','row'=>'col-md-2','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'6','maxlength'=>'6','value'=>$DBunidades->cnes],
                'name' => ['tag'=>'input','type'=>'text','title'=>'Unidade de Saúde','id'=>'name','row'=>'col-md-7','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$DBunidades->name],
                'bloco_id'=>['tag'=>'select','type'=>'','title'=>'Bloco Administrativo','id'=>'bloco_id','row'=>'col-md-3','connection'=>$DBblocos,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$DBunidades->bloco_id],
                'end_logradouro' => ['tag'=>'input','type'=>'text','title'=>'Logradouro','id'=>'end_logradouro','row'=>'col-md-7','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$DBunidades->end_logradouro],
                'end_num' => ['tag'=>'input','type'=>'text','title'=>'Nº','id'=>'end_num','row'=>'col-md-2','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$DBunidades->end_num],
                'end_bairro' => ['tag'=>'input','type'=>'text','title'=>'Bairro','id'=>'end_bairro','row'=>'col-md-3','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$DBunidades->end_bairro],
                'end_complemento' => ['tag'=>'input','type'=>'text','title'=>'Complemento','id'=>'end_complemento','row'=>'col-md-12','connection'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$DBunidades->end_complemento],
                'end_log' => ['tag'=>'input','type'=>'number','title'=>'Longitude','id'=>'end_log','row'=>'col-md-4','connection'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$DBunidades->end_log],
                'end_lat' => ['tag'=>'input','type'=>'number','title'=>'Latitude','id'=>'end_lat','row'=>'col-md-4','connection'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$DBunidades->end_lat],
                'status_id'=>['tag'=>'select','type'=>'','title'=>'Status','id'=>'status_id','row'=>'col-md-4','connection'=>$DBstatus,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>$DBunidades->status_id],
                ];

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Acessando Formulário de Edição de Unidades";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.config.unidade.edit',[
            'title'=>$title,
            'forms'=>$forms,
            'DBunidades'=>$DBunidades,
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
        //Declarando Variáveis enviadas via POST
            $data = $request->only('cnes','name','bloco_id','end_logradouro','end_num','end_bairro','end_complemento','end_log','end_lat','status_id');

        //Conexão com Banco de Dados
            $DBunidades = UnidadeModel::find($id);

        //Gravando dados no banco
            foreach ($data as $key => $value){
                $DBunidades->$key = $value;
            }
            $DBunidades->save();

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Editando dados da Unidade ". $DBunidades->titulo;
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return redirect()->route('unidade.index');
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
