
<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-8">
        <input type="text" id="captcha" class=" form-control" name="captcha" placeholder="验证码" maxlength="6">
    </div>

    <div class="col-sm-4" style="padding-left: 0">
        <img style="width: 100%;max-width: 120px;" src="{{captcha_src('verify_four')}}" alt="图形验证码" id="captchaImg" height="34" onclick="refreshCaptcha('captchaImg')">
    </div>
</div>

<script>

    function refreshCaptcha(dom) {
        let $dom = $('#'+dom);
        $dom.attr('src','{{captcha_src('verify_four')}}?'+img_name_random());
    }

    //图片后缀随机数
    function img_name_random() {
        var rand_one = parseInt(100 * Math.random());
        var rand_two = parseInt(100 * Math.random());
        return String(rand_one) + String(rand_two);
    }
</script>

