<!DOCTYPE html>
<html>
<head>
    <title>Mapa com OpenLayers e GeoServer</title>
    <!-- Incluir os arquivos do OpenLayers -->
    <link rel="stylesheet" href="https://openlayers.org/en/v6.13.0/css/ol.css" type="text/css">
    <script src="https://openlayers.org/en/v6.13.0/build/ol.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <meta http-equiv="Content-Security-Policy">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- 
    <style>
        #layerCheckboxList {
            height: 100vh; /* Ocupa toda a altura da tela */
            overflow-y: auto; /* Adiciona rolagem vertical */
        }

        .layer-checkbox input[type="checkbox"] {
             margin-right: 5px;
        }

        header {
            background-color: #1C184A;
            color: white;
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-left img {
            height: 60px;
            margin-right: 10px;
        }

        .header-center h2{
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            padding: 10px 20px; 
        }

        .header-left img {
            height: 60px;
            margin-right: 10px;
        }

        .header-right{
            display: flex;
            align-items: center;
            justify-content: center;
        }

        nav button {
            background: none; 
            border: none; 
            color: white; 
            font-weight: bold;
            padding: 10px 20px; 
            margin: 0 5px; 
            cursor: pointer; 
            font-size: 18px; 
        }

        nav button:hover {
            color: gray;
        }

        main {
            display: flex;
        }

        .container-fluid {
            background-color: white; 
            padding: 20px; 
        }


        h3 {
            color: #2F4471;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        #layerCheckboxList {
            background-color: #2F4471;
            padding: 20px;
            border-radius: 10px;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .map {
            height: 500px; /* Ajuste conforme necessário */
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .col-md-3 {
            margin-bottom: 20px;
        }


        .layer-category {
            padding: 10px;
            margin: 5px 0;
            background-color: none;
            border-radius: 5px;
        }

        .layer-category input[type="checkbox"] {
            margin-right: 10px;
        }

        details {
            border-bottom: 1px solid white; 
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 10px;
            background-color: none;
            color: white;
            transition: background-color 0.2s;
        }

        details:hover {
            background-color: #1c2736;
        }

        details summary {
            color: none;
            cursor: pointer;
            font-weight: bold;
            padding: 5px;
            background-color: none;
            border-radius: 3px;
            position: relative;
            list-style: none;
        }

        details summary::before {
            content: '\25BC'; 
            position: absolute;
            right: 15px;
            transition: transform 0.3s ease;
            transform: rotate(30deg);
        }

        details[open] summary::before {
            transform: rotate(120deg);
        }

        details div.layer-category {
            margin-left: 20px;
        }

        details summary {
            cursor: pointer;
            font-weight: bold;
            margin: 10px 0;
        }

        details summary:hover {
            color: #f0f0f0;
        }

        details[open] summary {
            color: #f0f0f0;
        }

        .search-container {
            position: relative;
            margin-bottom: 10px;
        }

        #searchInput {
            padding: 8px 30px 8px 8px;
            width: 100%;
            border: px solid #ccc;
            border-radius: 20px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .search-button {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .search-button i {
            color: #777;
        }

        #searchInput:focus {
            outline: none;
            border-color: #555; 
            box-shadow: 0 0 5px rgba(85, 85, 85, 0.5); /
        }

    </style> -->
    
</head>

<body>
    <header>
        <div class="header-left">
            <img src="{{ asset('img/Logo_Sobral.png') }}" alt="Logo Sobral">
        </div>

        <div class="header-center">
            <h2>Sobral em Mapas</h2>
        </div>
        
        <div class="header-right">
            <nav>
                <button>TUTORIAL</button>
                <button>SOBRE</button>
                <button>CONTATO</button>
            </nav>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Div para a caixa de seleção -->
            <div class="col-md-3">

            <div class="search-container">
                <button type="button" class="search-button"><i class="fas fa-search"></i></button>
                <input type="text" id="searchInput" placeholder="Pesquisar por mapas...">
            </div>

                <h3>Selecione um mapa para ter visualização:</h3>
                <div id="layerCheckboxList">

                    <!-- Alguns exemplos de como ficaria as categorias-->
                    
                    <!-- Categoria: Linhas do Transol -->
                    <details>
                        <summary>Linhas do Transol</summary>

                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_1">
                            <label for="transol_linha_1">Linha 1 do Transol</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_2">
                            <label for="transol_linha_2">Linha 2 do Transol</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_3">
                            <label for="transol_linha_3">Linha 3 do Transol</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_4">
                            <label for="transol_linha_4">Linha 4 do Transol</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_5">
                            <label for="transol_linha_5">Linha 5 do Transol</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_6">
                            <label for="transol_linha_6">Linha 6 do Transol</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_7">
                            <label for="transol_linha_7">Linha 7 do Transol</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_8">
                            <label for="transol_linha_8">Linha 8 do Transol</label>
                        </div>
                    </details>

                    <!-- Categoria: Infraestrutura -->
                    <details>
                        <summary>Infraestrutura</summary>
                        <div class="layer-category">
                            <input type="checkbox" id="acesso_a">
                            <label for="acesso_a">acesso_a</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="alvara_contrucao_p">
                            <label for="alvara_contrucao_p">alvara_contrucao_p</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="area_csf_pl">
                            <label for="area_csf_pl">area_csf_pl</label>
                        </div>
                    </details>

                    <!-- Categoria: Educação -->
                    <details>
                        <summary>Educação</summary>
                        <div class="layer-category">
                            <input type="checkbox" id="ensino_sobral">
                            <label for="ensino_sobral">ensino_sobral</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="ensino_sobral_municipal">
                            <label for="ensino_sobral_municipal">ensino_sobral_municipal</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="escolas_municipal">
                            <label for="escolas_municipal">escolas_municipal</label>
                        </div>
                    </details>

                    <!-- Categoria: Saúde -->
                    <details>
                        <summary>Saúde</summary>
                        <div class="layer-category">
                            <input type="checkbox" id="saude_sobral">
                            <label for="saude_sobral">saude_sobral</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="saude_sobral_municipal">
                            <label for="saude_sobral_municipal">saude_sobral_municipal</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="pop_saude_2022">
                            <label for="pop_saude_2022">pop_saude_2022</label>
                        </div>
                    </details>

                </div>
            </div>
            <!-- Div para o mapa -->
            <div class="col-md-9">
                <div id="map" class="map"></div>
            </div>
        </div>
    </div>

    <script type="module" src="{{ asset('js/home.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>