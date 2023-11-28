<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $details['title'] }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        h1 {
            color: #007BFF;
        }

        h2 {
            color: #007BFF;
        }

        h4 {
            margin-top: 5px;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 10px;
        }

        h3 {
            color: #007BFF;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <h2>Tâches à réaliser</h2>
    <h4>{{ $details['body'] }}</h4>
    <p>Date d'échéance {{ $details['date'] }}</p>
    <h3>Toute l'équipe de BegoTech vous remercie et vous invite à ne pas dépasser le délai. 🚀</h3>
</body>
</html>
