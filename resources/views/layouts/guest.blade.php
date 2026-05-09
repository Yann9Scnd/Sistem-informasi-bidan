<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Login') — PMB Sri Andayani, Amd.Keb</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
/* ── Guest layout minimal (login only) ── */
:root {
  --pink-primary:   #F8C8DC;
  --pink-secondary: #FDECEF;
  --pink-accent:    #E879A0;
  --green-btn:      #4CAF50;
  --green-hover:    #388E3C;
  --white:          #FFFFFF;
  --gray:           #9E9E9E;
  --text-dark:      #2D3748;
  --text-medium:    #4A5568;
  --text-light:     #718096;
  --error:          #FC8181;
}

*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #FDECEF 0%, #FFF0F5 40%, #F8C8DC22 100%);
  min-height: 100vh;
  display: flex; align-items: center; justify-content: center;
  padding: 20px;
  position: relative; overflow: hidden;
}
body::before {
  content: ''; position: fixed;
  top: -100px; right: -100px;
  width: 400px; height: 400px;
  background: radial-gradient(circle, #F8C8DC55 0%, transparent 70%);
  border-radius: 50%; pointer-events: none;
}
body::after {
  content: ''; position: fixed;
  bottom: -80px; left: -80px;
  width: 300px; height: 300px;
  background: radial-gradient(circle, #FDECEF88 0%, transparent 70%);
  border-radius: 50%; pointer-events: none;
}
</style>
@stack('styles')
</head>
<body>
  @yield('content')
@stack('scripts')
</body>
</html>