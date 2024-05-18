@extends('layouts.app')

@section('content')
<div class="main-index">
  <div class="container">
    <div class="d-md-flex justify-content-md-between my-3">
      <a href="{{route('user.apartments.show', $apartment_slug)}}" class="btn my -4" style="background-color: #fab005; color: #0A0F15" > <i class="fa-solid fa-circle-left me-2" style="color: #0A0F15"></i>Torna all'alloggio</a>
    </div>
 
   <div class="main-conteiner my-4 card-graph d-none d-md-block">
    <h1 class="mb-5">Statistiche {{ $apartment->title }}</h1>
    {{-- grafico unico --}}
    <div class="graph" style="height: 80%; width: 100%">
      <canvas id="totalChart" class="d-none d-md-block"></canvas>
    </div>
   </div>
    
   <div class="main-conteiner my-4 d-sm-block d-md-none">
      <h1 class="mb-4 fs-3">Statistiche {{ $apartment->title }}</h1>
      {{-- grafici divisi --}}
     <canvas id="messageChart" class="d-sm-block d-md-none"></canvas>
     <canvas id="viewChart" class="d-sm-block d-md-none my-4"></canvas>
   </div>

  </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const mexGraph = document.getElementById('messageChart');
    const monthsNames = @json($months_names);
    const messages6Months = @json($messages_6_months);
    const views6Months = @json($views_6_months);
  
    // grafico messaggi
    new Chart(mexGraph, {
      type: 'bar',
      data: {
        labels: monthsNames,
        datasets: [{
          label: 'Messaggi',
          data: messages6Months,
          backgroundColor: [
      'rgba(204, 17, 54, 0.7)'
    ],
          borderWidth: 1
        }]
      },
      options: {
        plugins: {
            legend: {
                display: true,
                labels: {
                    color: 'white',
                    
                }
            }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
                stepSize: 1,
                color: 'white'
            }
          },
          x: {
            ticks: {
                color: 'white'             
            }
          },
        }
      }
    });

    // grafico solo visualizzazioni
    const viewGraph = document.getElementById('viewChart');
  
    new Chart(viewGraph, {
      type: 'bar',
      data: {
        labels: monthsNames,
        datasets: [{
          label: 'Visualizzazioni',
          data: views6Months,
          backgroundColor: [
            'rgba(250, 176, 5, 0.7)'
    ],
          borderWidth: 1
        }]
      },
      options: {
        plugins: {
            legend: {
                display: true,
                labels: {
                    color: 'white',
                    
                }
            }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
                stepSize: 1,
                color: 'white'
            }
          },
          x: {
            ticks: {
                color: 'white'             
            }
          },
          
        }
      }
    });


    // grafico messaggi e visualizzazioni
    const totalGraph = document.getElementById('totalChart');

    new Chart(totalGraph, {
      type: 'bar',
      data: {       
        datasets: [{
          label: 'Messaggi',
          data: messages6Months,
          backgroundColor: [
            'rgba(204, 17, 54, 0.7)'
          ],
          borderWidth: 1
        },
        {
          label: 'Visualizzazioni',
          data: views6Months,
          backgroundColor: [
            'rgba(250, 176, 5, 0.7)'
          ],
          borderWidth: 1
        }],
        labels: monthsNames,
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                labels: {
                    color: 'white',
                    font: {
                      size: 18
                    }
                }
            }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
                stepSize: 1,
                color: 'white',
                font: {
                      size: 18
                    }
            }
          },
          x: {
            ticks: {
                color: 'white',
                font: {
                      size: 18
                    }
            }
          },
         
        }
        
      }
    });

  </script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection