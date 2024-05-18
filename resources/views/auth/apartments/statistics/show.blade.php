@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <canvas id="messageChart"></canvas>
  <canvas id="viewChart" class="my-5"></canvas>
 
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
          label: '# Messaggi',
          data: messages6Months,
          backgroundColor: [
      'rgba(255, 99, 132, 0.2)'
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
          label: '# Visualizzazioni',
          data: views6Months,
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
  </script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection