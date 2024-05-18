@extends('layouts.app')

@section('content')
<div class="container mt-5">
  {{-- grofico unico --}}
  <canvas id="totalChart"></canvas>

  {{-- grafici divisi --}}
  <canvas id="messageChart" class="d-none"></canvas>
  <canvas id="viewChart" class="my-5 d-none"></canvas>
 
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const mexGraph = document.getElementById('messageChart');
    const monthsNames = @json($months_names);
    const messages6Months = @json($messages_6_months);
    const views6Months = @json($views_6_months);
  
    new Chart(mexGraph, {
      type: 'bar',
      data: {
        labels: monthsNames,
        datasets: [{
          label: 'Messaggi',
          data: messages6Months,
          backgroundColor: [
      'rgba(204, 17, 54, 0.5)'
    ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    const viewGraph = document.getElementById('viewChart');
  
    new Chart(viewGraph, {
      type: 'bar',
      data: {
        labels: monthsNames,
        datasets: [{
          label: 'Visualizzazioni',
          data: views6Months,
          backgroundColor: [
            'rgba(13, 110, 253, 0.5)'
    ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
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
            'rgba(204, 17, 54, 0.5)'
          ],
          borderWidth: 1
        },
        {
          label: 'Visualizzazioni',
          data: views6Months,
          backgroundColor: [
            'rgba(13, 110, 253, 0.5)'
          ],
          borderWidth: 1
        }],
        labels: monthsNames,
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

  </script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection