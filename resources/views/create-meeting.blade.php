<!DOCTYPE html>
<html>
<head>
    <title>Create Jitsi Meeting</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Create Jitsi Meeting</h1>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('create-meeting.post') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Create Meeting</button>
    </form>
</div>
</body>
</html>
