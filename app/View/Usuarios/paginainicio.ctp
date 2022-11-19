
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php

    $this->layout='inicio';     
    echo $this->Html->script('usuarios/paginainicio');
?>

  <style>
    .box01{
      background: white;
      color: black;
      display: flex;
      align-items: flex-end;
      margin-top: 20px;
      width: 100%;
    }

    .box02{
      width: 100%;
      height: 400px;
      margin: 20px;
    }

    .box03{
      width: 100%;
      height: 400px;
      margin: 20px;
    }

    .canva {
      border: 0.3px solid #D7E1E6;
      padding: 10px;
      border-radius: 2px 10px;
    }
  </style>

  <div class="box01">
    
    <div class="box02 canva">
      <canvas id="contarBandejas"></canvas>
    </div>
    
    <div class="box03 canva">
      <canvas id="contarFinalizadas"></canvas>
    </div>
  
  </div>

  <div class="box01">
    
    <div class="box02 canva">
      <canvas id="totalGestion"></canvas>
    </div>
    
    <div class="box03 canva">
      <canvas id="totalGestionPorUsuario"></canvas>
    </div>
  
  </div>
