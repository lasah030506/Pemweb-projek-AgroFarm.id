<!DOCTYPE html>
<html>
<head>
    <title>Laporan Harga Pasar AgroFarm</title>
    <style>
        body {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
        }
        .date {
            text-align: right;
            font-size: 12px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Laporan Daftar Harga Komoditas</h2>
    <div class="date">Dicetak pada: {{ date('d-m-Y H:i') }}</div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Komoditas</th>
                <th>Satuan</th>
                <th>Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commodities as $index => $commodity)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $commodity->name }}</td>
                <td>{{ $commodity->unit }}</td>
                <td>{{ number_format($commodity->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
