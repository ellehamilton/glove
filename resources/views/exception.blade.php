<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <style>
        html, body {
            background-color: #fffAf0;
            font-family: 'Raleway', sans-serif;
        }

        header, main {
            color: #351514;
            margin: 2em auto;
            max-width: 800px;
        }

        main {
            line-height: 175%;
        }
    </style>
</head>

<body>
    <header>
        <h1>{{ $code }} {{ $name }}</h1>
    </header>

    <main>
        <p>
            {{ $description }}
        </p>
    </main>
</body>
</html>
