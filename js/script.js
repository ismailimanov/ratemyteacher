$(document).ready(function(){
    $('input[type="radio"]').on('click', function(){
        window.location = '?vurder=' + $(this).val() + '&teacherId=' + $('#teacherId').val();
    });
});