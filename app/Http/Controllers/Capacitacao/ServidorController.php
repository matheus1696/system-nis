<?php

namespace App\Http\Controllers\Capacitacao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        //
        $title = 'Cadastro de Servidores';
        $DBcapacitacoes = CapacitacaoModel::find($id);

        $forms = [
            'servidor' => ['tag'=>'input','type'=>'text','title'=>'Nome Servidor','id'=>'servidor','row'=>'col-md-8','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
            'cpf' => ['tag'=>'input','type'=>'text','title'=>'CPF','id'=>'cpf','row'=>'col-md-4','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'11','maxlength'=>'11','value'=>''],
        ];

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
        //
            $DBcapacitacoes = CapacitacaoModel::find($id);

        //Cadastrando Servidor na tabela tb_servidores
            //Declarando Variáveis enviadas via POST
                $data = $request->only('servidor','cpf');

            //Ponte para o banco via Eloquent
                $DBservidores = new ServidorModel;

            $validator = Validator::make($data, [
                'servidor' => 'required|string|min:6',
                'cpf' => 'required|cpf',
            ]);

            if ($validator->fails()) {
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
        //
        $title = 'Editar Cadastro de Servidores';
        $DBservidores = ServidorModel::find($id);

        $forms = [
            'servidor' => ['tag'=>'input','type'=>'text','title'=>'Nome Servidor','id'=>'servidor','row'=>'col-md-8','connection'=>'','value'=>$DBservidores->servidor,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
            'cpf' => ['tag'=>'input','type'=>'text','title'=>'CPF','id'=>'cpf','row'=>'col-md-4','connection'=>'','value'=>$DBservidores->cpf,'required'=>'required','min'=>'','max'=>'','minlength'=>'11','maxlength'=>'11'],
        ];

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

            //Ponte para o banco via Eloquent
                $DBservidores = ServidorModel::find($id);

            $validator = Validator::make($data, [
                'servidor' => 'required|min:6',
                'cpf' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->route('servers.edit',['server'=>$id])->withErrors($validator)->withInput();
            }

            //Gravando dados no banco
                foreach ($data as $key => $value){
                    $DBservidores->$key = $value;
                }

                $DBservidores->save();

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
        //
        $DBservidores = ServidorModel::find($id);
        $DBcapacitacoes = CapacitacaoModel::find($DBservidores->capacitacao_id);

        $DBservidores->delete();

        $DBservidores = ServidorModel::where('capacitacao_id', $DBservidores->capacitacao_id);
        $CountServidores = $DBservidores->count();

        $DBcapacitacoes->quant_capacitado = $CountServidores;
        $DBcapacitacoes->save();

        return redirect()->route('qualifications.show',['qualification'=>$DBcapacitacoes->id]);
    }
}
