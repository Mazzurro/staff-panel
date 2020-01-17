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
    .addAccount{
       	margin: 20px 20px 20px 0px;
    }
    .addAuthority{
       	margin: 20px 0px 20px 0px;
    }
    #searchRevenue {
	    display: flex;
	    font-size: 18px;
	}
    #search-container{
        display: flex;
        width: 50%;
        border: 1px solid var(--dragon-gold);
        border-radius: 4px;
        overflow: hidden;
        cursor: pointer;
        margin: 20px 0px;
    }
    .timetable1{
        display: grid !important;
        background: rgba(26, 26, 26, 0.98);
        opacity: 1;
        transition: opacity 2s;
        grid-template-columns: 60px 60px repeat(11, 228px );
        /*grid-template-rows: 55px 80px auto;*/
        /*overflow: auto;
        overflow:visible;*/
    }
    .timetable2{
        display: grid !important;
        background: rgba(26, 26, 26, 0.98);
        opacity: 1;
        transition: opacity 2s;
        grid-template-columns: 228px 100px repeat(20, 100px );
        /*grid-template-rows: 55px 80px auto;*/
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
    	height: 35px;
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
    .mainContent3{
        overflow: auto;
    }
    timetable-header{
        position: sticky;
        position: -webkit-sticky;
        white-space: pre;
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
    .content{
    	width: 2228px;
    }
    .content1{
        display: grid;
	    /*padding-left: 60px;*/
	    grid-template-columns: 228px 100px repeat(20, 100px );
	    height: 35px;
	    line-height: 35px;
	    color: white;
	    background: #96031a;
	    position: relative;
    }
    .content2{
        display:grid;
        height: 35px;
        grid-template-columns: 228px 100px repeat(20, 100px );
        background:rgba(26, 26, 26, 0.98);
        position:relative;
    }
    .content3{
        display:grid;
        height: 35px;
        grid-template-columns: 228px 100px repeat(20, 100px );
        background:rgba(26, 26, 26, 0.98);
        position:relative;
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
        	<div id="searchRevenue">
	    		<button class="addRunRate">Create run rate</button>
		        <button class="addAccount">Add new Social Account</button>
		        <button class="addAuthority">Authority Management</button>
	        	<select class="bg-search-select" style="width: 20px;margin: 20px 20px 20px 0;">
	        		<ul>
	        			<li>Please select an account</li>
	        		</ul>
	            </select>
		        	<!--<li>Please select an account</li>
		        	<li>Please select an account</li>
		        	<li>Please select an account</li>
		        	<li>Please select an account</li>
		        	<li>Please select an account</li>-->
		        </ul>
		        <div id="search-container">
		            <select class="bg-search-select">
		                <option class="dd-product" value="City, Country">City, Country</option>
		                <option class="dd-service" value="City Size">City Size</option>
		                <option class="dd-client" value="Priority">Priority</option>
		            </select>
		            <input id="search-box" type="search" name="search" placeholder="Search...">
		            <button style="margin:0px"><i class="fa fa-search search-icon"></i></button>
		        </div>
	    	</div>
            <div class="mainContent2">
                <timetable class="timetable1">
                    <timetable-header class="timetable-options"><span>Delete</span></timetable-header>
                    <timetable-header class="timetable-options2"><span>Editor</span></timetable-header>
                    <timetable-header><span>City, Country</span></timetable-header>
	                <timetable-header><span>City Size</span></timetable-header>
	                <timetable-header><span>Current Followers</span></timetable-header>
	                <timetable-header><span>Starting Month &amp;Year</span></timetable-header>
	                <timetable-header><span style="line-height: 26px;">of Followers Needed to&#10;Start a Community</span></timetable-header>
	                <timetable-header><span style="line-height: 26px;">Goal Date for Community&#10;Requirement</span></timetable-header>
	                <timetable-header><span>Priority (1 – 10) (High to Low)</span></timetable-header>
	                <timetable-header><span>Type of Growth</span></timetable-header>
	                <timetable-header><span>Population (EST in 2019)</span></timetable-header>
	                <timetable-header><span style="line-height: 26px;">EST of Population that&#10; Loves Film</span></timetable-header>
	                <timetable-header><span>EST Max Film Loving Followers</span></timetable-header>
                </timetable>
            </div>
            <div class="mainContent3" style="margin-top: 400px;">
            	 <timetable class="timetable2">
                    <timetable-header><span>City, Country</span></timetable-header>
	                <timetable-header><span>Mar-20</span></timetable-header>
	                <timetable-header><span>Apr-20</span></timetable-header>
	                <timetable-header><span>May-20</span></timetable-header>
	                <timetable-header><span>Jun-20</span></timetable-header>
	                <timetable-header><span>Jul-20</span></timetable-header>
	                <timetable-header><span>Aug-20</span></timetable-header>
	                <timetable-header><span>Sep-20</span></timetable-header>
	                <timetable-header><span>Oct-20</span></timetable-header>
	                <timetable-header><span>Nov-20</span></timetable-header>
	                <timetable-header><span>Dec-20</span></timetable-header>
	                <timetable-header><span>Jan-21</span></timetable-header>
	                <timetable-header><span>Feb-21</span></timetable-header>
	                <timetable-header><span>Mar-21</span></timetable-header>
	                <timetable-header><span>Apr-21</span></timetable-header>
	                <timetable-header><span>May-21</span></timetable-header>
	                <timetable-header><span>Jun-21</span></timetable-header>
	                <timetable-header><span>Jul-21</span></timetable-header>
	                <timetable-header><span>Aug-21</span></timetable-header>
	                <timetable-header><span>Sep-21</span></timetable-header>
	                <timetable-header><span>Oct-21</span></timetable-header>
                </timetable>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
$(document).ready(function () {
        $('.addRunRate').click(function () {
            $('#run-rate').addClass('panel-popup-active loading');
            let randAppID = paneljs.genID(5);
            $('#run-rate').append(`<div id="app-`+randAppID+`"></div>`);
            paneljs.fetch({type:'app', call:'newMedia'}, function (data) {
                        $('#run-rate').removeClass('loading');
                        $('#app-'+randAppID).append(data.data);
            });
        });
        $('.addAccount').click(function () {
            $('#run-rate').addClass('panel-popup-active loading');
            let randAppID = paneljs.genID(5);
            $('#run-rate').append(`<div id="app-`+randAppID+`"></div>`);
            paneljs.fetch({type:'app', call:'newAccount'}, function (data) {
                        $('#run-rate').removeClass('loading');
                        $('#app-'+randAppID).append(data.data);
            });
        });
        $('.addAuthority').click(function () {
            $('#run-rate').addClass('panel-popup-active loading');
            let randAppID = paneljs.genID(5);
            $('#run-rate').append(`<div id="app-`+randAppID+`"></div>`);
            paneljs.fetch({type:'app', call:'newAuthority', postData: {}}, function (data) {
                        $('#run-rate').removeClass('loading');
                        $('#app-'+randAppID).append(data.data);
            });
        });
        $.ajax({
            type:"POST",
            url:"http://192.168.50.90/staff/api/Socialmedia/List",
            success:function(data){
        		for(let item in data){
        				var City_size = "";
        				var Type_of = ""
        			if(data[item].population_total < 499999){
        				City_size = "Small City Population"
        			}else if(500000<=data[item].population_total < 999999){
        				City_size = "Medium City Population"
        			}else{
        				City_size = "Large City Population"
        			}
        			if(data[item].location_growth == 1){
        				Type_of = "Exponential"
        			}else{
        				Type_of = "Linear"
        			}
                    $('.timetable1').append(`
                     <div class="timetable-data runRate-${data[item].location_id}" id="delete_run_rate" run_rate_id="${data[item].location_id}" >
                        <span class="iconfont icon-delete" ></span>
                     </div>
                     <div class="timetable-data Editor_runRate runRate-${data[item].location_id}"id="update_run_rate"  run_rate_id="${data[item].location_id}">
                        <span id="Editor_run_rate"  class="iconfont icon-editor"></span>
                     </div>
                     <div class="timetable-data runRate-${data[item].location_id}" country_id_value="${data[item].location_id}"> ${data[item].location_city},${data[item].location_country} </div>
                     <div class="timetable-data runRate-${data[item].location_id}" roleID_value="${data[item].roleID}">${City_size}</div>
                     <div class="timetable-data runRate-${data[item].location_id}">${data[item].followers_total}</div>
                     <div class="timetable-data runRate-${data[item].location_id}">${data[item].followers_date}</div>
                     <div class="timetable-data runRate-${data[item].location_id}">${data[item].location_required_followers}</div>
                     <div class="timetable-data runRate-${data[item].location_id}">${data[item].location_required_date}</div>
                     <div class="timetable-data runRate-${data[item].location_id}">${data[item].location_priority}</div>
                     <div class="timetable-data runRate-${data[item].location_id}">${Type_of}</div>
                     <div class="timetable-data runRate-${data[item].location_id}">${data[item].population_total}</div>
                     <div class="timetable-data runRate-${data[item].location_id}">${data[item].location_film_lovers}%</div>
                     <div class="timetable-data runRate-${data[item].location_id}">${data[item].EST_Max_Film_Loving_Followers}</div>
                     `)
                }
           }
        })
        var arr = ["Bangalore,India","Mumbai,India","Calcutta,India","Hong Kong","Madrid"];
        for(let i = 0;i<arr.length;i++){
        	$('.mainContent3').append(`
        		<div class="content">
                	<div class="content1"><div class="timetable-data timetable-options" style="background:#96031a;color:white">${arr[i]}</div></div>
	                <div class="content2">
	                	<div class="timetable-data timetable-options">Start of Month Follower Count</div>
	                </div>
	                <div class="content2">
	                	<div class="timetable-data timetable-options"># of New Followers</div>
	                </div>
	                <div class="content2">
	                	<div class="timetable-data timetable-options">End of Month Follower Count</div>
	                </div>
	                <div class="content2">
	                	<div class="timetable-data timetable-options">High Reach Count</div>
	                </div>
	                <div class="content2">
	                	<div class="timetable-data timetable-options">Average Reach Count</div>
	                </div>
	                <div class="content2">
	                	<div class="timetable-data timetable-options">Low Reach Count</div>
	                </div>
	                <div class="content3">
	                	<div class="timetable-data timetable-options"></div>
	                </div>
                </div>
        	
        	`)
        }
        var arr2 = [
        	[17,20,22,25,29,32,37,41,47,53,60,68,77,87,99,112,127,143,162,184],
        	[3,2,3,4,3,5,4,6,6,7,8,9,10,12,13,15,16,19,22,25],
        	[20,22,25,29,32,37,41,47,53,60,68,77,87,99,112,127,143,162,184,209],
        	[77,90,99,113,131,144,167,185,212,239,270,306,347,392,446,504,572,644,729,828],
        	[51,60,66,75,87,96,111,123,141,159,180,204,231,261,297,336,381,429,486,552],
        	[26,30,33,38,44,48,56,62,71,80,90,102,116,131,149,168,191,215,243,276],
        	[17,20,22,25,29,32,37,41,47,53,60,68,77,87,99,112,127,143,162,184],
        	[3,2,3,4,3,5,4,6,6,7,8,9,10,12,13,15,16,19,22,25],
        	[20,22,25,29,32,37,41,47,53,60,68,77,87,99,112,127,143,162,184,209],
        	[77,90,99,113,131,144,167,185,212,239,270,306,347,392,446,504,572,644,729,828],
        	[51,60,66,75,87,96,111,123,141,159,180,204,231,261,297,336,381,429,486,552],
        	[26,30,33,38,44,48,56,62,71,80,90,102,116,131,149,168,191,215,243,276],
        	[17,20,22,25,29,32,37,41,47,53,60,68,77,87,99,112,127,143,162,184],
        	[3,2,3,4,3,5,4,6,6,7,8,9,10,12,13,15,16,19,22,25],
        	[20,22,25,29,32,37,41,47,53,60,68,77,87,99,112,127,143,162,184,209],
        	[77,90,99,113,131,144,167,185,212,239,270,306,347,392,446,504,572,644,729,828],
        	[51,60,66,75,87,96,111,123,141,159,180,204,231,261,297,336,381,429,486,552],
        	[26,30,33,38,44,48,56,62,71,80,90,102,116,131,149,168,191,215,243,276],
        	[17,20,22,25,29,32,37,41,47,53,60,68,77,87,99,112,127,143,162,184],
        	[3,2,3,4,3,5,4,6,6,7,8,9,10,12,13,15,16,19,22,25],
        	[20,22,25,29,32,37,41,47,53,60,68,77,87,99,112,127,143,162,184,209],
        	[77,90,99,113,131,144,167,185,212,239,270,306,347,392,446,504,572,644,729,828],
        	[51,60,66,75,87,96,111,123,141,159,180,204,231,261,297,336,381,429,486,552],
        	[26,30,33,38,44,48,56,62,71,80,90,102,116,131,149,168,191,215,243,276],
        	[17,20,22,25,29,32,37,41,47,53,60,68,77,87,99,112,127,143,162,184],
        	[3,2,3,4,3,5,4,6,6,7,8,9,10,12,13,15,16,19,22,25],
        	[20,22,25,29,32,37,41,47,53,60,68,77,87,99,112,127,143,162,184,209],
        	[77,90,99,113,131,144,167,185,212,239,270,306,347,392,446,504,572,644,729,828],
        	[51,60,66,75,87,96,111,123,141,159,180,204,231,261,297,336,381,429,486,552],
        	[26,30,33,38,44,48,56,62,71,80,90,102,116,131,149,168,191,215,243,276],
        ]
        var con = $('.content2')
        for(let j = 0;j<arr2.length;j++){
        	switch(j){
        		case 0:
        		for (let k = 0;k<arr2[0].length;k++) {
	    			$('.content2:eq(0)').append(`
		    			<div class="timetable-data">${arr2[0][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 1:
        		for (let k = 0;k<arr2[1].length;k++) {
	    			$('.content2:eq(1)').append(`
		    			<div class="timetable-data">${arr2[1][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 2:
        		for (let k = 0;k<arr2[2].length;k++) {
	    			$('.content2:eq(2)').append(`
		    			<div class="timetable-data">${arr2[2][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 3:
        		for (let k = 0;k<arr2[3].length;k++) {
	    			$('.content2:eq(3)').append(`
		    			<div class="timetable-data">${arr2[3][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 4:
        		for (let k = 0;k<arr2[4].length;k++) {
	    			$('.content2:eq(4)').append(`
		    			<div class="timetable-data">${arr2[4][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 5:
        		for (let k = 0;k<arr2[5].length;k++) {
	    			$('.content2:eq(5)').append(`
		    			<div class="timetable-data">${arr2[5][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 6:
        		for (let k = 0;k<arr2[6].length;k++) {
	    			$('.content2:eq(6)').append(`
		    			<div class="timetable-data">${arr2[6][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 7:
        		for (let k = 0;k<arr2[7].length;k++) {
	    			$('.content2:eq(7)').append(`
		    			<div class="timetable-data">${arr2[7][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 8:
        		for (let k = 0;k<arr2[8].length;k++) {
	    			$('.content2:eq(8)').append(`
		    			<div class="timetable-data">${arr2[8][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 9:
        		for (let k = 0;k<arr2[9].length;k++) {
	    			$('.content2:eq(9)').append(`
		    			<div class="timetable-data">${arr2[9][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 10:
        		for (let k = 0;k<arr2[10].length;k++) {
	    			$('.content2:eq(10)').append(`
		    			<div class="timetable-data">${arr2[10][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 11:
        		for (let k = 0;k<arr2[11].length;k++) {
	    			$('.content2:eq(11)').append(`
		    			<div class="timetable-data">${arr2[11][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 12:
        		for (let k = 0;k<arr2[12].length;k++) {
	    			$('.content2:eq(12)').append(`
		    			<div class="timetable-data">${arr2[12][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 13:
        		for (let k = 0;k<arr2[13].length;k++) {
	    			$('.content2:eq(13)').append(`
		    			<div class="timetable-data">${arr2[13][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 14:
        		for (let k = 0;k<arr2[14].length;k++) {
	    			$('.content2:eq(14)').append(`
		    			<div class="timetable-data">${arr2[14][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 15:
        		for (let k = 0;k<arr2[15].length;k++) {
	    			$('.content2:eq(15)').append(`
		    			<div class="timetable-data">${arr2[15][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 16:
        		for (let k = 0;k<arr2[16].length;k++) {
	    			$('.content2:eq(16)').append(`
		    			<div class="timetable-data">${arr2[16][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 17:
        		for (let k = 0;k<arr2[17].length;k++) {
	    			$('.content2:eq(17)').append(`
		    			<div class="timetable-data">${arr2[17][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 18:
        		for (let k = 0;k<arr2[18].length;k++) {
	    			$('.content2:eq(18)').append(`
		    			<div class="timetable-data">${arr2[18][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 19:
        		for (let k = 0;k<arr2[19].length;k++) {
	    			$('.content2:eq(19)').append(`
		    			<div class="timetable-data">${arr2[19][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 20:
        		for (let k = 0;k<arr2[20].length;k++) {
	    			$('.content2:eq(20)').append(`
		    			<div class="timetable-data">${arr2[20][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 21:
        		for (let k = 0;k<arr2[21].length;k++) {
	    			$('.content2:eq(21)').append(`
		    			<div class="timetable-data">${arr2[21][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 22:
        		for (let k = 0;k<arr2[22].length;k++) {
	    			$('.content2:eq(22)').append(`
		    			<div class="timetable-data">${arr2[22][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 23:
        		for (let k = 0;k<arr2[23].length;k++) {
	    			$('.content2:eq(23)').append(`
		    			<div class="timetable-data">${arr2[23][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 24:
        		for (let k = 0;k<arr2[24].length;k++) {
	    			$('.content2:eq(24)').append(`
		    			<div class="timetable-data">${arr2[24][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 25:
        		for (let k = 0;k<arr2[25].length;k++) {
	    			$('.content2:eq(25)').append(`
		    			<div class="timetable-data">${arr2[25][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 26:
        		for (let k = 0;k<arr2[26].length;k++) {
	    			$('.content2:eq(26)').append(`
		    			<div class="timetable-data">${arr2[26][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 27:
        		for (let k = 0;k<arr2[27].length;k++) {
	    			$('.content2:eq(27)').append(`
		    			<div class="timetable-data">${arr2[27][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 28:
        		for (let k = 0;k<arr2[28].length;k++) {
	    			$('.content2:eq(28)').append(`
		    			<div class="timetable-data">${arr2[28][k]}</div>
		    		`) 
	    		}
	    		break;
	    		case 29:
        		for (let k = 0;k<arr2[29].length;k++) {
	    			$('.content2:eq(29)').append(`
		    			<div class="timetable-data">${arr2[29][k]}</div>
		    		`) 
	    		}
	    		break;
        	}
        }
});
</script>