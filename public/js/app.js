

// header --------------------
$('#login-form').hide()

$('#show-register').click(() => {
    $('#login-form').hide()
    $('#register-form').show()
})

$('#show-login').click(() => {
    $('#register-form').hide()
    $('#login-form').show()
})
// --------------------

// ajax --------------------
$('#weeb-button').click(() => {
    const weeb = $('#weeb-text').val()
    console.log(weeb)
    $('#weeb-text').val("")
    $.ajax({
        type: 'POST',
        url: 'controllers/chatController.php?action=create',
        data: 'content=' + weeb,
        success: refresh,
        error: () => alert('something went wrong')
    })
})

function refresh() {
    $('#weeb-feed').load("controllers/chatController.php?action=refresh", setLikes)
}

function setLikes() {
    $('.like').click(e => {
        $.ajax({
            type: 'POST',
            url: 'controllers/chatController.php?action=like',
            data: 'id=' + $(e.target).data('id'),
            success: refresh,
            error: () => alert('something went wrong')
        })
    })
    
    $('.dislike').click(e => {
        $.ajax({
            type: 'POST',
            url: 'controllers/chatController.php?action=dislike',
            data: 'id=' + $(e.target).data('id'),
            success: refresh,
            error: () => alert('something went wrong')
        })
    })
}
refresh()


// --------------------