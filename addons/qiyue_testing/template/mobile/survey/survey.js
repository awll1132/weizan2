(function() {
    var e, _EVENTS;

    require.config({
        urlArgs: "_v=0.13",
        baseUrl: './../addons/testing/template/mobile/js',
        paths: {
            'zepto': 'zepto.min',
        }
    });

    _EVENTS = {
        tap: 'tap'
    };

    if (!/(android)|(iphone)|(ipod)/i.test(navigator.userAgent)) {
        _EVENTS.tap = 'click';
    }

    require(['zepto','http://res.wx.qq.com/open/js/jweixin-1.0.0.js'], function($, wx) {
        var pages, survery, _load_share_data;
        u = $(window).width();
        a = $(window).height();
        $(document.body).css({
            overflow: "hidden",
            width: u,
            height: a,
            "max-height": a
        }), document.addEventListener("touchmove", function(e) {
            e.preventDefault()
        });
        pages = {
            option: {
                'window': {
                    'width': null
                },
                page: {
                    number: null
                }
            },
            init: function() {
                this.option.window.width = $(window).width();
                this.option.page.number = $('.page').length;
                $('.pages').width(this.option.window.width * this.option.page.number);
                $('.page').width(this.option.window.width);
                $.fx.off = false;
                return this.page_item = $(".pages");
            },
            next: function(e) {
                var index, left, page, width;
                width = this.option.window.width;
                page = $(e.target).parents('.page').eq(0);
                index = $('.page').index(page);
                left = width * index + width;
                return this.page_item.animate({
                    translateX: -1 * left + 'px'
                }, 300, 'ease-out', function() {});
            },
            start: function(e) {
                var home;
                home = $(e.target).parents('.page').eq(0);
                return home.animate({
                    scale: '3,3',
                    opacity: 0
                }, 500, 'ease-out', function() {
                    return home.remove();
                });
            }
        };
        survery = {
            html: [],
            score: 0,
            subject_length: 0,
            subject_count: 0,
            result: {},
            answer: {},
            init: function() {
                var i, item, self, _i, _len, _ref,
                    _this = this;
                self = this;
                if (window.page_config.subject != null) {
                    this.subject_count = window.page_config.subject.length;
                    this.subject_length = window.page_config.subject.length;
                    _ref = window.page_config.subject;
                    for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
                        item = _ref[i];
                        this.creat_item(i + 1, item);
                    }
                    $('.home').after(this.html.join(''));
                }
                this.creat_result();
                $(document).on(_EVENTS.tap, '.option', function(e) {
                    var optionid, score, subjectid;
                    self.subject_count -= 1;
                    score = parseInt($(this).attr('score'));
                    optionid = $(this).attr('optionid');
                    subjectid = $(this).parent().attr('subjectid');
                    if (optionid) {
                        self.answer[subjectid] = {
                            selected: [optionid]
                        };
                    }
                    self.score += score;
                    if (self.subject_count === 0) {
                        return self.end();
                    }
                });
                $(document).on(_EVENTS.tap, '#share', function(e) {
                    return _this.share();
                });
                $(document).on(_EVENTS.tap, '#again', function(e) {
                    return _this.again();
                });
                $(document).on(_EVENTS.tap, '#weixin', function(e) {
                    return _this["public"]();
                });
                // return $("#weixin").hide();
            },
            get_params: function() {
                return this.answer;
            },
            creat_item: function(i, data) {
                var html, option, _i, _len, _ref;
                var desc = '';
                if (data.desc) {
                    desc = data.desc;
                    desc = desc.replace("\r\n", "<br />");
                }
                html = [];
                html.push('<div class="page">\
                  <div class="page-content">\
                      <div class="progress"><div><span>' + i + '</span>/' + this.subject_length + '</div></div>\
                      <h2>' + data.title + '</h2>\
                      <p>' + desc + '</p>\
                      <ul class="options" subjectid=' + data.subjectid + '>');
                _ref = data.option;
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    option = _ref[_i];
                    html.push('<li class="next option" optionid="' + option.optionid + '" score="' + option.score + '">' + option.title + '</li>');
                }
                html.push('</ul></div></div>');
                return this.html.push(html.join(''));
            },
            creat_result: function() {
                var html;
                html = [];
                if (window.page_config.show_score == 1) {
                    html.push('<div class="score"><b>0</b>');
                    if (window.page_config.index && window.page_config.index.name) {
                        html.push('<span>你的<i>' + window.page_config.index.name + '</i>指数</span>');
                    }
                    else {
                        html.push('<span>你的得分</span>');
                    }
                    html.push('</div>');
                    console.log(html);
                }
                html.push('<div class="conclusion"></div>');
                html.push('<p class="discription"></p>');
                html.push('<ul class="options">');
                html.push('<li onclick="location.reload()">再来一次</li>');
                html.push('<li id="share"><span class="share">给好友看看</span></li>');
                if (window.page_config.next != '') {
                    html.push('<li id="again">' + window.page_config.next.title + '</li>');
                }
                if (window.page_config.weixin.openid == "" && window.page_config.weixin.follow_url != "") {
                    html.push('<li id="weixin">关注' + window.page_config.weixin.nickname + '</li>');
                }
                html.push('</ul>');
                return $('.result .page-content').html(html.join(''));
            },
            find_result: function() {
                var end, result, start, _i, _len, _ref, _results;
                _ref = window.page_config.result;
                _results = [];
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    result = _ref[_i];
                    start = result.range_start;
                    end = result.range_end;
                    if (this.score >= start && this.score <= end) {
                        this.result = result;
                        break;
                    }
                    else {
                        _results.push(void 0);
                    }
                }
                return _results;
            },
            share: function() {
                return $(".share_overmask").show();
            },
            again: function() {
                return window.location.href = window.page_config.next.url;
            },
            "public": function() {
                return window.location.href = window.page_config.weixin.follow_url;
            },
            end: function() {
                var _share = window.page_config.share;
                this.find_result();
                $('.result .score b').html(this.score);
                if(this.result.summary){
                    $('.result .discription').html(this.result.summary.replace(/\r\n/ig, "<br/>"));
                }
                if ((this.result.conclusion != null) && this.result.conclusion != '') {
                    $('.result .conclusion').html('<span>' + this.result.conclusion + '</span>');
                }
                else {
                    $('.result .conclusion').remove();
                }

                if ((window.page_config.show_score == 0)) {
                    window.page_config.share.title = '我是' + survery.result.conclusion + '，来回答几道题，看看你的测试结果！';
                    window.page_config.share.title = survery.result.conclusion;
                }
                else {
                    window.page_config.share.title = '我的' + page_config.index.name + '指数为:' + this.score + '，你的呢？';
                    // + page_config.share.abstract
                }
                _load_share_data();
                _tools('people'); // 参加测试并出结果
            },
            style: function() {
                var banner, color, cover, style_config, _style;
                style_config = window.page_config.style;
                color = style_config.color;
                if (style_config.color_action == null) {
                    style_config.color_action = color;
                }
                if (style_config.color_result == null) {
                    style_config.color_result = color;
                }
                cover = style_config.cover;
                banner = style_config.banner;
                _style = '<style type="text/css">';
                if (window.page_config.next.url === '') {
                    _style += "#again{display:none;}";
                }
                //按钮
                if (style_config.button_img) {
                    _style += '.home .start span{background:url(' + style_config.button_img + ');-webkit-background-size: 100%;background-size: 100%;text-indent: -9999px;}';
                }
                else {
                    _style += '.home .start span{border-radius: 70px;border: 8px solid rgba(255, 255, 255, 0.8);box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.6);text-shadow: 0px 0px 1px rgba(0, 0, 0, 0.6);}';
                }
                _style += '\
          .options li{background-color:' + color + ';}\
          /*主题按下色*/\
          .options li:active{background-color:' + style_config.color_action + ';}\
           ';

                _style += '\
          /*封面图*/\
          .home .page-content {background-image: url(' + cover + ');}\
          /* 主题色*/\
          .progress div,h2{color:' + color + ';}\
          .progress div,h2{border:5px solid ' + color + ';}\
          /*结果反色*/\
          .result .score{background-color:' + style_config.color_result + ';}\
          .result .score span i{color:' + style_config.color_result + ';}';
                _style += '</style>';
                return $("head").append($(_style));
            }
        };
        survery.style();

        _tools = function(e) {
            $.getJSON(baseUrl+'&do=tools&op='+e);
        };
        _load_share_data = function() {
            var sharedata = window.page_config.share;
            wx.config(jssdkconfig);
            wx.ready(function () {
                wx.onMenuShareAppMessage(sharedata);
                wx.onMenuShareTimeline(sharedata);
                wx.onMenuShareQQ(sharedata);
                wx.onMenuShareWeibo(sharedata);
                // console.log(data)
            });
        };
        return $(function() {
            _load_share_data();
            survery.init();
            pages.init();
            _tools('viewnum');
            $(document).on(_EVENTS.tap, '.next', function(e) {
                return pages.next(e);
            });
            $(document).on(_EVENTS.tap, '.start', function(e) {
                return pages.start(e);
            });
            $(document).on(_EVENTS.tap, '.share_overmask', function() {
                return $(".share_overmask").hide();
            });
            return $(".page-loading-mask").animate({
                opacity: 0
            }, 500, 'ease-out', function() {
                return $(".page-loading-mask").remove();
            });
        });
    });
}).call(this);
