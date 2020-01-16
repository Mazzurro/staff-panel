<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/staff/staff.js"></script>
    <script type="text/javascript" src="/staff/temp.js"></script>
    <script type="text/javascript" src="/staff/scripts/72classes/panel.js"></script>
    <script type="text/javascript" src="/staff/scripts/72classes/timetablejs/timetable.js"></script>
    <script type="text/javascript" src="/staff/scripts/72classes/timetablejs/ext/assignments.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
</head>

<style>
    :root {
      --item-width: 250px; 
    }
    
    body {
        margin: 0;
        background: black;
    }
    body, body *:not(style):not(script) {
        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
    }

    timetable {
        position: absolute;
        display: grid;
        background: black;
        opacity: 1;
        transition: opacity 2s;
    }
     .load-only>*:not(.loading) {
        opacity: 0;
    }
    tr {
        position: relative;
    }
    timetable-head {
        white-space: nowrap;
        background: #212121;
        color: #ad9440;
        position: sticky;
        position: -webkit-sticky;
        top: 0;
        z-index: 6;
        border-bottom: 1px #ad9440 solid;
    }
    timetable-head:after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        height: 100vh;
        border-right: 1px rgba(173, 148, 64, 0.2) solid;
        pointer-events: none;
    }
    td {
        position: relative;
    }
    timetable-row {
        background: rgba(26, 26, 26, 0.98);
        color: #ad9440;
        left: 0;
        z-index: 5;
    }
    timetable-row, timetable-head {
        position: sticky;
        position: -webkit-sticky;
        padding: 15px;
        text-align: center;
        font-size: 14px;
    }
    timetable-row div {
        /*min-height: 50px;*/
    }
    timetable-row:before {
        content: '';
        position: absolute;
        border-bottom: 1px rgba(173, 148, 64, 0.2) solid;
        bottom: 0;
        left: 0;
        width: 100vw;
    }
    timetable-row:after {
        content: '';
        position: absolute;
        border-right: 1px rgba(173, 148, 64, 0.4) solid;
        right: 0;
        height: 100%;
        top: 0;
    }
    td[data-row][data-column] {
        vertical-align: top;
    }
    
    /*Animation*/
    th, td {
        animation: floatIn 1s forwards ease-out;
    }
    
    @keyframes floatIn {
        0% {
            opacity: 0;
            transform: translateY(-200px);
        }
        100% {
            opacity: 1;
            transform: translateY(0px);
        }
    }
    
    .slot-item {
        position: relative;
        left: 0;
        width: 100%;
        background: rgba(173, 148, 64, 0.85);
        min-height: 40px;
        display: block;
        color: #191919;
        display: grid;
        align-items: center;
        margin: 5px 0;
        font-size: 14px;
        animation: fade-in-left 0.75s forwards ease-out;
    }
    @keyframes fade-in-left {
        0% {transform: translateX(-100px); opacity: 0;}
        100% {transform: translateX(0px); opacity: 1;}
    }
    .slot-item[data-level="2"] {
        background: rgba(173, 148, 64, 0.35);
        border: 1px rgba(173, 148, 64, 0.85) solid;
        color: #ad9440;
    }
    .slot-item[data-level="3"] {
        background: #212121;
        border: 1px rgba(173, 148, 64, 0.85) solid;
        color: #ad9440;
    }
    /*projectImgList*/
    .projectImg{
        min-width: 250px;
        min-height: 200px;
        background: black;
    }


    .slot-item-title {
        position: sticky;
        position: -webkit-sticky;
        width: var(--item-width);
        min-height: 40px;
        height: 100%;
        left: 150px;
        z-index: 2;
    }
    .slot-item-title-top {
        display: grid;
        align-items: center;
        grid-template-columns: 28px 28px calc(100% - 56px);
        min-height: 40px;
    }
    .slot-icon-info, .slot-icon-next-level {
        font-size: 16px;
        place-self: center;
        cursor: pointer;
    }
    .slot-dropdown-content:not(.active) {
        overflow: hidden;
        height: 0;
    }
    .slot-dropdown-content>ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .slot-dropdown-item {
        padding: 5px;
        margin: 1px;
        background: #212121;
        color: #ad9440;
    }
    .slot-item-final {
        width: var(--item-width);
        height: 100%;
        /*background: #ad9440;*/
        display: grid;
        place-content: center;
        text-align: center;
        position: absolute;
        z-index: 1;
        right: 0;
    }
    .slot-item.right-cut .slot-item-final {
        display: none;
    }
    
    .loading {
        height: 100px;
        width: 100px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        position: absolute;
        display: grid;
        place-content: center;
        font-size: 18px;
        border-radius: 100%;
        text-align: center;
        border: 1px #ad9440 solid;
    }
    .loading:before {
        content: '';
        position: absolute;
        height: calc(125% - 4px);
        width: calc(125% - 4px);
        border-radius: 100%;
        border: 2px #ad9440 solid;
        border-color: #ad9440 transparent;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(0deg);
        animation: rotateright 2s infinite linear;
    }
    .loading:after {
        content: '';
        height: 90%;
        width: 90%;
        position: absolute;
        display: grid;
        place-content: center;
        font-size: 18px;
        border-radius: 100%;
        text-align: center;
        border: 1px #ad9440 solid;
        border-color: #ad9440 transparent;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(0deg);
        animation: rotateleft 2s infinite linear;
    }
    @keyframes rotateright {
        0% {transform: translate(-50%, -50%) rotate(0deg);}
        100% {transform: translate(-50%, -50%) rotate(359deg);}
    }
    @keyframes rotateleft {
        0% {transform: translate(-50%, -50%) rotate(0deg);}
        100% {transform: translate(-50%, -50%) rotate(-359deg);}
    }
    
    
    timetable-options {
        background: #ad9440;
        display: grid;
        grid-template-columns: 50% 50%;
        font-size: 22px;
        position: sticky;
        top: 0;
        left: 0;
        z-index: 100;
    }
    timetable-options>div {
        display: grid;
        place-content: center;
    }
    
    
    /*TimeTable Popout View*/
    timetable-popout {
        position: fixed;
        height: 100vh;
        max-width: 500px;
        width: 100%;
        background: #ad9440;
        z-index: 10000;
        right: 0;
        top: 0;
        box-shadow: 0 0 20px 2px rgba(0,0,0,0.5);
        border-left: 1px rgba(25, 25, 25, 0.6) solid;
        overflow: auto;
        display: block;
        animation: pop-out 0.25s forwards ease-out;
    }
    @keyframes pop-out {
        0% {right: -550px;}
        100% {right: 0px;}
    }
    timetable-popout.close {
        animation: pop-in 0.25s forwards ease-in;
    }
    @keyframes pop-in {
        0% {right: 0px;}
        100% {right: -550px;}
    }
    timetable-popout-topbar {
        min-height: 50px;
        background: #ad9440;
        display: grid;
        grid-template-columns: repeat(auto-fit, 50px);
        font-size: 24px;
        text-align: center;
        position: sticky;
        position: -webkit-sticky;
        top: 0;
        z-index: 10;
        border-bottom: 1px rgba(25, 25, 25, 0.6) solid;
    }
    .timetable-popout-icon {
        place-items: center;
        display: grid;
        position: relative;
        cursor: pointer;
    }
    .timetable-popout-icon svg {
        position: relative;
        z-index: 3;
    }
    .timetable-popout-icon:before, .timetable-popout-icon:after {
        content: '';
        position: absolute;
        display: block;
        width: 100%;
        height: 0%;
        top: 0;
        transition: height 0.25s;
    }
    .timetable-popout-icon:before {
        background: #dedede;
        z-index: 2;
    }
    .timetable-popout-icon:after {
        background: white;
        z-index: 4;
        mix-blend-mode: difference;
    }
    .timetable-popout-icon:hover:before, .timetable-popout-icon:hover:after {
        height: 100%;
    }
    timetable-popout-photo>img {
        object-fit: cover;
        height: 300px;
        width: 100%;
        display: block;
    }
    timetable-popout-body {
        padding: 10px 20px;
        display: block;
    }
    .timetable-popout-data {
        min-height: 200px;
        background: #191919;
        position: relative;
    }
    
    
    
    
    /*Input*/
    /*input text select*/
    .addAssignment:not([type="hidden"]){
        width:100%;
        background: #00000021;
        border: 1px #212121 solid;
        border-width: 0 0 0 1px;
        min-height: 36px;
        color: #212121;
        margin: 5px 0;
        font-size: 16px;
        padding-left: 5px;
        height: 25px;
        outline: none;
         /*-webkit-appearance: none;*/
    }
    .addAssignment option:hover{
        background:#ad9440;
    }
    input:not([type="hidden"]), textarea {
        background: #00000021;
        border: 1px #212121 solid;
        border-width: 0 0 0 1px;
        width: 100%;
        min-height: 36px;
        color: #212121;
        margin: 5px 0;
        font-size: 16px;
        padding-left: 5px;
        transition: border-left-width 0.25s;
    }
    textarea {
        min-height: 50px;
    }
    input:not([type="hidden"]):focus, textarea:focus {
        border-left-width: 5px;
        outline: none;
    }
    input:not([type="hidden"])::placeholder, textarea::placeholder {
        color: rgba(33, 33, 33, 0.5);
    }
    .input-multiline {
        display: flex;
    }
    .input-multiline input {
        margin: 5px;
    }
    
    /*input autocomplete*/
    .input-autocomplete input:not([type="hidden"]) {
        margin-bottom: 0;
    }
    .autocomplete-list {
        margin-bottom: 5px;
    }
    .autocomplete-item {
        font-size: 14px;
        background: #000000ab;
        color: #ad9440;
        padding: 10px 5px;
        cursor: pointer;
        transition: background 0.25s;
    }
    .autocomplete-item:hover {
        background: #000000d4;
    }
    
    /*Checkbox*/
    checkbox {
        display: grid;
        grid-template-columns: 40px calc(100% - 40px);
        background: #00000021;
        min-height: 40px;
        margin: 5px 0;
    }
    checkbox-toggle {
        height: 20px;
        width: 20px;
        border: 1px #212121 solid;
        place-self: center;
    }
    .checkbox-toggle {
         height: 20px!important;
         width: 20px!important;
         border: 1px #212121 solid !important;
         place-self: center;
         background: #00000021!important;
         cursor: pointer;
     }
    checkbox.active checkbox-toggle {
        background: #212121;
    }
    checkbox-text {
        border-left: 1px #212121 solid;
        padding: 11px;
        align-self: center;
    }

    
    
    
    
    
    
    /*Stories*/
    .row-type-saga:before {
        height: 100%;
        background: #ad9440;
        z-index: -1;
        background: rgba(150, 3, 26, 0.7);
    }
    .row-type-epic:before {
        height: 100%;
        background: #141415;
        z-index: -1;
    }

    /*Tracking Reports sub-level sidebar*/
    .timetable-icon-menu{
        display: grid;
        place-content: center;
        cursor:pointer;
    }
    .timetable-icon-search{
//        cursor:pointer;
    }
    .sidebarReports{
       display: none;
       position: fixed;
       height: 100vh;
       max-width: 250px;
       width: 100%;
       background-color: #000000;
       z-index: 10000;
       left: 0;
       top: 50px;
       border-right: 1px #ad9440 solid;
//       box-shadow: 0 0 20px 2px rgba(0,0,0,0.5);
       border-left: 1px rgba(25, 25, 25, 0.6) solid;
       overflow: auto;
       animation: sidebarReports-pop-out 0.25s forwards ease-out;
       transition: left 0.25s;
    }
    @keyframes sidebarReports-pop-out {
        0% {left: -250px;}
        100% {left: 0px;}
    }

    .sidebarReportsclose {
       animation: sidebarReports-pop-in 0.25s forwards ease-in;
       transition: left 0.25s;
    }
    @keyframes sidebarReports-pop-in {
        0% {left: 0px;}
        100% {left: -250px;}
    }
    .sidebarReports ul{
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .sidebarReports li{
        margin: 10px;
        text-align: -webkit-match-parent;
        box-sizing: border-box;
        display: block;
        font-weight: 300;
        -webkit-tap-highlight-color: transparent;
    }
    .sidebarReports .list-child>span {
        display: block;
        font-size:16px;
        list-style-type:none;
        background: #ad9440;
        color: #151515;
        padding: 10px;
        cursor: pointer;
    }
    #menu-checkbox{
       display:none;
    }
    #menu-checkbox:checked ~ sidebar-reports{
        display: block;
    }




/*App*/
app, app *:not(script):not(style) {
  display: block;
}
staff-list {
  overflow: hidden;
  color: #ad9440;
}
staff-list-main {
  height: 300px;
  background: #151515;
}
staff-list-side {
  border-top: 1px #ad9440 dashed;
  height: 90px;
  background: #151515;
  overflow-x: auto;
  overflow-y: hidden;
}
staff-list-side-content {
  width: -moz-max-content;
  width: max-content;
  height: 100%;
}
staff-list-members {
  overflow: auto;
  height: 300px;
}
staff-list-members-content {
    display: grid !important;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    place-items: center;
    padding: 5px;
}
staff-list-member {
    padding: 10px;
}
staff-list-department, staff-list-member, staff-list-department-chosen {
  width: 120px;
  text-align: center;
  height: 100%;
  display: inline-grid !important;
  cursor: pointer;
  transition: filter 0.25s;
}
staff-list-department:hover, staff-list-department-chosen:hover {
  filter: brightness(120%);
}
staff-list-member.chosen:hover staff-list-member-avatar {
  position: relative;
  filter: grayscale(1);
}
staff-list-member.chosen:hover:before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-45deg);
    width: 50px;
    height: 10px;
    z-index: 5;
    background: #800;
}
staff-list-member.chosen:hover:after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(45deg);
    width: 50px;
    height: 10px;
    z-index: 5;
    background: #800;
}
staff-list-department.active, staff-list-department-chosen.active {
  filter: brightness(150%);
}
staff-list-member.chosen {
  position: relative;
}
staff-list-member.active {
  filter: brightness(50%);
}
staff-list-member:hover staff-list-member-avatar {
  transform: scale(1.10);
}
staff-list-member:hover staff-list-member-name {
  font-size: 0;
}
staff-list-department-content, staff-list-member-content {
  align-self: center;
}
staff-list-department-icon, staff-list-member-avatar {
  border: 1px #ad9440 solid;
  border-radius: 100%;
  width: 30px;
  height: 30px;
  margin: auto;
  font-size: 16px;
  display: grid !important;
}
staff-list-member-avatar {
  background-size: cover;
  background-position: center;
  width: 70px !important;
  height: 70px !important;
  transition: transform 0.25s;
}
staff-list-department-icon svg, staff-list-department-icon span {
  align-self: center;
  margin: auto !important;
}
staff-list-department-name, staff-list-member-name {
  font-size: 12px;
  margin: 5px;
  transition: font-size 0.25s;
}
img.staff-proj-avatar {
    float: left;
    height: 50px;
    margin-right: 10px;
}

//left menu bar

        timetable-row .view2{
            position: sticky;
            position: -webkit-sticky;
            width: 250px;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            background: rgba(26, 26, 26, 0.98);
            color: #ad9440;
            left: 0;
            z-index: 5;
        }
        timetable-row #leftMenus{
            position: absolute;
            top: 80px;
            left: 110px;
        }
        timetable-row #leftMenus ul{
            position: absolute;
        }
        timetable-row .view2:hover>#leftMenus{
            display: block;
        }

        timetable-row #leftMenus ul{
             max-width: 250px;
             list-style: none;        /*去除列表的小圆点*/
             position:absolute;
         }
        timetable-row #leftMenus li{
            padding: 15px;
            list-style-type: none;
            background: rgba(26, 26, 26, 0.98);
            color: #ad9440;
            border-bottom: 1px solid #ad9440;
            width: 250px;
            text-align: center;
            position: relative;
        }
        timetable-row #leftMenus li>ul{
            left: 210px;
            display: none;
            top: 0;
        }
        timetable-row #leftMenus li:hover>ul{
            display: block;
        }
        timetable-row #leftMenus li:hover{
            background: #ad9440;
            color: rgba(26, 26, 26, 0.98);
        }



</style>
<div id="example-table"></div>

<script type="text/javascript">
let TTM;

/*function addNotif(a, e, o) {
     console.log(a);
     console.log(e);
     console.log(o);
 }*/

$(document).ready(function () {
     TTM = new TimeTableAssignments({
         jump: 7,
         dates: {
             fromDate: '2018-08-01',
             toDate: '2018-12-01'
         },
         tableID: 'example-table'
     });

    // $.post('https://72dragons.com/staff/api/assignments/list', {startDate:'2018-08-01', endDate:'2018-12-01'}).done(function (data) {
        //     let rowData = {}, epicItems = {}, storyItems = {}, slotItems = {}, assignment;
        //     for (var item in data) {
        //         assignment = data[item];
        //         if (assignment.sagaID != null && assignment.epicID != null && assignment.storyID != null) {

        //             //Saga
        //             if (!(assignment.sagaID in rowData)) rowData[assignment.sagaID] = {
        //                 rowID: assignment.sagaID,
        //                 title: assignment.saga,
        //                 //slotItems: {},
        //                 children: {},
        //                 type: 'Saga'
        //             }


        //             //Epic
        //             if (!(assignment.epicID in rowData[assignment.sagaID].children)) {
        //                 rowData[assignment.epicID] = {
        //                     rowID: assignment.epicID,
        //                     title: assignment.epic,
        //                     children: {},
        //                     type: 'Epic'
        //                     //slotItems: {},
        //                     //level: 1
        //                 }
        //                 rowData[assignment.sagaID].children[assignment.epicID] = assignment.epicID;
        //             }


        //             //Story
        //             if (!(assignment.storyID in rowData[assignment.epicID].children)) {
        //                 rowData[assignment.storyID] = {
        //                     rowID: assignment.storyID,
        //                     title: assignment.story,
        //                     slotItems: {},
        //                     type: 'Story'
        //                     //level: 1
        //                 }
        //                 rowData[assignment.epicID].children[assignment.storyID] = assignment.storyID;
        //             }


        //             //Assignment
        //             slotItems[assignment.assignmentID] = {
        //                 slotID: assignment.assignmentID,
        //                 startDate: assignment.startingDate.replace(/\-/g, ''),
        //                 endDate: assignment.endDate.replace(/\-/g, ''),
        //                 title: assignment.title,
        //                 level: 1,
        //                 slotItems: {}
        //             }


        //             //Link Assignment to the Saga
        //             //rowData[assignment.sagaID].slotItems[assignment.assignmentID] = assignment.assignmentID;
        //             rowData[assignment.storyID].slotItems[assignment.assignmentID] = assignment.assignmentID;
        //         }
        //     }

        //     TTM = new TimeTable({
        //         jump: 7,
        //         dates: {
        //             fromDate: '2018/08/01',
        //             toDate: '2018/12/01'
        //         },
        //         rows: rowData,
        //         slotItems: slotItems,
        //         jumpTo: 200,
        //         tableID: 'example-table'
        //     });

        // });


    


});


</script>


