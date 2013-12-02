<?php
    $this->widget('AdminHeadMenu', array());
    Yii::app()->clientScript->registerCoreScript('jquery');
?>

<h1>Статистика</h1>
<p>Количество фотографий:   <?php echo $countAllPhotos; ?></p>
<p>Количество отмодерированных фотографий:   <?php echo $countModeratePhotos; ?></p>  
<p>Количество пользователей:   <?php echo $countAllUsers; ?></p> 
<p>Количество активных пользователей:   <?php echo $countActiveUsers; ?></p> 
<canvas id="canvas" height="450" width="900"></canvas>
<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/chartsjs/'.'Chart.js');
?>
<script>
        var today = new Date();
        var lastDaysArray = new Array();
        var i;
        var date;
        //перебрать все даты за последний месяц и внести в массив (8.11 - 8.10)
        var todayDay = new Date().getDate();
        var lastMonth = new Date().getMonth(); //0 first index of object Month January
        
        var dateArray = 
        {
              "1": "31",
              "2": "28",
              "3": "31",
              "4": "30", 
              "5": "31", 
              "6": "30", 
              "7": "31", 
              "8": "31", 
              "9": "30", 
              "10": "31", 
              "11": "30", 
              "12": "31",                                   
        };
        // alert(today)
        $.each( dateArray, function( key, value ) {        
            if (key == lastMonth) {
                dayOfMonths = value; 
            }
        });
      
   
                
        for (var i = dayOfMonths; i > 0; i--) {
            
            var dayDiff = todayDay - i;
            
            if (dayDiff < 0) {
                var dm = parseInt(dayOfMonths);
                var day =  dm + dayDiff; 
                var dayMonth = day + '.' + lastMonth;
                lastDaysArray.push(dayMonth);
            } else if (dayDiff == 0) {
                var nextMonth = lastMonth+1;
                var dayMonth = 1 + '' + nextMonth;
                lastDaysArray.push(dayMonth);
            } else {
                var nextMonth = lastMonth+1; 
                var dayMonth = dayDiff + '.' + nextMonth;
                lastDaysArray.push(dayMonth);
            }
                // console.log(todayDay - i)                
        } 
          
        var lastDaysString = lastDaysArray.toString(); 
        var startDate=lastDaysArray[0];
        var endDate = lastDaysArray[lastDaysArray.length-1];
        var datesAjaxResponse;
        $.ajax({
            url: '<?php echo $this->createUrl("managemember/getLastMonthUserCount"); ?>', 
            async:false,           
            data : "startdate="+startDate+"&enddate="+endDate,                    
            success: function (data, textStatus) { 
                datesAjaxResponse = data;
                }
        });
        
        
        
        var day, month;
        var currentYear = new Date().getFullYear(); 
     
var obj = $.parseJSON(datesAjaxResponse);
var datesResponseArray=new Array();
var countUsersResponseArray=new Array();
var z;
var finishArray = new Array();
z=0;
$.each(obj, function(k, v) {
	datesResponseArray[z] = k;
	countUsersResponseArray[z] = v;
        z++;
}); 
        for (i=0;i<lastDaysArray.length;i++){
            arr=lastDaysArray[i].split(".");
            day=arr[0];
	    if (day<10) day="0"+day;		
            month=arr[1];
            fullDate = currentYear+"-"+month+"-"+day;
          var f=inArrayById(datesResponseArray, fullDate);
 	  if (f>-1) 
			finishArray[i]= countUsersResponseArray[f];
          else
			finishArray[i]= 0;
        }

	function inArrayById(array, value) {
            var checkIndex=-1;
	    $.each(array, function(i, element) { 
		if(element == value){
		    checkIndex = i;
		}
	    });
	    return checkIndex;
	}
        
        var lineChartData = {
            labels : lastDaysArray,
            /*[8.10,9.10,10.10,11.10,12.10,13.10,14.10,15.10,16.10,17.10,18.10,19.10,20.10,21.10,22.10,23.10,24.10,25.10,26.10,27.10,28.10,29.10,30
.10,111,1.11,2.11,3.11,4.11,5.11,6.11,7.11],*/
            datasets : [
                {
                    fillColor : "rgba(151,187,205,0.5)",
                    strokeColor : "rgba(151,187,205,1)",
                    pointColor : "rgba(151,187,205,1)",
                    pointStrokeColor : "#fff",
                    data: finishArray,
                },
              /*  {
                    fillColor : "rgba(151,187,205,0.5)",
                    strokeColor : "rgba(151,187,205,1)",
                    pointColor : "rgba(151,187,205,1)",
                    pointStrokeColor : "#fff",
                    data : [28,48,40,19,96,27,100]
                }*/
            ]
            
        }
var maxValue=50;
var steps = new Number(maxValue);
var stepWidth = new Number(1);
if (maxValue > 10) {
    stepWidth = Math.floor(maxValue / 10);
    steps = Math.ceil(maxValue / stepWidth);
}
       var myLine = new Chart(document.getElementById("canvas").getContext("2d"))
        .Line(lineChartData, { 
           scaleOverride: true, scaleSteps: steps, scaleStepWidth: stepWidth, scaleStartValue: 0,
            });
  </script>
