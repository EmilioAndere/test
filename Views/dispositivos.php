<?php $_SESSION['user'] = 'Emilio Andere'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <title>Dispositivos | <?= $_SESSION['user']; ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: url('Assets/bg.jpg');
        }
    </style>
</head>
<body>
    <div class="h-screen p-5">
        <div class="flex bg-opacity-50 bg-gray-100 shadow-md rounded-md p-5">
            <div class="flex w-full">
                <div class="w-1/4 md:w-2/4">
                    <select class="focus:outline-none uppercase p-2 rounded-md" name="devices" id="devices"></select>
                    <button class="bg-green-600 px-3 py-1 text-white hover:bg-green-800 rounded-md" id="show"><i class="fas fa-filter"></i></button>
                </div>
                <div class="flex justify-end w-3/4">
                    <div class="flex mx-2 text-center p-1 rounded-md cursor-pointer">
                        <input title="Numero de Estacion y/o Serie" type="text" class="focus:outline-none py-1 px-3 mr-3 rounded-full text-center" id="buscador" placeholder="Busqueda">
                        <button id="btnSearch" class="rounded-full bg-white hover:bg-gray-200 px-4 py-2">
                            <i class="fas fa-search"></i>
                        </button> 
                    </div>
                    <div id="create" class="mx-2 text-center bg-blue-300 hover:bg-blue-500 p-1 rounded-md cursor-pointer">
                        <i class="fas fa-dice-d6"></i>
                        <p class="text-xs">Create Devices</p>
                    </div>
                    <div id="register" class="mx-2 text-center bg-indigo-400 hover:bg-indigo-600 p-1 rounded-md cursor-pointer">
                        <i class="fas fa-save"></i>
                        <p class="text-xs">Register Device</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="formRegister" class="hidden bg-blue-500 text-white font-bold rounded-md w-full p-3 my-5 shadow-md">
            <h1 class="text-3xl text-center">Register Device New</h1>
            <div class="flex md:block justify-center m-5">
                <label for="" class="p-1">Numero Serie:</label>
                <input type="text" class="text-black focus:outline-none rounded-md px-5 py-1" id="nSerie" placeholder="# Serie">
                <label for="" class="p-1">Estación:</label>
                <input type="text" class="text-black focus:outline-none rounded-md px-5 py-1" id="estacion" placeholder="# Estación">
                <label for="" class="p-1">Tipo de Dispositivo: </label>
                <select class="px-5 py-1 rounded-md text-black focus:outline-none" id="typeDevice">
                    <option selected>Selecciona...</option>
                </select>
            </div>
            <div id="datos" class="">

            </div>
        </div>
        <div id="content" class="flex bg-opacity-100 justify-center bg-gray-100 max-h-full mt-5 rounded-md">
            <div class="pt-3">
                <h1 id="titleTable" class="capitalize text-center text-gray-300 text-3xl font-black py-2">No se han encontrado dispositivos</h1>
                <div class="flex justify-center w-full">
                    <img src="https://i.postimg.cc/rpSVnMGS/img-1.jpg" class="flex w-1/4 opacity-20 justify-center">
                </div>
            </div>
        </div>
        <div id="contNew" class="bg-gray-100 my-3 p-2 hidden"></div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script lang="javascript">

    let registerNone = `
        <h1 class="text-3xl text-center">Register Device New</h1>
        <div class="flex md:block justify-center m-5">
            <label for="" class="p-1">Numero Serie:</label>
            <input type="text" class="text-black focus:outline-none rounded-md px-5 py-1" id="nSerie" placeholder="# Serie">
            <label for="" class="p-1">Estación:</label>
            <input type="text" class="text-black focus:outline-none rounded-md px-5 py-1" id="estacion" placeholder="# Estación">
            <label for="" class="p-1">Tipo de Dispositivo: </label>
            <select class="px-5 py-1 rounded-md text-black focus:outline-none" id="typeDevice">
                <option selected>Selecciona...</option>
            </select>
        </div>
        <div id="datos" class="">

        </div>`;

    $("#register").click(function(){
        if($("#formRegister").attr("class").includes("hidden")){
            $("#formRegister").removeClass("hidden");
        }else{
            $("#formRegister").addClass("hidden");
        }
        
    })

    const buscar = (event) => {
        if(event.key != 'Control' && event.key != 'CapsLock' && event.key != 'Alt'){
            let val = $("#buscador").val();
            if(val == ""){
                $("#content").html(`
                    <div class="pt-3">
                        <h1 id="titleTable" class="capitalize text-center text-gray-300 text-3xl font-black py-2">No se han encontrado dispositivos</h1>
                        <div class="flex justify-center w-full">
                            <img src="https://i.postimg.cc/rpSVnMGS/img-1.jpg" class="flex w-1/4 opacity-20 justify-center">
                        </div>
                    </div>
                `);
            }else{
                fetch('./search/'+val)
                .then(data => data.json())
                .then(res => {
                    $("#content").removeClass("flex");
                    $("#content").addClass("block p-3");
                    emptyElement("#content");
                    // console.log(res);
                    res.forEach(item => {
                        $("#content").append(`<div id="`+item[0].id_dispositivo+`" class="cursor-pointer card flex bg-white rounded-md px-5 py-1 m-2 w-11/12"></div>`)
                        $("#content > #"+item[0].id_dispositivo).append(`<?php require_once 'Templates/cardSearch.php'; ?>`);
                        $("#content > #"+item[0].id_dispositivo+" > #cardId > h1").html(item[0].id_dispositivo);
                        $("#content > #"+item[0].id_dispositivo+" > #cardBody > #cardOne > #main > h2").html(item[1].slice(2,item[1].length));
                        $("#content > #"+item[0].id_dispositivo+" > #cardBody > #cardOne > #main > h3 > span").html(item[0].n_serie);
                        $("#content > #"+item[0].id_dispositivo+" > #cardBody > #cardOne > #second > p > span").html(item[0].estacion);
                        $("#content > #"+item[0].id_dispositivo+" > #cardBody > #cardTwo > #dateBuy").html(item[0].fecha_compra);
                    });
                });
            }
        }
    }
    $("#buscador").keyup((event) => { buscar(event) });
    $("#btnSearch").click((event) => { buscar(event) });

    fetch('./get/Dispositivo/Options')
        .then(res => res.json())
        .then(data => {
            let tablas = data.filter(item => item[0].includes('d_'));
            tablas.forEach(item => {
                let first = item[0].slice(2,item[0].length);
                $("#devices").append('<option value="'+first+'">'+first+'</option>');  
                $("#typeDevice").append('<option value="'+first+'">'+first+'</option>');  
            });
        });

        //activity
    $("#typeDevice").change(function(){
        let attrs = [];
        let dev = $("#typeDevice").val();
        fetch('./get/columns/'+dev)
            .then(data => data.json())
            .then(res => {
                emptyElement("#datos");
                res.forEach(item => {
                    if(item != 'id_dispositivo'){
                        $("#datos").append(`
                            <labe class="m-2">`+item+`</label>
                            <input type="text" class="m-2 w-full text-black rounded-md px-3 py-1" id="`+item+`" placeholder="`+item+`"><br>
                        `);
                    }
                    attrs.push(item);
                })
                $("#datos").append(`
                        <div>
                            <button id="saving" class="bg-white hover:bg-blue-700 text-black hover:text-white font-bold rounded-full w-2/12 py-2 ml-5">SAVE</button>
                            <button id="cancelReg" class="bg-white hover:bg-red-700 text-black hover:text-white font-bold rounded-full w-2/12 py-2 ml-5">CANCEL</button>
                        </div>
                    `);
                $("#saving").click(function(){
                    let values = [];
                    attrs.forEach(element => {
                        values.push($("#"+element).val());
                    });
                    let table = $("#typeDevice").val();
                    let serie = $("#nSerie").val();
                    let estacion = $("#estacion").val();
                    let attributos = JSON.stringify(attrs);
                    let valu = JSON.stringify(values);
                    fetch('./into/device/'+serie+'/'+estacion+'/'+table+'/'+attributos+'/'+valu)
                        .then(data => data.json())
                        .then(res => {
                            if(res.resp){
                                emptyElement("#formRegister");
                                $("#formRegister").append(`
                                    <p>${res.msg}</p>
                                `)
                                setTimeout(()=>{
                                  emptyElement("#formRegister");  
                                  $("#formRegister").addClass("hidden");
                                  addElements("#formRegister", registerNone);
                                },3000);

                            }else{
                                emptyElement("#formRegister");
                                $("#formRegister").append(`
                                    <p>${res.msg}</p>
                                `);
                                $("#formRegister").addClass("bg-red-400");
                                setTimeout(()=>{
                                  emptyElement("#formRegister");  
                                  $("#formRegister").addClass("hidden");
                                  addElements("#formRegister", registerNone);
                                },3000);
                            }
                            console.log(res);
                        })
                })

                $("#cancelReg").click(function(){
                    emptyElement("#datos");
                    if($("#formRegister").attr("class").includes("hidden")){
                        $("#formRegister").removeClass("hidden");
                    }else{
                        $("#formRegister").addClass("hidden");
                    }
                })
            })
    })

    $("#show").click(function(){
        let device = $("#devices").val();
        fetch('./device/get/'+device)
            .then(res => res.json())
            .then(data => {
                // console.log(data.length);
                if(data.length > 0){
                    $("#titleTable").text(device);
                    if(!$("#content").attr("class").includes("flex")){
                        $("#content").addClass("flex");
                        $("#content").removeClass("block p-3");
                    }
                    $("#content").html(`<table class="m-5 table-auto border border-collapse"><thead><tr id="tableHeader"><th class="border border-blue-500 font-black">#</th></tr></thead><tbody id="bodyTable"></tbody></table>`);
                    
                    console.log(data[0]);
                    let he = JSON.stringify(data[0]);
                    JSON.parse(he, function(k, v){
                        if(typeof(v) != "object"){
                            $("#tableHeader").append(`
                                <th class="border border-blue-500 text-center p-2 uppercase">`+k+`</th>
                            `)
                        }
                    })
                    // emptyElement("#content");
                    data.forEach(item => {
                        // let disp = JSON.stringify(item);
                        // $("#bodyTable").append("<tr>");
                        let arr = Object.values(item);
                        console.log(arr);
                        $("#bodyTable").append("<tr id='"+arr[0]+"' class='hover:bg-blue-700 hover:text-white'><td class='border border-blue-500 p-2 cursor-pointer'><i class='fas fa-clipboard-list text-2xl'></i></td></tr>");
                        arr.forEach(item => {
                            
                            $("#"+arr[0]).append(`
                                <td class='border border-blue-500 text-center p-2'>`+item+`</td>
                            `)
                        })
                    })
                }else{
                    $("#content").html(`
                        <div class="pt-3">
                            <h1 id="titleTable" class="capitalize text-center text-gray-300 text-3xl font-black py-2">No se han encontrado dispositivos</h1>
                            <div class="flex justify-center w-full">
                                <img src="https://i.postimg.cc/rpSVnMGS/img-1.jpg" class="flex w-1/4 opacity-20 justify-center">
                            </div>
                        </div>
                    `);
                }
            })
        })

    $("#create").click(function(){
        if(!$("#content").attr("class").includes("flex")){
            $("#content").addClass("flex");
            $("#content").removeClass("block p-3");
        }
        emptyElement("#content");
        $("#content").append(`<?php require_once 'Views/Templates/createDevice.php'; ?>`);

        $("#attribute").click(function(){
            $("#contNew").removeClass("hidden");
            $("#contNew").append(`<?php require_once 'Views/Templates/newAttributes.php'; ?>`);
        });

        $("#createDevice").click(function(){
            let names = [];
            let types = [];
            let nameTable = $("#nameTable").val();
            $(".name").each((key, item)=>{
                names.push(item.value);
            });
            $(".typeData").each((key, item) => {
                if(item.value == 'boolean' || item.value == 'date'){
                    types.push(item.value);
                }else{
                    types.push(item.value+'('+$(".sizeData")[key].value+')');
                }
            });
            fetch('index.php?controller=Dispositivo&action=createDevice&types='+JSON.stringify(types)+'&names='+JSON.stringify(names)+'&table='+nameTable)
                .then(res => res.text())
                .then(data => {
                    console.log("data");
                    console.log(data);
                })
        })

        $("#cancel").click(function(){
            emptyElement("#content");
            emptyElement("#contNew");
            $("#content").append(`
                <div class="pt-3">
                    <h1 id="titleTable" class="capitalize text-center text-gray-300 text-3xl font-black py-2">No se han encontrado dispositivos</h1>
                    <div class="flex justify-center w-full">
                        <img src="Assets/img_1.jpg" class="flex w-1/4 opacity-20 justify-center">
                    </div>
                </div>
            `);
            $("#contNew").addClass("hidden");
        });
    })

    function emptyElement(id){
        $(id).html(" ");
    }

    function addElements(id, element){
        $(id).append(element);
    }

</script>
</html>