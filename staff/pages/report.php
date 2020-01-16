<!-- <!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <link rel="stylesheet" type="text/css" href="/staff/scripts/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="/staff/scripts/slick/slick-theme.css">
    <script type="text/javascript" src="/staff/scripts/slick/slick.js"></script>
    <link rel="stylesheet" type="text/css" href="/staff/scripts/tabulator/dist/css/tabulator.css">
    <script type="text/javascript" src="scripts/tabulator/dist/js/tabulator.js"></script>
    <script type="text/javascript" src="/staff/scripts/72classes/panel.js"></script>
    <script type="text/javascript" src="/staff/scripts/72classes/project.js"></script>
    <script type="text/javascript" src="/staff/scripts/72classes/tabs.js"></script>
</head> -->
<style>
    .report,
    .report_update {
        display: flex;
        justify-content: center;
    }

    #report,
    #assignment,
    #report_update {
        background: #141415;
        margin-top: 60px;
        border: 1px solid
    }

    .assignment {
        display: flex;
        flex-direction: column;
        align-items: center;
    }


    .title,
    .button {
        display: grid !important;
        place-content: center;
        color: #ad9440;
        font-size: 25px;
        margin-top: 30px;
    }

    .input_text {
        display: flex;

        margin: 30px;
    }

    .input_texts {
        display: flex;
        margin: 30px 0 0 100px
    }

    .input_text_div {
        display: flex;
        width: 50%
    }

    .text {
        color: #ad9440;
        font-size: 18px;
        width: 100px;
        line-height: 36px
    }


    input[type="number"],
    .upadtes {
        background: #141415;
        border: 1px solid #ad9440;
        height: 36px;
        width: 180px;
        font-size: 16px;

        color: #ad9440;
        font-family: 'Josefin Sans', sans-serif;
        padding: 0 0 0 10px;
        line-height: 36px;
    }

    input[type="text"] {
        background: #141415;
        border: 1px solid #ad9440;
        min-height: 38px;
        width: 400px;
        font-size: 16px;
        color: #ad9440;
        font-family: 'Josefin Sans', sans-serif;
        padding: 0 0 0 10px;
        margin-left: 15px;

    }

    .input_date {
        display: flex
    }

    .text_area {
        width: 400px;
        height: 36px;
        max-width: 400px;
        min-width: 200px;
        min-height: 38px;
        background: #141415;
        border: 1px solid #ad9440;
        margin-left: 15px;
        font-size: 16px;
        color: #ad9440;
    }

    .complete {
        margin: 0 20px 0 67px;
        line-height: 36px
    }

    .button_list {
        display: flex;
        justify-content: center;
    }

    #greports {
        width: 180px !important
    }

    #submit,
    #cancel,
    #enter,
    #select,
    #unselect,
    #greports {
        border: 1px solid #ad9440;
        background: #191919;
        color: #ad9440;
        box-shadow: 0px 3px 9px 1px rgba(0, 0, 0, 0.5);
        margin: 0px 70px 20px 70px;
        transition: box-shadow 0.25s;
        width: 100px
    }

    @media (min-width:360px) and (max-width:414px) {
        .report {
            display: flex;
            justify-content: center;
        }

        #report {
            background: #141415;
            margin-top: 15px;
            margin-bottom: 30px;
            border: 1px solid
        }

        .text {
            color: #ad9440;
            font-size: 15px;
            line-height: 30px
        }

        .input_text {
            display: block;
            margin: 10px;
        }

        .input_text_div {
            display: block;
            width: 100%
        }

        input[type="text"],
        input[type="number"],
        .upadtes {
            background: #141415;
            border: 1px solid #ad9440;
            height: 30px;
            width: 100%;
            font-size: 10px;
            max-width: 240px;
            color: #ad9440;
            font-family: 'Josefin Sans', sans-serif;
            padding: 0 0 0 5px;
            margin-left: 0;
            line-height: 30px;
        }

        .input_date {
            display: block
        }

        .input_date>input {
            margin: 6px 0;
        }

        .text_area {
            height: 25px;
            min-width: 240px;
            min-height: 30px;
            background: #141415;
            border: 1px solid #ad9440;
            margin-left: 0px;
            font-size: 16px;
            color: #ad9440;
        }

        .complete {
            margin: 0;
            margin-top: 5px;
            line-height: 25px
        }

        .button_list {
            display: flex;
            justify-content: center;
        }

        #submit,
        #cancel {
            border: 1px solid #ad9440;
            background: #191919;
            color: #ad9440;
            box-shadow: 0px 3px 9px 1px rgba(0, 0, 0, 0.5);
            margin: 15px;
            transition: box-shadow 0.25s;
            height: 25px;
            line-height: 5px;
        }
    }
</style>

<body>
    <div class="report">
        <div id="report">
            <div class="title">Select Date Range For Report</div>
            <div class="input_text">
                <span class="text">start date</span>
                <div class="input_date">
                    <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                </div>
            </div>
            <div class="input_text">
                <span class="text">end date</span>
                <div class="input_date">
                    <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                </div>
            </div>
            <div class="button">
                <button id="enter">Enter</button>
            </div>
        </div>
    </div>
    <div class="assignment">
        <div id="assignment">
            <span class="title"># Assignmetns Selected</span>
            <div>
                <div style="display:flex;flex-flow:wrap">
                    <div class="input_text">
                        <span class="text ">Title</span>
                        <input type="text" value="" placeholder="">
                    </div>
                    <div class="input_text">
                        <span class="text">start date</span>
                        <div class="input_date">
                            <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                        </div>
                    </div>
                </div>
                <div style="display:flex;flex-flow:wrap">
                    <div class="input_text">
                        <span class="text">Description</span>
                        <textarea class="text_area" value="" placeholder="" placeholder-class="textarea-placeholder">
               </textarea>
                    </div>
                    <div class="input_text">
                        <span class="text">end date</span>
                        <div class="input_date">
                            <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                        </div>
                    </div>
                </div>
                <div class="input_texts">
                    <button id="select">Select</button>
                    <button id="unselect">UnSelect</button>
                </div>
            </div>
            <div>
                <div style="display:flex;flex-flow:wrap">
                    <div class="input_text">
                        <span class="text ">Title</span>
                        <input type="text" value="" placeholder="">
                    </div>
                    <div class="input_text">
                        <span class="text">start date</span>
                        <div class="input_date">
                            <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                        </div>
                    </div>
                </div>
                <div style="display:flex;flex-flow:wrap">
                    <div class="input_text">
                        <span class="text">Description</span>
                        <textarea class="text_area" value="" placeholder="" placeholder-class="textarea-placeholder">
               </textarea>
                    </div>
                    <div class="input_text">
                        <span class="text">end date</span>
                        <div class="input_date">
                            <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                        </div>
                    </div>
                </div>
                <div class="input_texts">
                    <button id="select">Select</button>
                    <button id="unselect">UnSelect</button>
                </div>
            </div>
            <div>
                <div style="display:flex;flex-flow:wrap">
                    <div class="input_text">
                        <span class="text ">Title</span>
                        <input type="text" value="" placeholder="">
                    </div>
                    <div class="input_text">
                        <span class="text">start date</span>
                        <div class="input_date">
                            <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                        </div>
                    </div>
                </div>
                <div style="display:flex;flex-flow:wrap">
                    <div class="input_text">
                        <span class="text">Description</span>
                        <textarea class="text_area" value="" placeholder="" placeholder-class="textarea-placeholder">
               </textarea>
                    </div>
                    <div class="input_text">
                        <span class="text">end date</span>
                        <div class="input_date">
                            <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                        </div>
                    </div>
                </div>
                <div class="input_texts">
                    <button id="select">Select</button>
                    <button id="unselect">UnSelect</button>
                </div>
            </div>
            <div>
                <div style="display:flex;flex-flow:wrap">
                    <div class="input_text">
                        <span class="text ">Title</span>
                        <input type="text" value="" placeholder="">
                    </div>
                    <div class="input_text">
                        <span class="text">start date</span>
                        <div class="input_date">
                            <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                        </div>
                    </div>
                </div>
                <div style="display:flex;flex-flow:wrap">
                    <div class="input_text">
                        <span class="text">Description</span>
                        <textarea class="text_area" value="" placeholder="" placeholder-class="textarea-placeholder">
               </textarea>
                    </div>
                    <div class="input_text">
                        <span class="text">end date</span>
                        <div class="input_date">
                            <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                        </div>
                    </div>
                </div>
                <div class="input_texts">
                    <button id="select">Select</button>
                    <button id="unselect">UnSelect</button>
                </div>
            </div>
            <div>
                <div style="display:flex;flex-flow:wrap">
                    <div class="input_text">
                        <span class="text ">Title</span>
                        <input type="text" value="" placeholder="">
                    </div>
                    <div class="input_text">
                        <span class="text">start date</span>
                        <div class="input_date">
                            <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                        </div>
                    </div>
                </div>
                <div style="display:flex;flex-flow:wrap">
                    <div class="input_text">
                        <span class="text">Description</span>
                        <textarea class="text_area" value="" placeholder="" placeholder-class="textarea-placeholder">
               </textarea>
                    </div>
                    <div class="input_text">
                        <span class="text">end date</span>
                        <div class="input_date">
                            <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                        </div>
                    </div>
                </div>
                <div class="input_texts">
                    <button id="select">Select</button>
                    <button id="unselect">UnSelect</button>
                </div>
            </div>
            <div>
                <div style="display:flex;flex-flow:wrap">
                    <div class="input_text">
                        <span class="text ">Title</span>
                        <input type="text" value="" placeholder="">
                    </div>
                    <div class="input_text">
                        <span class="text">start date</span>
                        <div class="input_date">
                            <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                        </div>
                    </div>
                </div>
                <div style="display:flex;flex-flow:wrap">
                    <div class="input_text">
                        <span class="text">Description</span>
                        <textarea class="text_area" value="" placeholder="" placeholder-class="textarea-placeholder">
               </textarea>
                    </div>
                    <div class="input_text">
                        <span class="text">end date</span>
                        <div class="input_date">
                            <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                        </div>
                    </div>
                </div>
                <div class="input_texts">
                    <button id="select">Select</button>
                    <button id="unselect">UnSelect</button>
                </div>
            </div>
            <div class="button">
                <button id="greports">Generaly Report</button>
            </div>
        </div>
    </div>
    <div class="report_update">
        <div id="report_update">
            <div class="input_text">
                <span class="text">Title</span>
                <input type="text" value="" placeholder="">
            </div>
            <div class="input_text">
                <span class="text">Descrip</span>
                <textarea class="text_area" value="" placeholder="" placeholder-class="textarea-placeholder">
            </textarea>
            </div>
            <div class="input_text">
                <span class="text">start date</span>
                <div class="input_date" style="margin-left: 15px">
                    <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                </div>
            </div>
            <div class="input_text">
                <span class="text">end date</span>
                <div class="input_date" style="margin-left: 15px">
                    <input type="number" placeholder="YYYY" value=""> <input type="number" placeholder="MM" value=""> <input type="number" placeholder="DD" value="">
                </div>
            </div>

            <div class="input_text">
                <div class="input_text_div">
                    <span class="text">updates</span>
                    <div class="upadtes" style="margin-left:15px">25</div>
                </div>
                <div class="input_text_div">
                    <span class="complete">completed</span>
                    <div class="upadtes">0%</div>
                </div>
            </div>
            <div class="button_list">
                <button id="submit">Submit</button>
                <button id="cancel">Cancel</button>
            </div>
        </div>
    </div>
</body>

