<?php

namespace App\Http\Controllers\TI\ProcessoLicitatorio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\LogModel;
use App\Models\TI\ProcessosLicitatorio\ProcessoLicModel;
use App\Models\TI\ProcessosLicitatorio\StatusProcessosLicModel;
use App\Models\TI\ProcessosLicitatorio\TiposProcessosLicModel;

class ProcessoLicController extends Controller
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
            $title = "Lista de Processos Licitatórios";

        //Conexão com Banco de Dados
            $DBlicitacoes = ProcessoLicModel::all();

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Editando lista de processos licitatórios";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.ti.processoLicitatorio.index',[
            'title'=>$title,
            'DBlicitacoes'=>$DBlicitacoes,
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
            $title = "Cadastro de Processos Licitatórios";

        //Conexão de Banco de Dados
            $DBstatus = StatusProcessosLicModel::all();
            $DBtipos = TiposProcessosLicModel::all();

        //Formulário
            $forms = [
                'p_licitatorio' => ['tag'=>'input','type'=>'text','title'=>'Processo Licitatório','id'=>'p_licitatorio','row'=>'col-md-3','connection'=>'','value'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'p_eletronico' => ['tag'=>'input','type'=>'text','title'=>'Pregão Eletrônico','id'=>'p_eletronico','row'=>'col-md-3','connection'=>'','value'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'r_preco' => ['tag'=>'input','type'=>'text','title'=>'Registro de Preço','id'=>'r_preco','row'=>'col-md-3','connection'=>'','value'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'status_id' => ['tag'=>'select','type'=>'','title'=>'Status','id'=>'status_id','row' => 'col-md-3', 'connection' => $DBstatus,'value'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'objetivo' => ['tag'=>'input','type'=>'text','title'=>'Objetivo','id'=>'objetivo','row'=>'col-md-9','connection'=>'','value'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'tipos_id' => ['tag'=>'select','type'=>'','title'=>'Tipo','id'=>'tipos_id','row' => 'col-md-3', 'connection' => $DBtipos,'value'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'descritivo' => ['tag'=>'textarea','type'=>'text','title'=>'Descrição','id'=>'descritivo','row'=>'col-md-12','connection'=>'','value'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'fiscal_mat' => ['tag'=>'input','type'=>'text','title'=>'Matrícula Fiscal','id'=>'fiscal_mat','row'=>'col-md-2','connection'=>'','value'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'fiscal_name' => ['tag'=>'input','type'=>'text','title'=>'Nome do Fiscal','id'=>'fiscal_name','row'=>'col-md-4','connection'=>'','value'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'gestor_mat' => ['tag'=>'input','type'=>'text','title'=>'Matricula Gestor','id'=>'gestor_mat','row'=>'col-md-2','connection'=>'','value'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'gestor_name' => ['tag'=>'input','type'=>'text','title'=>'Nome Gestor','id'=>'gestor_name','row'=>'col-md-4','connection'=>'','value'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
            ];
            
        //Logs            
            $log = new LogModel;
            $log->user_id = intval(Auth::id());
            $log->action = "Formulário de Cadastro de processos licitatórios";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.ti.processoLicitatorio.create',[
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
            $data = $request->only('p_licitatorio','p_eletronico','r_preco','objetivo','descritivo','fiscal_mat','fiscal_name','gestor_mat','gestor_name','status_id','tipos_id');

        //Conexão com Banco de Dados
            $DBlicitacoes = new ProcessoLicModel;

        //Validação de Dados
            $validator = Validator::make($data, [
                'p_licitatorio' => 'required|string|unique:tb_ti_processos_lic|min:6',
                'objetivo' => 'required',
            ]);        

            if ($validator->fails()) {

                //Logs            
                    $log = new LogModel;          
                    $log->user_id = intval(Auth::id());
                    $log->action = "Erro na Gravando de Processo Licitatório no banco de dados";
                    $log->date = date("Y-m-d H:i:s");
                    $log->save();

                return redirect()->route('licitacao.create')->withErrors($validator)->withInput();
            }

        //Gravando dados no banco
            foreach ($data as $key => $value){
                $DBlicitacoes->$key = $value;
            }
                $DBlicitacoes->save();

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Gravando Processo Licitatório no banco de dados";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return redirect()->route('licitacao.index');
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
            $DBlicitacao = ProcessoLicModel::find($id);

        //Titulo
            $title = $DBlicitacao->objetivo;

        //Lista dos dados
            $sections = [
                'p_licitatorio' => ['title'=>'Processo Licitatório','row'=>'col-md-3','value'=>$DBlicitacao->p_licitatorio],
                'p_eletronico' => ['title'=>'Pregão Eletrônico','row'=>'col-md-3','value'=>$DBlicitacao->p_eletronico],
                'r_preco' => ['title'=>'Registro de Preço','row'=>'col-md-3','value'=>$DBlicitacao->r_preco],
                'status_id' => ['title'=>'Status','row'=>'col-md-3','value'=>$DBlicitacao->tb_ti_status_processos_lic->name],
                'objetivo' => ['title'=>'Objetivo','row' => 'col-md-9','value'=>$DBlicitacao->objetivo],
                'tipos_id' => ['title'=>'Tipo','row'=>'col-md-3','value'=>$DBlicitacao->tb_ti_tipos_processos_lic->name],
                'descritivo' => ['title'=>'Descritivo','row'=>'col-md-12','value'=>$DBlicitacao->descritivo],
                'fiscal_mat' => ['title'=>'Matricula Fiscal','row'=>'col-md-2','value'=>$DBlicitacao->fiscal_mat],
                'fiscal_nome' => ['title'=>'Nome Fiscal','row'=>'col-md-4','value'=>$DBlicitacao->fiscal_name],
                'gestor_mat' => ['title'=>'Matricula Gestor','row'=>'col-md-2','value'=>$DBlicitacao->gestor_mat],
                'gestor_name' => ['title'=>'Nome Gestor','row'=>'col-md-4','value'=>$DBlicitacao->gestor_name],
            ];

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Acessando Processo Licitatório ". $title;
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.ti.processoLicitatorio.show',[
            'title' => $title,
            'sections' => $sections,
            'DBlicitacao' => $DBlicitacao,
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
        //Titulo
            $title = "Editar de Processos Licitatórios";

        //Conexão com Banco de Dados
            $DBlicitacao = ProcessoLicModel::find($id);
            $DBstatus = StatusProcessosLicModel::all();

        //Formulário
            $forms = [
                'p_licitatorio' => ['tag'=>'input','type'=>'text','title'=>'Processo Licitatório','id'=>'p_licitatorio','row'=>'col-md-3','connection'=>'','value'=>$DBlicitacao->p_licitatorio,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'p_eletronico' => ['tag'=>'input','type'=>'text','title'=>'Pregão Eletrônico','id'=>'p_eletronico','row'=>'col-md-3','connection'=>'','value'=>$DBlicitacao->p_eletronico,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'r_preco' => ['tag'=>'input','type'=>'text','title'=>'Registro de Preço','id'=>'r_preco','row'=>'col-md-3','connection'=>'','value'=>$DBlicitacao->r_preco,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'status_id' => ['tag'=>'select','type'=>'','title'=>'Status','id'=>'status_id','row' => 'col-md-3', 'connection' => $DBstatus,'value'=>$DBlicitacao->status_id,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'objetivo' => ['tag'=>'input','type'=>'text','title'=>'Objetivo','id'=>'objetivo','row'=>'col-md-9','connection'=>'','value'=>$DBlicitacao->objetivo,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'tipos_id' => ['tag'=>'select','type'=>'','title'=>'Tipo','id'=>'tipos_id','row' => 'col-md-3', 'connection' => $DBtipos,'value'=>$DBlicitacao->tipos_id,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'descritivo' => ['tag'=>'textarea','type'=>'text','title'=>'Descrição','id'=>'descritivo','row'=>'col-md-12','connection'=>'','value'=>$DBlicitacao->descritivo,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'fiscal_mat' => ['tag'=>'input','type'=>'text','title'=>'Matrícula Fiscal','id'=>'fiscal_mat','row'=>'col-md-2','connection'=>'','value'=>$DBlicitacao->fiscal_mat,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'fiscal_name' => ['tag'=>'input','type'=>'text','title'=>'Nome do Fiscal','id'=>'fiscal_name','row'=>'col-md-4','connection'=>'','value'=>$DBlicitacao->fiscal_name,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'gestor_mat' => ['tag'=>'input','type'=>'text','title'=>'Matricula Gestor','id'=>'gestor_mat','row'=>'col-md-2','connection'=>'','value'=>$DBlicitacao->gestor_mat,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'gestor_name' => ['tag'=>'input','type'=>'text','title'=>'Nome Gestor','id'=>'gestor_name','row'=>'col-md-4','connection'=>'','value'=>$DBlicitacao->gestor_name,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
            ];
            
        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Formulário de Cadastro de processos licitatórios";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.ti.processoLicitatorio.edit',[
            'title'=>$title,
            'forms'=>$forms,
            'DBlicitacao'=>$DBlicitacao,
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
        $data = $request->only('p_licitatorio','p_eletronico','r_preco','objetivo','descritivo','fiscal_mat','fiscal_name','gestor_mat','gestor_name','status_id','tipo_id');

        //Conexão com Banco de Dados
            $DBlicitacoes = ProcessoLicModel::find($id);

        //Validação de Dados
            $validator = Validator::make($data, [
                'p_licitatorio' => 'required|string|min:6',
                'objetivo' => 'required',
            ]);        

            if ($validator->fails()) {

                //Logs            
                    $log = new LogModel;          
                    $log->user_id = intval(Auth::id());
                    $log->action = "Erro na Atualização de dados do Processo Licitatório";
                    $log->date = date("Y-m-d H:i:s");
                    $log->save();

                return redirect()->route('licitacao.edit',['licitacao'=>$id])->withErrors($validator)->withInput();
            }

        //Gravando dados no banco
            foreach ($data as $key => $value){
                $DBlicitacoes->$key = $value;
            }
                $DBlicitacoes->save();

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Atualização de dados do Processo Licitatório";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return redirect()->route('licitacao.show',['licitacao'=>$id]);
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
        return redirect()->route('licitacao.index');
    }
}
