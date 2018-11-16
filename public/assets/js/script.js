// Next Step
function next(obj) {
    $box  = obj.closest('.box');
    $box.animate({height: "0px", display:"none"});
    $box.hide(1000);

    $next = obj.data('next');
    $($next).closest('.step').show();
}
// Get Token Session
function getToken() {
    return $('meta[name="_token"]').attr('content');
}
// Load Cliente
function loadCliente(token) {
    $.post(URLBASE +'done',{ token:token}, function (cliente) {
        $('#nome_completo').text(cliente.nome_completo);
        $('#data_nascimento').text(cliente.data_nascimento);
        $('#rua').text(cliente.rua);
        $('#numero').text(cliente.numero);
        $('#cep').text(cliente.cep);
        $('#cidade').text(cliente.cidade);
        $('#estado').text(cliente.estado);
        $('#telefone_fixo').text(cliente.telefone_fixo);
        $('#telefone_celular').text(cliente.telefone_celular);
    })
}
// Mask INPUT's
function mask_input() {
    $('.dated').mask('00/00/0000');
    $('.cep').mask('00000-000');
    $('.tel-cel').mask('(00) 00000-0000');
    $('.tel-fixo').mask('(00) 0000-0000');
}
// Validator
function validator(form) {
    return form.validate({
        rules: {
            nome_completo: "required",
            data_nascimento: "required",
            rua: "required",
            numero: "required",
            cep: "required",
            cidade: "required",
            estado: "required",
            telefone_fixo: "required",
            telefone_celular: "required"
        },
        messages: {
            nome_completo: "Informe seu Nome Completo",
            data_nascimento: "Informe sua Data de Nascimento",
            rua: "Informe sua Rua",
            numero: "Informe Numero da casa",
            cep: "Informe seu CEP",
            cidade: "Informe sua Cidade",
            estado: "Informe seu Estado",
            telefone_fixo: "Informe seu Telefone Fixo",
            telefone_celular: "Informe seu Telefone Celular"
        }
    })

    jQuery.validator.addMethod('checkDateFormat', function(value, element){
        var stringPattern = /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])2))(?:(?:1[6-9]|[2-9]d)?d{2})$|^(?:29(\/|-|\.)0?23(?:(?:(?:1[6-9]|[2-9]d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))4(?:(?:1[6-9]|[2-9]d)?d{2})$/gm;
        if(stringPattern.test(value)){ return true; }
        else { return false; }
    },"Informe sua Data de Nascimento");
}
// Bootstrap
$(function (e) {
    //Mask INPUT
    mask_input();
    // Start Create
    $('.start').on('click', function (e) {
        next($(this));
    });
    // Next Step
    $('.next').on('click', function (e) {
        $this = $(this);
        //Get Form
        $form = $this.closest('.next-form');
        // Starting Validator
        var validate = validator($form);
        //Submit Form
        if (validate.form()) {
            $form.submit();
        }
    });
    // Save Step
    $('.next-form').on('submit', function(e) {
        $form = $(this);
        $btn  = $form.find('.next');

        var data = new FormData($form[0]);
        data.append('token', getToken());

        $.ajax({
            url: URLBASE + 'store',
            data: data,
            type: 'POST',
            contentType: false,
            processData: false,
            beforeSend: function () {
                $btn.text('salvando...');
                $btn.attr('disabled',true)
            },
            success: function (result) {
                console.log(result);
            },
            error: function (error) {
                console.log(error);
            },
            complete: function () {
                $btn.text('Próximo');
                $btn.removeAttr('disabled');
                next($btn);
                if($done = $form.find('.done')) {
                    $done.trigger('click');
                }
            }
        });

        e.preventDefault();
    });
    // Back Step
    $('.previus').on('click', function(e) {
        $this = $(this);

        $box  = $this.closest('.box');
        $box.hide(1000);

        $previus = $this.data('previus');
        $previus = $($previus).closest('.step');
        $previus.animate({height: "800px", display:"block"});
        $previus.show();

        return true;
    });
    // Done
    $('.done').on('click', function(e) {
        $('#step-4').removeClass('step');
        loadCliente(getToken());
    });
    // Close
    $('.close').on('click', function (e) {
        window.location.href = '/';
    })
});
