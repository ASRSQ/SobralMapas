@section('sidebar')

<div class="sidebar" id="mainSidebar">
    <!-- Parte interna da sidebar com camadas/categorias -->
    <div class="sidebar-content">

        <div id="view-camadas" class="sidebar-camadas">
            <div class="sidebar-header d-flex justify-content-between">
                <span>Camadas</span>
            </div>
            
            <div class="accordion" id="accordionExample">
                <!-- Accordion Item #1 (Categoria) -->
                <div class="accordion-item cat">
                    <h2 class="accordion-header cat" id="headingOne">
                        <button class="accordion-button cat" type="button" data-bs-toggle="collapse" data-bs-target="#cat1" aria-expanded="true" aria-controls="collapseOne">
                            Categoria #1
                        </button>
                    </h2>
                    <div id="cat1" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body cat">
    
                            <!-- Subcategorias como um accordion interno -->
                            <div class="accordion" id="accordionSubcat1">
    
                                <!-- Subcategoria 1 -->
                                <div class="accordion-item sub">
                                    <h2 class="accordion-header sub" id="headingSubcat1">
                                        <button class="accordion-button sub collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#subcat1" aria-expanded="false" aria-controls="subcat1">
                                            Subcategoria 1
                                        </button>
                                    </h2>
                                    <div id="subcat1" class="accordion-collapse collapse" aria-labelledby="headingSubcat1" data-bs-parent="#accordionSubcat1">
                                        <div class="accordion-body sub">
                                            <!-- Camadas da Subcategoria 1 -->
                                            <ul class="list-unstyled sub-list">
                                                <li>
                                                    <input type="checkbox" id="transol_linha_6">
                                                    <div class="label-layer-box">
                                                        <label for="transol_linha_6">Linha transol 6</label>
                                                        <i class="fas fa-exclamation-circle hide-layer-alert" ></i>
                                                    </div>
                                                    
                                                </li>
                                                <li>
                                                    
                                                    <input type="checkbox" id="transol_linha_5">
                                                    <div class="label-layer-box">
                                                        <label for="transol_linha_55">Linha transol 5</label>
                                                        <i class="fas fa-exclamation-circle hide-layer-alert" ></i>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Subcategoria 2 -->
                                <div class="accordion-item sub">
                                    <h2 class="accordion-header sub" id="headingSubcat2">
                                        <button class="accordion-button sub collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#subcat2" aria-expanded="false" aria-controls="subcat2">
                                            Subcategoria 2
                                        </button>
                                    </h2>
                                    <div id="subcat2" class="accordion-collapse collapse" aria-labelledby="headingSubcat2" data-bs-parent="#accordionSubcat1">
                                        <div class="accordion-body sub">
                                            <!-- Camadas da Subcategoria 2 -->
                                            <ul class="list-unstyled">
                                                <li>
                                                    <input type="checkbox" id="layer3">
                                                    <label for="layer3">Layer 3</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" id="layer4">
                                                    <label for="layer4">Layer 4</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Accordion Item #2 (Categoria) -->
                <div class="accordion-item cat">
                    <h2 class="accordion-header cat" id="headingTwo">
                        <button class="accordion-button cat collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Categoria #2
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body cat">
    
                            <!-- Subcategorias como um accordion interno -->
                            <div class="accordion" id="accordionSubcat2">
                                <!-- Subcategoria 1 -->
                                <div class="accordion-item sub">
                                    <h2 class="accordion-header sub" id="headingSubcat3">
                                        <button class="accordion-button sub collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#subcat3" aria-expanded="false" aria-controls="subcat3">
                                            Subcategoria 1
                                        </button>
                                    </h2>
                                    <div id="subcat3" class="accordion-collapse collapse" aria-labelledby="headingSubcat3" data-bs-parent="#accordionSubcat2">
                                        <div class="accordion-body sub">
                                            <!-- Camadas da Subcategoria 1 -->
                                            <ul class="list-unstyled">
                                                <li>
                                                    <input type="checkbox" id="layer5">
                                                    <label for="layer5">Layer 5</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" id="layer6">
                                                    <label for="layer6">Layer 6</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Subcategoria 2 -->
                                <div class="accordion-item sub">
                                    <h2 class="accordion-header sub" id="headingSubcat4">
                                        <button class="accordion-button sub collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#subcat4" aria-expanded="false" aria-controls="subcat4">
                                            Subcategoria 2
                                        </button>
                                    </h2>
                                    <div id="subcat4" class="accordion-collapse collapse" aria-labelledby="headingSubcat4" data-bs-parent="#accordionSubcat2">
                                        <div class="accordion-body sub">
                                            <!-- Camadas da Subcategoria 2 -->
                                            <ul class="list-unstyled">
                                                <li>
                                                    <input type="checkbox" id="layer7">
                                                    <label for="layer7">Layer 7</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" id="layer8">
                                                    <label for="layer8">Layer 8</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>

        <div id="view-mapas-ativos" style="display: none" class="sidebar-mapas-ativos">
            <div class="sidebar-header mb-1 d-flex justify-content-between">
                <span>Mapas Ativos</span>
            </div>
            <!-- Mapas Ativos como um conjunto de accordion  -->
            <div class="accordion" id="accordionMapasAtivos"> 
                <!-- Accordion Item #1 (Categoria) -->
                <div class="accordion-item ma">
                    <div class="accordion-header ma">
                        <button class="accordion-button ma" type="button" data-bs-toggle="collapse" data-bs-target="#ma1" aria-expanded="true" aria-controls="collapseOne">
                            <img height="30px" src="api/layer/legend?layer=Ceara:transol_linha_3" alt="">
                            <span>Transol Linha 3</span>
                        </button>
                    </div>
                    <div id="ma1" class="accordion-collapse ma collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionMapasAtivos">
                        <div class="accordion-body ma">
                            <h3>Legenda</h3>
                            <div class="ma-img-box">
                                <img src="api/layer/legend?layer=Ceara:transol_linha_3" alt="">
                            </div>
                            <div class="ma-leg-box">
                                <p>Linha sul do transol que sai do bairro cohab 3 até arco do triunfo.</p>
                            </div>            
                        </div>
                    </div>
                </div>
            
                <!-- Accordion Item #2 -->
                <div class="accordion-item ma">
                    <div class="accordion-header ma">
                        <button class="accordion-button ma collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ma2" aria-expanded="false" aria-controls="collapseTwo">
                            <img height="30px" src="api/layer/legend?layer=Ceara:transol_linha_1" alt="">
                            <span>Transol Linha 1</span>
                        </button>
                    </div>
                    <div id="ma2" class="accordion-collapse ma collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionMapasAtivos">
                        <div class="accordion-body ma">
                            <h3>Legenda</h3>
                            <div class="ma-img-box">
                                <img src="api/layer/legend?layer=Ceara:transol_linha_1" alt="">
                            </div>
                            <div class="ma-leg-box">
                                <p>Linha norte do transol que sai do bairro novo recanto até Campo dos Velhos.</p>
                            </div>            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
    

    <!-- Coluna de botões que permanece visível quando retraída -->
    <div class="action-bar">
        {{-- toggle hamburguer --}}
        <button class="btn" id="toggleSidebar" data-bs-toggle="tooltip" title="Menu"><i class="fas fa-bars"></i></button>  
    
        {{-- pesquisar --}}
        <div class="search-container">
            <input type="text" class="input-search hidden form-control" placeholder="Pesquisar... [ENTER]" aria-label="Pesquisar" aria-describedby="searchButton">
            <button id="btn-search" class="btn" data-bs-toggle="tooltip" title="Pesquisar"><i class="fas fa-search"></i></button>
        </div>
        
        <button class="btn active" id="btn-camadas" data-bs-toggle="tooltip" title="Camadas"><i class="fas fa-layer-group"></i></button>
        <button class="btn" id="btn-mapas-ativos" data-bs-toggle="tooltip" title="Legenda e Mapas Ativos"><i class="fas fa-info"></i></button>
        <button class="btn" data-bs-toggle="tooltip" title="Limpar Mapa"><i class="fas fa-eraser"></i></button>
        <button class="btn" id="btn-imprimir" data-bs-toggle="tooltip" title="Imprimir"><i class="fas fa-print"></i></button>
        <button class="btn" id="btn-measure" data-bs-toggle="tooltip" title="Medir"><i class="fas fa-ruler"></i></button>
        <button class="btn" id="btn-expand" data-bs-toggle="tooltip" title="Expandir Tela"><i class="fas fa-expand-arrows-alt"></i></button>
    </div>
    
</div>

@endsection
