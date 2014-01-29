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
        var lastMonth = new Date().getMonth() + 1; //0 first index of object Month January
        var year = new Date().getFullYear();

        function daysInMonth(month,year) {
            return new Date(year, month, 0).getDate();
        }

        function getPrevMonth(month) {
            if (month == 1) {
                month = 12;
            } else  {
                month = month - 1;
            }

            return month < 10 ? '0'+month : month;
        }

        daysOfMonth = daysInMonth(lastMonth, year);

        if (lastMonth < 10)
            lastMonth = '0'+lastMonth;

        for (var i = daysOfMonth; i >= 0; i--) {
            
            var dayDiff = todayDay - i;
            
            if (dayDiff < 0) {
                var dm = parseInt(daysOfMonth);
                var day =  dm + dayDiff; 
                var dayMonth = day + '.' + getPrevMonth(lastMonth);
                lastDaysArray.push(dayMonth);
            } else if (dayDiff == 0) {
                var dayMonth = daysInMonth(getPrevMonth(lastMonth), year) + '.' + getPrevMonth(lastMonth);
                lastDaysArray.push(dayMonth);
            } else {
                if (dayDiff < 10)
                    dayDiff = '0'+dayDiff;
                var dayMonth = dayDiff + '.' + lastMonth;
                lastDaysArray.push(dayMonth);
            }
        }

        var lastDaysString = lastDaysArray.toString(); 
        var startDate = lastDaysArray[0];
        var endDate = lastDaysArray[lastDaysArray.length-1];
        var datesAjaxResponse;
        $.ajax({
            url: '<?php echo $this->createUrl("managemember/getLastMonthUserCount"); ?>', 
            async:false,           
            data : "startdate="+startDate+"&enddate="+endDate+"&lastdays="+lastDaysString,
            success: function (data, textStatus) { 
                datesAjaxResponse = data;
            }
        });

        var countData = $.parseJSON(datesAjaxResponse);

        var lineChartData = {
        labels : lastDaysArray,
            datasets : [
                {
                    fillColor : "rgba(151,187,205,0.5)",
                    strokeColor : "rgba(151,187,205,1)",
                    pointColor : "rgba(151,187,205,1)",
                    pointStrokeColor : "#fff",
                    data: countData
                },
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
