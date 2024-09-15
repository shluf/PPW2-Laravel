<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>List Buku</title>
</head>

<body>
    <table class="table table-stripped">
        <thead>
            <tr>
                <th>id</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Tanggal Terbit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

            @foreach($data_buku as $buku)
            <tr>
                <td>{{ $buku->id}}</td>
                <td>{{ $buku->judul }}</td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ "Rp. ".number_format($buku->harga, 2, ',','.') }}</td>
                <td>{{ $buku->tgl_terbit->format('d/m/Y') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Total Harga Buku</strong></td>
                <td colspan="2"><strong>Rp. {{ number_format($total_harga, 2, ',', '.') }}</strong></td>
            </tr>

        </tbody>
    </table>

    <p class="alert alert-info">Jumlah Buku: {{ $jumlah_buku }}</p>

</body>

</html>

