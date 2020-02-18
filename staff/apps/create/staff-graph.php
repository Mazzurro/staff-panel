<div class="panel panel-popup" id='container'>
<span>aaaaaaaaaa</span>

</div>
<script>
import Hightcharts from 'https://code.highcharts.com.cn/highcharts/es-modules/masters/highcharts.js'
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