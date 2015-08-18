<?php
/**
 * Created by PhpStorm.
 * User: Hana
 * Date: 2015-08-18
 * Time: 오후 5:00
 */

require("../vendor/autoload.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="js/webix/codebase/webix.css" type="text/css" media="screen" charset="utf-8">
    <script src="js/webix/codebase/webix.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery/jquery-2.1.4.min.js" type="text/javascript" charset="utf-8"></script>

    <style type="text/css">
        body {
            background-color: #ddd;
        }
        .webix_view, .webix_el_box .webixtype_form {
            font-family: 'PT Sans', Tahoma, 'Nanum Gothic', 'Malgun Gothic', serif;
        }
        .number .webix_cell {
            text-align: center;
        }
        .webix_view.webix_form.word_input {
            border-radius: 6px;
        }
        .word_input.noun {
            background-color: #CD812B;
        }
        .word_input.verb {
            background-color: #F17075;
        }
        .word_input.adverb {
            background-color: #7B6A97;
        }
        .word_input.adjective {
            background-color: #608F63;
        }
        .word_input .webix_el_label {
            font-size: 30px;
            color: whitesmoke;
        }
        .main_container {
            margin: 0 auto;
        }
        .hide {
            display:none !important;
        }
        .inline_block {
            display: inline-block;
        }
        .love_heart {
            width: 100%;
            height: 100%;
            margin: auto 0;
            background-image: url("images/love_heart_512.png");
        }
        .love_heart div {
            font-size: 50px;
            margin: auto 0;
            padding-top: 200px;
            text-align: center;
        }
    </style>
</head>
<body>
<!--<div id="container" style="width:960px;height:100%;"></div>-->
<script type="text/javascript" charset="UTF-8">
    function showLovePopup() {
        webix.ui({
            view:"popup",
            width: 542, height:542,
            position:"center",
            head:"사랑합니다",
            body: {
                template:"<div class='love_heart'><div>사랑합니다</div></div>"
            }
        }).show();
    }
    var favoriteMenu = {
        id: "side-menu", view: "menu", layout: "y", select:true, width: 200, data: [
            {id: 1, icon: "support", value: "♥ 이름별 보기", badge: "12"},
            {id: 2, icon: "support", value: "★ 평가별 보기", badge: "27"}
        ],
        on: {
            onMenuItemClick: function (id) {
                console.log(id);
            }
        }
    };
    var generateMenu = {
        id: "side-menu", view: "menu", layout: "y", select:true, width: 200, data: [
            {id: 1, icon: "support", value: "문장생성", badge: "12"}
        ],
        on: {
            onMenuItemClick: function (id) {
                console.log(id);
            }
        }
    };
    var wordListMenu = {
        id: "side-menu", view: "menu", layout: "y", select: true, width: 200, data: [
            {id: 1, icon: "support", value: "시", badge: "12"},
            {id: 2, icon: "support", value: "동시", badge: "27"},
            {id: 3, icon: "support", value: "소설", badge: "99"},
            {id: 4, icon: "support", value: "수필", badge: "99"},
            {id: 5, icon: "support", value: "동화", badge: "99"},
            {id: 6, icon: "support", value: "기타", badge: "99"}
        ],
        on: {
            onMenuItemClick: function (id) {
                console.log(id);
            }
        }
    };

    var currentMenuId = "show_word";
    webix.ui({
//        container:"container",
        type:"wide", css:"main_container", cols:[{
            type: "space",
            width:960,
            rows: [
                {id:"toolbar", view:"toolbar",cols:[
                    { view:"label", template: "Sentence Generator 시어 생성기 사랑합니다♥"},
                    { view:"button", id:"show_word", type:"icon", icon:"envelope", label:"단어보기", width:100, align:"left", on:{
                        onItemClick:function(id) {

                            if (currentMenuId !== "show_word") {
                                $$("body_layout").removeView("side-menu");
                                $$("body_layout").addView(wordListMenu, 0);
                                $$("side-menu").select(1);
                            }

                            currentMenuId = "show_word";
                        }
                    } },
                    { view:"button", id:"show_favorite", type:"icon", icon:"users", label:"즐겨찾기", width:100, align:"left", on:{
                        onItemClick:function(id) {
                            if (currentMenuId !== "show_favorite") {
                                $$("body_layout").removeView("side-menu");
                                $$("body_layout").addView(favoriteMenu, 0);
                                $$("side-menu").select(1);
                            }

                            currentMenuId = "show_favorite";
                        }
                    } },
                    { view:"button", id:"show_generate", type:"icon", icon:"cog", label:"문장생성", width:100, align:"left", on:{
                        onItemClick:function(id) {
                            if (currentMenuId !== "show_generate") {
                                $$("body_layout").removeView("side-menu");
                                $$("body_layout").addView(generateMenu, 0);
                                $$("side-menu").select(1);
                            }

                            currentMenuId = "show_generate";
                        }
                    } }
                ]},
                {id:"body_layout", cols: [webix.copy(wordListMenu),
//                        {view:"tree", width:200, data:[
//                            {id:"root1", value:"단어보기", open:true, data:[
//                                {id: 1, icon: "support", value: "시", badge: "12"},
//                                {id: 2, icon: "support", value: "동시", badge: "27"},
//                                {id: 3, icon: "support", value: "소설", badge: "99"},
//                                {id: 4, icon: "support", value: "수필", badge: "99"},
//                                {id: 5, icon: "support", value: "동화", badge: "99"},
//                                {id: 6, icon: "support", value: "기타", badge: "99"}
//                            ]}
//                        ]},
                        {$template: "Spacer", width: 10},
                        {
                            rows: [
                                {
                                    view: "form", id: "word_input_form", css: "word_input noun", elements: [
                                    {id:"word_input_title", view: "label", label: "명사"},
                                    {
                                        cols: [
                                            {view: "text", label: "", on:{
                                                onKeyPress: function(keyCode, event) {
                                                    if (keyCode === 13) {
                                                        showLovePopup();
                                                    }
                                                }
                                            }},
                                            {view: "button", value: "입력", type: "form", width: 100, on:{
                                                onItemClick: function(id, event) {
                                                    showLovePopup();
                                                    return false;
                                                }
                                            }}
                                        ]
                                    }
                                ]
                                },
                                {$template: "Spacer", height: 10},
                                {
                                    view: "tabbar", id:"tabbar", value:"noun", multiview:true, options: [
                                    {value:"명사", id:"noun"},
                                    {value:"동사", id:"verb"},
                                    {value:"부사", id:"adverb"},
                                    {value:"형용사", id:"adjective"}
                                ],on: {
                                    onAfterTabClick: function(id, event) {
                                        console.log("on after");

                                    },
                                    onBeforeTabClick: function(id, event) {
                                    },
                                    onChange: function(newV, oldV) {
                                        var wordInputTitle = $$("word_input_title");
                                        var $wordInputTitle = jQuery("div[view_id='word_input_form']");
                                        $wordInputTitle.removeClass(oldV).addClass(newV);
                                        if (newV == "noun") {
                                            wordInputTitle.setValue("명사");
                                        } else if (newV == "verb") {
                                            wordInputTitle.setValue("동사");
                                        } else if (newV == "adverb") {
                                            wordInputTitle.setValue("부사");
                                        } else if (newV == "adjective") {
                                            wordInputTitle.setValue("형용사");
                                        }
                                    }
                                }},
                                {
                                    cells:[
                                    {
//                                        header: "명사", body: {
                                        id: "noun", view: "datatable", columns: [
                                            {id: "number", header: "No.", width: 50, css: "number"},
                                            {
                                                id: "noun_checkbox",
                                                header: {content: "masterCheckbox"},
                                                checkValue: "on",
                                                uncheckValue: "off",
                                                template: "{common.checkbox()}",
                                                width: 40
                                            },
                                            {id: "title", header: "단어", width: 200},
                                            {id: "year", header: "Release year", fillspace: true},
                                            {id: "votes", header: "Votes", width: 200}
                                        ],
                                        data: [
                                            {
                                                id: 1,
                                                number: "1",
                                                title: "The Shawshank Redemption",
                                                year: 1994,
                                                votes: 678790
                                            },
                                            {id: 2, number: "2", title: "The Godfather", year: 1972, votes: 511495}
                                        ],
                                            select:true
//                                    }
                                    },
                                    {
//                                        header: "동사", body: {
                                        id: "verb", view: "datatable", columns: [
                                            {id: "number", header: "No.", width: 50, css: "number"},
                                            {
                                                id: "verb_checkbox",
                                                header: {content: "masterCheckbox"},
                                                checkValue: "on",
                                                uncheckValue: "off",
                                                template: "{common.checkbox()}",
                                                width: 40
                                            },
                                            {id: "title", header: "Film title", width: 200},
                                            {id: "year", header: "Release year", fillspace: true},
                                            {id: "votes", header: "Votes", width: 200}
                                        ],
                                        data: [
                                            {
                                                id: 1,
                                                number: "1",
                                                title: "The Shawshank Redemption",
                                                year: 1994,
                                                votes: 678790
                                            },
                                            {id: 2, number: "2", title: "The Godfather", year: 1972, votes: 511495},
                                            {id: 3, number: "3", title: "Interstellar", year: 2014, votes: 511445}
                                        ]
//                                    }
                                    },
                                    {
//                                        header: "형용사", body: {
                                        id: "adverb", view: "datatable", columns: [
                                            {id: "number", header: "No.", width: 50, css: "number"},
                                            {
                                                id: "verb_checkbox",
                                                header: {content: "masterCheckbox"},
                                                checkValue: "on",
                                                uncheckValue: "off",
                                                template: "{common.checkbox()}",
                                                width: 40
                                            },
                                            {id: "title", header: "Film title", width: 200},
                                            {id: "year", header: "Release year", fillspace: true},
                                            {id: "votes", header: "Votes", width: 200}
                                        ],
                                        data: [
                                            {
                                                id: 1,
                                                number: "1",
                                                title: "The Shawshank Redemption",
                                                year: 1994,
                                                votes: 678790
                                            },
                                            {id: 2, number: "2", title: "The Godfather", year: 1972, votes: 511495},
                                            {id: 3, number: "3", title: "Interstellar", year: 2014, votes: 511445}
                                        ]
//                                    }
                                    },
                                    {
//                                        header: "부사", body: {
                                        id: "adjective", view: "datatable", columns: [
                                            {id: "number", header: "No.", width: 50, css: "number"},
                                            {
                                                id: "verb_checkbox",
                                                header: {content: "masterCheckbox"},
                                                checkValue: "on",
                                                uncheckValue: "off",
                                                template: "{common.checkbox()}",
                                                width: 40
                                            },
                                            {id: "title", header: "Film title", width: 200},
                                            {id: "year", header: "Release year", fillspace: true},
                                            {id: "votes", header: "Votes", width: 200}
                                        ],
                                        data: [
                                            {
                                                id: 1,
                                                number: "1",
                                                title: "The Shawshank Redemption",
                                                year: 1994,
                                                votes: 678790
                                            },
                                            {id: 2, number: "2", title: "The Godfather", year: 1972, votes: 511495},
                                            {id: 3, number: "3", title: "Interstellar", year: 2014, votes: 511445}
                                        ]
//                                    }
                                    }
                                    ]
                                }
                            ]
                        }
                    ]
                }
            ]
        }]});

    $$("side-menu").select(1);
    $$("word_input_title").setValue("명사");

</script>
</body>
</html>