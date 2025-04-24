jQuery(document).ready(function ($) {
    let mediaUploader;

    $('#macher_logo_upload').click(function (e) {
        e.preventDefault();

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media({
            title: macherLoginTexts.title,
            button: {
                text: macherLoginTexts.button
            },
            multiple: false
        });

        mediaUploader.on('select', function () {
            const attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#macher_backend_login_logo_url').val(attachment.url);
            $('#macher_logo_preview').attr('src', attachment.url).show();
            $('#macher_logo_remove').show();
        });

        mediaUploader.open();
    });

    $('#macher_logo_remove').click(function () {
        $('#macher_backend_login_logo_url').val('');
        $('#macher_logo_preview').hide();
        $('#macher_logo_remove').hide();
    });
});

jQuery(document).ready(function ($) {
    // Prüfe, ob nur E-Mail erlaubt ist
    const loginMode = $('body').attr('data-macher-login-mode');

    if (loginMode === 'email') {
        $('#loginform').on('submit', function (e) {
            const username = $('#user_login').val();
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(username)) {
                e.preventDefault();
                alert('Bitte gib eine gültige E-Mail-Adresse ein.');
            }
        });
    }
});
