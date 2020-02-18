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
      src: url('iconfont.eot?t=1581999560417'); /* IE9 */
      src: url('iconfont.eot?t=1581999560417#iefix') format('embedded-opentype'), /* IE6-IE8 */
      url('data:application/x-font-woff2;charset=utf-8;base64,d09GMgABAAAAAASYAAsAAAAACWgAAARMAAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHEIGVgCDMgqFeIR5ATYCJAMUCwwABCAFhG0HVhsTCBFVnCHJfhbYzS6V8H9Igb6dlVXJmhpjiA2+8LenUE7VgV3XTthNmQeMgRGAs3EyQo8gNMIXoTviN9I7DRBAMDdRocPv26+deLqDUCakb/Eq1rV+nVn5PjuLvA6tUqqHCKHxP4eLa2OBzd/gyDJac+C0ol4U9qIJlGVjbOxFYQHegZz7KYhn00HHBJ0HAkBGFipA2rTr4oYEDnUaAUAmjB09FFLEAF5AJJDUYsZaDrIBAiS6mhoA1ju/T76iFpEACoFBvajHqLYj0OKD+mE50+IaBjANWnc2APwmgAGoAMABMi3TMQHMS1SAQf4M5mgBQIYECtpVr9wPpR+Wx+MEkgWpZC0JcNBu/nlEhKowAdMiyYEPqiEIlLnQgUJZCh0YlMshOhaFYK2RATgA/IHkQ1UVOEMpKERIqkURTGCqzBQVYs4h86kCG1G0JBSmUPoZ/alM3F28I5qN9vhkMv75c/eLF55Xr3ym/tT88uX8EVsC0b3Jo7cHI9qIwFF9Vyx0ZCc0w5TgVm2LKm/b5t8+2hSw9Io5Ue4Onuw7GiVEjxZZDofBtUihNRRLJ/5YMJKK3dWxXHialeB/Vt96/kkm3RGe3+ub5EBYiygKf/GirfnOK5+ghGL+aJH88qV737Pgk8wxR69nCVa++6psIr5gLJ3p0UAYtDw3xJEwPyGF7uxT+8DRUe1aoEWLedpztcoWldrZFme1UYv7mluEnj4rnzDe4TCaN582wTDWtsDXVzozqthOphuGbhdWGUyfULx5woRYPzRpuYGQ9wVRVoVHvhfECgLzrJOi/WofiX6wOvW+8c87QzU2fN7A2he2nRFSyKhOvIwhOypr7FQ/sZ014KBUPGsrLaH9ZohthgycUkdsV+TBF/fwCMlsJ3KGj+uC0SN4l89qtERPqmNHZ/fI33aPIF1s1WtESiM13rMuo0YcP13Uq3uvogb3h/SUbPk2qVVKCM2m2vszF++XOy7JpfbfbxuvupL65fVjUKFx43L7cRfrb8ccqLVMY5QlrrGnTEttZvfZ+HfpbzBj6oljg61N/us3CgcAvB1f3+GPa1Nd8EIo8RG+OcKKZfwrVo3ClGJDoKQEY23OMv/TIAPeF4/DXzeuJJPARkiCEEAlyARGUoDgmAoQKOqASNIcZOWuNiuc2BxZIoAyLwQImzegLK4AY/OD4JhfELj8g8jWHGTeTvdUFGV2Z4y5YAXFM5iy70g3y87NvEblm5zDYod0j+xMGOIgiqevsEPuYoF7UIkIAXHfwiW5DJumh4F7i6UEWmQ4hiFlvSgo+3ay0xpDOYEqoPAMGKVeh6z6Ypf4+WtI8Ro5Lij5Yb+HmGO6B7FAVAFxpegqlZzKYOeBkhCCmEmE9VrgEjbUaIkeGLJHWagkArpBbHAU0kpUVREMr2rPcQeATD1GiBJGOBGICOHaW7/ffmnq9c2LvCNfYLcuDBluTbx2Ou9K7ScT') format('woff2'),
      url('iconfont.woff?t=1581999560417') format('woff'),
      url('iconfont.ttf?t=1581999560417') format('truetype'), /* chrome, firefox, opera, Safari, Android, iOS 4.2+ */
      url('iconfont.svg?t=1581999560417#iconfont') format('svg'); /* iOS 4.1- */
    }

    .iconfont {
      font-family: "iconfont" !important;
      font-size: 16px;
      font-style: normal;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      cursor: pointer;
    }

    .icon-shuju:before {
      content: "\e685";
      font-size:28px;
    }

    .icon-icon_huabanfuben:before {
      content: "\e621";
      font-size: 28px;
    }

    .icon-editor:before {
      content: "\e629";
    }

    .icon-delete:before {
      content: "\e614";
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
    .head-icon{
        background: rgba(26, 26, 26, 0.98);
        color: #ad9440;
        text-align: center;
        display: -webkit-box;
        -webkit-box-orient: horizontal;
        -webkit-box-pack: center;
        -webkit-box-align: center;
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
                    <timetable-head class="head-icon"><span class="iconfont icon-icon_huabanfuben" id="pie-data">Pie data</span></timetable-head>
                    <timetable-head class="head-icon"><span class="iconfont icon-shuju" id="curve-data">Curve data</span></timetable-head>
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
                    <timetable-month-head id="jan" >9 Units Sold</timetable-month-head>
                    <timetable-month-head id="jan_Unit_Sold" >10 Unit Sold</timetable-month-head>
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
                    <timetable-month-head id="feb" >9 Units Sold</timetable-month-head>
                    <timetable-month-head id="feb_Unit_Sold" >10 Unit Sold</timetable-month-head>
                    <timetable-month-head>$1028(USD)</timetable-month-head>
                    <timetable-month-head>$8335(USD)</timetable-month-head>

                    <timetable-month><span>Units Sold</span></timetable-month>
                    <timetable-month><span>Unit Sold (Stretch Goal)</span></timetable-month>
                    <timetable-month><span>Sales Income</span></timetable-month>
                    <timetable-month><span>Stretch Sales Income</span></timetable-month>
                </timetable>
            </div>
            <div class="monthContainer mar">
                <h4>2020-03</h4>
                <timetable>
                    <timetable-month-head id="mar">9 Units Sold</timetable-month-head>
                    <timetable-month-head id="mar_Unit_Sold">10 Unit Sold</timetable-month-head>
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
                    <timetable-month-head id="apr">9 Units Sold</timetable-month-head>
                    <timetable-month-head id="apr_Unit_Sold">10 Unit Sold</timetable-month-head>
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
                    <timetable-month-head id="may">9 Units Sold</timetable-month-head>
                    <timetable-month-head id="may_Unit_Sold">10 Unit Sold</timetable-month-head>
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
                    <timetable-month-head id="jun">9 Units Sold</timetable-month-head>
                    <timetable-month-head id="jun_Unit_Sold">10 Unit Sold</timetable-month-head>
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
                    <timetable-month-head id="july">9 Units Sold</timetable-month-head>
                    <timetable-month-head id="july_Unit_Sold">10 Unit Sold</timetable-month-head>
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
                    <timetable-month-head id="july">9 Units Sold</timetable-month-head>
                    <timetable-month-head id="_Unit_Sold">10 Unit Sold</timetable-month-head>
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
                    <timetable-month-head id="sept">9 Units Sold</timetable-month-head>
                    <timetable-month-head id="sept_Unit_Sold">10 Unit Sold</timetable-month-head>
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
                    <timetable-month-head id="oct">9 Units Sold</timetable-month-head>
                    <timetable-month-head id="oct_Unit_Sold">10 Unit Sold</timetable-month-head>
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
                    <timetable-month-head id="nov">9 Units Sold</timetable-month-head>
                    <timetable-month-head id="nov_Unit_Sold">10 Unit Sold</timetable-month-head>
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
                    <timetable-month-head id="dec">9 Units Sold</timetable-month-head>
                    <timetable-month-head id="dec_Unit_Sold">10 Unit Sold</timetable-month-head>
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
                     <timetable-month-head id="totals">9 Units Sold</timetable-month-head>
                     <timetable-month-head id="month_totals">10 Unit Sold</timetable-month-head>
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

//模拟数据
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
                 {rId:'1',date:"2020-01", Units_Sold:"2",Unit_Sold_Stretch_Goal:"3",datesID:"1"},
                 {rId:'2',date:"2020-01", Units_Sold:"3.5",Unit_Sold_Stretch_Goal:"5",datesID:"2"},
                 {rId:'2',date:"2020-01", Units_Sold:"4",Unit_Sold_Stretch_Goal:"3",datesID:"2"},
                 {rId:'1',date:"2020-02", Units_Sold:"0.5",Unit_Sold_Stretch_Goal:"10",datesID:"3"},
                 {rId:'2',date:"2020-02", Units_Sold:"3",Unit_Sold_Stretch_Goal:"9",datesID:"4"},
                 {rId:'1',date:"2020-03", Units_Sold:"5.5",Unit_Sold_Stretch_Goal:"7",datesID:"5"},
                 {rId:'2',date:"2020-03", Units_Sold:"3",Unit_Sold_Stretch_Goal:"7",datesID:"6"},
                 {rId:'1',date:"2020-04", Units_Sold:"1.3",Unit_Sold_Stretch_Goal:"3",datesID:"7"},
                 {rId:'2',date:"2020-04", Units_Sold:"10",Unit_Sold_Stretch_Goal:"4",datesID:"8"},
                 {rId:'1',date:"2020-05", Units_Sold:"1.5",Unit_Sold_Stretch_Goal:"3",datesID:"9"},
                 {rId:'2',date:"2020-05", Units_Sold:"6.5",Unit_Sold_Stretch_Goal:"2",datesID:"10"},
                 {rId:'3',date:"2020-05", Units_Sold:"66",Unit_Sold_Stretch_Goal:"2",datesID:"10"},
          ]
};
            var revenue=revenueData.revenueDates;//主表
            var revenueMonth=revenueData.saleDates;//月表


            for(let item in revenue){
                console.log("主表：",revenue[item]);
                /*for(let item in revenueMonth){//item 表示json数组中某个对象*/
                    for(let j in revenueMonth){//j表示json对象中的key
                        /*console.log(j);*/

                        console.log("第二层循环：");
                        console.log(revenueMonth);
                        console.log(revenueMonth[j].date);
                        console.log(revenueMonth[j].rId);
                        /*console.log(revenue[item].rId);
                        console.log(revenueMonth[item].rId);*/
                        switch(revenueMonth[j].date){
                            case "2020-01":
                            console.log("一月份id：",revenueMonth[j].rId,"主要ID",revenue[j].rId);
                                if(revenue[item].rId==revenueMonth[j].rId){
                                    console.log(revenueMonth[j].date,revenue[item].Unit_Value_USD,revenueMonth[j].Units_Sold,revenueMonth[j].Unit_Sold_Stretch_Goal);
                                    monthDataUnitSold(revenueMonth[j].date,revenue[item].Unit_Value_USD,revenueMonth[j].Units_Sold,revenueMonth[j].Unit_Sold_Stretch_Goal);
                                }
                            break;
                            case "2020-02":
                            console.log("二月份id：",revenueMonth[item].rId,"主要ID",revenue[item].rId);
                                if(revenue[item].rId==revenueMonth[j].rId){
                                    console.log(revenueMonth[j].date,revenue[item].Unit_Value_USD,revenueMonth[j].Units_Sold,revenueMonth[j].Unit_Sold_Stretch_Goal);
                                    monthDataUnitSold(revenueMonth[j].date,revenue[item].Unit_Value_USD,revenueMonth[j].Units_Sold,revenueMonth[j].Unit_Sold_Stretch_Goal);
                                }
                            break;
                            case "2020-03":
                                console.log("三月份id：",revenueMonth[item].rId,"主要ID",revenue[item].rId);
                                if(revenue[item].rId==revenueMonth[j].rId){
                                    console.log(revenueMonth[j].date,revenue[item].Unit_Value_USD,revenueMonth[j].Units_Sold,revenueMonth[j].Unit_Sold_Stretch_Goal);
                                    monthDataUnitSold(revenueMonth[j].date,revenue[item].Unit_Value_USD,revenueMonth[j].Units_Sold,revenueMonth[j].Unit_Sold_Stretch_Goal);
                                }
                            break;
                            case "2020-04":
                                console.log("四月份id：",revenueMonth[item].rId,"主要ID",revenue[item].rId);
                                if(revenue[item].rId==revenueMonth[j].rId){
                                    console.log(revenueMonth[j].date,revenue[item].Unit_Value_USD,revenueMonth[j].Units_Sold,revenueMonth[j].Unit_Sold_Stretch_Goal);
                                    monthDataUnitSold(revenueMonth[j].date,revenue[item].Unit_Value_USD,revenueMonth[j].Units_Sold,revenueMonth[j].Unit_Sold_Stretch_Goal);
                                }
                            break;
                            case "2020-05":
                                console.log("五月份id：",revenueMonth[item].rId,"主要ID",revenue[item].rId);
                                if(revenue[item].rId==revenueMonth[j].rId){
                                    console.log(revenueMonth[j].date,revenue[item].Unit_Value_USD,revenueMonth[j].Units_Sold,revenueMonth[j].Unit_Sold_Stretch_Goal);
                                    monthDataUnitSold(revenueMonth[j].date,revenue[item].Unit_Value_USD,revenueMonth[j].Units_Sold,revenueMonth[j].Unit_Sold_Stretch_Goal);
                                }
                            break;
                        }


                        //满足条件:月份表中的为2020-01的数据
                       /*if(revenueMonth[item][j]=="2020-01"){//revenueMonth[item][j] 表示json中value*/
                            /*console.log("if判断111");
                            console.log(revenueMonth[item].rId);
                            console.log(revenue[item].rId);*/
                            //满足条件:主表中的rId等于月份表中的rId时
                            /*if(revenue[item].rId==revenueMonth[item].rId){*/
                                /*console.log("if判断222");
                                console.log("主表22：",revenue[item].rId,revenue[item].Unit_Value_USD);
                                console.log("月份22：",revenueMonth[item]);
                                console.log("月份22：",revenueMonth[item].Units_Sold,revenueMonth[item].Unit_Sold_Stretch_Goal);*/

                                /*月份：revenueMonth[item].date、
                                  主表列：revenue[item].Unit_Value_USD、
                                  月份表列：Units_Sold、Unit Sold (Stretch Goal)
                                */
                               /*monthDataUnitSold(revenueMonth[item].date,revenue[item].Unit_Value_USD,revenueMonth[item].Units_Sold,revenueMonth[item].Unit_Sold_Stretch_Goal);
                            }*/
                       /*}else if(revenueMonth[item][j]=="2020-02"){
                            console.log("//////二月if判断///////");
                            console.log(revenueMonth[item].rId);
                            console.log(revenue[item].rId);
                            //满足条件:主表中的rId等于月份表中的rId时
                            if(revenue[item].rId==revenueMonth[item].rId){
                                console.log("//////if判断222////////");
                                console.log("主表22：",revenue[item].rId,revenue[item].Unit_Value_USD);*/
                                /*console.log("月份22：",revenueMonth[item]);*/
                                /*console.log("月份22：",revenueMonth[item].Units_Sold,revenueMonth[item].Unit_Sold_Stretch_Goal);
                                var jValue=revenueMonth[item];//value所对应的对象
                                console.log("/////////////////////////////////////////////");*/
                                /*月份：revenueMonth[item].date、
                                  主表列：revenue[item].Unit_Value_USD、
                                  月份表列：Units_Sold、Unit Sold (Stretch Goal)
                                */
                                /*console.log(revenueMonth[item].date,revenue[item].Unit_Value_USD,revenueMonth[item].Units_Sold,revenueMonth[item].Unit_Sold_Stretch_Goal);
                               console.log("////////////////////////////////////结束////////////////////////////////////////")
                               monthDataUnitSold(revenueMonth[item].date,revenue[item].Unit_Value_USD,revenueMonth[item].Units_Sold,revenueMonth[item].Unit_Sold_Stretch_Goal);
                            }
                       }*/
                    }
                /*}*/
          }
            /*for(var i=0;i<monthData.length;i++){
                if(Object.keys(monthData[i])=="janMonth"){
                    console.log("一月");
                    for(let item in monthData[i].janMonth){

                        monthDataUnitSold(1000,monthData[i].janMonth[item].UnitSold,monthData[i].janMonth[item].UnitSoldStretchGoal);
                    }
                }

            };*/
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

            /*遍历月份表格
            月份表格的日期：rMonth、价格：price
            月份表的列：UnitSold(列)、UnitSoldStretchGoal(列)
            */
            function monthDataUnitSold(rMonth,price,UnitSold,UnitSoldStretchGoal){
                 console.log("形参：",rMonth,price,UnitSold,UnitSoldStretchGoal)
                 /*console.log(UnitSold);
                 console.log(UnitSoldStretchGoal);*/
                 let resultData=price*UnitSold;
                 let resultDataP=price*UnitSoldStretchGoal;

                 switch(rMonth){
                    case "2020-01":
                        console.log("go 2020-01：添加1月数据");
                        $(".jan timetable").append(`
                       <div class="timetable-data fanhuiBtn" data-slotID="1" data-column="2020-01"><input  oninput="updateInput(this,${price})" readonly="true" value="${UnitSold}"/></div>
                       <div class="timetable-data fanhuiBtn" data-slotID="2" data-column="2020-01"><input  oninput="updateInput(this,${price})" readonly="true" value="${UnitSoldStretchGoal}"/></div>
                       <div class="timetable-data" revenue_id="3" >${resultData}</div>
                       <div class="timetable-data" revenue_id="4">${resultDataP}</div>`);
                    break;
                    case "2020-02":
                        console.log("go 2020-02：添加二月数据");
                        $(".feb timetable").append(`
                       <div class="timetable-data fanhuiBtn" data-slotID="1" data-column="2020-02"><input  oninput="updateInput(this,${price})" readonly="true" value="${UnitSold}"/></div>
                       <div class="timetable-data fanhuiBtn" data-slotID="2" data-column="2020-02"><input  oninput="updateInput(this,${price})" readonly="true" value="${UnitSoldStretchGoal}"/></div>
                       <div class="timetable-data" revenue_id="3" >${resultData}</div>
                       <div class="timetable-data" revenue_id="4">${resultDataP}</div>`);
                    break;
                    case "2020-03":
                        console.log("go 2020-03：添加三月数据");
                        $(".mar timetable").append(`
                       <div class="timetable-data fanhuiBtn" data-slotID="1" data-column="2020-03"><input  oninput="updateInput(this,${price})" readonly="true" value="${UnitSold}"/></div>
                       <div class="timetable-data fanhuiBtn" data-slotID="2" data-column="2020-03"><input  oninput="updateInput(this,${price})" readonly="true" value="${UnitSoldStretchGoal}"/></div>
                       <div class="timetable-data" revenue_id="3" >${resultData}</div>
                       <div class="timetable-data" revenue_id="4">${resultDataP}</div>`);
                    break;
                    case "2020-04":
                        console.log("go 2020-03：添加三月数据");
                        $(".apr timetable").append(`
                       <div class="timetable-data fanhuiBtn" data-slotID="1" data-column="2020-04"><input  oninput="updateInput(this,${price})" readonly="true" value="${UnitSold}"/></div>
                       <div class="timetable-data fanhuiBtn" data-slotID="2" data-column="2020-03"><input  oninput="updateInput(this,${price})" readonly="true" value="${UnitSoldStretchGoal}"/></div>
                       <div class="timetable-data" revenue_id="3" >${resultData}</div>
                       <div class="timetable-data" revenue_id="4">${resultDataP}</div>`);
                    break;
                    case "2020-05":
                        console.log("go 2020-03：添加三月数据");
                        $(".may timetable").append(`
                       <div class="timetable-data fanhuiBtn" data-slotID="1" data-column="2020-03"><input  oninput="updateInput(this,${price})" readonly="true" value="${UnitSold}"/></div>
                       <div class="timetable-data fanhuiBtn" data-slotID="2" data-column="2020-03"><input  oninput="updateInput(this,${price})" readonly="true" value="${UnitSoldStretchGoal}"/></div>
                       <div class="timetable-data" revenue_id="3" >${resultData}</div>
                       <div class="timetable-data" revenue_id="4">${resultDataP}</div>`);
                    break;

                 }


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
            //弹出饼状图形数据
            $("#pie-data").click(function(){
                 $('#revenue_Container').addClass('panel-popup-active loading');
                let randAppID = paneljs.genID(5);
                $('#revenue_Container').append(`<div id="app-`+randAppID+`"></div>`);
                paneljs.fetch({type:'app', call:'pie-data-revenue',postData:{}}, function (data) {
                            $('#revenue_Container').removeClass('loading');
                            $('#app-'+randAppID).append(data.data);
                });

            })

            //弹出曲线图形数据
            $("#curve-data").click(function(){
                alert("pie-data，yes")

            })

            //编辑Revenue
            $(document).on('click',"#update_Revenue",function(){
                console.log("编辑");
                var dataId=$(this).attr("data-id");
                var products=$(this).next().text();
                var serviceData=$(this).next().next().text();
                var clientsData=$(this).next().next().next().text();
                var revenueOrigin=$(this).next().next().next().next().text();
                var revenueDestination=$(this).next().next().next().next().next().text();
                var Unit_Value_USD=$(this).next().next().next().next().next().next().text();
                var Unit_Value_Local_Currency=$(this).next().next().next().next().next().next().next().text();
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