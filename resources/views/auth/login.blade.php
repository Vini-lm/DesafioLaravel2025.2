
<body>
    <div>
    <!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->

    <h1>Login</h1>

    <form action="/login" method="post">

        @csrf

        <div>
            <input name="email" placeholder="Email" />

            @error('email')
            <span> {{ $message }}</span>
            @enderror

        </div>
        <br>
        <div>
            <input type="password" name="password" placeholder="Senha" />

            @error('password')
            <span> {{ $message }}</span>
            @enderror
        </div>
        <br>


        <button>Login</button>

    </form>

</div>
</body>
