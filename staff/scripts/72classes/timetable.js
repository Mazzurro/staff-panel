class TimeTable {
    
    constructor(params) {
        this.dates = {};
        this.jump = params.jump; //In days
        for (var i = 0; i < params.dates.length; i++) {
            this.linkDate(params.dates[i]);
        }
        this.rows = ('rows' in params ? params.rows : {});
        this.slotItems = ('slotItems' in params ? params.slotItems : {});
        
        if ('jumpTo' in params) this.dateJump("right", params.jumpTo, false);

        if ('tableID' in params) this.createTable(params.tableID);
        
    }
    
    createTable(tableID) {
        this.table = $('#'+tableID).html(`<timetable class="timeline">

            <style class="timetable-styling"></style>
        </timetable>`).contents();
        
        this.updateStyling();
        
        for (var date in this.dates) {
            this.insertDate(1, this.dates[date].original);
        }
        
        for (var row in this.rows) {
            this.insertRow(1, this.rows[row]);
        }
    }
    
    updateStyling() {
        let columns = '[sections] 150px', rows = '[dates] 50px', jumpIn = function (slotItem, tableClass) {

            if (!('slotItems' in slotItem) || slotItem['slotItems'].length == 0) return;
            
            let slotItemCSS = '';
            for (var slotItemID in slotItem.slotItems) {
                slotItemCSS += ' [row-item-'+slotItemID+'] auto';
                slotItemCSS += jumpIn(tableClass.slotItems[slotItemID], tableClass);
            }
            return slotItemCSS;
        };
        
        for (var date in this.dates) {
            columns += ' [col-'+date+'] 250px [col-'+date+'-end] 0px';
        }
        
        for (var section in this.rows) {
            rows += ' [row-'+section+'-start] auto';
            rows += jumpIn(this.rows[section], this);
            rows += ' [row-'+section+'-end] auto';
        }
        
        $('.timetable-styling').text('.timeline { grid-template-columns: '+columns+'; grid-template-rows: '+rows+';}');
    }
    
    linkSlotItem(parent, item) {
        parent.slotItems[item.slotID] = item.slotID;
    }
    
    insertSlotItem(item) {
        
        //Calculate width
        let trueDateRange = this.validateDateRange({startDate:item.startDate,endDate:item.endDate});
        $('.timeline').append(`<div class="slot-item" data-slotID="`+item.slotID+`" style="grid-column: col-`+trueDateRange.startDate+` / col-`+trueDateRange.endDate+`-end; grid-row: row-item-`+item.slotID+`;">
                <div style="background-color: #00b5ad;color: red;width: 100%;height: 100px;text-align: center;">
                    <img style="margin: auto;" src="../../media/images/avatars/antonio-ho-sin2t.jpg">
                </div>
                <div class="slot-item-title">
                    <div class="slot-item-title-top">
                        <div class="slot-dropdown-arrow">
                            <i class="fas fa-caret-square-down"></i>
                        </div>
                        <div>`+item.title+`</div>
                    </div>
                    <div class="slot-dropdown-content">
                        <ul>
                            <li class="slot-dropdown-item">View Information</li>
                            <li class="slot-dropdown-item" data-slot-dropdown="level">View Level 2s</li>
                        </ul>
                    </div>
                </div>
                <div class="slot-item-final"></div>
            </div>`);
    }
    
    
    
    validateDateRange(dateRange) {
        if (!(dateRange.startDate in this.dates)) dateRange.startDate = this.dates[Object.keys(this.dates)[0]].dateID;
        if (!(dateRange.endDate in this.dates)) dateRange.endDate = this.dates[Object.keys(this.dates)[Object.keys(this.dates).length - 1]].dateID;
        return dateRange;
    }
    
    dateJump(direction, numOfJumps, update) {
        if (numOfJumps <= 0) return;
        
        if (direction == "left") {
            let newDate = new Date((new Date(this.dates[Object.keys(this.dates)[0]].original)).getTime() - this.jump * 24 * 60 * 60 * 1000);
            let formatDate = this.formatDate(newDate);
            if (update) this.handleDate(0, formatDate);
            else this.linkDate(formatDate);
        } else if (direction == "right") {
            let newDate = new Date((new Date(this.dates[Object.keys(this.dates)[Object.keys(this.dates).length - 1]].original)).getTime() + this.jump * 24 * 60 * 60 * 1000);
            let formatDate = this.formatDate(newDate);
            if (update) this.handleDate(1, formatDate);
            else this.linkDate(formatDate);
        }
        
        this.dateJump(direction, --numOfJumps, update);
    }
    
    linkDate(dateVal) {
        this.dates[this.formatDateID(dateVal)] = {
            dateID: this.formatDateID(dateVal),
            original: dateVal
        };
    }
    
    insertDate(position, dateVal) {
        $('.timeline').append(`<timetable-head style="grid-column: col-`+this.formatDateID(dateVal)+` / col-`+this.formatDateID(dateVal)+`; grid-row: dates;" data-column="`+this.formatDateID(dateVal)+`"><div>`+(new Date(dateVal)).toDateString()+`</div></timetable-head>`);
    }
    
    handleDate(position, dateVal) {
        this.linkDate(dateVal);
        this.insertDate(position, dateVal);
    }
    
    removeDate(position) {
        
    }
    
    insertRow(position, row) {
        $('.timeline').append(`<timetable-row style="grid-column: sections; grid-row: row-`+row.rowID+`-start / row-`+row.rowID+`-end;" data-section="`+row.rowID+`"><div>`+row.title+`</div></timetable-section>`);
        
        for (var item in row.slotItems) {
            this.insertSlotItem(this.slotItems[item]);
        }
    }
    
    removeRow() {
        
    }
    
    formatDate(dateObj) {
        return dateObj.getFullYear() + '/' + ((parseInt(dateObj.getMonth().toString()) + 1).toString().length == 1 ? '0'+(parseInt(dateObj.getMonth().toString()) + 1) : (parseInt(dateObj.getMonth().toString()) + 1)) + '/' + (dateObj.getDate().toString().length == 1 ? '0'+dateObj.getDate() : dateObj.getDate());
    }
    
    formatDateID(date) {
        return date.replace(/\//g, '');
    }
    
}