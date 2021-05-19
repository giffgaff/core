<!doctype html>
<html @if ($direction) dir="{{ $direction }}" @endif
      @if ($language) lang="{{ $language }}" @endif>
    <head>
        <meta charset="utf-8">
        <title>{{ $title }}</title>

        {!! $head !!}
    </head>

    <body>
        {!! $layout !!}

        <div id="modal"></div>
        <div id="alerts"></div>

        <!-- workaround for old iOS devices -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.6/es6-shim.min.js" integrity="sha512-Dg4/NsM35WYe4Vpj/ZzxsN7K4ifsi6ecw9+VB5rmCntqoQjEu4dQxL6/qQVebHalidCqWiVkWVK59QtJCCjBDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/es7-shim/6.0.0/es7-shim.min.js" integrity="sha512-LUBx8YucSzBQpB8HbxpcI07wpM/IN3BRfTshhgWh/X/Bpl9jhLgHjUyShOdCP+yLgBZMRdsEOERXJilznrP1tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/proxy-polyfill/0.3.2/proxy.min.js" integrity="sha512-rkQmC9k6r2JmC6vL68NnR2dPJnAg2zcAX562Y097B2TVaxUkF910WNhHJgdgz+NX2bJ0Lx8RegJ1vE87OKWlag==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            document.getElementById('flarum-loading').style.display = 'block';
            var flarum = {extensions: {}};
        </script>    

        {!! $js !!}

        <script>
            document.getElementById('flarum-loading').style.display = 'none';

            try {
                flarum.core.app.load(@json($payload));
                flarum.core.app.bootExtensions(flarum.extensions);
                flarum.core.app.boot();
            } catch (e) {
                var error = document.getElementById('flarum-loading-error');
                error.innerHTML += document.getElementById('flarum-content').textContent;
                error.style.display = 'block';
                throw e;
            }
        </script>

        {!! $foot !!}
    </body>
</html>
