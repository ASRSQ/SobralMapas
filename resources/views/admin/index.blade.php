@extends('adminlte::page')

@section('title', 'Relatórios de Acessos e Interesses')


@section('content_header')
    <h1>Relatórios de Acessos e Interesses</h1>
@endsection

@section('content')
    <div class="row">
        <!-- Card com Gráfico de Barras -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Acessos por Mês</h3>
                </div>
                <div class="card-body">
                    <canvas id="graficoBarras"></canvas>
                </div>
            </div>
        </div>

        <!-- Card com Gráfico de Linha -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Interesses por Assunto</h3>
                </div>
                <div class="card-body">
                    <canvas id="graficoLinha"></canvas>
                </div>
            </div>
        </div>

        <!-- Card com Gráfico de Pizza -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Distribuição de Acessos por Dispositivo</h3>
                </div>
                <div class="card-body">
                    <canvas id="graficoPizza"></canvas>
                </div>
            </div>
        </div>

        <!-- Card com Gráfico Polar -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Popularidade por Categoria</h3>
                </div>
                <div class="card-body">
                    <canvas id="graficoPolar"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de Barras (Acessos por Mês)
        const ctxBarras = document.getElementById('graficoBarras').getContext('2d');
        new Chart(ctxBarras, {
            type: 'bar',
            data: {
                labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho'],
                datasets: [{
                    label: 'Acessos',
                    data: [120, 150, 180, 200, 230, 250],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de Linha (Interesses por Assunto)
        const ctxLinha = document.getElementById('graficoLinha').getContext('2d');
        new Chart(ctxLinha, {
            type: 'line',
            data: {
                labels: ['Tecnologia', 'Ciências', 'Matemática', 'Arte', 'História', 'Literatura'],
                datasets: [{
                    label: 'Interesses',
                    data: [90, 110, 80, 100, 70, 60],
                    fill: false,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true
            }
        });

        // Gráfico de Pizza (Distribuição de Acessos por Dispositivo)
        const ctxPizza = document.getElementById('graficoPizza').getContext('2d');
        new Chart(ctxPizza, {
            type: 'pie',
            data: {
                labels: ['Desktop', 'Mobile', 'Tablet'],
                datasets: [{
                    data: [60, 30, 10],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        // Gráfico Polar (Popularidade por Categoria)
        const ctxPolar = document.getElementById('graficoPolar').getContext('2d');
        new Chart(ctxPolar, {
            type: 'polarArea',
            data: {
                labels: ['Esportes', 'Música', 'Filmes', 'Livros', 'Jogos'],
                datasets: [{
                    data: [20, 25, 30, 15, 10],
                    backgroundColor: [
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(255, 205, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(54, 162, 235, 0.6)'
                    ]
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endsection
