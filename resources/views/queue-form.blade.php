<!DOCTYPE html>
<html>
<head>
    <title>Queue Form</title>
</head>
<body>
    <h1>Send Queued Email</h1>
    <form action="/process-queue" method="POST">
        @csrf
        <label for="email">Enter Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Send</button>
    </form>
</body>
</html>