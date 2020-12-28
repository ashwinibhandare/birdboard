<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>

{{--<script src="{{ mix('js/app.js') }}"></script>--}}
<div id="app">
    <dropdown align="right" width="200px">
        <template v-slot:trigger>
            <button class="flex items-center text-default no-underline text-sm" href="#" role="button">
                <img width="35" class="rounded-full mr-3" src="{{gravatar_url(auth()->user()->email)}}">
                {{ auth()->user()->name }}
            </button>
        </template>
        <a href="#"
           class="block text-default no-underline hover:underline text-sm leading-loose"
        onclick="javascript: document.querySelector('#logout-form').submit()">Logout</a>
        <a href="#" class="block text-default no-underline hover:underline text-sm leading-loose">Item 2</a>

        <form id="logout-form" method="POST" action="/logout">
            @csrf
            <button href="#" class="block text-default no-underline hover:underline text-sm leading-loose">Item 3</button>
        </form>
    </dropdown>


    @yield('content')

</div>


</body>
<script>
    import Button from "../../js/Jetstream/Button";
    export default {
        components: {Button}
    }
</script>
<script>
    import Button from "../../js/Jetstream/Button";
    export default {
        components: {Button}
    }
</script>
