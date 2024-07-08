@extends('layouts.dashboard')

@push('page-styles')
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
@endpush

@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="activity"></i></div>
                        Accueil
                    </h1>
                    <div class="page-header-subtitle">Passe une bonne journée</div>
                </div>
              
            </div>
        </div>
    </div>
</header>

<!-- Main page content -->
<div class="container-xl px-4 mt-n10">
    <!-- Example Colored Cards for Dashboard Demo -->
    <div class="row">
    <div class="col-lg-6 col-xl-3 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Profits (Jour)</div>
                        <div class="text-lg fw-bold">{{ number_format($profitToday) }}</div>
                    </div>
                    <i class="feather-xl text-white-50" data-feather="calendar"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="#">Voir</a>
                <div class="text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Profits (Total)</div>
                        <div class="text-lg fw-bold">{{ number_format($totalProfit) }}</div>
                    </div>
                    <i class="feather-xl text-white-50" data-feather="dollar-sign"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="#">Voir</a>
                <div class="text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Paiements effectués</div>
                        <div class="text-lg fw-bold">{{ number_format($paymentsPaid) }}</div>
                    </div>
                    <i class="feather-xl text-white-50" data-feather="check-square"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="#">Voir</a>
                <div class="text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3 mb-4">
        <div class="card bg-danger text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Paiements en attente</div>
                        <div class="text-lg fw-bold">{{ number_format($paymentsPending) }}</div>
                    </div>
                    <i class="feather-xl text-white-50" data-feather="message-circle"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="#">Voir</a>
                <div class="text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>
    <!-- Example Charts for Dashboard Demo -->
    <div class="row">
        <div class="col-xl-6 mb-4">
            <div class="card card-header-actions h-100">
                <div class="card-header">
                    Courbes de revenues
                    <div class="dropdown no-caret">
                        <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="areaChartDropdownExample" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="text-gray-500" data-feather="more-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="areaChartDropdownExample">
                            <a class="dropdown-item" href="#">Last 12 Months</a>
                            <a class="dropdown-item" href="#">Last 30 Days</a>
                            <a class="dropdown-item" href="#">Last 7 Days</a>
                            <a class="dropdown-item" href="#">This Month</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Custom Range</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-4">
            <div class="card card-header-actions h-100">
                <div class="card-header">
                    Commandes par mois
                    <div class="dropdown no-caret">
                        <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="areaChartDropdownExample" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="text-gray-500" data-feather="more-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="areaChartDropdownExample">
                            <a class="dropdown-item" href="#">Last 12 Months</a>
                            <a class="dropdown-item" href="#">Last 30 Days</a>
                            <a class="dropdown-item" href="#">Last 7 Days</a>
                            <a class="dropdown-item" href="#">This Month</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Custom Range</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-bar"><canvas id="myBarChart" width="100%" height="30"></canvas></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-scripts')
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script>
// JavaScript pour initialiser les graphiques avec Chart.js
var revenuesByMonthData = {!! $revenuesByMonth !!}; // Assurez-vous d'avoir les données correctes des revenus par mois

// Fonction pour formater les nombres avec des décimales
function number_format(value) {
    return value.toString(); // Format pour le montant total des revenus
}

// Configuration et initialisation des graphiques
var ctx1 = document.getElementById('myAreaChart').getContext('2d');
var myAreaChart = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jui', 'Jui', 'Aut', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Revenues',
            data: Object.values(revenuesByMonthData), // Utilisation des données réelles des revenus par mois
            backgroundColor: 'rgba(255, 99, 132, 0.05)', // Rouge avec transparence
            borderColor: 'rgba(255, 99, 132, 1)', // Rouge
            pointBackgroundColor: 'rgba(255, 99, 132, 1)', // Rouge
            pointBorderColor: 'rgba(255, 99, 132, 1)', // Rouge
            pointHoverBackgroundColor: 'rgba(255, 99, 132, 1)', // Rouge
            pointHoverBorderColor: 'rgba(255, 99, 132, 1)', // Rouge
            pointRadius: 3,
            pointHitRadius: 10,
            fill: true
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                time: {
                    unit: 'date'
                },
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 12
                }
            }],
            yAxes: [{
                ticks: {
                    maxTicksLimit: 5,
                    padding: 10,
                    callback: function(value, index, values) {
                        return number_format(value);
                    }
                },
                gridLines: {
                    color: 'rgba(255, 255, 255, 1)', // Blanc
                    zeroLineColor: 'rgba(255, 255, 255, 1)', // Blanc
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }]
        }
    }
});

var ctx2 = document.getElementById('myBarChart').getContext('2d');
var myBarChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['Janv', 'Fév', 'Mar', 'Avr', 'Mai', 'Jui', 'Juil', 'Aou', 'Sep', 'Oct', 'Nov', 'Déc'],
        datasets: [{
            label: 'Nombre de commandes',
            backgroundColor: 'rgba(255, 55, 25, 1)', // Noir
            hoverBackgroundColor: 'rgba(255, 99, 132, 1)', // Rouge
            borderColor: 'rgba(0, 0, 0, 1)', // Noir
            data: {!! $ordersByMonth !!}, 
            maxBarThickness: 25,
        }]
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 12 // Affichez les 12 mois
                },
                maxBarThickness: 25,
            }],
            yAxes: [{
                ticks: {
                    min: 0,
                    maxTicksLimit: 5,
                    padding: 10,
                    callback: function(value, index, values) {
                        return number_format(value);
                    }
                },
                gridLines: {
                    color: 'rgba(255, 255, 255, 1)', // Blanc
                    zeroLineColor: 'rgba(255, 255, 255, 1)', // Blanc
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }]
        },
        legend: {
            display: false
        },
        tooltips: {
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            backgroundColor: 'rgb(255,255,255)',
            bodyFontColor: '#858796',
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                }
            }
        }
    }
});

// Litepicker pour la sélection des dates
var picker = new Litepicker({
    element: document.getElementById('litepickerRangePlugin'),
    format: 'YYYY-MM-DD',
    lang: 'fr',
    singleMode: false,
    numberOfMonths: 1,
    numberOfColumns: 1,
    autoApply: true,
    resetButton: true,
    tooltipText: {
        one: 'jour',
        other: 'jours'
    },
    setup: (picker) => {
        picker.on('selected', (date1, date2) => {
            console.log(date1, date2);
        });
    }
});
</script>
@endpush
