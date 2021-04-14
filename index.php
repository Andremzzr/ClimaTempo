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
        $new_weather =$weather->getWeatherByCity($citySearched);
        if ($new_weather == false) {
            echo "Deu um erro";
        }
        else{
        foreach($new_weather as $value){
          
          $date = str_replace('-','/',$value['date']);    
          $resultados .='<div class="previsoes">
                  <div class="box">
                <div class="box-header">
                    <div class="pre-content"> 
                    <div class="date">'.$date.'</div>
                    '.$value['weather'].'
                  
                </div>
                </div>

            <div class="box-body">
              
            
              <div class="cbt h-temp"><img src="images/icons/upload.png" class="img-temp">'.$value['temp_max'].'°C</div>
              <div class="cbt l-temp"><img class="img-temp" src="images/icons/download.png">'.$value['temp_min'].'°C</div>
              <div class="cb humidity"><img class="img-temp" src="images/icons/raindrop-close-up.png">'.$value['humidity'].'%</div>
              <div class="cb pop"><img class="img-temp" src="images/icons/protection-symbol-of-opened-umbrella-silhouette-under-raindrops.png">'.$value['pop'].'%</div>

          </div>
                </div>
                </div>
              </div>


          </main>';
        }
    }

        ?>

        <main>
              <div class="city-title">
                  <div class="title">Forecast for <b><?php echo $citySearched. PHP_EOL; ?></b></div>
    </div>
             
 
        <?php echo $resultados ?>
 
 <?php
    }
    

}

