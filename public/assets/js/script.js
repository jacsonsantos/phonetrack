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

function loadCliente(token) {
    $.post(URLBASE +'done',{ token:token}, function (result) {
        console.log(result);
    })
}

$(function (e) {
    //Mask INPUT
    $('.date').mask('00/00/0000');
    $('.cep').mask('00000-000');
    $('.tel-cel').mask('(00) 00000-0000');
    $('.tel-fixo').mask('(00) 0000-0000');

    // Start Create
    $('.start').on('click', function (e) {
        next($(this));
    })

    // Next Step
    $('.next').on('click', function (e) {
        $this = $(this);
        //Save data
        $this.closest('.next-form').submit();
    })

    // Next Step
    $('.next-form').on('submit', function (e) {
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
            }
        });

        e.preventDefault();
    })

    // Back Step
    $('.previus').on('click', function (e) {
        $this = $(this);

        $box  = $this.closest('.box');
        $box.hide(1000);

        $previus = $this.data('previus');
        $previus = $($previus).closest('.step');
        $previus.animate({height: "800px", display:"block"});
        $previus.show();

        return true;
    })
    
    $('.done').on('click', function (e) {
        $('#step-4').removeClass('step');
        loadCliente(getToken());
    })
    // Close
    $('.close').on('click', function (e) {
        window.location.href = '/';
    })
})