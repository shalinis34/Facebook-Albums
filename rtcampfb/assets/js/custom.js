/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
  function progressBar()
    {
        var progressbar = $( "#progress" ),
        progressLabel = $( ".progress-label" );
        progressbar.progressbar({
            value: false,
            change: function() {
                progressLabel.text( progressbar.progressbar( "value" ) + "%" );
            },
            complete: function() {
                progressLabel.text( "Complete!" );
            }
        });
        function progress() {
            var val = progressbar.progressbar( "value" ) || 0;
            progressbar.progressbar( "value", val + 1 );
            if ( val < 90 ) {
                setTimeout( progress,100 );
            }
        }
        setTimeout( progress, 1000 );
    }
    function downloadSingleAlbum(album_id)
    {    progressBar();
        $.ajax({
            url: 'download.php',
            type: 'GET',
            data: 'type=single&album_ids='+album_id,
            success: function(data) {
                $('.ui-progressbar-value').css('width','100%');
                $('.progress-label').text('Completed !');
                //called when successful
                $('#ajaxphp-results').html(data);
                // alert(data);
            }
        });
    }
    function downloadSelectedAlbum()
    {  //By each()
        var c = [];
        $('.download:checked').each(function() {
            c.push($(this).val());
        });
        console.log(c);
        progressBar();
        $.ajax({
            url: 'download.php',
            type: 'GET',
            data: 'type=selected&album_ids='+c,
            success: function(data) {
                $('.ui-progressbar-value').css('width','100%');
                $('.progress-label').text('Completed !');
                //called when successful
                $('#ajaxphp-results').html(data);
                // alert(data);
            }

        });

    }
    function downloadAllAlbum(album_id)
    {  //By each()
        var c = [];
        $('.download').each(function() {
            c.push($(this).val());
        });
        console.log(c);
        progressBar();
        $.ajax({
            url: 'download.php',
            type: 'GET',
            data: 'type=all&album_ids='+c,
            success: function(data) {
                $('.ui-progressbar-value').css('width','100%');
                $('.progress-label').text('Completed !');
                //called when successful
                $('#ajaxphp-results').html(data);
                // alert(data);
            }
        });
    }
    function moveSingleAlbum(album_id)
    {
        progressBar();
        $.ajax({
            url: 'move.php',
            type: 'GET',
            data: 'type=single&album_ids='+album_id,
            success: function(data) {
                $('.ui-progressbar-value').css('width','100%');
                $('.progress-label').text('Completed !');
                //called when successful
                $('#ajaxphp-results').html(data);
                // alert(data);
            }
        });

    }
    function moveSelectedAlbum(album_id)
    {  //By each()
        var c = [];
        $('.download').each(function() {
            c.push($(this).val());
        });
        console.log(c);
        progressBar();
        $.ajax({
            url: 'move.php',
            type: 'GET',
            data: 'type=selected&album_ids='+c,
            success: function(data) {
                $('.ui-progressbar-value').css('width','100%');
                $('.progress-label').text('Completed !');
                //called when successful
                $('#ajaxphp-results').html(data);
                // alert(data);
            }
        });

    }
    function moveAllAlbum(album_id)
    {  //By each()
        var c = [];
        $('.download').each(function() {
            c.push($(this).val());
        });
        console.log(c);
        progressBar();
        $.ajax({
            url: 'move.php',
            type: 'GET',
            data: 'type=all&album_ids='+c,
            success: function(data) {

                $('.ui-progressbar-value').css('width','100%');
                $('.progress-label').text('Completed !');
                //called when successful
                $('#ajaxphp-results').html(data);
                // alert(data);
            }

        });

    }
