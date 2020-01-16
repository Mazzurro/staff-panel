<div id="social-media-postings" class="panel">
    <div class="panel">
        <div class="panel-content">
            <div class="box">
                <div class="box-head">
                    <h3>Schedule Options</h3>
                </div>
                <div class="box-content">
                    <div class="box box-dropdown">
                        <div class="box-head">
                            <div class="box-dropdown-click">
                                <h5>Filter</h5>
                            </div>
                        </div>
                        <div class="box-content invert">
                            
                        </div>
                    </div>
                    <div class="box box-dropdown">
                        <div class="box-head">
                            <div class="box-dropdown-click">
                                <h5>Download As</h5>
                            </div>
                        </div>
                        <div class="box-content invert">
                            <button id="downloadCSV">CSV</button>
                            <button id="downloadPDF">PDF</button>
                        </div>
                    </div>
                    <div class="box box-dropdown">
                        <div class="box-head">
                            <div class="box-dropdown-click">
                                <h5>Upload CSV</h5>
                            </div>
                        </div>
                        <div class="box-content invert">
                            <form id="uploadCSV" method="post" enctype="multipart/form-data">
                                <p>Before uploading, please ensure you have all the columns below (excluding Posting ID) included and ordered in your CSV file.</p>
                                <input type="file" name="csvFile">
                                <span></span>
                                <input type="submit" value="Upload">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-content">
            <div id="example-table"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var table = new Tabulator("#example-table", {          //load row data from array
    	tooltips:true,            //show tool tips on cells
    	pagination:"local", //enable remote pagination
        ajaxURL:"https://72dragons.com/staff/api/social-media/schedule/list", //set url for ajax request
        paginationSize:20,
        initialSort:[             //set the initial sort order of the data
    		{column:"postingID", dir:"desc"},
    	],
    	cellEdited:function(cell){
    	    submitCell(cell, 0);
        },
    	columns:[
            {title:"Posting ID", field:"postingID", sorter:"number"},
            {title:"Month", field:"thisMonth", sorter:"string", editor:"select", editorParams:{values:["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]}},
            {title:"Ring", field:"thisRing", sorter:"string", editor:"autocomplete", editorParams:{values:true}},
            {title:"Sphere", field:"thisSphere", sorter:"string", editor:"autocomplete", editorParams:{values:true}},
            {title:"RAG", field:"rag", sorter:"string", editor:"select", align:"center", editorParams:{values:["Green", "Yellow", "Red"]}},
            {title:"First Draft Due", field:"firstDraftDue", sorter:"date", sorter:"date", align:"center", editor:true},
            {title:"Second Draft Due", field:"secondDraftDue", sorter:"date", sorter:"date", align:"center", editor:true},
            {title:"Posting Date", field:"postingDate", sorter:"date", sorter:"date", align:"center", editor:true},
            {title:"Comment", field:"comment", editor:true},
            {title:"Posting Time Range", field:"timeRangeToPost", sorter:"number", editor:"autocomplete", editorParams:{values:true}},
            {title:"Instant Or Scheduled", field:"scheduledPost", sorter:"number", editor:"select", editorParams:{values:["Instant", "Scheduled"]}},
            {title:"Manager Approval", field:"managerApproval", formatter:"tickCross", sorter:"boolean", align:"center", editor:true},
            {title:"Posting Manager", field:"postingManager", formatter:"tickCross", sorter:"boolean", align:"center", editor:true},
            {title:"Content", field:"thisCategory", sorter:"string", editor:"autocomplete", editorParams:{values:true}},
            {title:"Assigned To", field:"assignedTo", sorter:"string", editor:"autocomplete", editorParams:{values:true}},
            {title:"Post Type", field:"thisType", sorter:"string", editor:"autocomplete", editorParams:{values:true}},
            {title:"Series", field:"thisSeries", sorter:"string", editor:"autocomplete", editorParams:{values:true}},
            {title:"Title", field:"thisTitle", sorter:"string", editor:"autocomplete", editorParams:{values:true}},
            {title:"Content Detail", field:"contentDetail", sorter:"string", editor:"textarea"},
            {title:"Platform", field:"thisPlatform", sorter:"string", editor:"autocomplete", editorParams:{values:true}},
            {title:"Content Type", field:"thisContentType", sorter:"string", editor:"autocomplete", editorParams:{values:true}},
            {title:"Live Sessions", field:"thisLive", sorter:"string", editor:"autocomplete", editorParams:{values:true}},
            {title:"Target Region", field:"thisRegion", sorter:"string", editor:"autocomplete", editorParams:{values:true}},
            {title:"Target Language", field:"thisLanguage", sorter:"string", editor:"autocomplete", editorParams:{values:true}}
        ]
    });
    
    function submitCell(cell, tries) {
        if (++tries == 3) return addNotif('Unable to Update', 'The maximum number of tries has been reached (3). Please try again or ensure you are connected to the internet.', 2);
	    $.post('...', {val:cell._cell.value,id:cell._cell.row.data.postingID,item:cell._cell.column.field}).done(function () {
	        
	    }).fail(function(data) {
            addNotif(data.title, data.message, 2);
            submitCell(cell, tries);
        });
    }
    
    document.getElementById('downloadCSV').addEventListener('click', function () {
       table.download("csv", "data.csv"); 
    });
    
    $(document).ready(function () {
       setBLDD('#social-media-postings'); 
       
        $('#uploadCSV').submit(function (e) {
            e.preventDefault();
            
            var form = $(this), formData = new FormData(form[0]);
            $.ajax({
                url: '/staff/api/social-media/schedule/upload',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                xhr: function() {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        myXhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                var progressPercent = Math.floor((e.loaded / e.total) * 100) + '%';
                                $(form).find('span').text('Upload Progress: '+progressPercent);
                            }
                        } , false);
                    }
                    return myXhr;
                }
            }).done(function(data) {
                form.find('input[type=file]').val('');
                form.find('span').text('Upload Complete');
                addNotif(data.title, data.message, 1);
            }).fail(function(data) {
                addNotif(data.title, data.message, 2);
            });
        });
    });
</script>