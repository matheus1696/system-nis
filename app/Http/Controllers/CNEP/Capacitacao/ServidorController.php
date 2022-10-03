<?php

namespace App\Http\Controllers\CNEP\Capacitacao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\LogModel;

use App\Models\CNEP\Capacitacao\CapacitacaoModel;
use App\Models\CNEP\Capacitacao\ServidorModel;

class ServidorController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //Titulo
            $title = 'Cadastro de Servidores';

        //Conexão com Banco de Dados
            $DBcapacitacoes = CapacitacaoModel::find($id);

        //Formulário
            $forms = [
                'servidor' => ['tag'=>'input','type'=>'text','title'=>'Nome Servidor','id'=>'servidor','row'=>'col-md-8','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                'cpf' => ['tag'=>'input','type'=>'text','title'=>'CPF','id'=>'cpf','row'=>'col-md-4','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'11','maxlength'=>'11','value'=>''],
            ];
        
        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Formulário de Criação de Servidor da Capacitação " . $DBcapacitacoes->titulo;
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.cnep.capacitacao.servidor.create',[
            'title' => $title,
            'forms' => $forms,
            'capacitacoes' => $DBcapacitacoes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        //Conexão com Banco de Dados
            $DBcapacitacoes = CapacitacaoModel::find($id);

        //Declarando Variáveis enviadas via POST
            $data = $request->only('servidor','cpf');

        //Conexão com Banco de Dados
            $DBservidores = new ServidorModel;

        //Validando dados
            $validator = Validator::make($data, [
                'servidor' => 'required|string|min:6',
                'cpf' => 'required|cpf',
            ]);

            if ($validator->fails()) {
                
                //Logs            
                    $log = new LogModel;          
                    $log->user_id = intval(Auth::id());
                    $log->action = "Erro na Criação de Servidor para Capacitação " . $DBcapacitacoes->titulo;
                    $log->date = date("Y-m-d H:i:s");
                    $log->save();

                return redirect()->route('servers.create',['qualification'=>$id])->withErrors($validator)->withInput();
            }

            //Gravando dados no banco
                foreach ($data as $key => $value){
                    $DBservidores->$key = $value;
                }

                $DBservidores->capacitacao_id = $id;
                $DBservidores->save();

            //Cadastrando Quantidade de Servidores na tb_capacitacoes
                $DBservidores = ServidorModel::where('capacitacao_id', $id);
                $CountServidoresCapacitados = $DBservidores->count();

                $DBcapacitacoes->quant_capacitado = $CountServidoresCapacitados;
                $DBcapacitacoes->save();

            //Logs            
                $log = new LogModel;          
                $log->user_id = intval(Auth::id());
                $log->action = "Criação do Servidor na Capacitação " . $DBcapacitacoes->titulo;
                $log->date = date("Y-m-d H:i:s");
                $log->save();

        return redirect()->route('qualifications.show',['qualification'=>$id]);
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
            $title = 'Editar Cadastro de Servidores';

        //Conexão com Banco de Dados
            $DBservidores = ServidorModel::find($id);
        
        //Formulário
            $forms = [
                'servidor' => ['tag'=>'input','type'=>'text','title'=>'Nome Servidor','id'=>'servidor','row'=>'col-md-8','connection'=>'','value'=>$DBservidores->servidor,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
                'cpf' => ['tag'=>'input','type'=>'text','title'=>'CPF','id'=>'cpf','row'=>'col-md-4','connection'=>'','value'=>$DBservidores->cpf,'required'=>'required','min'=>'','max'=>'','minlength'=>'11','maxlength'=>'11'],
            ];
        
        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Edição do Servidor ". $DBservidores->servidor;
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.cnep.capacitacao.servidor.edit',[
            'title' => $title,
            'forms' => $forms,
            'servidores' => $DBservidores,
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
        //Cadastrando Servidor na tabela tb_servidores
            //Declarando Variáveis enviadas via POST
                $data = $request->only('servidor','cpf','funcao_id','unidade_id');

            //Conexão com Banco de Dados
                $DBservidores = ServidorModel::find($id);

            //Validação de dados
                $validator = Validator::make($data, [
                    'servidor' => 'required|min:6',
                    'cpf' => 'required',
                ]);

                if ($validator->fails()) {
                    //Logs            
                        $log = new LogModel;          
                        $log->user_id = intval(Auth::id());
                        $log->action = "Erro na Edição do Servidor ". $DBservidores->servidor;
                        $log->date = date("Y-m-d H:i:s");
                        $log->save();

                    return redirect()->route('servers.edit',['server'=>$id])->withErrors($validator)->withInput();
                }

            //Gravando dados no banco
                foreach ($data as $key => $value){
                    $DBservidores->$key = $value;
                }

                $DBservidores->save();

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Edição do Servidor ". $DBservidores->servidor;
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return redirect()->route('qualifications.show',['qualification'=>$DBservidores->capacitacao_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Conexão com Banco de dados
            $DBservidores = ServidorModel::find($id);
            $DBcapacitacoes = CapacitacaoModel::find($DBservidores->capacitacao_id);

        //Deletendo Servidor
            $DBservidores->delete();

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Deletendo Servidor ". $DBservidores->servidor;
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        $DBservidores = ServidorModel::where('capacitacao_id', $DBservidores->capacitacao_id);
        $CountServidores = $DBservidores->count();

        $DBcapacitacoes->quant_capacitado = $CountServidores;
        $DBcapacitacoes->save();

        return redirect()->route('qualifications.show',['qualification'=>$DBcapacitacoes->id]);
    }
}
