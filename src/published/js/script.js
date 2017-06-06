$(".filter-select").change(function() {
    $(this).parents("form[name='filter_form']").submit();
});

$(".filter-url-select").change(function() {
    location.href = $(this).find("option:selected").val();
});