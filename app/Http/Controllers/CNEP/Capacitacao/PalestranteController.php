<?php

namespace App\Http\Controllers\CNEP\Capacitacao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\LogModel;
use App\Models\CNEP\Capacitacao\CapacitacaoModel;
use App\Models\CNEP\Capacitacao\PalestranteModel;

class PalestranteController extends Controller
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
        $title = 'Cadastro de Palestrante';

        //Conexão com Banco de Dados
        $DBcapacitacoes = CapacitacaoModel::find($id);

        //Formulário
            $forms = [
                'palestrante' => ['tag'=>'input','type'=>'text','title'=>'Nome do Palestrante','id'=>'palestrante','row'=>'col-md-8','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
                'cpf' => ['tag'=>'input','type'=>'text','title'=>'CPF','id'=>'cpf','row'=>'col-md-4','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'11','maxlength'=>'11','value'=>''],
            ];

        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Formulário de Adição de Palestrante a Capacitação ". $DBcapacitacoes->titulo;
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.cnep.capacitacao.palestrante.create',[
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

        //Cadastrando Servidor na tabela tb_servidores

            //Declarando Variáveis enviadas via POST
                $data = $request->only('palestrante','cpf');

            //Conexão com Banco de Dados
                $DBpalestrantes = new PalestranteModel;

            $validator = Validator::make($data, [
                'palestrante' => 'required|string|min:6',
                'cpf' => 'required|cpf',
            ]);

            if ($validator->fails()) {
                

                //Logs            
                    $log = new LogModel;          
                    $log->user_id = intval(Auth::id());
                    $log->action = "Erro ao cadastrar Palestrante na ". $DBcapacitacoes->titulo;
                    $log->date = date("Y-m-d H:i:s");
                    $log->save();

                return redirect()->route('speakers.create',['qualification'=>$id])->withErrors($validator)->withInput();
            }

            //Gravando dados no banco
                foreach ($data as $key => $value){
                    $DBpalestrantes->$key = $value;
                }
                $DBpalestrantes->capacitacao_id = $id;
                $DBpalestrantes->save();

            //Logs            
                $log = new LogModel;          
                $log->user_id = intval(Auth::id());
                $log->action = "Palestrante ". $DBpalestrantes->palestrante . " Cadastrado na Capacitação " . $DBcapacitacoes->titulo;
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
            $title = 'Editar Cadastro de Palestrante';

        //Conexão de Banco de Dados
            $DBpalestrantes = PalestranteModel::find($id);

        //Formulário
            $forms = [
                'palestrante' => ['tag'=>'input','type'=>'text','title'=>'Nome do Palestrante','id'=>'palestrante','row'=>'col-md-8','connection'=>'','value'=>$DBpalestrantes->palestrante,'required'=>'required','min'=>'','max'=>'','minlength'=>'11','maxlength'=>'11'],
                'cpf' => ['tag'=>'input','type'=>'text','title'=>'CPF','id'=>'cpf','row'=>'col-md-4','connection'=>'','value'=>$DBpalestrantes->cpf,'required'=>'required','min'=>'','max'=>'','minlength'=>'11','maxlength'=>'11'],
            ];
        
        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Formulário de Edição do Palestrante ". $DBpalestrantes->palestrante;
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return view('views.cnep.capacitacao.palestrante.edit',[
            'title' => $title,
            'forms' => $forms,
            'palestrantes' => $DBpalestrantes,
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
            $data = $request->only('palestrante','cpf');

        //Conexão com Banco de Dados
            $DBpalestrantes = PalestranteModel::find($id);

        //Gravando dados no banco
            foreach ($data as $key => $value){
                $DBpalestrantes->$key = $value;
            }

            $DBpalestrantes->save();
        
        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Edição do Palestrante ". $DBpalestrantes->palestrante;
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return redirect()->route('qualifications.show',['qualification'=>$DBpalestrantes->capacitacao_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Conexão com Banco de Dados
            $DBpalestrantes = PalestranteModel::find($id);
        
        //Excluindo Palestrante
            $DBpalestrantes->delete();
        
        //Logs            
            $log = new LogModel;          
            $log->user_id = intval(Auth::id());
            $log->action = "Deletando Palestrante ". $DBpalestrantes->palestrante;
            $log->date = date("Y-m-d H:i:s");
            $log->save();

        return redirect()->route('qualifications.show',['qualification'=>$DBpalestrantes->capacitacao_id]);
    }
}
