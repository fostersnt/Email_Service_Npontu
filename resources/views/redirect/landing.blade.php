<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REDIRECT URL</title>
    <script src="{{asset('jQuery/jquery-3.6.3.min.js')}}"></script>

    <style>
        .main{
            height: 98vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        button{
            width: 100%;
            padding: 20px;
            border: none;
            outline: none;
            border-radius: 10px;
            color: white;
            font-size: 30px;
            cursor: pointer;
            background-image: linear-gradient(orange, orangered);
        }

        button:hover{
            background-image: linear-gradient(blue, yellow);
        }
    </style>

</head>
<body>
    <div class="main">
        <div>
            <img src="{{asset('images/abc.png')}}" height="200" width="200" alt="">
        </div>
        <div>
            <h1> 
                @if (Request::has('feedback'))
        
                    {{ Request::get('feedback') }}
        
                @else
                    
                @endif
            </h1>
            <button type="submit" id="click_me">Click Me If You Want To Continue</button>
        </div>
    </div>
</body>
</html>

<script>
    $(document).ready(function() {
        $('#click_me').click(function(e) {
            e.preventDefault();
            alert("Hey! Don't click me. Don't you know I am tired?");
        })
    })
</script>