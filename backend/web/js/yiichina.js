/**
 * 
 */
jQuery(document).ready(function () {
    $(".feed-index").slimScroll({
        height: "350px",
        wheelStep: 10
    });

    if($(window).height() - 200 < $('.online-scroll').height()) {
        height =  $(window).height() - 200;
    } else {
        height = $('.online-scroll').height() + 3;
    }

    $(".online-scroll").slimScroll({
        height: height,
        wheelStep: 10,
        size: "5px"
    });
    
    // tooltip
	$("[data-toggle=tooltip]").tooltip({container: 'body'});

    // back-to-top
    $(window).scroll(function(){
        if ($(this).scrollTop() > 500) {
            $('.back-to-top').fadeIn();
        } else {
            $('.back-to-top').fadeOut();
        }
    });
    $(".back-to-top").click(function(e) {
        e.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });

    // 签到
    $(".btn-registration").click(function(){
        var button = $(this);
        $.ajax({
            url: "/registration",
            dataType: 'json',
            success: function(html){
                button.html("<span class=\"fa fa-calendar\"></span> 今日已签到<br />已连续" + html.days + "天").addClass('disabled');
            },
            error: function (XMLHttpRequest, textStatus) {
                $('#modal').modal({ remote: '/login'});
                this.abort();
            }
        });
        return false;
    });

    //说说表情
    $(".emot").popover({
        html: true,
        placement: 'bottom',
        content: '<table class="emot">\
            <tr><td><img src="/images/emot/1.gif" alt="微笑" /></td><td><img src="/images/emot/2.gif" alt="撇嘴" /></td><td><img src="/images/emot/3.gif" alt="色" /></td><td><img src="/images/emot/4.gif" alt="发呆" /></td><td><img src="/images/emot/5.gif" alt="得意" /></td><td><img src="/images/emot/6.gif" alt="流泪" /></td><td><img src="/images/emot/7.gif" alt="害羞" /></td><td><img src="/images/emot/8.gif" alt="闭嘴" /></td><td><img src="/images/emot/9.gif" alt="睡" /></td><td><img src="/images/emot/10.gif" alt="大哭" /></td></tr>\
            <tr><td><img src="/images/emot/11.gif" alt="尴尬" /></td><td><img src="/images/emot/12.gif" alt="发怒" /></td><td><img src="/images/emot/13.gif" alt="调皮" /></td><td><img src="/images/emot/14.gif" alt="呲牙" /></td><td><img src="/images/emot/15.gif" alt="惊讶" /></td><td><img src="/images/emot/16.gif" alt="难过" /></td><td><img src="/images/emot/17.gif" alt="酷" /></td><td><img src="/images/emot/18.gif" alt="冷汗" /></td><td><img src="/images/emot/19.gif" alt="抓狂" /></td><td><img src="/images/emot/20.gif" alt="吐" /></td></tr>\
            <tr><td><img src="/images/emot/21.gif" alt="偷笑" /></td><td><img src="/images/emot/22.gif" alt="可爱" /></td><td><img src="/images/emot/23.gif" alt="白眼" /></td><td><img src="/images/emot/24.gif" alt="傲慢" /></td><td><img src="/images/emot/25.gif" alt="饥饿" /></td><td><img src="/images/emot/26.gif" alt="困" /></td><td><img src="/images/emot/27.gif" alt="惊恐" /></td><td><img src="/images/emot/28.gif" alt="流汗" /></td><td><img src="/images/emot/29.gif" alt="憨笑" /></td><td><img src="/images/emot/30.gif" alt="大兵" /></td></tr>\
            <tr><td><img src="/images/emot/31.gif" alt="奋斗" /></td><td><img src="/images/emot/32.gif" alt="咒骂" /></td><td><img src="/images/emot/33.gif" alt="疑问" /></td><td><img src="/images/emot/34.gif" alt="嘘" /></td><td><img src="/images/emot/35.gif" alt="晕" /></td><td><img src="/images/emot/36.gif" alt="折磨" /></td><td><img src="/images/emot/37.gif" alt="衰" /></td><td><img src="/images/emot/38.gif" alt="骷髅" /></td><td><img src="/images/emot/39.gif" alt="敲打" /></td><td><img src="/images/emot/40.gif" alt="再见" /></td></tr>\
            <tr><td><img src="/images/emot/41.gif" alt="擦汗" /></td><td><img src="/images/emot/42.gif" alt="抠鼻" /></td><td><img src="/images/emot/43.gif" alt="鼓掌" /></td><td><img src="/images/emot/44.gif" alt="糗大了" /></td><td><img src="/images/emot/45.gif" alt="坏笑" /></td><td><img src="/images/emot/46.gif" alt="左哼哼" /></td><td><img src="/images/emot/47.gif" alt="右哼哼" /></td><td><img src="/images/emot/48.gif" alt="哈欠" /></td><td><img src="/images/emot/49.gif" alt="鄙视" /></td><td><img src="/images/emot/50.gif" alt="委屈" /></td></tr>\
            <tr><td><img src="/images/emot/51.gif" alt="快哭了" /></td><td><img src="/images/emot/52.gif" alt="阴险" /></td><td><img src="/images/emot/53.gif" alt="亲亲" /></td><td><img src="/images/emot/54.gif" alt="吓" /></td><td><img src="/images/emot/55.gif" alt="可怜" /></td><td><img src="/images/emot/56.gif" alt="菜刀" /></td><td><img src="/images/emot/57.gif" alt="西瓜" /></td><td><img src="/images/emot/58.gif" alt="啤酒" /></td><td><img src="/images/emot/59.gif" alt="篮球" /></td><td><img src="/images/emot/60.gif" alt="乒乓" /></td></tr>\
            <tr><td><img src="/images/emot/61.gif" alt="咖啡" /></td><td><img src="/images/emot/62.gif" alt="饭" /></td><td><img src="/images/emot/63.gif" alt="猪头" /></td><td><img src="/images/emot/64.gif" alt="玫瑰" /></td><td><img src="/images/emot/65.gif" alt="凋谢" /></td><td><img src="/images/emot/66.gif" alt="示爱" /></td><td><img src="/images/emot/67.gif" alt="爱心" /></td><td><img src="/images/emot/68.gif" alt="心碎" /></td><td><img src="/images/emot/69.gif" alt="蛋糕" /></td><td><img src="/images/emot/70.gif" alt="闪电" /></td></tr>\
            <tr><td><img src="/images/emot/71.gif" alt="炸弹" /></td><td><img src="/images/emot/72.gif" alt="刀" /></td><td><img src="/images/emot/73.gif" alt="足球" /></td><td><img src="/images/emot/74.gif" alt="瓢虫" /></td><td><img src="/images/emot/75.gif" alt="便便" /></td><td><img src="/images/emot/76.gif" alt="月亮" /></td><td><img src="/images/emot/77.gif" alt="太阳" /></td><td><img src="/images/emot/78.gif" alt="礼物" /></td><td><img src="/images/emot/79.gif" alt="拥抱" /></td><td><img src="/images/emot/80.gif" alt="强" /></td></tr>\
            <tr><td><img src="/images/emot/81.gif" alt="弱" /></td><td><img src="/images/emot/82.gif" alt="握手" /></td><td><img src="/images/emot/83.gif" alt="胜利" /></td><td><img src="/images/emot/84.gif" alt="抱拳" /></td><td><img src="/images/emot/85.gif" alt="勾引" /></td><td><img src="/images/emot/86.gif" alt="拳头" /></td><td><img src="/images/emot/87.gif" alt="差劲" /></td><td><img src="/images/emot/88.gif" alt="爱你" /></td><td><img src="/images/emot/89.gif" alt="NO" /></td><td><img src="/images/emot/90.gif" alt="OK" /></td></tr>\
            </table>',
    }).on('shown.bs.popover', function () {
        $(this).parent().find('td').click(function(){
            $("#feed-content").insertAtCaret("["+$(this).find('img').attr('alt')+"]"); 
        });
    }).on('blur', function() {
        $(".emot").popover('hide');
    });

    //头像提示会员信息
	$('[rel=author]').popover({
	    trigger : 'manual',
        container: 'body',
	    html : true,
        placement: 'auto right',
	    content : '<div class="popover-user"></div>',
	}).on('mouseenter', function(){
	    var _this = this;
	    $(this).popover('show');
	    $.ajax({
	        url: $(this).attr('href'),
	        success: function(html){
	            $('.popover-user').html(html);
                $('.popover .btn-success, .popover .btn-danger').click(function(){
                    $.ajax({
                        url: $(this).attr('href'),
                        success: function(data) {
                            $('.popover .btn-success').text('关注成功').addClass('disabled');
                            $('.popover .btn-danger').text('取消成功').addClass('disabled');
                        },
                        error: function (XMLHttpRequest, textStatus) {
                            $(_this).popover('hide');
                            $('#modal').modal({ remote: '/login'});
                            this.abort();
                        }
                    });
                    return false;
                });
	        }
	    });
	    $('.popover').on('mouseleave', function () {
	        $(_this).popover('hide');
	    });
	}).on('mouseleave', function () {
	    var _this = this;
	    setTimeout(function () {
	        if(!$('.popover:hover').length) {
	            $(_this).popover('hide')
	        }
	    }, 100);
	});
    //会员中心关注
    $('.follow').on('click', function() {
        var a = $(this);
        $.ajax({
            url: a.attr('href'),
            dataType: 'json',
            success: function(data) {
                if(data.action == 'create') {
                    a.html('取消关注');
                } else {
                    a.html('点击关注');
                }
            },
        });
        return false;
    });
    //右侧面板关注
    $('.btn-follow').on('click', function() {
        var a = $(this);
        $.ajax({
            url: $(this).attr('href'),
            dataType: 'json',
            success: function(data) {
                if(data.action == 'create') {
                    a.removeClass('btn-success').addClass('btn-danger');
                    a.find('span').removeClass('glyphicon-plus').addClass('glyphicon-minus');
                } else {
                    a.removeClass('btn-danger').addClass('btn-success');
                    a.find('span').removeClass('glyphicon-minus').addClass('glyphicon-plus');
                }
            },
            error: function (XMLHttpRequest, textStatus) {
                $('#modal').modal({ remote: '/login'});
                this.abort();
            }
        });
        return false;
    });

    //详细页收藏
	$('.favourites a').on('click', function() {
        var a = $(this);
        var span = $(this).find('span');
        var em = $(this).find('em');
        $.ajax({
            url: a.attr('href'),
            dataType: 'json',
            success: function(data) {
                if(data.action == 'create') {
                    span.attr('class', 'fa fa-star');
                    a.attr('data-original-title', '您已收藏').tooltip('show').attr('data-original-title', '取消收藏');
                } else {
                    span.attr('class', 'fa fa-star-o');
                    a.attr('data-original-title', '您已取消收藏').tooltip('show').attr('data-original-title', '收藏');
                }
                em.html(data.count);
            },
            error: function (XMLHttpRequest, textStatus) {
                $('#modal').modal({ remote: '/login'});
                this.abort();
            }
        });
        return false;
    });

    //会员中心收藏
    $('.media-action .favourite').on('click', function() {
        var a = $(this);
        $.ajax({
            url: a.attr('href'),
            dataType: 'json',
            success: function(data) {
                if(data.action == 'create') {
                    a.html('取消收藏');
                } else {
                    a.html('重新收藏');
                }
            }
        });
        return false;
    });

    //投票
    $('.vote a').on('click', function() {
        var a = $(this);
        var title = a.attr('data-original-title');
        $.ajax({
            url: a.attr('href'),
            dataType: 'json',
            success: function(data) {
                a.parent().find('.up span').attr('class', 'fa fa-thumbs-o-up');
                a.parent().find('.down span').attr('class', 'fa fa-thumbs-o-down');
                a.find('span').attr('class', a.find('span').attr('class').replace('o-', ''));
                a.parent().find('.up em').html(data.up);
                a.parent().find('.down em').html(data.down);
                a.attr('data-original-title');
                a.attr('data-original-title', '您已' + title).tooltip('show').attr('data-original-title', title);
            },
            error: function (XMLHttpRequest, textStatus) {
                $('#modal').modal({ remote: '/login'});
                this.abort();
            }
        });
        return false;
    });
    
    //回复
    $(".reply-btn").click(function(){
        $(".reply-form").removeClass("hidden");
        if($(this).parent().attr("class")=="media-action") {
            $(".reply-form").appendTo($(this).parent());
            $(".reply-form").find("textarea").val("");
        } else {
            $(".reply-form").appendTo($(this).parents("li").find(".media-action"));
            $(".reply-form").find("textarea").val("@"+$(this).parents(".media-heading").find("a").html()+" ");
        }
        $(".reply-form").find(".parent_id").val($(this).parents("li").attr("data-key"));
        return false;
    });
    
    //说说回复
    $(".feed-btn").click(function(){
        $("#feed-content").val("@"+$(this).parents(".media-heading").find("a").html()+" ");
    });
});

$.fn.insertAtCaret = function(myValue) {
    return this.each(function() {
        var me = this;
        if (document.selection) {
            me.focus();
            sel = document.selection.createRange();
            sel.text = myValue;
            me.focus();
        } else if (me.selectionStart || me.selectionStart == '0') {
            var startPos = me.selectionStart, endPos = me.selectionEnd, scrollTop = me.scrollTop;
            me.value = me.value.substring(0, startPos) + myValue + me.value.substring(endPos, me.value.length);
            me.focus();
            me.selectionStart = startPos + myValue.length;
            me.selectionEnd = startPos + myValue.length;
            me.scrollTop = scrollTop;
        } else {
            me.value += myValue;
            me.focus();
        }
    });
};

function attachment(id,name,size) {
    $('#attachment').append('<p>图片请插入：!['+name+'](/image/'+id+' "'+name+'")<br />附件请插入：['+name+'](/download/'+id+')</p>');
}

var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F4a3af5cc318b92f2687be7ab6567a45c' type='text/javascript'%3E%3C/script%3E"));
