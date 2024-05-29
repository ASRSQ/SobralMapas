   // URL do serviço WMS
   var wmsUrl = 'http://geoserver.sobral.ce.gov.br/geoserver/ows';

   // Lista de camadas
   var layers = [
       //'Ceara:logradouro_sobral',
    //    'sobral:lot_mae_rainha',
       //'sobral:CORTE',
       //'Ceara:MBV_TIFF_NEW',
       //'sobral:MDT_Sobral_Tiff',
       //'sobral:PePalhano_Orthomosaic_modificado',
       //'sde:SC_Cidades_Aracatiacu_CE',
       //'sde:SC_Cidades_Jaibaras_CE',
       //'sde:SC_Cidades_Taperuaba_CE',
       'Ceara:acesso_a',
       //'sobral:admiro',
       //'sde:alto_grande',
       'Ceara:alvara_contrucao_p',
       //'sde:aprazivel',
       'Ceara:area_csf_pl',
       'Ceara:area_esgoto',
       'Ceara:area_fotogrametria_pl',
       'sde:area_prodesol',
       'sde:asfaltado_l',
       'sde:auto_infra',
       'Ceara:bairros_2023_a',
       'Ceara:bairros_a',
       //'Ceara:bar_map',
       //'sde:bar_p',
       //'Ceara:barragem_l',
    //    'sde:belo_horizonte',
       //'Ceara:beneficado_rf',
       //'sobral:boa_esperanca',
    //    'sobral:boa_vizinhaca_2',
    //    'sobral:boa_vizinhanca_1',
    //    'sde:bonfim',
       //'Ceara:cadastro',
    //    'Ceara:cadastro_unificado',
       'sde:cadunico_familias_p',
       'sobral:camera_p',
       'Ceara:campo_quadra_a',
    //    'Ceara:canal_l',
    //    'sobral:caracara_2023',
    //    'Ceara:casos_positivos_dengue_2021',
       'Ceara:cb_poste_p',
       'Ceara:cb_torre_p',
       'Ceara:cemiterio_p',
       'Ceara:ciclovia_a',
       'Ceara:cobertura_a',
    //    'sobral:cohab_1',
    //    'sobral:cohab_2',
    //    'sobral:condominio_moradas',
       'Ceara:consulta_imobiliaria_p',
    //    'Ceara:conviver',
    //    'Ceara:covid',
    //    'Ceara:cprm_risco_2012',
    //    'Ceara:cprm_risco_2019',
    //    'Ceara:curva_nivel_hgeohnor2020_l',
    //    'Ceara:curva_nivel_l',
       'Ceara:dep_abast_agua_a',
    //    'sobral:derby',
       'Ceara:distrito_a',
       'Ceara:distrito_aula_a',
       'Ceara:divisao_distrital_a',
       'Ceara:documento_cartorio_a',
       'sde:dom_expedito',
       'Ceara:edificacao_a',
       'Ceara:eixo_ciclovia_l',
       'Ceara:emplacamento_distrito_p',
       'Ceara:empresas_cadastradas_vw',
       'Ceara:ensino_sobral',
       'Ceara:ensino_sobral_municipal',
       'Ceara:escolas_municipal',
       'Ceara:espacos_criativos_sobral',
       'Ceara:estacao_tratamento_agua_p',
       'Ceara:estacionamento_a',
       'Ceara:face_sobral_pgv',
    //    'Ceara:faixa_alta_tensao_pl',
       'sde:fiscalizar_p',
    //    'Ceara:grade_censitaria',
    //    'sobral:grajau',
    //    'sobral:gran_ville_2022',
    //    'sobral:gran_ville_a',
    //    'sobral:grendene',
    //    'sobral:gruta',
    //    'Ceara:ilha_a',
       'Ceara:imoveis_historico_intervecao_p',
       'Ceara:inquerito_sanitario_domiciliar',
       'Ceara:internalização_rede_eletrica_a',
       'Ceara:intervencoes_fiscalizacao',
    //    'sde:itaunas',
    //    'sde:jatoba_ortomosaic',
    //    'sobral:jatoba_residence_preto_v10',
    //    'sobral:jordao_2023_10',
    //    'sobral:jose_ribeiro_dias',
    //    'sobral:juca_parente',
       'sde:lixeira_p',
       'Ceara:localidades_p',
       'Ceara:log_oficial',
       'Ceara:logradouro_l',
       'Ceara:logradouro_oficial_view',
       'Ceara:lote_a',
       'Ceara:lote_a_sobral',
       'Ceara:lote_aula_a',
       'Ceara:loteamentos_a',
    //    'sobral:luciano_arruda',
    //    'sobral:mae_rainha',
    //    'sobral:mae_rainha_1',
    //    'sobral:mansoes_da_colina',
       'sde:margem_esquerda',
       'Ceara:marquise_a',
       'Ceara:massa_dagua_a',
    //    'sobral:morada_dos_ventos_1',
    //    'sobral:morada_dos_ventos_2',
    //    'sobral:morada_planalto_1',
    //    'sobral:morada_planalto_2',
    //    'sobral:morada_planalto_3_b',
    //    'sobral:morada_ventos',
    //    'sobral:moradas',
    //    'sobral:moradas_da_boa_vizinhanca_1_',
    //    'sobral:moradas_do_corrego_1',
    //    'sobral:moradas_dos_ventos_3',
       'sde:moradavento',
       'sobral:municipio_satelite',
       'sde:notificacoes',
       'sobral:nova_betania',
       'sobral:nova_caicara',
       'sobral:nova_januaria',
       'Ceara:numero_porta_campo',
       'sobral:orgulho_tropical',
       'sobral:ortomosaico_aprazivel_V10',
       'Ceara:outdoor_p',
       'sobral:padre_palhano',
       'Ceara:paradas_linha_1',
       'sobral:parque_das_flores',
       'sde:parque_esperanca',
       'sobral:parque_havai',
       'sobral:parque_jatoba',
       'sobral:parque_silvana',
       'sde:parque_sinha_saboia',
       'sobral:patos_2023_v10',
       'sobral:pedro_mendes_carneiro',
       'Ceara:perimetro_urbano_distrito',
       'Ceara:piscina_a',
       'sobral:planalto',
       'sobral:planalto_2_geo',
       'Ceara:ponto_acumulo_lixo',
       'Ceara:ponto_cotado_altimetrico_p',
       'Ceara:pontos_notaveis_comercial_servico_sobral',
       'Ceara:pontos_notaveis_condominio_sobral',
       'Ceara:pontos_notaveis_ensino_sobral',
       'Ceara:pontos_notaveis_industrial_sobral',
       'Ceara:pontos_notaveis_instituicao_finan_sobral',
       'Ceara:pontos_notaveis_lazer_sobral',
       'Ceara:pontos_notaveis_outros_sobral',
       'Ceara:pontos_notaveis_religioso_sobral',
       'Ceara:pontos_notaveis_saude_sobral',
       'Ceara:pontos_notaveis_servico_publico_sobral',
       'sde:pop_saude_2022',
       'sobral:portal_das_flores',
       'Ceara:pracas_a',
       'Ceara:prdAracatiacu',
       'Ceara:prdJaibaras',
       'Ceara:prdSobral',
    //    'sobral:prdSobral_2007',
    //    'sde:prdSobral_2022',
       'sde:prdSobral_atual2',
    //    'sobral:prdSobral_atual_v03_2024',
    //    'Ceara:prdTaperuaba',
    //    'sobral:princesa_isabel',
       'Ceara:projecoes_a',
       'sobral:projeto_padre_palhano',
       'Ceara:quadra_a',
       'Ceara:quadra_aula_a',
       'Ceara:quadra_sobral_pgv',
       'Ceara:quiosque_p',
       'sde:rce_2017_nao',
       'sde:rce_2017_sim',
       'sde:rce_2023',
       'Ceara:rede_eletrica_subterraneo',
       'Ceara:rede_geodesica_sobral',
       'sobral:rosario_de_fatima_1',
       'sobral:rosario_de_fatima_2_v8',
       'Ceara:rota_coleta_2019',
       'Ceara:saae_area_influencia_pl',
       'Ceara:saae_bombas_p',
       'Ceara:saae_captacao_agua',
       'Ceara:saae_centro_reservacao_pl',
       'Ceara:saae_coleta_agua_p',
       'Ceara:saae_coleta_esgoto_p',
       'Ceara:saae_elevatoria_esgoto_p',
       'Ceara:saae_estacao_tratamento_esgoto_p',
       'Ceara:saae_ligacao_clandestina_p',
       'Ceara:saae_recalque_l',
       'Ceara:saae_registro_p',
       'Ceara:saae_reservatorios_p',
       'Ceara:saae_tubulacao_agua_l',
       'Ceara:saae_tubulacao_agua_projetada_l',
       'Ceara:saneamento_l',
       'sobral:sao_francisco',
       'Ceara:saude_sobral',
       'Ceara:saude_sobral_municipal',
       'Ceara:sec_saude_chagas2018',
       'Ceara:sec_saude_divisao',
       'Ceara:sec_saude_divisao_focos_positivos',
       'Ceara:sec_saude_ind_pred_primeiro_ciclo',
       'Ceara:sec_saude_ind_pred_quarto_ciclo',
       'Ceara:sec_saude_ind_pred_segundo_ciclo',
       'Ceara:sec_saude_ind_pred_terceiro_ciclo',
       'Ceara:sec_saude_numeracao',
       'Ceara:sec_saude_numeracao_focos_positivos',
       'Ceara:sec_saude_polio_sarampo2018',
       'Ceara:sec_saude_quadras_primeiro_ciclo',
       'Ceara:sec_saude_quadras_quarto_ciclo',
       'Ceara:sec_saude_quadras_segundo_ciclo',
       'Ceara:sec_saude_quadras_terceiro_ciclo',
       'Ceara:sec_saude_sobral_sede',
       'Ceara:setor_a',
       'Ceara:setor_aula_a',
       'sobral:sitio_cachoeira',
       'Ceara:tch_arruamento_a',
       'Ceara:tch_rodoviario_a',
       'Ceara:telheiro_a',
       'sobral:terra_nova',
       'Ceara:terreno_a',
       'sobral:terreno_novos',
       'Ceara:territorio_cras',
       'Ceara:transol_linha_1',
       'Ceara:transol_linha_3',
       'Ceara:transol_linha_4',
       'Ceara:transol_linha_5',
       'Ceara:transol_linha_6',
       'Ceara:transol_linha_7',
       'Ceara:transol_linha_8',
       'Ceara:trecho_drenagem_l',
       'Ceara:trecho_energia_l',
       'Ceara:trecho_massa_dagua_a',
       'Ceara:utilidade_publica_a',
       'Ceara:vias_pavimentadas',
       'Ceara:vias_tapas_buracos',
       'sobral:village_betania_2_final',
       'sobral:vistas_do_campo',
       'Ceara:vw_alvara_construcao',
       'Ceara:vw_checklist_fiscal_urbano',
       'Ceara:vw_checklist_habite_se',
       'Ceara:vw_logradouro_aracatiacu',
       'Ceara:vw_logradouro_jaibaras',
       'Ceara:vw_logradouro_sobral',
       'Ceara:vw_logradouro_taperuaba',
       'Ceara:zoneam_amb_app',
       'Ceara:zoneam_amb_zeia',
       'Ceara:zoneam_bairros_2018',
       'Ceara:zoneam_hid_acudes_lagoas',
       'Ceara:zoneam_hid_rio_acarau',
       'Ceara:zoneam_hid_rios_riachos',
       'Ceara:zoneam_perim_urb_final',
       'Ceara:zoneam_proposta_2018',
       'Ceara:zoneamento_sede_2023_pl',
       'Ceara:zoneamento_sede_distrito_2023_pl'
   ];

  // Referência ao elemento da lista de checkboxes
   var layerCheckboxList = document.getElementById('layerCheckboxList');

   // Criar checkboxes para o OpenStreetMap e ArcGIS e adicionar à lista
   var osmCheckboxDiv = document.createElement('div');
   osmCheckboxDiv.className = 'layer-checkbox';

   var osmCheckbox = document.createElement('input');
   osmCheckbox.type = 'checkbox';
   osmCheckbox.value = 'OSM';
   osmCheckbox.id = 'OSM';

   var osmLabel = document.createElement('label');
   osmLabel.htmlFor = 'OSM';
   osmLabel.textContent = 'OpenStreetMap';

   osmCheckboxDiv.appendChild(osmCheckbox);
   osmCheckboxDiv.appendChild(osmLabel);
   layerCheckboxList.appendChild(osmCheckboxDiv);

   var arcgisCheckboxDiv = document.createElement('div');
   arcgisCheckboxDiv.className = 'layer-checkbox';

   var arcgisCheckbox = document.createElement('input');
   arcgisCheckbox.type = 'checkbox';
   arcgisCheckbox.value = 'ArcGIS';
   arcgisCheckbox.id = 'ArcGIS';

   var arcgisLabel = document.createElement('label');
   arcgisLabel.htmlFor = 'ArcGIS';
   arcgisLabel.textContent = 'ArcGIS Topo Map';

   arcgisCheckboxDiv.appendChild(arcgisCheckbox);
   arcgisCheckboxDiv.appendChild(arcgisLabel);
   layerCheckboxList.appendChild(arcgisCheckboxDiv);

   layers.forEach(function(layerName) {
       var checkboxDiv = document.createElement('div');
       checkboxDiv.className = 'layer-checkbox';

       var checkbox = document.createElement('input');
       checkbox.type = 'checkbox';
       checkbox.value = layerName;
       checkbox.id = layerName;

       var label = document.createElement('label');
       label.htmlFor = layerName;
       label.textContent = layerName.split(':')[1]; // Extrair o nome da camada sem o namespace

       checkboxDiv.appendChild(checkbox);
       checkboxDiv.appendChild(label);
       layerCheckboxList.appendChild(checkboxDiv);
   });

   // Event listener para alterações nas checkboxes de camadas
   layerCheckboxList.addEventListener('change', function() {
       // Limpar todas as camadas existentes no mapa
       map.getLayers().clear();

       // Adicionar as camadas selecionadas ao mapa
       var selectedLayers = Array.from(layerCheckboxList.querySelectorAll('input[type="checkbox"]:checked')).map(function(checkbox) {
           return checkbox.value;
       });

       selectedLayers.forEach(function(layerName) {
           if (layerName === 'OSM') {
               // Adicionar a camada do OpenStreetMap
               map.addLayer(new ol.layer.Tile({
                   source: new ol.source.OSM(),
                   name: 'OpenStreetMap' // Define o nome da camada para identificação posterior
               }));
           } else if (layerName === 'ArcGIS') {
               // Adicionar a camada do ArcGIS
               var arcgisLayer = new ol.layer.Tile({
                   source: new ol.source.XYZ({
                       attributions: 'Tiles © <a href="https://services.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer">ArcGIS</a>',
                       url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}',
                   }),
                   name: 'ArcGIS Topo Map' // Define o nome da camada para identificação posterior
               });
               map.addLayer(arcgisLayer);

           } 
           else {
               // Adicionar outras camadas selecionadas
               var newLayer = new ol.layer.Tile({
                   source: new ol.source.TileWMS({
                       url: wmsUrl+'?http=true',
                       params: {
                           'LAYERS': layerName,
                           'TILED': true
                       },
                       serverType: 'geoserver',
                       options: {
                        // Force HTTP requests
                        proxy: function(request) {
                          var url = request.getUrl();
                          if (url.startsWith('https')) {
                            // Replace 'https' with 'http'
                            url = url.replace('https', 'http');
                            request.setUrl(url);
                          }
                          return request;
                        }
                    }
                   }),
                   name: layerName // Define o nome da camada para identificação posterior
               });
               map.addLayer(newLayer);
           }
       });
   });

   // Criar o mapa
   var map = new ol.Map({
       // Especificar o target (div) onde o mapa será exibido
       target: 'map',
       // Camadas base
       layers: [
           // Camada base do OpenStreetMap
           new ol.layer.Tile({
               source: new ol.source.OSM()
           })
       ],
       // Visualização do mapa
       view: new ol.View({
           center: ol.proj.fromLonLat([-40.3526, -3.6857]),
           zoom: 12 // Ajuste o nível de zoom conforme necessário
       })
   });
