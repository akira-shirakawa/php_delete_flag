$('.js-button-add-target').click(function(){
    $('.js-add-target').addClass('is-active');
}),
$('.modal-background').click(function(){

    $('.modal').removeClass('is-active');
}),
params = (new URL(document.location)).searchParams;
id = params.get('id');
link = '.link-'+String(id);
console.log(link);
$(link).addClass('is-current');
$('.js-submit-target').click(function(){
    console.log('hoge');
    $('#js-search').submit();
}),
$('.js-delete-button').click(function(){
    id = $(this).attr('class');
    id = parseInt(id);
    $('#js-delete-target').val(id);
    $('#js-delete-form-target').submit();
}),
$('.js-edit-button').click(function(){
    $('.js-edit-target').addClass('is-active');
    id = $(this).attr('class');
    id = parseInt(id);
    comment = $(this).parent().prev().text();
    $('#js-edit-target').val(comment);
    $('#js-edit-target-hidden').val(id);
    $('#js-edit-target-old').val(comment);
})