<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel com Bootstrap</title>
    @vite(['resources/js/app.js'])
    @vite(['resources/css/app.css'])
</head>


<body>
    <div class="container mt-5">
        <form action="{{ route('clima') }}" method="GET" class="p-4 shadow rounded">
            @csrf 
            <div class="row g-3">
                <!-- Campo para o CEP -->
                <div class="col-sm-3">
                    <label for="cep" class="form-label">CEP:</label>
                    <input type="text" name="cep" id="cep" class="form-control" placeholder="Digite o CEP" maxlength="9" required>
                </div>

                <!-- Campo para a Cidade -->
                <div class="col-sm-7">
                    <label for="cid" class="form-label">Cidade</label>
                    <input type="text" name="cid" id="cid" class="form-control" placeholder="informe o CEP" readonly required>
                </div>

                <!-- Botão de Submissão -->
                <div class="col-sm-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary fw-bold w-100">Consultar previsão</button>
                </div>
            </div>   
        </form> 

        <div class="container mt-5">
            <div class="p-4 shadow rounded bg-white position-relative">
                <form action="{{ route('save') }}" method="POST">
                    @csrf
                    <!-- Botão no canto superior direito -->
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="btn fw-bold text-warning" title="Salvar" onclick="showAlert('Salvar', 'Deseja salvar essa previsão?', 'question')">
                            <i data-lucide="bookmark" class="bookmark-icon fs-2 text-warning hover-fill-primary"></i>
                        </span>
                    </div>
                </form>
        
                <!-- Cabeçalho com Localização -->
                <div class="mb-4">
                    <h2>{{ $weather['location']['name'] }}, {{ $weather['location']['region'] }} - {{ $weather['location']['country'] }}</h2>
                    <p class="text-muted">{{ \Carbon\Carbon::parse($weather['location']['localtime'])->format('d/m/Y H:i') }}</p>
                </div>
                
                <!-- Dados principais e Tabela de dados adicionais -->
                <div class="row">
                    <!-- Coluna da esquerda com dados principais -->
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="row w-100">
                            <div class="col-md-3 text-center">
                                <img src="{{ $icon }}" alt="Weather Icon" class="img-fluid" style="max-width: 150px;">
                            </div>
                            <div class="col-md-4 text-center">
                                <p class="fs-1 fw-bold">{{ $weather['current']['temperature'] }}°C</p>
                                <p class="h5">{{ $description }}</p>
                            </div>
                            <div class="col-md-5 text-center">
                                <p class="fs-1 fw-bold">{{ $weather['current']['wind_speed'] }} km/h</p>
                                <p class="h5">Vento</p>
                            </div>
                        </div>
                    </div>
        
                    <!-- Coluna da direita com a tabela de dados adicionais -->
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm text-start">
                            <tbody>
                                <tr>
                                    <th class="p-1 text-start">
                                        <div class="d-flex flex-column">
                                            Pressão
                                            <i data-lucide="wind-arrow-down"></i>
                                        </div>
                                    </th>
                                    <td class="p-1">{{ $weather['current']['pressure'] }} hPa</td>
                                </tr>
                                <tr>
                                    <th class="p-1 text-start">
                                        <div class="d-flex flex-column">
                                            Humidade
                                            <i data-lucide="droplet"></i>
                                        </div>
                                    </th>
                                    <td class="p-1">{{ $weather['current']['humidity'] }}%</td>
                                </tr>
                                <tr>
                                    <th class="p-1 text-start">
                                        <div class="d-flex flex-column">
                                            Visibilidade
                                            <i data-lucide="eye"></i>
                                        </div>
                                    </th>
                                    <td class="p-1">{{ $weather['current']['visibility'] }} km</td>
                                </tr>
                                <tr>
                                    <th class="p-1 text-start">
                                        <div class="d-flex flex-column">
                                            Índice UV
                                            <i data-lucide="sun"></i>
                                        </div>
                                    </th>
                                    <td class="p-1">{{ $weather['current']['uv_index'] }}</td>
                                </tr>
                                <tr>
                                    <th class="p-1 text-start">
                                        <div class="d-flex flex-column">
                                            Sensação Térmica
                                            <i data-lucide="thermometer-sun"></i>
                                        </div>
                                    </th>
                                    <td class="p-1">{{ $weather['current']['feelslike'] }}°C</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <hr class="mt-5">
        <h2 class="mb-3">Previsões do tempo salvas</h2>
        <p>Nenhuma previsão foi salva</p>


    </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function showAlert(title, text, icon){
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                //logica para salvar
            }
        });
    }

    function saveWeatherForecast() {
            // Dados que você quer salvar, como a previsão do tempo
            const weatherData = {
                temperature: "{{ $weather['current']['temperature'] }}",
                city: "{{ $weather['location']['name'] }}",
                country: "{{ $weather['location']['country'] }}",
                // Adicione mais informações conforme necessário
            };

            // Usando Axios para enviar os dados para o backend
            axios.post("{{ route('save') }}", weatherData, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                Swal.fire('Salvo!', 'A previsão do tempo foi salva com sucesso.', 'success');
            })
            .catch(error => {
                console.error('Erro ao salvar:', error);
                Swal.fire('Erro!', 'Ocorreu um erro ao salvar.', 'error');
            });
        }
</script>


