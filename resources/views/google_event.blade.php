<!DOCTYPE html>
<html>
<head>
    <title>Google Meet Event</title>
</head>
<body>
    <h1>Google Meet Event Created</h1>
    <p>Event Summary: {{ $event->getSummary() }}</p>
    <p>Event Start Time: {{ $event->getStart()->getDateTime() }}</p>
    <p>Event End Time: {{ $event->getEnd()->getDateTime() }}</p>
    <p>Join URL: <a href="{{ $event->getHangoutLink() }}" target="_blank">Join Meeting</a></p>
</body>
</html>
