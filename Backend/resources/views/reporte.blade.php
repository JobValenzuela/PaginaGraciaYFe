<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receta Médica</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            font-size: 24px;
        }
        .patient-info, .doctor-info {
            margin-bottom: 20px;
        }
        .patient-info p, .doctor-info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        table th {
            background-color: #f2f2f2;
        }
        .signature {
            text-align: right;
            margin-top: 50px;
        }
        .signature p {
            display: inline-block;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Receta Médica</h1>

        <!-- Información del paciente -->
        <div class="patient-info">
            <p><strong>Nombre del Paciente:</strong> {{ $nombre_paciente }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
        </div>

        <!-- Tabla de medicamentos -->
        <table>
            <thead>
                <tr>
                    <th>Nombre del Medicamento</th>
                    <th>Dosis</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicamentos as $medicamento)
                    <tr>
                        <td>{{ $medicamento->nombre_medicamento }}</td>
                        <td>{{ $medicamento->dosis }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Información del doctor -->
        <div class="doctor-info">
            <p><strong>Doctor:</strong> {{ $nombre_doctor }}</p>
        </div>

        <!-- Firma del doctor -->
        <div class="signature">
            <p>Firma del Doctor</p>
        </div>
    </div>
</body>
</html>
