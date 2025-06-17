<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Halaman Tidak Ditemukan</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      text-align: center;
      color: #343a40;
    }

    .container {
      max-width: 600px;
    }

    h1 {
      font-size: 8rem;
      color: #dc3545;
    }

    h2 {
      font-size: 2rem;
      margin-bottom: 20px;
    }

    p {
      font-size: 1.1rem;
      margin-bottom: 30px;
    }

    a {
      text-decoration: none;
      padding: 12px 24px;
      background-color: #007bff;
      color: white;
      border-radius: 6px;
      transition: background-color 0.3s;
    }

    a:hover {
      background-color: #0056b3;
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 6rem;
      }

      h2 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  @yield('content')
</body>
</html>
