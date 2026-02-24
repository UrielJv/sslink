<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Carta de Término</title>

    <style>
        body {
            font-family: DejaVu Serif, serif;
            margin: 60px 55px;
            font-size: 13.5px;
            line-height: 1.6;
            color: #111;
        }

        .institucion {
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .oficio {
            text-align: right;
            font-size: 11px;
            margin-top: 10px;
        }

        .titulo {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 25px 0 20px 0;
            text-transform: uppercase;
        }

        .centrado {
            font-weight: bold;
        }

        .firma {
            margin-top: 60px;
            text-align: center;
        }

        .firma-linea {
            border-top: 1px solid #000;
            width: 260px;
            margin: 0 auto 5px auto;
        }
    </style>
</head>
<body>

    @php
        $logoPath = public_path('assets/img/logoo.jpeg');
        $logoBase64 = null;

        if (file_exists($logoPath)) {
            $imageType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoBase64 = 'data:image/' . $imageType . ';base64,' . base64_encode(file_get_contents($logoPath));
        }
    @endphp

    @if($logoBase64)
        <div style="text-align: center; margin-bottom: 10px;">
            <img src="{{ $logoBase64 }}" width="150">
            <div class="institucion">SSLINK</div>
        </div>
    @endif

    <div class="oficio">
        Oficio No. CT-{{ $estudiante->id }}-{{ now()->year }}<br>
        {{ now()->format('d/m/Y') }}
    </div>

    <div class="titulo">
        Carta de Término
    </div>

    <p>A quien corresponda:</p>

    <p>
        Por medio de la presente se hace constar que el(la) estudiante:
    </p>

    <p class="centrado">
        {{ $estudiante->user->nombre }}
        {{ $estudiante->user->apellido_paterno }}
        {{ $estudiante->user->apellido_materno }}
    </p>

    <p>
        con matrícula <strong>{{ $estudiante->matricula }}</strong>, de la carrera
        <strong>{{ $estudiante->carrera }}</strong> de la institución
        <strong>{{ $estudiante->escuela }}</strong> (CCT: {{ $estudiante->cct }}),
        ha concluido satisfactoriamente su servicio social y/o prácticas profesionales
        en el área de <strong>{{ $estudiante->area }}</strong>.
    </p>

    <p>
        El periodo comprendió del
        <strong>{{ optional($estudiante->fecha_inicio)->format('d/m/Y') }}</strong>
        al
        <strong>{{ optional($estudiante->fecha_fin)->format('d/m/Y') }}</strong>,
        cumpliendo un total de
        <strong>{{ $estudiante->horas_requeridas }} horas</strong>.
    </p>

    <p>
        Se extiende la presente para los fines académicos y administrativos que correspondan.
    </p>

    <br><br><br>

    <div class="firma">
        <div class="firma-linea"></div>
        <strong>
            Lic. Aline Alejandra Pérez Flores
        </strong><br>
        Directora<br>
    </div>

</body>
</html>
