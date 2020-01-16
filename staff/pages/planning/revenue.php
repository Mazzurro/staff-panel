<head>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300" rel="stylesheet">
        <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
</head>
<style>
:root {
    --black: #000000;
    --dragon-black: #141415;
    --red: #800000;
    --dragon-red: #96031a;
    --dragon-gold: #ad9440;
    --white: #ffffff;
    --dragon-white: #fffbfe;
}

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
    .mainContainer{
    padding:10px
    }
    .revenue_Container{
      margin-right: 2px;
    }
    .revenue_Container timetable{
        height: 730px;
        overflow: auto;
        display: grid !important;
        background: rgba(26, 26, 26, 0.98);
        opacity: 1;
        transition: opacity 2s;
        grid-template-columns: 60px repeat(7, 228px );
        grid-template-rows: 55px 80px repeat(8, 80px );
        /*overflow: auto;
        overflow:visible;
        border-right: 5px solid red;*/
    }
    timetable-header {
        background: #212121;
        color: #ad9440;
        border-right: 1px #ad9440 solid;
        border-bottom: 1px #ad9440 solid;
    }
    timetable-header >span{
        text-align: center;
        line-height: 80px;
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
          /*max-width: 1950px;*/
          overflow: auto;
          display: grid;
          grid-template-columns: repeat(14, auto);
          grid-template-rows: auto;
    }
    timetable-header{
        position: sticky;
        position: -webkit-sticky;
        white-space: nowrap;
        top: 0;
        z-index: 6;
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
    timetable-month{
        border-right: 1px #ad9440 solid;
        border-bottom: 1px #ad9440 solid;
        text-align: center;
        display: -webkit-box !important;
          -webkit-box-orient: horizontal;
          -webkit-box-pack: center;
          -webkit-box-align: center;

          display: -moz-box !important;
          -moz-box-orient: horizontal;
          -moz-box-pack: center;
          -moz-box-align: center;

          display: -o-box !important;
          -o-box-orient: horizontal;
          -o-box-pack: center;
          -o-box-align: center;

          display: -ms-box !important;
          -ms-box-orient: horizontal;
          -ms-box-pack: center;
          -ms-box-align: center;

          display: box !important;
          box-orient: horizontal;
          box-pack: center;
          box-align: center;
    }
    timetable-month>space{

    }
    .monthContainer{
            margin-right: 2px;
            /*margin-bottom: 10px;*/
    }
    .monthContainer timetable{
            height: 730px;
            display: grid !important;
            background: rgba(26, 26, 26, 0.98);
            opacity: 1;
            transition: opacity 2s;
            grid-template-columns: repeat(4, 228px );
            /*grid-template-rows: 55px 80px auto;*/
            grid-template-rows: 55px 80px repeat(15, 80px );
            overflow:auto;
            /*border-right: 5px solid white;
            margin-right:20px;*/
    }
    .monthContainer h4{
        text-align: center;
        margin-bottom:82px;
    }
    timetable-month-head{
        background-color: #ad9440;
        color: #000000 ;
        text-align: center;
        line-height: 55px;
    }
    #searchRevenue{
        display: flex;
        font-size: 18px;
    }
    .timetable-data input{
        border: none;
        background: none;
        color: #AD9440;
        margin: auto;
        text-align: center;
        outline:none
    }
    #search-container{
        display: flex;
        flex: 1 1 300px;
        border: 1px solid var(--dragon-gold);
        border-radius: 4px;
        overflow: hidden;
        cursor: pointer;
        margin: 20px 0px;
    }
    #searchRevenue .search-month{
            width:250px;
            border: 0;
            padding: 2px 6px;
            background: var(--dragon-black);
            border: 1px solid var(--dragon-gold);
            border-radius:4px;
            outline: none;
            color: #ad9440;
            font-size: inherit;
            padding: 20px 10px;
            margin: 20px 10px;
    }
    #searchRevenue span{
        padding: 30px 10px;
    }
    #searchRevenue .search-month:focus{
        border: 1px solid var(--dragon-gold);
    }
    /*.inputDynamic{
        border: 1px solid #AD9440 !important;
        background: var(--black) !important;
    }*/
</style>
<body>
    <div class="mainContainer" id="revenue_Container">
        <div class="mainContent">
            <div class="revenue_Container">
                <h4 style="text-align: center;">Revenue Plan 72 Dragons 2019</h4>

                <div id="searchRevenue">
                    <button class="addRevenue" style="margin: 20px 10px 20px 0px;">Add Revenue</button>
                    <span>Start Date:</span><input class="search-month" name="start_Date" type="text" placeholder="YYYY-MM"/>
                    <span>Due Date:</span><input class="search-month" name="due_Date" type="text" placeholder="YYYY-MM"/>
                    <button class="searchMonth" style="margin: 20px 10px 20px 0px;">Search</button>

                    <div id="search-container">
                        <select class="bg-search-select">
                            <option class="dd-product" value="product">product</option>
                            <option class="dd-service" value="service">service</option>
                            <option class="dd-client" value="client">client</option>
                            <option class="dd-revenue-origin" value="revenue-origin">revenue origin</option>
                            <option class="dd-revenue-destination" value="revenue-destination">revenue destination</option>
                            <option class="dd-month-revenueincome" value="month-revenueincome">month revenueincome</option>
                            <option class="dd-month" value="dd-month">month</option>
                        </select>
                        <input id="search-box" type="search" name="search" placeholder="Search...">
                        <button style="margin:0px"><i class="fa fa-search search-icon"></i></button>
                    </div>
                </div>
                <timetable>
                    <timetable-head></timetable-head>
                    <timetable-head></timetable-head>
                    <timetable-head></timetable-head>
                    <timetable-head></timetable-head>
                    <timetable-head></timetable-head>
                    <timetable-head></timetable-head>
                    <timetable-head></timetable-head>
                    <timetable-head></timetable-head>

                    <timetable-header><span>Editor</span></timetable-header>
                    <timetable-header><span>Products</span></timetable-header>
                    <timetable-header><span>Services</span></timetable-header>
                    <timetable-header><span>Clients</span></timetable-header>
                    <timetable-header><span>Revenue Origin</span></timetable-header>
                    <timetable-header><span>Revenue Destination</span></timetable-header>
                    <timetable-header><span>Unit Value (USD)</span></timetable-header>
                    <timetable-header><span>Unit Value (Local Currency)</span></timetable-header>
                </timetable>
            </div>

            <div class="monthContainer jan">
                <h4>2020-01</h4>
                <timetable>
                    <timetable-month-head>9 Units Sold</timetable-month-head>
                    <timetable-month-head>10 Unit Sold</timetable-month-head>
                    <timetable-month-head>$1028(USD)</timetable-month-head>
                    <timetable-month-head>$8335(USD)</timetable-month-head>

                    <timetable-month><span>Units Sold</span></timetable-month>
                    <timetable-month><span>Unit Sold (Stretch Goal)</span></timetable-month>
                    <timetable-month><span>Sales Income</span></timetable-month>
                    <timetable-month><span>Stretch Sales Income</span></timetable-month>
                </timetable>
            </div>

            <div class="monthContainer feb">
                <h4>2020-02</h4>
                <timetable>
                    <timetable-month-head>9 Units Sold</timetable-month-head>
                    <timetable-month-head>10 Unit Sold</timetable-month-head>
                    <timetable-month-head>$1028(USD)</timetable-month-head>
                    <timetable-month-head>$8335(USD)</timetable-month-head>

                    <timetable-month><span>Units Sold</span></timetable-month>
                    <timetable-month><span>Unit Sold (Stretch Goal)</span></timetable-month>
                    <timetable-month><span>Sales Income</span></timetable-month>
                    <timetable-month><span>Stretch Sales Income</span></timetable-month>
                </timetable>
            </div>
            <div class="monthContainer feb">
                <h4>2020-03</h4>
                <timetable>
                    <timetable-month-head>9 Units Sold</timetable-month-head>
                    <timetable-month-head>10 Unit Sold</timetable-month-head>
                    <timetable-month-head>$1028(USD)</timetable-month-head>
                    <timetable-month-head>$8335(USD)</timetable-month-head>

                    <timetable-month><span>Units Sold</span></timetable-month>
                    <timetable-month><span>Unit Sold (Stretch Goal)</span></timetable-month>
                    <timetable-month><span>Sales Income</span></timetable-month>
                    <timetable-month><span>Stretch Sales Income</span></timetable-month>
                </timetable>
            </div>
            <div class="monthContainer apr">
                <h4>2020-04</h4>
                <timetable>
                    <timetable-month-head>9 Units Sold</timetable-month-head>
                    <timetable-month-head>10 Unit Sold</timetable-month-head>
                    <timetable-month-head>$1028(USD)</timetable-month-head>
                    <timetable-month-head>$8335(USD)</timetable-month-head>

                    <timetable-month><span>Units Sold</span></timetable-month>
                    <timetable-month><span>Unit Sold (Stretch Goal)</span></timetable-month>
                    <timetable-month><span>Sales Income</span></timetable-month>
                    <timetable-month><span>Stretch Sales Income</span></timetable-month>
                </timetable>
            </div>
            <div class="monthContainer may">
                <h4>2020-05</h4>
                <timetable>
                    <timetable-month-head>9 Units Sold</timetable-month-head>
                    <timetable-month-head>10 Unit Sold</timetable-month-head>
                    <timetable-month-head>$1028(USD)</timetable-month-head>
                    <timetable-month-head>$8335(USD)</timetable-month-head>

                    <timetable-month><span>Units Sold</span></timetable-month>
                    <timetable-month><span>Unit Sold (Stretch Goal)</span></timetable-month>
                    <timetable-month><span>Sales Income</span></timetable-month>
                    <timetable-month><span>Stretch Sales Income</span></timetable-month>
                </timetable>
            </div>
            <div class="monthContainer jun">
                <h4>2020-06</h4>
                <timetable>
                    <timetable-month-head>9 Units Sold</timetable-month-head>
                    <timetable-month-head>10 Unit Sold</timetable-month-head>
                    <timetable-month-head>$1028(USD)</timetable-month-head>
                    <timetable-month-head>$8335(USD)</timetable-month-head>

                    <timetable-month><span>Units Sold</span></timetable-month>
                    <timetable-month><span>Unit Sold (Stretch Goal)</span></timetable-month>
                    <timetable-month><span>Sales Income</span></timetable-month>
                    <timetable-month><span>Stretch Sales Income</span></timetable-month>
                </timetable>
            </div>
            <div class="monthContainer july">
                <h4>2020-07</h4>
                <timetable>
                    <timetable-month-head>9 Units Sold</timetable-month-head>
                    <timetable-month-head>10 Unit Sold</timetable-month-head>
                    <timetable-month-head>$1028(USD)</timetable-month-head>
                    <timetable-month-head>$8335(USD)</timetable-month-head>

                    <timetable-month><span>Units Sold</span></timetable-month>
                    <timetable-month><span>Unit Sold (Stretch Goal)</span></timetable-month>
                    <timetable-month><span>Sales Income</span></timetable-month>
                    <timetable-month><span>Stretch Sales Income</span></timetable-month>
                </timetable>
            </div>
            <div class="monthContainer aug">
                <h4>2020-08</h4>
                <timetable>
                    <timetable-month-head>9 Units Sold</timetable-month-head>
                    <timetable-month-head>10 Unit Sold</timetable-month-head>
                    <timetable-month-head>$1028(USD)</timetable-month-head>
                    <timetable-month-head>$8335(USD)</timetable-month-head>

                    <timetable-month><span>Units Sold</span></timetable-month>
                    <timetable-month><span>Unit Sold (Stretch Goal)</span></timetable-month>
                    <timetable-month><span>Sales Income</span></timetable-month>
                    <timetable-month><span>Stretch Sales Income</span></timetable-month>
                </timetable>
            </div>
            <div class="monthContainer sept">
                <h4>2020-09</h4>
                <timetable>
                    <timetable-month-head>9 Units Sold</timetable-month-head>
                    <timetable-month-head>10 Unit Sold</timetable-month-head>
                    <timetable-month-head>$1028(USD)</timetable-month-head>
                    <timetable-month-head>$8335(USD)</timetable-month-head>

                    <timetable-month><span>Units Sold</span></timetable-month>
                    <timetable-month><span>Unit Sold (Stretch Goal)</span></timetable-month>
                    <timetable-month><span>Sales Income</span></timetable-month>
                    <timetable-month><span>Stretch Sales Income</span></timetable-month>
                </timetable>
            </div>
            <div class="monthContainer oct">
                <h4>2020-10</h4>
                <timetable>
                    <timetable-month-head>9 Units Sold</timetable-month-head>
                    <timetable-month-head>10 Unit Sold</timetable-month-head>
                    <timetable-month-head>$1028(USD)</timetable-month-head>
                    <timetable-month-head>$8335(USD)</timetable-month-head>

                    <timetable-month><span>Units Sold</span></timetable-month>
                    <timetable-month><span>Unit Sold (Stretch Goal)</span></timetable-month>
                    <timetable-month><span>Sales Income</span></timetable-month>
                    <timetable-month><span>Stretch Sales Income</span></timetable-month>
                </timetable>
            </div>
            <div class="monthContainer nov">
                <h4>2020-11</h4>
                <timetable>
                    <timetable-month-head>9 Units Sold</timetable-month-head>
                    <timetable-month-head>10 Unit Sold</timetable-month-head>
                    <timetable-month-head>$1028(USD)</timetable-month-head>
                    <timetable-month-head>$8335(USD)</timetable-month-head>

                    <timetable-month><span>Units Sold</span></timetable-month>
                    <timetable-month><span>Unit Sold (Stretch Goal)</span></timetable-month>
                    <timetable-month><span>Sales Income</span></timetable-month>
                    <timetable-month><span>Stretch Sales Income</span></timetable-month>
                </timetable>
            </div>

            <div class="monthContainer dec">
                <h4>2020-12</h4>
                <timetable>
                    <timetable-month-head>9 Units Sold</timetable-month-head>
                    <timetable-month-head>10 Unit Sold</timetable-month-head>
                    <timetable-month-head>$1028(USD)</timetable-month-head>
                    <timetable-month-head>$8335(USD)</timetable-month-head>

                    <timetable-month><span>Units Sold</span></timetable-month>
                    <timetable-month><span>Unit Sold (Stretch Goal)</span></timetable-month>
                    <timetable-month><span>Sales Income</span></timetable-month>
                    <timetable-month><span>Stretch Sales Income</span></timetable-month>
                </timetable>
            </div>

            <div class="monthContainer totals">
                 <h4>2020 Sales Totals</h4>
                 <timetable>
                     <timetable-month-head>9 Units Sold</timetable-month-head>
                     <timetable-month-head>10 Unit Sold</timetable-month-head>
                     <timetable-month-head>$1028(USD)</timetable-month-head>
                     <timetable-month-head>$8335(USD)</timetable-month-head>

                     <timetable-month><span>Units Sold</span></timetable-month>
                     <timetable-month><span>Unit Sold (Stretch Goal)</span></timetable-month>
                     <timetable-month><span>Sales Income</span></timetable-month>
                     <timetable-month><span>Stretch Sales Income</span></timetable-month>
                 </timetable>
             </div>
        </div>
    </div>
</body>
<script type="text/javascript">

$(document).ready(function (){
var monthData=[
    {janMonth:{1:{UnitSold:2,UnitSoldStretchGoal:3},2:{UnitSold:21,UnitSoldStretchGoal:5}}},
    {febMonth:{1:{UnitSold:5,UnitSoldStretchGoal:12},2:{UnitSold:1,UnitSoldStretchGoal:7}}},
    {marMonth:{1:{UnitSold:5,UnitSoldStretchGoal:31},2:{UnitSold:22,UnitSoldStretchGoal:12}}},
    {aprMonth:{1:{UnitSold:3,UnitSoldStretchGoal:2},2:{UnitSold:5,UnitSoldStretchGoal:5}}},
    {mayMonth:{1:{UnitSold:6,UnitSoldStretchGoal:12},2:{UnitSold:1,UnitSoldStretchGoal:7}}},
    {junMonth:{1:{UnitSold:8,UnitSoldStretchGoal:12},2:{UnitSold:33,UnitSoldStretchGoal:21}}},
    {julyMonth:{1:{UnitSold:11,UnitSoldStretchGoal:12},2:{UnitSold:11,UnitSoldStretchGoal:31}}},
    {augMonth:{1:{UnitSold:13,UnitSoldStretchGoal:18},2:{UnitSold:11,UnitSoldStretchGoal:31}}},
    {septMonth:{1:{UnitSold:13,UnitSoldStretchGoal:1},2:{UnitSold:1,UnitSoldStretchGoal:7}}},
    {octMonth:{1:{UnitSold:25,UnitSoldStretchGoal:5},2:{UnitSold:9,UnitSoldStretchGoal:11}}},
    {novMonth:{1:{UnitSold:36,UnitSoldStretchGoal:7},2:{UnitSold:2,UnitSoldStretchGoal:17}}},
    {decMonth:{1:{UnitSold:51,UnitSoldStretchGoal:6},2:{UnitSold:1,UnitSoldStretchGoal:7}}}
]
var revenueData={
          revenueDates:[
            {rId:"1",product:"Art",Services:"Art Website",Clients:"Marcy and Sons",remove_Origin:"Hong Kong",revenue_Destination:"Shenzhen",Unit_Value_USD:"1000",Unit_Value_Local_Currency:"112"},
            {rId:"2",product:"Electronic Communication Products",Services:"Instagram Management",Clients:"Latino Caucus APHA",remove_Origin:"Hong Kong",revenue_Destination:"New York",Unit_Value_USD:"1200",Unit_Value_Local_Currency:"1555"},
            {rId:"3",product:"Staff Panel management system",Services:"Management",Clients:"Latino Caucus APHA",remove_Origin:"India",revenue_Destination:"New York",Unit_Value_USD:"500",Unit_Value_Local_Currency:"520"},
            {rId:"4",product:"Art",Services:"Instagram Management",Clients:"Latino Caucus APHA",remove_Origin:"Hong Kong",revenue_Destination:"New York",Unit_Value_USD:"900",Unit_Value_Local_Currency:"1555"},
            {rId:"5",product:"Electronic Communication Products",Services:"Instagram Management",Clients:"Latino Caucus APHA",remove_Origin:"India",revenue_Destination:"India",Unit_Value_USD:"700",Unit_Value_Local_Currency:"956"},
            {rId:"6",product:"Art",Services:"Instagram Management",Clients:"Latino Caucus APHA",remove_Origin:"Hong Kong",revenue_Destination:"Shenzhen",Unit_Value_USD:"1000",Unit_Value_Local_Currency:"1555"},
            {rId:"7",product:"Electronic Communication Products",Services:"Instagram Management",Clients:"buffett",remove_Origin:"Hong Kong",revenue_Destination:"New York",Unit_Value_USD:"1500",Unit_Value_Local_Currency:"1735"},
          ],
          saleDates: [
                 {rId:'1',date:"2021-01", Units_Sold:"2","Unit Sold (Stretch Goal)":"3"},
                 {rId:'2',date:"2021-02", Units_Sold:"3.5","Unit Sold (Stretch Goal)":"5"},
                 {rId:'3',date:"2021-03", Units_Sold:"0.5","Unit Sold (Stretch Goal)":"10"},
                 {rId:'4',date:"2021-04", Units_Sold:"1.3","Unit Sold (Stretch Goal)":"3"},
                 {rId:'5',date:"2021-05", Units_Sold:"2.1","Unit Sold (Stretch Goal)":"4"},
                 {rId:'6',date:"2021-06", Units_Sold:"1.5","Unit Sold (Stretch Goal)":"3"},
                 {rId:'7',date:"2021-07", Units_Sold:"0.5","Unit Sold (Stretch Goal)":"2"},
          ]
};
            var revenue=revenueData.revenueDates;
            var revenueMonth=revenueData.saleDates;
            console.log(revenueData.revenueDates);
            /*console.log(monthData);*/

            for(var i=0;i<monthData.length;i++){
                /*console.log("属性名：",monthData[i]);*/
                /*console.log(Object.keys(monthData[i]));*/
                if(Object.keys(monthData[i])=="janMonth"){
                    console.log("一月");
                    for(let item in monthData[i].janMonth){
                        /*console.log(monthData[i].janMonth[item].UnitSold);*/
                        monthDataUnitSold(1000,monthData[i].janMonth[item].UnitSold,monthData[i].janMonth[item].UnitSoldStretchGoal);
                    }
                }
                /*if(Object.keys(monthData[i])=="febMonth"){
                    console.log("二月");
                    for(let item in monthData[i].febMonth){
                        console.log(monthData[i].febMonth[item].UnitSold);
                        monthDataUnitSold(2000,monthData[i].febMonth[item].UnitSold,monthData[i].febMonth[item].UnitSoldStretchGoal);
                    }
                }*/
            };
            //遍历主表格
            for(let item in revenue){
                $('.revenue_Container timetable').append(`
                 <div class="timetable-data" id="update_Revenue" data-id="${revenue[item].rId}"><span class="iconfont icon-editor"></span></div>
                 <div class="timetable-data">${revenue[item].product}</div>
                 <div class="timetable-data">${revenue[item].Services}</div>
                 <div class="timetable-data">${revenue[item].Clients}</div>
                 <div class="timetable-data">${revenue[item].remove_Origin}</div>
                 <div class="timetable-data">${revenue[item].revenue_Destination}</div>
                 <div class="timetable-data">${revenue[item].Unit_Value_USD}</div>
                 <div class="timetable-data">${revenue[item].Unit_Value_Local_Currency}</div>`);
            }

            //遍历月份表格，第一个表price价格，UnitSold(列)、UnitSoldStretchGoal(列)
            function monthDataUnitSold(price,UnitSold,UnitSoldStretchGoal){
                 console.log(price);
                 console.log(UnitSold);
                 console.log(UnitSoldStretchGoal);
                 let resultData=price*UnitSold;
                 let resultDataP=price*UnitSoldStretchGoal;

                 console.log($('.monthContainer h4').text());

                 $('.monthContainer timetable').append(`
                   <div class="timetable-data fanhuiBtn" data-slotID="1" data-column="2020-01"><input  oninput="updateInput(this,${price})" readonly="true" value="${UnitSold}"/></div>
                   <div class="timetable-data fanhuiBtn" data-slotID="2" data-column="2020-01"><input  oninput="updateInput(this,${price})" readonly="true" value="${UnitSoldStretchGoal}"/></div>
                   <div class="timetable-data" revenue_id="3" >${resultData}</div>
                   <div class="timetable-data" revenue_id="4">${resultDataP}</div>`);

            };
                $(".monthContainer timetable .fanhuiBtn").on("dblclick", function () {
                    var currentValue=$(this).children().val();
                    var slotID=$(this).attr("data-slotID");
                    console.log("双击");
                    /*console.log($(this).children())*/

                    $($(this).children().removeAttr("readonly"));
                    $(this).children().addClass("inputDynamic");
                    console.log($(this).children().val());
                    /* $(this).children().attr("oninput","updateInput(this,'"+$(this).children().val()+"','"+slotID+"')");*/
                    //双击显示input框
                    /*updateRevenue($(this),$(this).attr("revenue_id"),$(this).text());*/
                    /*updateRen(this,$(this).attr("data-slotID"),currentValue);*/

                });
                //修改月份表格中Units Sold、Unit Sold (Stretch Goal)列的值
               function updateRen(currentInput,current_id,revenueName){
                    console.log("方法：");
                    console.log(currentInput,current_id,revenueName);
                    //为当前的子元素添加属性
                    $(currentInput).children().attr("onblur","current_blur(this,'"+revenueName+"','"+current_id+"')");
                    $(currentInput).children().attr("onchange","OnPropChanged(this,'"+revenueName+"','"+current_id+"')");

               }
            //编辑Revenue
            $(document).on('click',"#update_Revenue",function(){
             /*$("#update_Revenue").click(function(){*/
                console.log("编辑");
                var dataId=$(this).attr("data-id");
                var products=$(this).next().text();
                var serviceData=$(this).next().next().text();
                var clientsData=$(this).next().next().next().text();
                var revenueOrigin=$(this).next().next().next().next().text();
                var revenueDestination=$(this).next().next().next().next().next().text();
                var Unit_Value_USD=$(this).next().next().next().next().next().next().text();
                var Unit_Value_Local_Currency=$(this).next().next().next().next().next().next().next().text();
                console.log(dataId);
                console.log(products);
                console.log(serviceData);
                console.log(clientsData);
                console.log(revenueOrigin);
                console.log(revenueDestination);
                console.log(Unit_Value_USD);
                console.log(Unit_Value_Local_Currency);
                    $('#revenue_Container').addClass('panel-popup-active loading');
                    let randAppID = paneljs.genID(5);
                    $('#revenue_Container').append(`<div id="app-`+randAppID+`"></div>`);
                    paneljs.fetch({type:'app', call:'editorRevenue',postData:{
                    dataId:dataId,
                    products: products,
                    serviceData:serviceData,
                    clientsData:clientsData,
                    revenue_Origin:revenueOrigin,
                    revenueDestination:revenueDestination,
                    Unit_Value_USD:Unit_Value_USD,
                    Unit_Value_Local_Currency:Unit_Value_Local_Currency,
                    }}, function (data) {
                                $('#revenue_Container').removeClass('loading');
                                $('#app-'+randAppID).append(data.data);
                    });
             });

            //监听input的value值改变
                //当按input发生变化触发
                $("#search-box").on("input propertychange",function(){

                    //获取当前下拉框选中的option的class名称
                    var dropdownValue = $(".bg-search-select").find("option:selected").attr("class");
                    var searchValue = $("#search-box").val();
                    /*$.ajxa({
                        type:"POST",
                        url:"",
                        data:{},
                        success:function(){

                        }
                    });*/

                    //隐藏所有
                    $(".revenue_Container timetable  div").hide();
                    switch(dropdownValue){
                        case "dd-product":
                            //显示有关标题类型的项目
                            console.log("显示product");
                            //判断.float-fade-in .box-head元素内是否包含另一个元素
                               $(".revenue_Container timetable  div").filter(":Contains("+searchValue+")").closest('.revenue_Container timetable  div').show();
                            break;
                        case "dd-service":
                                console.log("显service");
                                $(".box-list-Community .dd-completed").filter(":Contains("+searchValue+")").closest('.box-list-Community').show();
                            break;
                        case "dd-client":
                                console.log("显示client");
                                $(".box-list-Community .update-date").filter(":Contains("+searchValue+")").closest('.box-list-Community').show();
                            break;
                        case "dd-revenue-origin":
                                console.log("显示revenue-origin");
                                $(".box-list-Community .update-date").filter(":Contains("+searchValue+")").closest('.box-list-Community').show();
                            break;
                        case "dd-revenue-destination":
                                console.log("显示revenue-destination");
                                $(".box-list-Community .update-date").filter(":Contains("+searchValue+")").closest('.box-list-Community').show();
                            break;
                        case "dd-month-revenueincome":
                                console.log("显示month-revenueincome");
                                $(".box-list-Community .update-date").filter(":Contains("+searchValue+")").closest('.box-list-Community').show();
                            break;
                        case "dd-month":
                                $(".monthContainer").hide();
                                if(searchValue!=""){
                                  //筛选.monthContainer h4中是否包含输入值，如果包含显示，否则隐藏
                                  $(".monthContainer h4").filter(":Contains("+searchValue+")").parent().show();
                                }else{
                                  $(".monthContainer").show();
                                }
                            break;
                        default:
                            console.log("default");
                            if(searchValue==""){
                                $(".revenue_Container timetable  div").show();
                            }
                    }
                });
            //搜索表格的月份数据
            $(".searchMonth").click(function(){
                var start_Date=$("input[name=start_Date]").val();
                var due_Date=$("input[name=due_Date]").val();
                getMonths(start_Date,due_Date);
            });
            /*$.ajax({
                  type:"POST",
                url:"http://192.168.50.90/staff/api/run-rate/list",
                success:function(data){
                    console.log(data);
                    console.log(data.length);
                        var dataLength=data.length-1; 4
                    //根据返回的数据长度给 timetable标签设置grid-template-rows行的样式
                    var squaresGrid = document.getElementsByTagName("timetable");
                    for (let i = 0; i < squaresGrid.length; i++) {
                       squaresGrid[i].style.gridTemplateRows = "55px 80px repeat("+dataLength+', 80px )';
                    }
                }
            });*/
    //添加Revenue
    $(".addRevenue").click(function(){
        $('#revenue_Container').addClass('panel-popup-active loading');
            let randAppID = paneljs.genID(5);
            $('#revenue_Container').append(`<div id="app-`+randAppID+`"></div>`);
            paneljs.fetch({type:'app', call:'addRevenue'}, function (data) {
                        $('#revenue_Container').removeClass('loading');
                        $('#app-'+randAppID).append(data.data);
            });
    });
});
            //筛选月份差，格式:YYYY-MM
            function getMonths(start, end){

            //日期格式yyyy-mm
            var date_ym= /^(\d{4})-(0\d{1}|1[0-2])$/;
            if(!date_ym.test(start) || !date_ym.test(end)){
                $("input[name=start_Date]").val("");
                $("input[name=due_Date]").val("");
                addNotif("Unable to search month", "Please enter the date in the correct format. Example: 2020-01-01.", 2);
            }else{
                //定义一个数组
                var result = [];
                //分割"-"符号
                var starts = start.split('-');
                var ends = end.split('-');
                console.log("starts:",starts);
                console.log("ends:",ends);

                //得到开始日期 开始年、月
                var staYear = starts[0]*1;
                var staMon = starts[1]*1 < 10? starts[1]:starts[1];

                //得到结束日期 结束年、月
                var endYear = ends[0]*1;
                var endMon = ends[1]*1 < 10? ends[1]:ends[1];;
                result.push(staYear+'-'+staMon);
                while (staYear <= endYear) {
                    //如果开始日期和结束日期是同一年
                    if (staYear === endYear) {
                        //staMon：开始月,endMon：结束月
                        while (staMon < endMon) {
                            staMon++;
                            if(staMon < 10){//开始月份小于10月时在staMon前面加“0”，否则
                                result.push(staYear+'-0'+staMon);
                            }else{
                                result.push(staYear+'-'+staMon);
                            }
                        }
                        staYear++;
                    } else {
                        staMon++;
                        if (staMon > 12) {
                            staMon = 1;
                            staYear++;
                        }
                        if(staMon < 10){
                            result.push(staYear+'-0'+staMon);
                        }else{
                            result.push(staYear+'-'+staMon);
                        }
                    }
                }
                console.log(result);
                $(".monthContainer").hide();
                $(".monthContainer h4").filter(":Contains(2020 Sales Totals)").parent().show();
                for(i=0;i<result.length;i++){
                        console.log(result[i])
                        if(start!="" && end!=""){
                          //筛选.monthContainer h4中是否包含输入值，如果包含显示，否则隐藏
                          $(".monthContainer h4").filter(":Contains("+result[i]+")").parent().show();
                        }else{
                            $(".monthContainer").show();
                        }
                }
                return result;
               };
            };


        //当输入框发生改变时
        function updateInput(current,danJa){
            console.log(current);
            console.log($(current));

            console.log($(current).val());
           console.log(danJa);
           var totalResults  =Number(danJa*$(current).val());
           console.log(totalResults);
           //给当前input相邻的第二个元素赋值
           $(current).parent().next().next().text(totalResults);
           //设置当前input框的val
           $(current).attr({"value": $(current).val()})
           //发送AJAX更新
        }
        function OnPropChanged(currentInput,revenueName,current_id){
                console.log(currentInput,revenueName,current_id);

        }
               //行id：current_id,input的值：revenueName，当前指向：currentInput
               function current_blur(currentInput,revenueName,current_id){
                   console.log(currentInput,revenueName,current_id);

                    if($(currentInput).val()!=revenueName){
                       console.log("发送请求");
                       //为当前元素赋值
                       $(currentInput).attr({"value": $(currentInput).val()});
                       $(currentInput).attr("readonly","true");
                       $(currentInput).removeClass("inputDynamic");
                   }else if($(currentInput).val()==""){
                       alert("不能为空！");
                       $(currentInput).attr({"value": revenueName});
                       $(currentInput).attr("readonly","true");
                       $(currentInput).removeClass("inputDynamic");
                   }else{
                       console.log("else");
                       $(currentInput).attr({"value": revenueName});
                       $(currentInput).attr("readonly","true");
                       $(currentInput).removeClass("inputDynamic");
                   }
                   console.log('当前input的值：',$(currentInput).val())
                   /*$(currentInput).attr({"value": $(currentInput).val()});
                   $(currentInput).attr("readonly","true");
                   $(currentInput).removeClass("inputDynamic");*/

               };
        function calculate_Sales_Income(){
            //
        }
        //UnitValue(单位价值)* Units Sold(数量)=Unit Value (USD),哪一个月份:monthData
        function calculate_Unit_Sold(unitValue,unitsSold,monthData){
            //

        }
        //  dblclick  双击 事件
        function updateRevenue (current,current_id,revenueName){
           console.log("双击");
           console.log(current);
           console.log(current_id);
           console.log(revenueName);
           $(current).html("");
           //给当前位置添加input框
            $(current).append("<input value='"+revenueName+"'/>");
            //监听input的value值
            /*$(current).live("input propertychange",function(event){
                console.log(event)
            })*/
            //为当前的子元素添加属性
            $(current).children("input").attr("onblur","nameblur(this,'"+revenueName+"','"+current_id+"')");
            $(current).children("input").focus();
            $(current).removeAttr("ondblclick");

        };
        function nameblur(currentInput,revenueName,current_id){
            let current_Input=$(currentInput).val();
            //如果现在输入的内容与之前不同则改变
            if($(currentInput).val()!=revenueName){
                console.log("发送请求");
                //为父元素添加用户输入的值
                $(currentInput).parent().append(current_Input);
                //移除当前输入的input框
                $(currentInput).remove();
            }else{
                console.log("else");
                $(currentInput).parent().append(current_Input);
                $(currentInput).remove();
            }
        }
</script>