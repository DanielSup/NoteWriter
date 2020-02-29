$(function(){
    $.nette.init();
});

function myfunction(){
    if($("#frm-addForm-preprocessor").val() != "none"){
        $("#frm-addForm-text").hide();
    } else {
        $("#frm-addForm-text").show();
    }

    console.log($("#frm-addForm-preprocessor").val());
}
