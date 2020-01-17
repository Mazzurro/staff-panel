<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
</head>
<body>
    <div id='planning'>
        <div class='new'>
            <button class='add-staff'>Add a new staff planning</button>
            <div class=lookUpBox>
                <span>Look up Through Month</span>
                <span>From:</span>
                <input type="text" class='lookUpFrom' placeholder='YYYY-MM'>
                <span>To:</span>
                <input type="text" class='lookUpTo' placeholder='YYYY-MM'>
                <button class='lookUp'>Confirm</button>
            </div>
        </div>
        <div class='mainTable'>
            <div class='top'>
                <div class='optional'></div>
                <div class='optionalx'></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div class='month monthTT'></div>
            </div>
            <div class='header'> 
                <div class='optional'><span>Delete</span></div>
                <div class='optionalx'><span>Editor</span></div>
                <div><span>Product</span></div>
                <div><span>Capability</span></div>
                <div><span>Service</span></div>
                <div><span>Role</span></div>
                <div><span>Location</span></div>
                <div><span>Name</span></div>
                <div><span>Location Manager</span></div>
                <div><span>Functional Manager</span></div>
                <div><span>Join Date</span></div>
                <div><span>Ending Date</span></div>
                <div><span>Run Rate(/Month)</span></div>
                <div><span>Salary(/Month)</span></div>
                <div class='month'>
                    <div class='monthItem'><span>Run Rate(January 2019)</span></div>
                    <div class='monthItem'><span>Salary(January 2019)</span></div>
                    <div class='monthItem'><span>Difference(January 2019)</span></div>
                    <div class='monthItem'><span>Run Rate(February 2019)</span></div>
                    <div class='monthItem'><span>Salary(February 2019)</span></div>
                    <div class='monthItem'><span>Difference(February 2019)</span></div>
                    <div class='monthItem'><span>Run Rate(March 2019)</span></div>
                    <div class='monthItem'><span>Salary(March 2019)</span></div>
                    <div class='monthItem'><span>Difference(March 2019)</span></div>
                    <div class='monthItem'><span>Run Rate(April 2019)</span></div>
                    <div class='monthItem'><span>Salary(April 2019)</span></div>
                    <div class='monthItem'><span>Difference(April 2019)</span></div>
                    <div class='monthItem'><span>Run Rate(May 2019)</span></div>
                    <div class='monthItem'><span>Salary(May 2019)</span></div>
                    <div class='monthItem'><span>Difference(May 2019)</span></div>
                    <div class='monthItem'><span>Run Rate(June 2019)</span></div>
                    <div class='monthItem'><span>Salary(June 2019)</span></div>
                    <div class='monthItem'><span>Difference(June 2019)</span></div>
                    <div class='monthItem'><span>Run Rate(July 2019)</span></div>
                    <div class='monthItem'><span>Salary(July 2019)</span></div>
                    <div class='monthItem'><span>Difference(July 2019)</span></div>
                    <div class='monthItem'><span>Run Rate(August 2019)</span></div>
                    <div class='monthItem'><span>Salary(August 2019)</span></div>
                    <div class='monthItem'><span>Difference(August 2019)</span></div>
                    <div class='monthItem'><span>Run Rate(September 2019)</span></div>
                    <div class='monthItem'><span>Salary(September 2019)</span></div>
                    <div class='monthItem'><span>Difference(September 2019)</span></div>
                    <div class='monthItem'><span>Run Rate(October 2019)</span></div>
                    <div class='monthItem'><span>Salary(October 2019)</span></div>
                    <div class='monthItem'><span>Difference(October 2019)</span></div>
                    <div class='monthItem'><span>Run Rate(November 2019)</span></div>
                    <div class='monthItem'><span>Salary(November 2019)</span></div>
                    <div class='monthItem'><span>Difference(November 2019)</span></div>
                    <div class='monthItem'><span>Run Rate(December 2019)</span></div>
                    <div class='monthItem'><span>Salary(December 2019)</span></div>
                    <div class='monthItem'><span>Difference(December 2019)</span></div>
                    <div class='monthItem'><span>Run Rate(Total 2019)</span></div>
                    <div class='monthItem'><span>Salary(Total 2019)</span></div>
                    <div class='monthItem'><span>Difference(Total 2019)</span></div>
                </div>
            </div>
            <div class='content'></div>
        </div>
    </div>
</body>
<script>
// var fData={
//     productIT:{
//         name:'IT product Zero',
//         id:1,
//         capability:{
//             mokeUp:{
//                 name:'Moke up',
//                 id:2,
//                 service:{
//                     picture:{
//                         name:'picture',
//                         id:4,
//                         member:[
//                             {
//                                 department:'Design',
//                                 role:'Designer',
//                                 name:'Seven'
//                             },{
//                                 department:'Design',
//                                 role:'Designer',
//                                 name:'Eight'
//                             }
//                         ]
//                     },
//                     composition:{
//                         name:'composition',
//                         id:5,
//                         member:[
//                             {
//                                 departmeng:'Design',
//                                 role:'Designer',
//                                 name:'Kevin'
//                             },{
//                                 departmeng:'Design',
//                                 role:'Designer',
//                                 name:'Eleven'
//                             }
//                         ]
//                     }
//                 }
//             },
//             webDevelop:{
//                 name:'Web Develop',
//                 id:3,
//                 service:{
//                     front:{
//                         name:'Front End',
//                         id:6,
//                         member:[
//                             {
//                                 department:'IT',
//                                 role:'Front-end Engineer',
//                                 name:'Cody'
//                             },{
//                                 department:'IT',
//                                 role:'Front-end Engineer',
//                                 name:'Just'
//                             },{
//                                 department:'IT',
//                                 role:'Front-end Engineer',
//                                 name:'Yin'
//                             },{
//                                 department:'IT',
//                                 role:'Front-end Engineer',
//                                 name:'Yin'
//                             },{
//                                 department:'IT',
//                                 role:'Front-end Engineer',
//                                 name:'Yin'
//                             },{
//                                 department:'IT',
//                                 role:'Front-end Engineer',
//                                 name:'Yin'
//                             },{
//                                 department:'IT',
//                                 role:'Front-end Engineer',
//                                 name:'Yin'
//                             },{
//                                 department:'IT',
//                                 role:'Front-end Engineer',
//                                 name:'Yin'
//                             },{
//                                 department:'IT',
//                                 role:'Front-end Engineer',
//                                 name:'Yin'
//                             }
//                         ]
//                     },
//                     back:{
//                         name:'Back End',
//                         id:7,
//                         member:[
//                             {
//                                 department:'IT',
//                                 role:'Back-end Engineer',
//                                 name:'Ma'
//                             }
//                         ]
//                     }
//                 }
//             }
//         }
//     }
// }
//loading list data
function getMonthlyData(sDate,eDate){
    var sYear=parseInt(sDate.split('-')[0])
    var sMonth=parseInt(sDate.split('-')[1])
    var eYear=parseInt(eDate.split('-')[0])
    var eMonth=parseInt(eDate.split('-')[1])
    var monthLength=(eYear-sYear)*12+(eMonth-sMonth)
    var allMonth=[],year,month
    console.log(sYear,sMonth,eYear,eMonth,monthLength)
    for(year=sYear;year<eYear;){
        for(month=sMonth;month<=12;month++){
            allMonth.push(year+'-'+(month<10?'0'+month:month))
            if(month==12){
                year++
            }
        }
    }
    if(sYear==eYear){
        month=sMonth
    }else{
        month=1
    }
    for(;month<=eMonth;month++){
        allMonth.push(year+'-'+(month<10?'0'+month:month) )
    }
    console.log(allMonth)
    $.ajax({
        type:'POST',
        url:'http://192.168.50.90/staff/api/staffing/getTree',
        data:{
            joinDate:sDate,
            leaveDate:eDate
        },
        success:function(res){
            console.log(res)
            $('.content').children().remove()
            $('.monthContent').children().remove()
            $('.monthTT').children().remove()
            $('.content').append(`
                <div class='deleteIcon item'></div>
                <div class='editorIcon item'></div>
                <div class='productContent item'></div>
                <div class='monthContent'></div>
            `)
            var mm=['2019-01','2019-02','2019-03','2019-04','2019-05','2019-06','2019-07','2019-08','2019-09','2019-10','2019-11','2019-12'],
            ttRR=[0,0,0,0,0,0,0,0,0,0,0,0],
            ttSlr=[0,0,0,0,0,0,0,0,0,0,0,0],
            ttDfr=[0,0,0,0,0,0,0,0,0,0,0,0],
            fnRR=0,
            fnSlr=0,
            fnDfr=0
            for(let a in res){
                if(res[a].son){
                    $('.productContent').append(`
                        <div class='product name pro${res[a].typeID}'><span>${res[a].title}</span></div>
                        <div class='item productDe pr${res[a].typeID}'></div>
                    `)
                    for(let b in res[a].son){
                        var item=res[a].son
                        if(item[b].son){
                            $(`.pr${res[a].typeID}`).append(`
                                <div class='capability name'><span>${item[b].title}</span></div>
                                <div class='item capabilityDe ca${item[b].typeID}'></div>
                            `)
                            for(let c in item[b].son){
                                var itemx=item[b].son
                                if(itemx[c].staff){
                                    $(`.ca${item[b].typeID}`).append(`
                                        <div class='service name'><span>${itemx[c].title}</span></div>
                                        <div class='item serviceDe se${itemx[c].typeID}'></div>
                                    `)
                                    for(let d in itemx[c].staff){
                                        var itemy=itemx[c].staff
                                        var role,
                                        fullName,
                                        runrate,
                                        joinDate,
                                        leaveDate,
                                        salary,
                                        locationManager,
                                        functionalManager,
                                        tyRR=0,
                                        tySlr=0,
                                        tyDfr=0
                                        for(let i in itemy[d].roles){
                                            role=itemy[d].roles[i].name
                                        }
                                        itemy[d].middleName?
                                            fullName=`${itemy[d].firstName} ${itemy[d].middleName} ${itemy[d].lastName}`:
                                            fullName=`${itemy[d].firstName} ${itemy[d].lastName}`
                                        for(let j in itemy[d].RunRate){
                                            if(itemy[d].RunRate[j]){
                                                runrate='USD$'+itemy[d].RunRate[j]
                                            }else{
                                                runrate='USD$0'
                                            }  
                                        }
                                        itemy[d].joinDate?
                                            joinDate=itemy[d].joinDate:
                                            joinDate='——'
                                        itemy[d].leaveDate?
                                            leaveDate=itemy[d].leaveDate:
                                            leaveDate='——'
                                        itemy[d].LocationManager.name?
                                            locationManager=itemy[d].LocationManager.name:
                                            locationManager='——'
                                        itemy[d].FunctionalManager.name?
                                            functionalManager=itemy[d].FunctionalManager.name:
                                            functionalManager='——'
                                        itemy[d].salary?
                                            salary='USD$'+itemy[d].salary:
                                            salary='USD$0'
                                        $(`.se${itemx[c].typeID}`).append(`
                                            <div class='role name'><span>${role}</span></div>
                                            <div class='location name'><span>${itemy[d].Country_Name}</span></div>
                                            <div class='fullName name'><span>${fullName}</span></div>
                                            <div class='locationM name'><span>${locationManager}</span></div>
                                            <div class='functionalM name'><span>${functionalManager}</span></div>
                                            <div class='joinD name'><span>${joinDate}</span></div>
                                            <div class='endingD name'><span>${leaveDate}</span></div>
                                            <div class='runR name'><span>${runrate}</span></div>
                                            <div class='salary name'><span>${salary}</span></div>
                                        `)
                                        $('.deleteIcon').append(`
                                            <div class='delIcon name' data-id='${itemy[d].staffID}'><span class='icon-delete iconfont'></span></div>
                                        `)
                                        $('.editorIcon').append(`
                                            <div class='ediIcon name' data-id='${itemy[d].staffID}'><span class='icon-editor iconfont'></span></div>
                                        `)
                                        for(let i in mm){
                                            if(mm[i]<joinDate){
                                                $('.monthContent').append(`
                                                    <div class='monthContentMonth'>
                                                        <div class='monthContentItem name black'><span>——</span></div>
                                                        <div class='monthContentItem name black'><span>——</span></div>
                                                        <div class='monthContentItem name'><span>——</span></div>
                                                    </div>    
                                                `)
                                            }else{
                                                $('.monthContent').append(`
                                                    <div class='monthContentMonth'>
                                                        <div class='monthContentItem name black'><span>${runrate}</span></div>
                                                        <div class='monthContentItem name black'><span>${salary}</span></div>
                                                        <div class='monthContentItem name'><span>${salary.substring(4)-runrate.substring(4)?'USD$'+(salary.substring(4)-runrate.substring(4)):'——'}</span></div>
                                                    </div>    
                                                `)
                                                if(parseInt(runrate.substring(4))){
                                                    ttRR[i]+=parseInt(runrate.substring(4))
                                                    tyRR+=parseInt(runrate.substring(4))
                                                }
                                                if(parseInt(salary.substring(4))){
                                                    ttSlr[i]+=parseInt(salary.substring(4))
                                                    tySlr+=parseInt(salary.substring(4))
                                                }
                                            } 
                                        }
                                        tyDfr=tySlr-tyRR
                                        $('.monthContent').append(`
                                            <div class='monthContentMonth'>
                                                <div class='monthContentItem name black'><span>USD$${tyRR}</span></div>
                                                <div class='monthContentItem name black'><span>USD$${tySlr}</span></div>
                                                <div class='monthContentItem name'><span>USD$${tyDfr}</span></div>
                                            </div>  
                                        `)
                                    }
                                }else{
                                    $(`.pr${res[a].typeID}`).remove()
                                    $(`.pro${res[a].typeID}`).remove()
                                } 
                            }
                        } 
                    } 
                }  
            }
            for(let i in ttDfr){
                ttDfr[i]=ttSlr[i]-ttRR[i]
                fnRR+=ttRR[i]
                fnSlr+=ttSlr[i]
                fnDfr+=ttDfr[i]
                $('.monthTT').append(`
                    <div><span>USD$${ttRR[i]}</span></div>
                    <div><span>USD$${ttSlr[i]}</span></div>
                    <div><span>USD$${ttDfr[i]}</span></div>
                `)
            }
            $('.monthTT').append(`
                <div><span>USD$${fnRR}</span></div>
                <div><span>USD$${fnSlr}</span></div>
                <div><span>USD$${fnDfr}</span></div>
            `)
            console.log(ttRR,ttSlr,ttDfr)
        }
    })
}
$.ajax({
    type:'GET',
    url:'http://192.168.50.90/staff/api/staffing/getTree',
    success:function(res){
        console.log(res)
        $('.content').append(`
            <div class='deleteIcon item'></div>
            <div class='editorIcon item'></div>
            <div class='productContent item'></div>
            <div class='monthContent'></div>
        `)
        var mm=['2019-01','2019-02','2019-03','2019-04','2019-05','2019-06','2019-07','2019-08','2019-09','2019-10','2019-11','2019-12'],
        ttRR=[0,0,0,0,0,0,0,0,0,0,0,0],
        ttSlr=[0,0,0,0,0,0,0,0,0,0,0,0],
        ttDfr=[0,0,0,0,0,0,0,0,0,0,0,0],
        fnRR=0,
        fnSlr=0,
        fnDfr=0
        for(let a in res){
            if(res[a].son){
                $('.productContent').append(`
                    <div class='product name pro${res[a].typeID}'><span>${res[a].title}</span></div>
                    <div class='item productDe pr${res[a].typeID}'></div>
                `)
                for(let b in res[a].son){
                    var item=res[a].son
                    if(item[b].son){
                        $(`.pr${res[a].typeID}`).append(`
                            <div class='capability name'><span>${item[b].title}</span></div>
                            <div class='item capabilityDe ca${item[b].typeID}'></div>
                        `)
                        for(let c in item[b].son){
                            var itemx=item[b].son
                            if(itemx[c].staff){
                                $(`.ca${item[b].typeID}`).append(`
                                    <div class='service name'><span>${itemx[c].title}</span></div>
                                    <div class='item serviceDe se${itemx[c].typeID}'></div>
                                `)
                                for(let d in itemx[c].staff){
                                    var itemy=itemx[c].staff
                                    var role,
                                    fullName,
                                    runrate,
                                    joinDate,
                                    leaveDate,
                                    salary,
                                    locationManager,
                                    functionalManager,
                                    tyRR=0,
                                    tySlr=0,
                                    tyDfr=0
                                    for(let i in itemy[d].roles){
                                        role=itemy[d].roles[i].name
                                    }
                                    itemy[d].middleName?
                                        fullName=`${itemy[d].firstName} ${itemy[d].middleName} ${itemy[d].lastName}`:
                                        fullName=`${itemy[d].firstName} ${itemy[d].lastName}`
                                    for(let j in itemy[d].RunRate){
                                        if(itemy[d].RunRate[j]){
                                            runrate='USD$'+itemy[d].RunRate[j]
                                        }else{
                                            runrate='USD$0'
                                        }  
                                    }
                                    itemy[d].joinDate?
                                        joinDate=itemy[d].joinDate:
                                        joinDate='——'
                                    itemy[d].leaveDate?
                                        leaveDate=itemy[d].leaveDate:
                                        leaveDate='——'
                                    itemy[d].LocationManager.name?
                                        locationManager=itemy[d].LocationManager.name:
                                        locationManager='——'
                                    itemy[d].FunctionalManager.name?
                                        functionalManager=itemy[d].FunctionalManager.name:
                                        functionalManager='——'
                                    itemy[d].salary?
                                        salary='USD$'+itemy[d].salary:
                                        salary='USD$0'
                                    $(`.se${itemx[c].typeID}`).append(`
                                        <div class='role name'><span>${role}</span></div>
                                        <div class='location name'><span>${itemy[d].Country_Name}</span></div>
                                        <div class='fullName name'><span>${fullName}</span></div>
                                        <div class='locationM name'><span>${locationManager}</span></div>
                                        <div class='functionalM name'><span>${functionalManager}</span></div>
                                        <div class='joinD name'><span>${joinDate}</span></div>
                                        <div class='endingD name'><span>${leaveDate}</span></div>
                                        <div class='runR name'><span>${runrate}</span></div>
                                        <div class='salary name'><span>${salary}</span></div>
                                    `)
                                    $('.deleteIcon').append(`
                                        <div class='delIcon name' data-id='${itemy[d].staffID}'><span class='icon-delete iconfont'></span></div>
                                    `)
                                    $('.editorIcon').append(`
                                        <div class='ediIcon name' data-id='${itemy[d].staffID}'><span class='icon-editor iconfont'></span></div>
                                    `)
                                    for(let i in mm){
                                        if(mm[i]<joinDate){
                                            $('.monthContent').append(`
                                                <div class='monthContentMonth'>
                                                    <div class='monthContentItem name black'><span>——</span></div>
                                                    <div class='monthContentItem name black'><span>——</span></div>
                                                    <div class='monthContentItem name'><span>——</span></div>
                                                </div>    
                                            `)
                                        }else{
                                            $('.monthContent').append(`
                                                <div class='monthContentMonth'>
                                                    <div class='monthContentItem name black'><span>${runrate}</span></div>
                                                    <div class='monthContentItem name black'><span>${salary}</span></div>
                                                    <div class='monthContentItem name'><span>${salary.substring(4)-runrate.substring(4)?'USD$'+(salary.substring(4)-runrate.substring(4)):'——'}</span></div>
                                                </div>    
                                            `)
                                            if(parseInt(runrate.substring(4))){
                                                ttRR[i]+=parseInt(runrate.substring(4))
                                                tyRR+=parseInt(runrate.substring(4))
                                            }
                                            if(parseInt(salary.substring(4))){
                                                ttSlr[i]+=parseInt(salary.substring(4))
                                                tySlr+=parseInt(salary.substring(4))
                                            }
                                        } 
                                    }
                                    tyDfr=tySlr-tyRR
                                    $('.monthContent').append(`
                                        <div class='monthContentMonth'>
                                            <div class='monthContentItem name black'><span>USD$${tyRR}</span></div>
                                            <div class='monthContentItem name black'><span>USD$${tySlr}</span></div>
                                            <div class='monthContentItem name'><span>USD$${tyDfr}</span></div>
                                        </div>  
                                    `)
                                }
                            }else{
                                $(`.pr${res[a].typeID}`).remove()
                                $(`.pro${res[a].typeID}`).remove()
                            } 
                        }
                    } 
                } 
            }  
        }
        for(let i in ttDfr){
            ttDfr[i]=ttSlr[i]-ttRR[i]
            fnRR+=ttRR[i]
            fnSlr+=ttSlr[i]
            fnDfr+=ttDfr[i]
            $('.monthTT').append(`
                <div><span>USD$${ttRR[i]}</span></div>
                <div><span>USD$${ttSlr[i]}</span></div>
                <div><span>USD$${ttDfr[i]}</span></div>
            `)
        }
        $('.monthTT').append(`
            <div><span>USD$${fnRR}</span></div>
            <div><span>USD$${fnSlr}</span></div>
            <div><span>USD$${fnDfr}</span></div>
        `)
        console.log(ttRR,ttSlr,ttDfr)
    }
})


 
// for(let a in fData){
//     $('.content').append(`
//         <div class='deleteIcon name'></div>
//         <div class='editorIcon name'></div>
//         <div class='product name'><span>${fData[a].name}</span></div>
//         <div class='item productDe de${fData[a].id}'></div>
//     `)
//     for(let b in fData[a].capability){
//         var item=fData[a].capability
//         $(`.de${fData[a].id}`).append(`<div class='capability name'><span>${item[b].name}</span></div><div class='item capabilityDe de${item[b].id}'></div>`)
//         for(let c in item[b].service){
//             var itemx=item[b].service
//             console.log(fData[a].name,item[b].name,itemx[c].name)
//             $(`.de${item[b].id}`).append(`<div class='service name'><span>${itemx[c].name}</span></div><div class='item serviceDe de${itemx[c].id}'></div>`)
//             for(let d in itemx[c].member){
//                 var itemy=itemx[c].member
//                 $(`.de${itemx[c].id}`).append(`
//                     <div class='role name'><span>${itemy[d].role}</span></div>
//                     <div class='location name'><span>X</span></div>
//                     <div class='fullName name'><span>${itemy[d].name}</span></div>
//                     <div class='locationM name'><span>Will Tsai</span></div>
//                     <div class='functionalM name'><span>David Moreno</span></div>
//                     <div class='joinD name'><span>88-88-2088</span></div>
//                     <div class='endingD name'><span>88-88-2088</span></div>
//                     <div class='runR name'><span>Unset</span></div>
//                     <div class='salary name'><span>Unset</span></div>
//                 `)
//                 $('.deleteIcon').append(`
//                     <span class='icon-delete iconfont'></span>
//                 `)
//                 $('.editorIcon').append(`
//                     <span class='icon-editor iconfont'></span>
//                 `)
//             }
//         }
//     }
// }
$('.lookUp').click(function(){
    var sDate=$('.lookUpFrom').val(),
    eDate=$('.lookUpTo').val()
    getMonthlyData(sDate,eDate)
})
$('.add-staff').click(function ()  {
    console.log("haha");
    $('#planning').addClass('panel-popup-active loading');
    let randAppID = paneljs.genID(5);
    $('#planning').append(`<div id="app-`+randAppID+`"></div>`);
    paneljs.fetch({type:'app', call:'8'},function (data) {
        console.log(data);
        $('#planning').removeClass('loading');
        $('#app-'+randAppID).append(data.data);
    });  
})
$(document).on('click','.ediIcon',function ()  {
    console.log('ffff')
    $('#planning').addClass('panel-popup-active loading');
    let randAppID = paneljs.genID(5);
    $('#planning').append(`<div id="app-`+randAppID+`"></div>`);
    paneljs.fetch({type:'app', call:'editstaff',postData:{staffID:$(this).attr("data-id")}},function (data) {
        console.log(data);
        $('#planning').removeClass('loading');
        $('#app-'+randAppID).append(data.data);
    });  
})
$(document).on('click','.delIcon',function(){
    $.ajax({
        type:'POST',
        url:'http://192.168.50.90/staff/api/staffing/del',
        data:{
            staffID:$(this).attr("data-id")
        },
        success:function(){
            loadContent('staff-planning',{},0)
        }
    })
})
// $('.ediIcon').click(function ()  {
//     console.log('ffff')
//     $('#planning').addClass('panel-popup-active loading');
//     let randAppID = paneljs.genID(5);
//     $('#planning').append(`<div id="app-`+randAppID+`"></div>`);
//     paneljs.fetch({type:'app', call:'editstaff',postData:{staffID:$(this).attr("data-id")}},function (data) {
//         console.log(data);
//         $('#planning').removeClass('loading');
//         $('#app-'+randAppID).append(data.data);
//     });  
// })
$.ajax({
    type:'GET',
    url:'http://192.168.50.90/staff/api/run-rate/list',
    success:function(res){
        console.log('list:',res)
    }
})
</script>
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
    .name .icon-delete,.name .icon-editor{
        padding:28px 0;
        z-index:5;
        background:rgba(26, 26, 26, 0.98);
    }
    .optional{
        position:sticky;
        left:0;
        top:0;
        z-index:5;
        background: #212121;
        border-bottom:1px #ad9440 solid;
    }
    .optionalx{
        position:sticky;
        left:59px;
        top:0;
        z-index:5;
        background: #212121;
        border-bottom:1px #ad9440 solid;
    }
    .item.deleteIcon{
        position:sticky;
        left:0;
        /* z-index:5; */
        /* background:rgba(26, 26, 26, 0.98); */
        /* border-top:1px #ad9440 solid; */
    }
    .item.editorIcon{
        position:sticky;
        left:59px;
        /* z-index:5; */
        /* background:rgba(26, 26, 26, 0.98); */
        /* border-top:1px #ad9440 solid; */
    }
    #planning{
        padding:10px;
        height:100%
    }
    .new{
        margin: 20px 0px;
    }
    .lookUpBox{
        /* border:1px solid #ad9440; */
        background:black;
        height:47px;
        margin-left:50px;
        padding:5px 40px 5px 5px;
    }
    .new button{
        margin-left:50px
    }
    .new span{
        margin-left:50px;
        height:37px;
        line-height:37px
    }
    .new input{
        width:200px;
        height:37px;
        line-height:37px;
        background:#191919
    }
    .new span,.new input,.lookUpBox,.new button{
        display:inline-block;
        vertical-align:middle
    }
    .mainTable{
        display:grid;
        max-height:90%;
        overflow:auto;
        position:relative;
        background: black;
        text-align:center;
        opacity: 1;
        transition: opacity 2s;
        grid-template-rows: 55px auto;
        overflow: auto;
    }
    .top{
        display:grid;
        grid-template-columns: 59px 59px repeat(12, 228px ) auto;
        position: sticky;
        top: 0;
        z-index: 5;
    }
    .top div{
        border:none;
        background:black
    }
    .header{
        position: sticky;
        top: 55px;
        z-index: 5;
        background: #212121;
        color: #ad9440;
        grid-template-columns: 59px 59px repeat(12, 228px ) auto;
        height:55px;
        line-height: 55px;
        display:grid;
        border-bottom: 1px #ad9440 solid;
        
    }
    .header div{
        border-right: 1px #ad9440 solid;
        height:55px
    }
    .header span{
        height:100%;
        width:100%;
    }
    .content{
        display:grid;
        grid-template-columns: 59px 59px 2736px auto;
        background:rgba(26, 26, 26, 0.98);
        position:relative;
    }
    .icon-delete:before {
      content: "\e614";
    }

    .icon-editor:before {
      content: "\e629";
    }
    .name{
        display:table;
        height:100%;
        border-right: 1px #ad9440 solid;
        /* border-top:1px #ad9440 solid; */
        border-bottom:1px #ad9440 solid;
    }
    .name span{
        display:table-cell;
        vertical-align:middle;
        padding:30px 0 
    }
    .item{
        display:grid;
        /* padding:10px; */
        /* border:1px #ad9440 solid; */
    }
    .productContent{
        grid-template-columns: 228px 2508px
    }
    .productDe{
        grid-template-columns: 228px 2280px
    }
    .capabilityDe{
        grid-template-columns:228px 2052px
    }
    .serviceDe{
        grid-template-columns:repeat(9,228px)
    }
    /* .runRate{
        grid-template-rows:30px 25px;
        grid-template-columns: repeat(5, 228px)
    }
    .runHead{
        grid-area:1/1/2/6;
        line-height:30px;
        border-bottom: 1px #ad9440 solid;
    }
    .runItem{
        line-height:25px;
        border-right: 1px #ad9440 solid;
    } */
    .productName{
        display:table;
        border-bottom:1px #ad9440 solid;
        margin:0;
    }
    .productName span{
        display:table-cell;
        vertical-align:middle;
        padding:30px
    }
    .month{
        display:grid;
        grid-template-rows:55px;
        grid-auto-flow:column
    }
    .month div{
        width:228px
    }
    .monthContent{
        display:grid;
        grid-template-columns:repeat(auto-fill,684px);
    }
    .monthContentMonth{
        display:grid;
        grid-template-columns:228px 228px 228px
    }
    .monthContentItem span{
        padding:30px 0
    }
    .monthTT span{
        line-height:55px;
        color:black;
        background:#ad9440;
        border-right:black solid 1px
    }
    .black{
        background:black
    }
</style>