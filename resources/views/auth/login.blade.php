<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
        * {
            border: none;
            outline: none;
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: Poppins, sans-serif;
            text-decoration: none;  
            scroll-behavior: smooth;
            list-style-type: none;
            transition: 0.1s ease;
        }
        body{
            background-color: #f4f4f4; 
        }
        .container{ 
            max-width: 500px;
            height: auto;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%,-50%);
            padding: 50px; 
            background: white; 
            border-radius: 1.5rem; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1); 
            gap: 20px;
        }
        h1{ 
            text-align: center; 
        }
        .bx{
            position: absolute;
            
            left: 60px;
            align-content: center;
        }
        .input{
            display: flex;
        }
        input{ 
            width: 100%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
        }
        input:focus{
            border: 1px solid black;
        }
        button{ 
            width: 100%; 
            padding: 10px; 
            background: #5cb85c; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
        }
        button:hover { 
            background: #005E39; 
        }
        .error{ 
            color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="input input1">
            <i class='bx bxs-envelope' ></i>
            <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input input2">
            <i class='bx bxs-lock-open-alt' ></i>
            <input type="password" name="password" placeholder="Password (8 Character)" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
    </div>
</body>
</html>
