jQuery(document).ready(function($) {
    function activateTabFromHash() {
        var hash = window.location.hash;

        if (hash && $('.macher-tab-links a[href="' + hash + '"]').length) {
            $('.macher-tab-links li').removeClass('active');
            $('.macher-tab-content .tab').removeClass('active');

            $('.macher-tab-links a[href="' + hash + '"]').parent().addClass('active');
            $(hash).addClass('active');
        }
    }

    // Tab per Klick aktivieren
    $('.macher-tab-links a').on('click', function(e) {
        e.preventDefault();

        var target = $(this).attr('href');

        $('.macher-tab-links li').removeClass('active');
        $(this).parent().addClass('active');

        $('.macher-tab-content .tab').removeClass('active');
        $(target).addClass('active');

        // URL-Hash setzen (optional für Browser-Verlauf)
        window.location.hash = target;
    });

    // Direkt beim Laden aktivieren, falls #tab-x in URL steht
    activateTabFromHash();
});
