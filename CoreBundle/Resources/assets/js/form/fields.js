(function () {
    define(['jquery', 'bootstrap'], function ($, bs) {
        var $toggleFields = $('.field-toggle');
        $toggleFields.each(function () {
            var oValue,
                $field = $(this),
                $switch = $field.find('.field-toggle-switch'),
                $value = $field.find('.field-toggle-value');
            $switch.on('change', function (e) {
                if(this.checked) {
                    $value.val(oValue);
                    oValue = null;
                    $value.attr('disabled', false);
                } else {
                    oValue = $value.val();
                    $value.val('');
                    $value.attr('disabled', true);
                }
            });
        });

        $('.config-name-widget').each(function(){
            var $field = $(this),
                $nameInput = $field.find('input[type="text"]'),
                $textDisplay = $field.find('.config-name-value > span'),
                target = $field.data('target'),
                $form = $field.closest('form'),
                $target = $form.find('input[type="text"][name$="['+target+']"]'),
                autoUpdate = true;

            $target.on('keyup', function(){
                if(!autoUpdate){
                    return;
                }
                var value = this.value.trim().replace(/[^\w -_]/g, '').replace(/[- ]/g, '_');
                $textDisplay.text(value);
                $nameInput.val(value);
            });

            $nameInput.on('keyup', function(){
                autoUpdate = false;
                $textDisplay.text(this.value);
            });

            $field.on('click', '.config-name-toggle-input', function(){
                $field.children('.config-name-input').fadeIn();
                $field.find('.config-name-value').fadeOut();

                return false;
            });
        });
    });
})();
