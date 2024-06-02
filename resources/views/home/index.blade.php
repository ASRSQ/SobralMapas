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
                        <summary>Mobiliadade Urbana</summary>
                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_1">
                            <label for="transol_linha_1">Linha 1 do Transol</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_3">
                            <label for="transol_linha_3">Linha 2 do Transol</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_4">
                            <label for="transol_linha_4">Linha 3 do Transol</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_5">
                            <label for="transol_linha_5">Linha 4 do Transol</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_6">
                            <label for="transol_linha_6">Linha 5 do Transol</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_7">
                            <label for="transol_linha_7">Linha 6 do Transol</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="transol_linha_8">
                            <label for="transol_linha_8">Linha 7 do Transol</label>
                        </div>
                        <div class="layer-category">
                            <input type="checkbox" id="ciclovia_a">
                            <label for="ciclovia_a">Ciclovia</label>
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
                    <div id="collapseDragDropMaps" class="container drag-drop-body p-0 collapse show" style="">
                        <div class="drag-drop-list">
                            <!-- Outros mapas ativos existentes -->

                            <!-- Dropdown para o mapa personalizado -->
                            <div class="dropdown">
                                <hr>
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Mapa Personalizado
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="customMapDropdown">
                                    <!-- Camadas selecionadas serão adicionadas aqui dinamicamente -->
                                </ul>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
            <!-- Div para o mapa -->
            <div class="col-md-9">
                <div id="map" class="map"></div>
                <div id="legend" class="card">
                <div id="legend_heading" class="card-header p-0">
                    <span class="btn d-flex justify-content-between">Legenda</span>
                </div>
                <div id="legend_body" class="card-body">
                    <!-- Aqui será inserida a legenda dinamicamente -->
                </div>
            </div>

            </div>
        </div>
    </div>

    <script type="module" src="{{ asset('js/home.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>