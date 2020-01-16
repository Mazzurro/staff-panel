<head>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300" rel="stylesheet">
        <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
</head>
<style>
    @font-face {font-family: "iconfont";
      src: url('iconfont.eot?t=1577263980856'); /* IE9 */
      src: url('iconfont.eot?t=1577263980856#iefix') format('embedded-opentype'), /* IE6-IE8 */
      url('data:application/x-font-woff2;charset=utf-8;base64,d09GMgABAAAAAAP0AAsAAAAACGQAAAOoAAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHEIGVgCDBgqESINlATYCJAMMCwgABCAFhG0HOxswBxFVnGvIfiaYbk24dka5MdZxol9CL9IzGaRT7/VvRZESVhwAgOLEcst2gVAu4QTEM9JsxoAD1sAXWXWit6ZjbKMiVJfseepZ/kd+defDOo/TKIWQIBwNEEAg9n8ux3dNDHD+9/LIMppj+dG9KI4DCmisYfcCy9ICSdAbxi5oiaeBABDhgTCQvIKyOghgMCcRAGRseLAbQsYC1lBPIICAr1jJQFZBA4Fbyt0HsDL4PvmKGCIAHDQU5llVA/l9yPogfwimignaqAJlOhcAtg6gAMIAMIB0VHqaQKNMGChEVcOay3kwEHBTxU0HAomm4q0/PIADAQgPs9YCABCEshzwQXYkiTYYyq5a+nDjeQBWAC4DeCP5ZKDaLFiYPOHuvEQsCSMz+9bp1R2OgxsNh5U+/YEtW40H92+GcqhHMqxX1snihg26jYMWes8sWRbwdcm7NB5QCdmiBljtOwSmHPa3Pmh0JTqj4bAztj2Oszr31MNM9yzR+uwTd27ToZnPn9eJ+kPKYUliL17kW9561aiRDhp1aoD48mXdzmeGJ+5DB656aKzZtsuiBWk0GF3pFlV/CFx7oSKQUB3DidtMVFr2KkLe+6n0ASHf/Yx++hnWE2pL7H71g7X9lmbT5919+f6qz6s89+z86VAjwlbzi3DApvCozfInujkKAUmm03xlEOo1nc/rap8cxxcE1MMXrqrXONLN8OodKcNgHyv7LKtBWxzibFFa1/+7q+sjZTaRUYeDD0e9p2UDfUdPBtRU1gQk3e2qFmx8bYQcp4PImGLbSrWsxXvEQSu37rIZlbUOLT4tmHRwvxHvFqalrbboAgCY0KdUgbnQu3T0X/8GzW8W7e60TvsvSAwA8DY4bwyGTRi6V0EABzDpn5V2xDFNblopUySOxMhTmGGb92aGqGnxPxsBwM5vuM/BJHERApdC4JhxB0rghzBKGGhI4oAnyARRqGq9xB6ZIzMHEOIFgLDxBo6VS0DZ+CCM8gUNrT/wbJqDqCH7HSUB+V0uoWDUIJ/gVd8Z2867sP6A9toISssD5gUp+jjkSZbPV9ghTTEn3mzBbMBQ38IenIdN08NAfUDFiWMeyjQ1VU9KVN9OdnIRJDCkAekJeEqvY7z2bFf4/AGyrhoCNWCq/BeIRL57kEtkHZBK03XC3Er/6MYqMGbwOIP0WmAPXaixMj0wVA8LkMISbkBqUEpRM9NVkyyva99vB4DIfIDGEUoYzO5FF3y+jk50yl0nEw==') format('woff2'),
      url('iconfont.woff?t=1577263980856') format('woff'),
      url('iconfont.ttf?t=1577263980856') format('truetype'), /* chrome, firefox, opera, Safari, Android, iOS 4.2+ */
      url('iconfont.svg?t=1577263980856#iconfont') format('svg'); /* iOS 4.1- */
    }

    .iconfont {
      font-family: "iconfont" !important;
      font-size: 20px;
      font-style: normal;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      cursor: pointer;
    }

    .icon-editor:before {
      content: "\e629";
    }

    .icon-delete:before {
      content: "\e614";
    }
    .run-rate{
    padding:10px
    }
    .addRunRate{
       margin: 20px 20px 20px 0px;
    }
    timetable{
        height: 800px;
        display: grid !important;
        background: rgba(26, 26, 26, 0.98);
        opacity: 1;
        transition: opacity 2s;
        grid-template-columns: 60px 60px repeat(8, 228px );
        /*grid-template-rows: 55px 80px auto;*/
        grid-template-rows: 55px 80px repeat(5, 80px );
        /*overflow: auto;
        overflow:visible;*/
    }
    timetable-header {
        background: #212121;
        color: #ad9440;
        border-right: 1px #ad9440 solid;
        border-bottom: 1px #ad9440 solid;

    }
    timetable-header >span,
    timetable-header >i{
        text-align: center;
        line-height: 55px;
    }
    timetable-header:after {
        /*content: '';
        position: absolute;
        top: 0;
        right: 0;
        height: 100vh;
        border-right: 1px rgba(173, 148, 64, 0.2) solid;
        pointer-events: none;*/
    }
    .timetable-data {
        background: rgba(26, 26, 26, 0.98);
        color: #ad9440;
        text-align: center;
        font-size: 14px;
        border-right: 1px solid #9994;
        border-bottom: 1px solid #9994;

        display: -webkit-box;
          -webkit-box-orient: horizontal;
          -webkit-box-pack: center;
          -webkit-box-align: center;

          display: -moz-box;
          -moz-box-orient: horizontal;
          -moz-box-pack: center;
          -moz-box-align: center;

          display: -o-box;
          -o-box-orient: horizontal;
          -o-box-pack: center;
          -o-box-align: center;

          display: -ms-box;
          -ms-box-orient: horizontal;
          -ms-box-pack: center;
          -ms-box-align: center;

          display: box;
          box-orient: horizontal;
          box-pack: center;
          box-align: center;
    }
    .mainContent{
          margin: auto;
          max-width: 1950px;

    }
    .mainContent2{
        overflow: auto;
    }
    timetable-header{
        position: sticky;
        position: -webkit-sticky;
        white-space: nowrap;
        top: 0;
        z-index: 6;
    }
    .timetable-options{
        position: sticky;
        position: -webkit-sticky;
        white-space: nowrap;
        top:0;
        left: 0;
        z-index: 100;
    }
    .timetable-options2{
        position: sticky;
        position: -webkit-sticky;
        white-space: nowrap;
        top:0;
        left: 60px;
        z-index: 100;
    }
    #delete_run_rate{
        position: sticky;
        position: -webkit-sticky;
        left: 0;
        z-index: 5;
    }
    #update_run_rate{
        position: sticky;
        position: -webkit-sticky;
        left: 60px;
        z-index: 5;
    }
</style>
<body>
    <div class="run-rate" id="run-rate">
        <div class="mainContent">
        <button class="addRunRate">Create run rate</button>
        <button class="addRole">Add Role</button>
            <div class="mainContent2">
                <timetable>
                    <timetable-header class="timetable-options"><span>Delete</span></timetable-header>
                    <timetable-header class="timetable-options2"><span>Editor</span></timetable-header>
                    <timetable-header><span>Country</span></timetable-header>
                    <timetable-header><span>Role</span></timetable-header>
                    <timetable-header><span>Cost Year</span></timetable-header>
                    <timetable-header><span>Volunteer Cost</span></timetable-header>
                    <timetable-header><span>Additional Cost</span></timetable-header>
                    <timetable-header><span>Low Cost</span></timetable-header>
                    <timetable-header><span>Medium Cost</span></timetable-header>
                    <timetable-header><span>High Cost</span></timetable-header>
                </timetable>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
$(document).ready(function () {
        $.ajax({
            type:"POST",
            url:"http://192.168.50.90/staff/api/run-rate/list",
            success:function(data){
                console.log(data)
                console.log(data.length);
                var dataLength=data.length-1;
                //根据返回的数据长度给timetable标签设置grid-template-rows行的样式
                var squaresGrid = document.getElementsByTagName("timetable");
                for (let i = 0; i < squaresGrid.length; i++) {
                   squaresGrid[i].style.gridTemplateRows = "55px 80px repeat("+dataLength+', 80px )';
                }
                for(let item in data){
                    $('timetable').append(`
                     <div class="timetable-data runRate-${data[item].RunRate_id}" id="delete_run_rate" run_rate_id="${data[item].RunRate_id}" >
                        <span class="iconfont icon-delete" ></span>
                     </div>
                     <div class="timetable-data Editor_runRate runRate-${data[item].RunRate_id}"id="update_run_rate"  run_rate_id="${data[item].RunRate_id}">
                        <span id="Editor_run_rate"  class="iconfont icon-editor"></span>
                     </div>

                     <div class="timetable-data runRate-${data[item].RunRate_id}" country_id_value="${data[item].Country_id}"> ${data[item].Country_Name} </div>
                     <div class="timetable-data runRate-${data[item].RunRate_id}" roleID_value="${data[item].roleID}">${data[item].name}</div>
                     <div class="timetable-data runRate-${data[item].RunRate_id}">${data[item].CostYear}</div>
                     <div class="timetable-data runRate-${data[item].RunRate_id}">${data[item].VolunteerCost}</div>
                     <div class="timetable-data runRate-${data[item].RunRate_id}">${data[item].AdditionalCost}</div>
                     <div class="timetable-data runRate-${data[item].RunRate_id}">${data[item].LowCost}</div>
                     <div class="timetable-data runRate-${data[item].RunRate_id}">${data[item].MediumCost}</div>
                     <div class="timetable-data runRate-${data[item].RunRate_id}">${data[item].HighCost}</div>
                     `)
                }

                $(document).on('click',"#delete_run_rate",function(){
                    let runRate_id=$(this).attr("run_rate_id");

                    if(confirm("Are you sure you want to delete the current run rate?")){
                        $.ajax({
                            type:"POST",
                            data:{RunRate_id:$(this).attr("run_rate_id")},
                            url:"http://192.168.50.90/staff/api/run-rate/del",
                            success:function(data){
                                console.log(data);
                                     $(".runRate-"+runRate_id).remove();
                                    addNotif("Delete An Run Rate", "Delete the success!", 1);
                            }
                        });
                    }

                });


                $(document).on('click',".Editor_runRate",function(){

                    $('#run-rate').addClass('panel-popup-active loading');
                        let randAppID = paneljs.genID(5);
                        $('#run-rate').append(`<div id="app-`+randAppID+`"></div>`);
                        paneljs.fetch({type:'app', call:'7',
                        postData:{
                        run_rate_id: $(this).attr("run_rate_id"),
                        country:$(this).next().attr("country_id_value"),
                        role:$(this).next().next().attr("roleID_value"),
                        cost_Year:$(this).next().next().next().text(),
                        volunteerCost:$(this).next().next().next().next().text(),
                        additionalCost:$(this).next().next().next().next().next().text(),
                        lowCost:$(this).next().next().next().next().next().next().text(),
                        mediumCost:$(this).next().next().next().next().next().next().next().text(),
                        highCost:$(this).next().next().next().next().next().next().next().next().text(),
                        }},
                        function (data) {
                        console.log(data);
                        $('#run-rate').removeClass('loading');
                        $('#app-'+randAppID).append(data.data);
                    });
                });
            }
        });
        $('.addRunRate').click(function () {
            $('#run-rate').addClass('panel-popup-active loading');
            let randAppID = paneljs.genID(5);
            $('#run-rate').append(`<div id="app-`+randAppID+`"></div>`);
            paneljs.fetch({type:'app', call:'6'}, function (data) {
                        $('#run-rate').removeClass('loading');
                        $('#app-'+randAppID).append(data.data);
            });
        });
        //添加角色
        $(".addRole").click(function(){
            $('#run-rate').addClass('panel-popup-active loading');
            let randAppID = paneljs.genID(5);
            $('#run-rate').append(`<div id="app-`+randAppID+`"></div>`);
            paneljs.fetch({type:'app', call:'addRole'}, function (data) {
                        $('#run-rate').removeClass('loading');
                        $('#app-'+randAppID).append(data.data);
            });
        });
});
</script>