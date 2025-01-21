<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Confirmation de Code PIN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .container {
            text-align: center;
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            margin-bottom: 20px;
        }

        .pin-inputs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .pin-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 18px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s;
        }

        .pin-input:focus {
            border-color: #007bff;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 15px;
            font-size: 14px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Entrez votre Code PIN</h2>
        <p style="color: #ccc">Nous vous avons envoyé le code par email</p>
        <div class="pin-inputs">
            <!-- Modifié pour 4 champs -->
            <input type="text" maxlength="1" class="pin-input" oninput="moveNext(this)">
            <input type="text" maxlength="1" class="pin-input" oninput="moveNext(this)">
            <input type="text" maxlength="1" class="pin-input" oninput="moveNext(this)">
            <input type="text" maxlength="1" class="pin-input" oninput="moveNext(this)">
        </div>
        <button onclick="verifyPin()">Confirmer</button>
        <p id="message" class="message"></p>
    </div>

    <script>
        // Fonction pour passer automatiquement au champ suivant
        function moveNext(input) {
            if (input.value.length === 1) {
                const nextInput = input.nextElementSibling;
                if (nextInput && nextInput.classList.contains('pin-input')) {
                    nextInput.focus();
                }
            } else if (input.value.length === 0) {
                const prevInput = input.previousElementSibling;
                if (prevInput && prevInput.classList.contains('pin-input')) {
                    prevInput.focus();
                }
            }
        }

        // Fonction pour vérifier le code PIN
        function verifyPin() {
            const inputs = document.querySelectorAll('.pin-input');
            const pin = Array.from(inputs).map(input => input.value).join('');
            const message = document.getElementById('message');

            if (pin.length === 4 && /^\d{4}$/.test(pin)) {
                // Envoi du PIN au serveur pour validation
                const idUtilisateur = "{{ session('utilisateur_id') }}";

                fetch(`http://localhost:8081/api/confirmerConnexion/${idUtilisateur}/${pin}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            message.textContent = "❌ " + data.error;
                            message.className = "message error";

                        } else {
                            message.textContent = "✔️ " + data.message;
                            message.className = "message success";

                            // Rediriger l'utilisateur vers la page d'accueil ou une autre page après succès
                            setTimeout(() => {
                                window.location.href =
                                    "/dashboard";
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        message.textContent = "❌ Une erreur est survenue. Veuillez réessayer.";
                        message.className = "message error";
                    });
            } else {
                message.textContent = "❌ Veuillez entrer un code PIN valide à 4 chiffres.";
                message.className = "message error";
            }
        }
    </script>
</body>

</html>
