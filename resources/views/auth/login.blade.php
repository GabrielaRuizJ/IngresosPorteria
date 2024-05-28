<!DOCTYPE html>
<html>
<head>
	<title>Sistema de ingresos</title>
	<link rel="stylesheet" href="{{asset('css/cssLogin.css')}}">
    <script src="{{asset('js/fontAwesome.js')}}"></script>
</head>
<body>
	<img class="wave" src="build/assets/images/wavePV.svg">
	<div class="container">
        <div class="img">
			<img src="build/assets/images/logoLogin.svg">
		</div>
        <x-auth-session-status class="mb-4" :status="session('status')" />
        @if ($errors->any())
            <div class="alert-login alert-light-login" role="alert">
                @foreach ($errors->all() as $error)
                    <label>{{$error}}</label>
                @endforeach
            </div>
        @endif
        <div class="login-content">
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
				<img src="build/assets/images/logoLogin.svg">
				<h2 class="title">Bienvenido</h2>
                <div class="input-div one">
                    <div class="i">
                            <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                      <x-input-label for="username" :value="__('Usuario')" />
                      <x-text-input id="username" class="block mt-1 w-full input" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                      <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i"> 
                         <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full input"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
            
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>
                <div class="">
                    <label for="remember_me" class="">
                        <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recordar datos') }}</span>
                    </label>
                </div>
                <div class="">
                    <x-primary-button class=" btn">
                        {{ __('Ingresar') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@section('js')

    <script type="text/javascript">
        const inputs = document.querySelectorAll(".input");
        function addcl(){
            let parent = this.parentNode.parentNode;
            parent.classList.add("focus");
        }
        function remcl(){
            let parent = this.parentNode.parentNode;
            if(this.value == ""){
                parent.classList.remove("focus");
            }
        }
        inputs.forEach(input => {
            input.addEventListener("focus", addcl);
            input.addEventListener("blur", remcl);
        });
    </script>
@stop
   
</body>
</html>