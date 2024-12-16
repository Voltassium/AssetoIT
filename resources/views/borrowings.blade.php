<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">{{ $title }}</h2>
    <p style="text-align: center;">Tanggal: {{ $date }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pengguna</th>
                <th>Nama Perangkat</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($borrowings as $index => $borrowing)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $borrowing->user->name }}</td>
                    <td>{{ $borrowing->device->name }}</td>
                    <td>{{ $borrowing->borrow_date }}</td>
                    <td>{{ $borrowing->return_date }}</td>
                    <td>
                        @if ($borrowing->actual_return_date)
                            Dikembalikan pada {{ $borrowing->actual_return_date }}
                        @else
                            Belum Dikembalikan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
