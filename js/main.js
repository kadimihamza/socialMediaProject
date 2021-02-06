function chercher(){
    $.post('cherche.php', {search: $("#search").val()}, function(data){
        $('#result').html(data);
    })
}