<!-- resources/views/api.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>API Response</title>
</head>
<body>
    <h1>API Response</h1>

    <p>Match ID: {{ $data['match_id'] }}</p>
    <p>API Name: {{ $data['api_name'] }}</p>
    <p>Called: {{ $data['called'] }}</p>
    <pre>{{ json_encode($data, JSON_PRETTY_PRINT) }}</pre>
</body>
</html>
