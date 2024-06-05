<?php
    //...

    if (isset($_POST['Usuario']) && isset($_POST['Clave'])) {
        $usuario = Validar($_POST['Usuario']);
        $clave = Validar($_POST['Clave']);

        $Sql = "SELECT * FROM usuarios WHERE NombreUsuario = '$usuario'";
        $query = mysqli_query($conexion, $Sql);

        if ($query->num_rows == 1) {
            $usuarioQ = $query->fetch_assoc();

            $Id = $usuarioQ['Id'];
            $NombreUsuario = $usuarioQ['NombreUsuario'];
            $ClaveHasheada = $usuarioQ['Clave'];
            $NombreCompleto = $usuarioQ['NombreCompleto'];

            echo "Usuario: $usuario, Clave: $clave, Clave Hasheada: $ClaveHasheada<br>";

            if (strcasecmp($usuario, $NombreUsuario) == 0) {
                if (password_verify($clave, $ClaveHasheada)) {
                    echo "Clave correcta<br>";
                    $_SESSION['Id'] = $Id;
                    $_SESSION['NombreUsuario'] = $NombreUsuario;
                    $_SESSION['NombreCompleto'] = $NombreCompleto;

                    echo "<script>
                        alert('Bienvenido $NombreCompleto');
                        location.href = '../Home.php'
                    </script>";
                } else {
                    echo "Clave incorrecta<br>";
                    header('Location:../Index.php?error=Usuario o clave incorrecta');
                }
            } else {
                echo "Usuario incorrecto<br>";
                header('Location:../Index.php?error=Usuario o clave incorrecta');
            }
        } else {
            echo "No se encontró el usuario<br>";
            header('Location:../Index.php?error=Usuario o clave incorrecta');
        }
    }
?>