<?php
$topImage = !empty($pageImage) ? $pageImage : url('/') . '/imgs/1.jpg';
$jumbotronImage = url('/') . '/imgs/1.jpg';
$_siteName = 'SexyGirlCollection.Com';
$_siteTitle = !empty($pageTitle) ? $pageTitle : 'Sexy Girl Collection - Hot girls, Sexy girls, Girls in bikini';
$_siteDescription = 'See the best looking girl pics, hot girls, cute girls, bikini girls, college girls, hot celebrities and more!';
$_currentUrl = url()->current();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="{{ $_siteDescription }}">
        <meta name="author" content="{{ $_siteName }}">

        <title>{{ $_siteTitle }}</title>

        <link rel="image_src" href="{{ $topImage }}" />
        <link rel="canonical" href="{{ $_currentUrl }}" />
        <meta property="og:site_name" content="{{ $_siteName }}">
        <meta property="og:image" content="{{ $topImage }}">
        <meta property="og:description" content="{{ $_siteDescription }}">
        <meta property="og:url" content="{{ url()->full() }}">
        <meta property="og:title" content="{{ $_siteTitle }}">
        <meta property="og:type" content="article">
        <meta name="twitter:title" content="{{ $_siteTitle }}">
        <meta name="twitter:description" content="{{ $_siteDescription }}">
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- Custom styles for this template -->
        <link href="{{ asset('/css/custom.css').'?'.time() }}" rel="stylesheet">

        <?php if (!empty(config('services.google')['ga_key'])): ?>
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google')['ga_key'] }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag() {
                    dataLayer.push(arguments);
                }
                gtag('js', new Date());

                gtag('config', "<?php echo config('services.google')['ga_key']; ?>");
            </script>
        <?php endif; ?>
        
</head>

<body>
    <div class="container">
        <header class="blog-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col text-center text-bold">
                    <a class="blog-header-logo text-dark" href="{{ url('/') }}">SBGC</a>
                </div>
            </div>
        </header>

        <div class="nav-scroller py-1 mb-2">
            <nav class="nav d-flex justify-content-between">
                <a class="p-2 text-muted text-center" href="{{ url('/') }}">Home</a>
                <a class="p-2 text-muted text-center" href="{{ url('/images') }}">Images</a>
                <a class="p-2 text-muted text-center" href="{{ url('/videos') }}">Videos</a>
                <a class="p-2 text-muted text-center" href="{{ url('/movies') }}">Movies</a>
            </nav>
        </div>
    </div>

    <main role="main" class="container">
        @yield('content')
    </main><!-- /.container -->

    <footer class="blog-footer">
        <p>© 2020 <a href="{{ url('') }}">{{ $_siteName }}</a>. All right reserved.</p>
        <p>
            <a href="#">Back to top</a>
        </p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ asset('/js/custom.js').'?'.time() }}"></script>
</body>
</html>
