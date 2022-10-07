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
            $DBlicitacoes = ProcessoLicModel::select('*')->orderBy('data_vencimento')->get();

        //Alerta de Vencimento
            $dateAlert = date('d/m/Y');

        //Logs            
            $log = new LogModel;
            $log->user_id = intval(Auth::id());
            $log->action = "Editando lista de processos licitatórios";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.ti.processoLicitatorio.pl.index',[
            'title'=>$title,
            'dateAlert'=>$dateAlert,
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
                'p_licitatorio' => ['tag'=>'input','type'=>'text','title'=>'Processo Licitatório','id'=>'p_licitatorio','row'=>'col-md-4','connection'=>'','value'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'p_eletronico' => ['tag'=>'input','type'=>'text','title'=>'Pregão Eletrônico','id'=>'p_eletronico','row'=>'col-md-4','connection'=>'','value'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'r_preco' => ['tag'=>'input','type'=>'text','title'=>'Registro de Preço','id'=>'r_preco','row'=>'col-md-4','connection'=>'','value'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'tipos_id' => ['tag'=>'select','type'=>'','title'=>'Tipo','id'=>'tipos_id','row' => 'col-md-4', 'connection' => $DBtipos,'value'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'status_id' => ['tag'=>'select','type'=>'','title'=>'Status','id'=>'status_id','row' => 'col-md-4', 'connection' => $DBstatus,'value'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'data_vencimento' => ['tag'=>'input','type'=>'date','title'=>'Data Vencimento','id'=>'data_vencimento','row'=>'col-md-4','connection'=>'','value'=>'','required'=>'','min'=>'2020-01-01','max'=>'2030-12-31','minlength'=>'','maxlength'=>''],
                'objetivo' => ['tag'=>'input','type'=>'text','title'=>'Objetivo','id'=>'objetivo','row'=>'col-md-12','connection'=>'','value'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'descritivo' => ['tag'=>'textarea','type'=>'text','title'=>'Descrição','id'=>'descritivo','row'=>'col-md-12','connection'=>'','value'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'fiscal_mat' => ['tag'=>'input','type'=>'text','title'=>'Matrícula Fiscal','id'=>'fiscal_mat','row'=>'col-md-3','connection'=>'','value'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'fiscal_name' => ['tag'=>'input','type'=>'text','title'=>'Nome do Fiscal','id'=>'fiscal_name','row'=>'col-md-9','connection'=>'','value'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'gestor_mat' => ['tag'=>'input','type'=>'text','title'=>'Matricula Gestor','id'=>'gestor_mat','row'=>'col-md-3','connection'=>'','value'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'gestor_name' => ['tag'=>'input','type'=>'text','title'=>'Nome Gestor','id'=>'gestor_name','row'=>'col-md-9','connection'=>'','value'=>'','required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
            ];
            
        //Logs            
            $log = new LogModel;
            $log->user_id = intval(Auth::id());
            $log->action = "Formulário de Cadastro de processos licitatórios";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.ti.processoLicitatorio.pl.create',[
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
            $data = $request->only('p_licitatorio','p_eletronico','r_preco','objetivo','descritivo','fiscal_mat','fiscal_name','gestor_mat','gestor_name','data_vencimento','status_id','tipos_id');

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
            $DBlicitacoes = ProcessoLicModel::find($id);

        //Titulo
            $title = $DBlicitacoes->objetivo;

        //Organizando Data para Exibição
            $date = date('d/m/Y', strtotime($DBlicitacoes->data_vencimento));

        //Lista dos dados
            $sections = [
                'p_licitatorio' => ['title'=>'Processo Licitatório','row'=>'col-md-4','value'=>$DBlicitacoes->p_licitatorio],
                'p_eletronico' => ['title'=>'Pregão Eletrônico','row'=>'col-md-4','value'=>$DBlicitacoes->p_eletronico],
                'r_preco' => ['title'=>'Registro de Preço','row'=>'col-md-4','value'=>$DBlicitacoes->r_preco],
                'status_id' => ['title'=>'Status','row'=>'col-md-4','value'=>$DBlicitacoes->tb_ti_status_processos_lic->name],
                'tipos_id' => ['title'=>'Tipo','row'=>'col-md-4','value'=>$DBlicitacoes->tb_ti_tipos_processos_lic->name],
                'data_vencimento' => ['title'=>'Data de Vencimento','row'=>'col-md-4','value'=>$date],
                'objetivo' => ['title'=>'Objetivo','row' => 'col-md-9','value'=>$DBlicitacoes->objetivo],
                'descritivo' => ['title'=>'Descritivo','row'=>'col-md-12','value'=>$DBlicitacoes->descritivo],
                'fiscal_mat' => ['title'=>'Matricula Fiscal','row'=>'col-md-3','value'=>$DBlicitacoes->fiscal_mat],
                'fiscal_nome' => ['title'=>'Nome Fiscal','row'=>'col-md-9','value'=>$DBlicitacoes->fiscal_name],
                'gestor_mat' => ['title'=>'Matricula Gestor','row'=>'col-md-3','value'=>$DBlicitacoes->gestor_mat],
                'gestor_name' => ['title'=>'Nome Gestor','row'=>'col-md-9','value'=>$DBlicitacoes->gestor_name],
            ];

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Acessando Processo Licitatório ". $title;
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.ti.processoLicitatorio.pl.show',[
            'title' => $title,
            'sections' => $sections,
            'DBlicitacoes' => $DBlicitacoes,
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
            $DBlicitacoes = ProcessoLicModel::find($id);
            $DBstatus = StatusProcessosLicModel::all();
            $DBtipos = TiposProcessosLicModel::all();

        //Formulário
            $forms = [
                'p_licitatorio' => ['tag'=>'input','type'=>'text','title'=>'Processo Licitatório','id'=>'p_licitatorio','row'=>'col-md-4','connection'=>'','value'=>$DBlicitacoes->p_licitatorio,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'p_eletronico' => ['tag'=>'input','type'=>'text','title'=>'Pregão Eletrônico','id'=>'p_eletronico','row'=>'col-md-4','connection'=>'','value'=>$DBlicitacoes->p_eletronico,'required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'r_preco' => ['tag'=>'input','type'=>'text','title'=>'Registro de Preço','id'=>'r_preco','row'=>'col-md-4','connection'=>'','value'=>$DBlicitacoes->r_preco,'required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'tipos_id' => ['tag'=>'select','type'=>'','title'=>'Tipo','id'=>'tipos_id','row' => 'col-md-4', 'connection' => $DBtipos,'value'=>$DBlicitacoes->tipos_id,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'status_id' => ['tag'=>'select','type'=>'','title'=>'Status','id'=>'status_id','row' => 'col-md-4', 'connection' => $DBstatus,'value'=>$DBlicitacoes->status_id,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'data_vencimento' => ['tag'=>'input','type'=>'date','title'=>'Data Vencimento','id'=>'data_vencimento','row'=>'col-md-4','connection'=>'','value'=>$DBlicitacoes->data_vencimento,'required'=>'','min'=>'2020-01-01','max'=>'2030-12-31','minlength'=>'','maxlength'=>''],
                'objetivo' => ['tag'=>'input','type'=>'text','title'=>'Objetivo','id'=>'objetivo','row'=>'col-md-12','connection'=>'','value'=>$DBlicitacoes->objetivo,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'descritivo' => ['tag'=>'textarea','type'=>'text','title'=>'Descrição','id'=>'descritivo','row'=>'col-md-12','connection'=>'','value'=>$DBlicitacoes->descritivo,'required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'fiscal_mat' => ['tag'=>'input','type'=>'text','title'=>'Matrícula Fiscal','id'=>'fiscal_mat','row'=>'col-md-3','connection'=>'','value'=>$DBlicitacoes->fiscal_mat,'required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'fiscal_name' => ['tag'=>'input','type'=>'text','title'=>'Nome do Fiscal','id'=>'fiscal_name','row'=>'col-md-9','connection'=>'','value'=>$DBlicitacoes->fiscal_name,'required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'gestor_mat' => ['tag'=>'input','type'=>'text','title'=>'Matricula Gestor','id'=>'gestor_mat','row'=>'col-md-3','connection'=>'','value'=>$DBlicitacoes->gestor_mat,'required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'gestor_name' => ['tag'=>'input','type'=>'text','title'=>'Nome Gestor','id'=>'gestor_name','row'=>'col-md-9','connection'=>'','value'=>$DBlicitacoes->gestor_name,'required'=>'','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
            ];
            
        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Formulário de Cadastro de processos licitatórios";
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.ti.processoLicitatorio.pl.edit',[
            'title'=>$title,
            'forms'=>$forms,
            'DBlicitacoes'=>$DBlicitacoes,
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
        $data = $request->only('p_licitatorio','p_eletronico','r_preco','objetivo','descritivo','fiscal_mat','fiscal_name','gestor_mat','gestor_name','data_vencimento','status_id','tipos_id');

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
        return redirect()->route('licitacao.pl.index');
    }
}
