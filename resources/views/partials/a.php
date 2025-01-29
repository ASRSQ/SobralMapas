<div class="sidebar" id="mainSidebar">
    <!-- Parte interna da sidebar com camadas/categorias -->
    <div class="sidebar-content">

        <div id="view-camadas" class="sidebar-camadas">
            <div class="sidebar-header d-flex justify-content-between">
                <span>Camadas</span>
            </div>
            <div class="accordion" id="accordionExample">
            @foreach($layers->groupBy(fn($layer) => $layer->getCategory() ?? 'Sem Categoria') as $categoryName => $subcategories)
                    <div class="accordion-item cat">
                        <h2 class="accordion-header cat">
                            <button class="accordion-button cat" type="button" data-bs-toggle="collapse" data-bs-target="#cat-{{ Str::slug($categoryName) }}">
                                {{ $categoryName }}
                            </button>
                        </h2>
                        <div id="cat-{{ Str::slug($categoryName) }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body cat">
                                <div class="accordion" id="accordionSubcat-{{ Str::slug($categoryName) }}">
                                    @foreach($subcategories->groupBy(fn($layer) => $layer->getSubcategory() ?? 'Sem Subcategoria') as $subcategoryName => $subcategoryLayers)
                                        <div class="accordion-item sub">
                                            <h2 class="accordion-header sub">
                                                <button class="accordion-button sub collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#subcat-{{ Str::slug($subcategoryName) }}">
                                                    {{ $subcategoryName }}
                                                </button>
                                            </h2>
                                            <div id="subcat-{{ Str::slug($subcategoryName) }}" class="accordion-collapse collapse" data-bs-parent="#accordionSubcat-{{ Str::slug($categoryName) }}">
                                                <div class="accordion-body sub">
                                                    <ul class="list-unstyled sub-list">
                                                        @foreach($subcategoryLayers as $layer)
                                                            <li>
                                                                <input type="checkbox" id="layer_{{ $layer->getId() }}" onchange="toggleLayer(map, '{{ $layer->getLayerName() }}', this.checked)">
                                                                <label for="layer_{{ $layer->getId() }}">
                                                                    {{ $layer->getName() }}
                                                                </label>
                                                                <i class="fas fa-exclamation-circle hide-layer-alert"></i>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
