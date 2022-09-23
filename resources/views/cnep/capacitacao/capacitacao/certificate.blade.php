<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Certificado</title>
        <style>

            @page{
                margin: 0;
                padding: 0;
                size: landscape;
            }

            body{
                margin: 0;
                padding: 0; 
                background: url(img/cert/cert.png) no-repeat;
                background-size: contain;
            }

            .bg-cert{   
                margin: 0;
                padding: 0; 
                width: 29.7cm;
                height: 19cm;
            }

            .tx-cert{
                font-size: 1.7em;
                text-align: justify;
                padding: 6.5cm 3.5cm 0cm 5cm;
            }

        </style>
    </head>
    <body>
        @foreach ($servidores as $servidor)
            <section class="bg-cert">
                <p class="tx-cert">
                    Conferimos a {{$servidor->servidor}} portador do CPF {{substr($servidor->cpf, 0, 3) . '.' .substr($servidor->cpf, 3, 3) . '.' .substr($servidor->cpf, 6, 3) . '-' .substr($servidor->cpf, 9, 2);}}, o presente certificado por participar da Capacitação “{{$capacitacoes->titulo}}”, realizado pela {{$capacitacoes->tb_locais_auditorios->name}}, no dia {{$date}}, com carga horária total de {{$capacitacoes->carga_horaria}} horas.
                </p>
            </section>
        @endforeach
    </body>
</html>
