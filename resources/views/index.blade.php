<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 7 PDF Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <div style="font-family: sans-serif" class=" mt-5">
        <h4 class="text-center mb-3">Device Usages Report</h2>
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-danger">
                    <th scope="col">Timestamp</th>
                    <th scope="col">DeviceID</th>
                    <th scope="col">Watt Usage (w)</th>
                    <th scope="col">Energy Usage (kWH)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($device_usages ?? [] as $data)
                <tr>
                    <th scope="row">{{ $data->created_at }}</th>
                    <td>{{ $data->user_device_id }}</td>
                    <td>{{ $data->watt }}</td>
                    <td>{{ $data->kwh }}</td>
                </tr>
                @endforeach 
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>