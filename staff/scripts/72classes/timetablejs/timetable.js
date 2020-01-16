class TimeTable {

    constructor(params) {
        if ('tableID' in params) this.prepare(params.tableID);

        this.jump = params.jump; //In days
        this.rows = ('rows' in params ? params.rows : {});
        this.slotItems = ('slotItems' in params ? params.slotItems : {});
        params.dates.fromDate = params.dates.fromDate.replace(/-/g, '/');
        params.dates.toDate = params.dates.toDate.replace(/-/g, '/');
        this.dates = this.incrementDate(params.dates.fromDate, params.dates.toDate, this.jump);

        this.createTable(params.tableID);
        this.finishup(params.tableID);
    }

    prepare(tableID) {
        $('#'+tableID).addClass('load-only').html('<div class="loading"></div>');
    }

    finishup(tableID) {
        setTimeout(function () {
            $('#'+tableID).removeClass('load-only');
        }, 500);
    }

    createTable(tableID) {
        this.table = $('#'+tableID).append(`<timetable class="timeline">
            <timetable-options>
                <label for="menu-checkbox"  class="timetable-icon-menu">
                    <input id="menu-checkbox" type="checkbox">
                    <i class="fas fa-bars"></i>
                </label>
                <div class="timetable-icon-search">
                    <i class="fas fa-search"></i>
                </div>
            </timetable-options>
            <style class="timetable-styling"></style>
        </timetable>`).children('timetable').eq(0);

        this.updateStyling();

        for (var date in this.dates) {
            this.insertDate(1, this.dates[date].original);
        }

        for (var row in this.rows) {
            this.insertRow(1, this.rows[row]);
        }

        let thisClass = this;

        thisClass.table.find('.list-child-span').click(function () {
            alert("xxxxxxx");
            thisClass.createNewAssignment();
        })

        this.table.find('#menu-checkbox').click(function () {
            thisClass.createNewPopup();
           let check_box=$('#menu-checkbox').is(':checked');
           if (check_box){
               $('.sidebarReports').css('display','block');
           }else{
               $('.sidebarReports').css('display','none');
           }
        })
        this.table.find('.timetable-icon-search').click(function () {
            thisClass.createSearchFilter();
            $(document).ready(function(){
                var ImportType;
                $('#common-form').find('input[type="checkbox"]').bind('click', function () {
                    // console.log($(this).val());
                    $('#common-form').find('input[type=checkbox]').not(this).prop("checked", false);
                });
                //获取到当前复选框选中的值
                $('#common-form').find('input[type="checkbox"]').each(function (i) {
                    ImportType= $(this).val();
                });
            });
        });

        // this.table.find('.timetable-icon-menu').click(function () {
        //     thisClass.createNewPopup();
        // })
    }

    updateTable() {
        this.updateStyling();

        for (var date in this.dates) {
            this.insertDate(1, this.dates[date].original);
        }

        for (var row in this.rows) {
            this.insertRow(1, this.rows[row]);
        }
        let a=`<div id="leftMenus" style="z-index: 9999!important;">
                        <ul>
                            <li> <span>Saga Name1</span>
                                <ul>
                                    <li> <span>Epic Name1-1</span>
                                        <ul>
                                            <li> <span>Story Name1-1-1</span></li>
                                        </ul>
                                    </li>
                                    <li> <span>Epic Name1-2</span>
                                        <ul>
                                            <li> <span>Story Name1-2-1</span></li>
                                            <li> <span>Story Name1-2-2</span></li>
                                        </ul>
                                    </li>
                                    <li> <span>Epic Name1-3</span>
                                        <ul>
                                            <li> <span>Story Name1-3-1</span></li>
                                        </ul>
                                    </li>
                                </ul>
                           </li>

                           <li> <span>Saga Name2</span>
                                <ul>
                                    <li> <span>Epic Name2-1</span>
                                        <ul>
                                            <li> <span>Story Name2-1-1</span></li>
                                            <li> <span>Story Name2-1-2</span></li>
                                        </ul>
                                     </li>
                                     <li> <span>Epic Name2-2</span>
                                        <ul>
                                             <li> <span>Story Name2-2-1</span></li>
                                            <li> <span>Story Name2-2-2</span></li>
                                        </ul>
                                     </li>
                                </ul>
                           </li>
                           <li> <span>Saga Name3</span>
                                <ul>
                                    <li> <span>Epic Name3-1</span>
                                        <ul>
                                            <li> <span>Story Name3-2-1</span></li>
                                        </ul>
                                    </li>
                                </ul>
                           </li>
                        </ul>
                       </div>`;
        $("timetable-row .view2").css("cursor","pointer");
        $("timetable-row .view2").parent().append(a);
        $("timetable-row").children("#leftMenus").css("display","none");
        $("timetable-row .view2").click(function () {
            // $("timetable-row").children($("#leftMenus").css("display","block"));
            // $(this).children("ul").toggle(1000);//在hide和show之间切换
            $("timetable-row").children("#leftMenus").toggle(100);
        })

    }

    resetTable() {
        this.rows = {};
        this.slotItems = {};
        this.dates = {};
        this.table.html(`<timetable-options>
<!--                <div class="timetable-icon-menu">-->
<!--                    <i class="fas fa-bars"></i>-->
<!--                </div>-->
                <label for="menu-checkbox"  class="timetable-icon-menu">
                    <input id="menu-checkbox" type="checkbox">
                    <i class="fas fa-bars"></i>
                </label>
                <div class="timetable-icon-search">
                    <i class="fas fa-search"></i>
                </div>
            </timetable-options>
            <style class="timetable-styling"></style>`);

        let thisClass = this;

        this.table.find('.timetable-icon-search').click(function () {
            thisClass.createSearchFilter();

        });

        this.table.find('#menu-checkbox').click(function () {
            thisClass.createNewPopup();
            let check_box=$('#menu-checkbox').is(':checked');
            console.log(check_box)
            if (check_box){
                $('.sidebarReports').css('display','block');
            }else{
                $('.sidebarReports').css('display','none');
            }
        })

    }
    /*Tracking Reports sub-level sidebar*/
    // createPopup(popup,callback){
    //     console.log("createPopupcreatePopupcreatePopup");
    //     let createDivs=$('timetable-options').append(`<sidebar-reports class="sidebarReports">`+popup.body+`</sidebar-reports>`);
    //     callback(createDivs);
    // }
    createPopout(popoutData, callback) {
        let popoutID = this.genID(10), createdDiv, icons = '';
        for (var i = 0; i < popoutData.icons.length; i++) {
            icons += '<div class="timetable-popout-icon" data-name="'+popoutData.icons[i].dataName+'">'+popoutData.icons[i].icon+'</div>';
        }
        createdDiv = $(`<timetable-popout data-id=`+popoutID+`>
            <timetable-popout-topbar>`+icons+`</timetable-popout-topbar>
            <timetable-popout-photo>`+('photo' in popoutData && popoutData.photo !== null ? '<img src="'+popoutData.photo+'">' : '')+`</timetable-popout-photo>
            <timetable-popout-body>`+('body' in popoutData ? popoutData.body : '')+`</timetable-popout-body>
        </timetable-popout>`).appendTo(this.table);

        if ('photo' in popoutData && popoutData.photo !== null)
            createdDiv.scroll(function () {
                $(this).find('img').eq(0).css('padding-top', ($(this).scrollTop() / 1.5) + 'px');
                $(this).find('img').eq(0).css('filter', 'brightness('+ (100 - 100 * ($(this).scrollTop() / 300)) + '%)');
            });

        callback(createdDiv);
    }

    updateStyling() {
        let columns = '[sections] 150px', rows = '[dates] 50px', jumpIn = function (TimeTableClass, index) {
            var slotItem = TimeTableClass.rows[index];
            if (!('slotItems' in slotItem) || slotItem['slotItems'].length == 0) return;

            let slotItemCSS = '';
            for (var slotItemID in slotItem.slotItems) {
                slotItemCSS += ' [row-item-'+slotItemID+'] auto';
                //slotItemCSS += jumpIn(TimeTableClass, slotItemID);
            }
            return slotItemCSS;
        }, storyJumpIn = function (TimeTableClass, index) {
            var storyCSS = '';
            if ("children" in TimeTableClass.rows[index]) {
                for (var childIndex in TimeTableClass.rows[index].children) {
                    if (TimeTableClass.rows[childIndex].type == 'Story') storyCSS += ' [row-'+childIndex+'-start] auto' + jumpIn(TimeTableClass, childIndex) + ' [row-'+childIndex+'-end] auto';
                    else storyCSS += ' [row-'+childIndex+'-start] auto' + ' [row-'+childIndex+'-end] auto' + storyJumpIn(TimeTableClass, childIndex);
                }
            }
            return storyCSS;
        };

        for (var date in this.dates) {
            columns += ' [col-'+date+'] 250px [col-'+date+'-end] 0px';
        }

        for (var section in this.rows) {
            if (this.rows[section].type == 'Saga') {
                rows += ' [row-'+section+'-start] auto';
                //rows += jumpIn(this, this.rows[section]);
                rows += ' [row-'+section+'-end] auto';
                rows += storyJumpIn(this, section);
            }
        }

        $('.timetable-styling').text('.timeline { grid-template-columns: '+columns+'; grid-template-rows: '+rows+';}');
    }

    linkSlotItem(parent, item) {
        parent.slotItems[item.slotID] = item.slotID;
    }

    insertSlotItem(item) {
        //Calculate width
        let trueDateRange = this.validateDateRange({startDate:item.startDate,endDate:item.endDate});

        $('[data-slotID='+item.slotID+']').remove();
        $('.timeline').append(`<div class="slot-item" data-level="`+item.level+`" data-slotID="`+item.slotID+`" style="grid-column: col-`+trueDateRange.startDate+` / col-`+trueDateRange.endDate+`-end; grid-row: row-item-`+item.slotID+`;">
                <div class="projectImg">
                    <img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1569490516226&di=848fa41520a60ac48d46c2cbd09be521&imgtype=0&src=http%3A%2F%2Fpic180.nipic.com%2Ffile%2F20180904%2F3046502_101132515000_2.jpg" style="max-width: 250px;height: auto" alt="projectPicture"  title="projectPictureImage">
                </div>
                <div class="slot-item-title">
                    <div class="slot-item-title-top">
                        <div class="slot-icon-info">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                        <div class="slot-icon-next-level">
                            <i class="fas fa-sort-amount-down"></i>
                        </div>
                        <div class="slot-item-title-text">`+item.title+`</div>
                    </div>
                    <div class="slot-dropdown-content">
                        <ul>
<!--                        <li class="slot-dropdown-item" data-action="info">View Milestone Information</li>-->
<!--                        <li class="slot-dropdown-item" data-action="edit">Edit Milestone Information</li>-->
<!--                        <li class="slot-dropdown-item" data-action="add">Add Level 2 Milestone</li>-->
<!--                        <li class="slot-dropdown-item" data-action="remove">Remove Milestone</li>-->
                            <li class="slot-dropdown-item" data-action="add">Add Update</li>
                            <li class="slot-dropdown-item" data-action="view">View Update</li>
                        </ul>
                    </div>
                </div >
                <div class="slot-item-final"></div>
            </div>`);
//console.log(this.table);
            //th.loadSlotItemEvents(this.table.find('[data-slotID='+item.slotID+']').eq(0));
            this.delayLoadSlotItem(item);

    }

    delayLoadSlotItem(item) {
        // let th = this;
        // if(!this.table.find('[data-slotID='+item.slotID+']').eq(0).length) {
        //     setTimeout(function () {
        //         th.delayLoadSlotItem(item)
        //         console.log('keep looking')
        //     }, 1000);
        // } else {
        //     console.log('all ok');
            this.loadSlotItemEvents(this.table.find('[data-slotID='+item.slotID+']').eq(0));
        // }
    }

    loadSlotItemEvents(item) {
        console.log("error");
        return;
    }

    validateDateRange(dateRange) {
        if (!(dateRange.startDate in this.dates)) {
            if (dateRange.startDate <= this.dates[Object.keys(this.dates)[0]].dateID)
                dateRange.startDate = this.dates[Object.keys(this.dates)[0]].dateID;
            else dateRange = this.validateDateRange({
                endDate:dateRange.endDate,
                startDate:this.formatDate(this.formatDate(new Date((new Date(this.formatDate(dateRange.startDate, 'REV_DATE_ID'))).getTime() - 1 * 24 * 60 * 60 * 1000), 'DATE'), 'DATE_ID')
            });
        }

        if (!(dateRange.endDate in this.dates)) {
            if (dateRange.endDate >= this.dates[Object.keys(this.dates)[Object.keys(this.dates).length - 1]].dateID)
                dateRange.endDate = this.dates[Object.keys(this.dates)[Object.keys(this.dates).length - 1]].dateID;
            else dateRange = this.validateDateRange({
                startDate:dateRange.startDate,
                endDate:this.formatDate(this.formatDate(new Date((new Date(this.formatDate(dateRange.endDate, 'REV_DATE_ID'))).getTime() - 1 * 24 * 60 * 60 * 1000), 'DATE'), 'DATE_ID')
            });
        }

        return dateRange;
    }

    incrementDate(fromDate, toDate, amount) {
        let fromObj = {dateID:this.formatDate(fromDate, 'DATE_ID'), original:fromDate}, toObj = {dateID:this.formatDate(toDate, 'DATE_ID'), original:toDate};
        if (fromObj.dateID >= toObj.dateID) return {[fromObj.dateID]:fromObj};

        let dateObj = new Date((new Date(fromObj.original)).getTime() + amount * 24 * 60 * 60 * 1000);
        let newDate = this.formatDate(dateObj, 'DATE');

        let nextDate = this.incrementDate(newDate, toDate, amount);
        nextDate[fromObj.dateID] = fromObj;
        return nextDate;
    }

    linkDate(dateVal) {
        this.dates[this.formatDate(dateVal, 'DATE_ID')] = {
            dateID: this.formatDate(dateVal, 'DATE_ID'),
            original: dateVal
        };
    }

    insertDate(position, dateVal) {
        $('[data-column='+this.formatDate(dateVal, 'DATE_ID')+']').remove();
        $('.timeline').append(`<timetable-head style="grid-column: col-`+this.formatDate(dateVal, 'DATE_ID')+` / col-`+this.formatDate(dateVal, 'DATE_ID')+`; grid-row: dates;"data-column="`+this.formatDate(dateVal, 'DATE_ID')+`"><div>`+(new Date(dateVal)).toDateString()+`</div></timetable-head>`);
    }

    handleDate(position, dateVal) {
        this.linkDate(dateVal);
        this.insertDate(position, dateVal);
    }

    removeDate(position) {

    }

    insertRow(position, row) {
        $('[data-section='+row.rowID+']').remove();
        $('.timeline').append(`<timetable-row style="grid-column: sections; grid-row: row-`+row.rowID+`-start / row-`+row.rowID+`-end;" data-section="`+row.rowID+`" class="row-type-`+row.type.toLowerCase()+`"><div class="view`+row.rowID+`"+>`+row.title+`</div></timetable-section>`);
        //console.log(this.slotItems);
        if ("slotItems" in row) {
            //this.insertRowDelay(row, 0)
            for (var item in row.slotItems) {
                console.log(this.slotItems[item]);
               this.insertSlotItem(this.slotItems[item]);
            }
        }
    }

    // insertRowDelay(row, currentIndex) {
    //     if (currentIndex == Object.keys(row.slotItems).length) return;
    //     this.insertSlotItem(this.slotItems[Object.keys(row.slotItems)[currentIndex++]]);
    //     let th = this;
    //     setTimeout(function () {
    //         console.log('insert');
    //         th.insertRowDelay(row, currentIndex);
    //
    //     }, 10);
    // }

    removeRow() {

    }

    createSearchFilter() {
        console.log("createSearchFilter of timetable")
    }

    formatDate(date, func) {
        switch (func) {
            case 'DB_DATE':
                date = date.split('/');
                return {year:date[0], month:date[1], day:date[2]};
            case 'REV_DB_DATE':
                return date.year+'/'+date.month+'/'+date.day;
            case 'DATE':
                return date.getFullYear() + '/' + ((parseInt(date.getMonth().toString()) + 1).toString().length == 1 ? '0'+(parseInt(date.getMonth().toString()) + 1) : (parseInt(date.getMonth().toString()) + 1)) + '/' + (date.getDate().toString().length == 1 ? '0'+date.getDate() : date.getDate());
            case 'DATE_ID':
                return date.replace(/\//g, '').replace(/\-/g, '');
            case 'REV_DATE_ID':
                return date.slice(0,4) + '/' + date.slice(4,6) + '/' + date.slice(6,8);
            case 'REV_DASH_DB_DATE':
            return date.year+'-'+date.month+'-'+date.day;
        }
    }

    genID(length) {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

        for (var i = 0; i < length; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

}