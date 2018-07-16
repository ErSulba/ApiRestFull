Hola {{ $user->name }}

Has cambiado tu correo electronico, Por favor verifica la nueva direccion usando el siguiente enlace:

{{ route('verify', $user->verification_token) }}