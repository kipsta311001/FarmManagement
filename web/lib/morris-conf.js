
var Script = function () {

    //morris chart
    
    $(function () {
      $.ajax({
        url:"http://serveur1.arras-sio.com/symfony4-4066/poinB3/web/index.php?page=api",    //the page containing php script
        type: "post",    //request type,
        dataType: 'json',
        data: {fonction: "f"},
        success:function(result){
            var elements = [];
            console.log(result);
            var date = result.splice(0,1);
            
            for (const element of result){
              var dataStat = [];  
              
              elements.push(element[0]);
          
              for (let i = 1; i < element.length; i++){
                var data = {};
                //dataStat.push({"period": date[0][i], key: element[i]});
                data["period"] = date[0][i];
                data[element[0]] = element[i];
                dataStat.push(data);
                console.log(element[0]);
              }
              Morris.Area({
                element: element[0],
                data: dataStat,
        
                  xkey: 'period',
                  ykeys: [element[0]],
                  labels: [element[0]],
                  hideHover: 'auto',
                  lineWidth: 1,
                  pointSize: 5,
                  lineColors: [Math.floor(Math.random()*16777215).toString(16)],
                  fillOpacity: 0.5,
                  smooth: true
              });
            }
            
        },
        error:function(){
          console.log('ERROR: ' + jqXHR.status);
      }
    })
     
      
      Morris.Area({
        element: 'hero-area',
        data: [
          {period: '2010-01-21', "iphone": 2666, ipad: null, itouch: 2647},
          {period: '2010-02-23', iphone: 2778, ipad: 2294, itouch: 2441},
          {period: '2010-03-30', iphone: 4912, ipad: 1969, itouch: 2501},
          {period: '2010-04-12', iphone: 3767, ipad: 3597, itouch: 5689},
          {period: '2011-01-23', iphone: 6810, ipad: 1914, itouch: 2293},
          {period: '2011-02-25', iphone: 5670, ipad: 4293, itouch: 1881},
          {period: '2011-03-01', iphone: 4820, ipad: 3795, itouch: 1588},
          {period: '2011-04-02', iphone: 15073, ipad: 5967, itouch: 5175},
          {period: '2012-01-05', test: 10687, ipad: 4460, itouch: 2028},
          {period: '2012-02-10', iphone: 8432, ipad: 5713, itouch: 1791}
        ],

          xkey: 'period',
          ykeys: ['iphone', 'ipad', 'itouch'],
          labels: ['iPhone', 'iPad', 'iPod Touch'],
          hideHover: 'auto',
          lineWidth: 1,
          pointSize: 5,
          lineColors: ['#4a8bc2', '#ff6c60', '#a9d86e'],
          fillOpacity: 0.5,
          smooth: true
      });

      

    });

}();





