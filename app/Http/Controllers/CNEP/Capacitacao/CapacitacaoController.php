<?php

namespace App\Http\Controllers\CNEP\Capacitacao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\CNEP\Capacitacao\CapacitacaoModel;
use App\Models\CNEP\Capacitacao\ServidorModel;
use App\Models\CNEP\Capacitacao\PalestranteModel;
use App\Models\Config\LocalModel;

use Barryvdh\DomPDF\Facade\Pdf;

class CapacitacaoController extends Controller
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
        $title = 'Lista de Capacitações';
        $DBcapacitacoes = CapacitacaoModel::paginate(15);

        return view('views.cnep.capacitacao.capacitacao.index',[
            'title' => $title,
            'capacitacoes' => $DBcapacitacoes,
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
        $title = 'Lista de Capacitações';
        $DBlocais = LocalModel::all();

        $forms = [
            'titulo' => ['tag'=>'input','type'=>'text','title'=>'Titulo','id'=>'titulo','row'=>'col-md-12','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
            'data_realizacao' => ['tag'=>'input','type'=>'date','title'=>'Data Realização','id'=>'data_realizacao','row'=>'col-md-4','connection'=>'','required'=>'required','min'=>'2022-01-01','max'=>'2030-12-31','minlength'=>'','maxlength'=>'','value'=>''],
            'local_id' => ['tag'=>'select','type'=>'','title'=>'Local','id'=>'local_id','row' => 'col-md-4', 'connection' => $DBlocais,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
            'carga_horaria' => ['tag'=>'input','type'=>'number','title'=>'Carga Horária','id'=>'carga_horaria','row'=>'col-md-4','connection'=>'','required'=>'required','min'=>'0','max'=>'120','minlength'=>'','maxlength'=>'','value'=>''],
        ];

        return view('views.cnep.capacitacao.capacitacao.create',[
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
        //Declarando Variáveis enviadas via POST
            $data = $request->only('titulo','data_realizacao','local_id','carga_horaria');

        //Ponte para o banco via Eloquent
            $DBcapacitacoes = New CapacitacaoModel;

        $validator = Validator::make($data, [
            'titulo' => 'required|string|unique:tb_cnep_capacitacoes|min:6',
            'data_realizacao' => 'required',
            'local_id' => 'required',
            'carga_horaria' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('qualifications.create')->withErrors($validator)->withInput();
        }

        //Gravando dados no banco
            foreach ($data as $key => $value){
                $DBcapacitacoes->$key = $value;
            }
            $DBcapacitacoes->quant_capacitado = 0;
            $DBcapacitacoes->save();

        return redirect()->route('qualifications.index');
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
        $DBcapacitacoes = CapacitacaoModel::find($id);
        $DBservidores = ServidorModel::where('capacitacao_id', $id)->orderBy('servidor')->get();
        $DBpalestrantes = PalestranteModel::where('capacitacao_id', $id)->orderBy('palestrante')->get();
        $title = $DBcapacitacoes->titulo;

        $date = date('d/m/Y', strtotime($DBcapacitacoes->data_realizacao));

        $sections = [
            'titulo' => ['title'=>'Titulo','row'=>'col-md-6','value'=>$DBcapacitacoes->titulo],
            'data_realizacao' => ['title'=>'Data Realização','row'=>'col-md-3','value'=>$date],
            'carga_horaria' => ['title'=>'Carga Horária','row'=>'col-md-3','value'=>$DBcapacitacoes->carga_horaria.' Horas'],
            'local_id' => ['title'=>'Local','row' => 'col-md-6','value'=>$DBcapacitacoes->tb_config_locais_auditorios->name],
            'quant_capacitado' => ['title'=>'Quantidade Capacitados','row'=>'col-md-3','value'=>$DBcapacitacoes->quant_capacitado],
        ];

        return view('views.cnep.capacitacao.capacitacao.show',[
            'title' => $title,
            'sections' => $sections,
            'capacitacoes' => $DBcapacitacoes,
            'servidores' => $DBservidores,
            'palestrantes' => $DBpalestrantes,
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
        $title = 'Editar Capacitações';
        $DBcapacitacoes = CapacitacaoModel::find($id);
        $DBlocais = LocalModel::all();

        $forms = [
            'titulo' => ['tag'=>'input','type'=>'text','title'=>'Titulo','id'=>'titulo','row'=>'col-md-12','connection'=>'','value'=>$DBcapacitacoes->titulo,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
            'data_realizacao' => ['tag'=>'input','type'=>'date','title'=>'Data Realização','id'=>'data_realizacao','row'=>'col-md-4','connection'=>'','value'=>$DBcapacitacoes->data_realizacao,'required'=>'required','min'=>'2022-01-01','max'=>'2030-12-31','minlength'=>'','maxlength'=>''],
            'local_id' => ['tag'=>'select','type'=>'','title'=>'Local','id'=>'local_id','row' => 'col-md-4', 'connection' => $DBlocais,'value'=>$DBcapacitacoes->local_id,'required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>''],
            'carga_horaria' => ['tag'=>'input','type'=>'number','title'=>'Carga Horária','id'=>'carga_horaria','row'=>'col-md-4','connection'=>'','value'=>$DBcapacitacoes->carga_horaria,'required'=>'required','min'=>'','max'=>'','minlength'=>'0','maxlength'=>'120'],
        ];

        return view('views.cnep.capacitacao.capacitacao.edit',[
            'title' => $title,
            'forms' => $forms,
            'capacitacoes' => $DBcapacitacoes,
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
        $data = $request->only('titulo','data_realizacao','local_id','carga_horaria');

        //Ponte para o banco via Eloquent
            $DBcapacitacoes = CapacitacaoModel::find($id);

        //Gravando dados no banco
            foreach ($data as $key => $value){
                $DBcapacitacoes->$key = $value;
            }

            $DBcapacitacoes->save();

        return redirect()->route('qualifications.show',['qualification'=>$DBcapacitacoes->id]);
    }

    public function certificate(Request $request, $id){

        //
        $DBcapacitacoes = CapacitacaoModel::find($id);
        $DBservidores = ServidorModel::where('capacitacao_id', $id)->orderBy('servidor')->get();

        $meses = ['01'=>'Janeiro','02'=>'Fevereiro','03'=>'Março','04'=>'Abril','05'=>'Maio','06'=>'Junho','07'=>'Julho','08'=>'Agosto','09'=>'Setembro','10'=>'Outubro','11'=>'Novembro','12'=>'Dezembro'];

        $dia = date('d', strtotime($DBcapacitacoes->data_realizacao));
        $mesB = date('m', strtotime($DBcapacitacoes->data_realizacao));
        $mes = $meses[$mesB];
        $ano = date('Y', strtotime($DBcapacitacoes->data_realizacao));

        $date = "$dia de $mes de $ano";
        
        $pdf = PDF::loadView('views.cnep.capacitacao.capacitacao.certificate',[
                'capacitacoes' => $DBcapacitacoes,
                'servidores' => $DBservidores,
                'date' => $date
            ]);

        return $pdf->download("$DBcapacitacoes->titulo.pdf");

        //return view('cnep.capacitacao.capacitacao.certificate',[
        #    'capacitacoes' => $DBcapacitacoes,
        #    'servidores' => $DBservidores,
        #    'date' => $date
        #]);
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
        $DBservidores = ServidorModel::where('capacitacao_id', $id);
        $CountServidores = $DBservidores->count();

        $DBpalestrantes = PalestranteModel::where('capacitacao_id', $id);
        $CountPalestrante = $DBpalestrantes->count();

        //Verificando se Existe Servidor Vinculado a Capacitação
            if ($CountServidores <= 0 && $CountPalestrante <= 0) {
                $DBcapacitacoes = CapacitacaoModel::find($id);
                $DBcapacitacoes->delete();

                return redirect()->route('qualifications.index');
            }else {
                return redirect()->route('qualifications.index')->with('error','A Capacitação que deseja excluir contém servidores ou palestrantes cadastrados, caso deseje realizar a exlusão remova todos e tente novamente.');
            }
    }
}
