<?php


require_once __DIR__.'/assets/html/index.html';
require __DIR__.'/vendor/autoload.php';

use App\Weather;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

if(isset($_POST['btn-search'])){
    $citySearched = $_POST['search'];
    $citySearched = filter_var($_POST['search'],FILTER_SANITIZE_STRING);
    if(trim($citySearched) == ''){
        header('Location: index.php');
    }else{

       $resultados = '';
        $weather = new Weather;
      
        
        
        foreach($weather->getWeatherByCity($citySearched) as $value){
          
            $resultados .='<div class="previsoes">
            <div class="box">
          <div class="box-header">
              <div class="pre-content"> 
              <div class="date">'.$value['date'].'</div>
            '.$value['weather'].'
          </div>
          </div>

      <div class="box-body">
        
      <div class="box-body-left">
      <div class="high-temp"> <img src="images/icons/upload.png" alt="Arrow up"><div class="high-temp-value">
      '.$value['temp_max'].'°C</div> </div> 



      <div class="low-temp"><img src="images/icons/download.png" alt="Arrow down"></div> <div class="low-temp-value">
      '.$value['temp_min'].'°C</div>
          <br>
        </div>  
    
          
          
          
        

      
      <div>
      <div class="humidity">
      <img src="images/icons/raindrop-close-up.png" alt="Water Drop">
      <div class="humidity-value">'.$value['humidity'].'%</div>
      </div>

      <div class="pop">
      <img src="images/icons/protection-symbol-of-opened-umbrella-silhouette-under-raindrops.png" alt="Umbrella in Rain" class="umbrella">
      <div class="pop-value">'.$value['pop'].'%</div>  
    </div>
  </div>
          </div>
          </div>
        </div>


    </main>';
        }


        ?>

        <main>
              <div class="city-title">
                  <div class="title">Previsão para <b><?php echo $citySearched. PHP_EOL; ?></b></div>
    </div>
             
 
        <?php echo $resultados ?>
 
 <?php
    }
    

}

