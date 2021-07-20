<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        body{
            background-image: url('Assets/bg.jpg');
        }
    </style>
</head>
<body>
    <div class="flex bg-gray-200 rounded-md shadow-md p-5 m-10 bg-opacity-50">
        <img src="https://i.postimg.cc/63gFpK25/laptop-PNG101812.png" class="w-1/4">
        <div class="w-3/4 text-white">
            <h1 class="uppercase w-full text-center font-bold text-3xl">estación 1</h1>
            <p class="text-center text-gray-300 text-sm mb-10">AHBF9I3BISDN</p>
            <div class="flex w-2/4">
                <p class="w-2/4 text-right mr-3 uppercase">fecha compra: </p>
                <p class="w-2/4">23-09-21</p>
            </div>
            <div class="flex w-2/4">
                <p class="w-2/4 text-right mr-3 uppercase">SO: </p>
                <p class="w-2/4">Windows 10</p>
            </div>
            <div class="flex w-2/4">
                <p class="w-2/4 text-right mr-3 uppercase">almacenamiento: </p>
                <p class="w-2/4">1 TB</p>
            </div>
        </div>
    </div>
    
    <div id="history" class="bg-gray-200 rounded-md shadow-md p-5 m-10 bg-opacity-50">
        <div class="flex items-center">
            <i id="down" class="cursor-pointer fas fa-chevron-down"></i>
            <h2 class="pl-3">HISTORIAL</h2>
        </div>
        <div class="flex justify-center">
            <table class="w-full m-5">
                <thead>
                    <th>
                        <td class="p-2 border border-black">#</td>
                        <td class="p-2 border border-black">Numero Serie</td>
                        <td class="p-2 border border-black">SO</td>
                        <td class="p-2 border border-black">almacenamiento</td>
                    </th>
                </thead>
            </table>
        </div>
        
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script lang="javascript">

        $("#down").click(function(){
            let classes = $("#down").attr("class");
            if(classes.includes("fa-chevron-down")){
                $("#down").attr("class","cursor-pointer fas fa-chevron-up");
                $("table").removeClass("hidden");
            }else{
                $("#down").attr("class","cursor-pointer fas fa-chevron-down");
                $("table").addClass("hidden");
            }
        })

</script>
</html>