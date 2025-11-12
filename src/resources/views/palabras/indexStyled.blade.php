<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Palabras</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 900px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.4;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
            text-decoration: none;
            color: #fff;
        }
        .btn-primary { background-color: #007bff; border-color: #007bff; }
        .btn-info { background-color: #17a2b8; border-color: #17a2b8; }
        .btn-warning { background-color: #ffc107; border-color: #ffc107; color: #212529; }
        .btn-danger { background-color: #dc3545; border-color: #dc3545; }
        .mb-3 { margin-bottom: 1rem; }
    </style>
</head>
<body>
<div class="container">
    <h1>Listado de Palabras</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Palabra</th>
            </tr>
        </thead>
        <tbody>
            @if(count($palabras) > 0)
                @foreach($palabras as $palabra)
                    <tr>
                        <td>{{ $palabra->id }}</td>
                        <td>{{ $palabra->palabra }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" style="text-align: center;">No hay palabras registradas.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
</body>
</html>