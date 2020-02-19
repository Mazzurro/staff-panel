<div class="panel panel-popup" id='container'>

</div>
<script src="http://cdn.highcharts.com.cn/highcharts/highcharts.js"></script>
<script>
var chart=Highcharts.chart('container',{
    title:{
        text:'staff graph'
    },
    plotOptions:{
        series:{
            pointInterval:1,
            pointIntervalUnit:'month',
            pointStart:1
        }
    },
    series:[{
        name:'staff',
        data:[1,2,3,4,5]
    }]
})
</script>