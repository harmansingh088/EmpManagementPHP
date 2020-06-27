<?php
class ChartHTML  {

    static function showHeader(){ ?>
      <!DOCTYPE html>
      <html lang="en">
        <head>
          <meta charset="UTF-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <meta http-equiv="X-UA-Compatible" content="ie=edge" />
          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
          <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          />
          <link rel="stylesheet" href="css/Navigation.css">
          <link rel="stylesheet" href="css/Users.css">
          <link rel="stylesheet" href="css/UserForm.css">
          <title>My Chart.js Chart</title>
        </head>
        <body>
        <?php }

    static function showFooter(){ ?>
          </body>
          </html>
      <?php }

    static function showNavigation($fromWhere){ 
      if($fromWhere == 'Sale'){
        ?>
        <div class="topnav">
            <a href="?action=users">Users</a>
            <a href="?action=items">Items</a>
            <a href="?action=hoursChart">Hours Chart</a>
            <a class="active">Sales Chart</a>
            <div class="topnav-right">
                <a href="?action=logout"><?php echo $_SESSION['firstName'].' '.$_SESSION['lastName'].'(Logout)'?> </a>
            </div>
        </div>
        <?php
      }
      else{
        ?>
        <div class="topnav">
            <a href="?action=users">Users</a>
            <a href="?action=items">Items</a>
            <a class="active">Hours Chart</a>
            <a href="?action=salesChart">Sales Chart</a>
            <div class="topnav-right">
                <a href="?action=logout"><?php echo $_SESSION['firstName'].' '.$_SESSION['lastName'].'(Logout)'?> </a>
            </div>
        </div>
        <?php

      } 
    }
    static function showChart($fromWhere, $url){ ?>
          <div class="container">
            <canvas id="myChart"></canvas>
          </div>

          <script>

            window.onload = function(){
              var xmlhttp = new XMLHttpRequest();
              var url = "<?php echo $url ?>";

              xmlhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                      var myArr = JSON.parse(this.responseText);
                      dataLoaded(myArr);
                  }
              };
              xmlhttp.open("GET", url, true);
              xmlhttp.send();
            }

            function getColor(){ 
              return "hsl(" + 360 * Math.random() + ',' +
                        (25 + 70 * Math.random()) + '%,' + 
                        (85 + 10 * Math.random()) + '%)'
            }


            function dataLoaded(myArr){
              var names = [];
              var numbers = [];
              var colors = [];
              for(var i = 0; i<myArr.length; i++){
                names[i] = myArr[i].firstName + myArr[i].lastName;
                numbers[i] = myArr[i].sum;
                colors[i] = getColor();
              }
              let myChart = document.getElementById("myChart").getContext("2d");

              // Global Options
              Chart.defaults.global.defaultFontFamily = "Lato";
              Chart.defaults.global.defaultFontSize = 18;
              Chart.defaults.global.defaultFontColor = "#777";

              let massPopChart = new Chart(myChart, {
                type: "bar", // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data: {
                  labels: names,
                  datasets: [
                    {
                      label: "<?php echo $fromWhere ?>",
                      data: numbers,
                      //backgroundColor:'green',
                      backgroundColor: colors,
                      borderWidth: 1,
                      borderColor: "#777",
                      hoverBorderWidth: 3,
                      hoverBorderColor: "#000",
                    },
                  ],
                },
                options: {
                  title: {
                    display: true,
                    text: "<?php echo $fromWhere ?> Chart",
                    fontSize: 25,
                  },
                  legend: {
                    display: true,
                    position: "right",
                    labels: {
                      fontColor: "#000",
                    },
                  },
                  layout: {
                    padding: {
                      left: 50,
                      right: 0,
                      bottom: 0,
                      top: 0,
                    },
                  },
                  tooltips: {
                    enabled: true,
                  },
                },
              });
            }
            
          </script>
        </body>
      </html>
<?php }
}
